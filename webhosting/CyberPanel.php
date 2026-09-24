<?php

/**
 * Copyright 2022-2024 FOSSBilling
 * Copyright 2011-2021 BoxBilling, Inc.
 * SPDX-License-Identifier: Apache-2.0.
 *
 * @copyright FOSSBilling (https://www.fossbilling.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */

class Server_Manager_CyberPanel extends Server_Manager
{
    /**
     * Returns server manager parameters.
     *
     * @return array returns an array with the label of the server manager
     */
    public static function getForm(): array
    {
        return [
            'label' => 'CyberPanel',
        ];
    }

    /**
     * Returns the URL for account management.
     *
     * @param Server_Account|null $account the account for which the URL is generated
     *
     * @return string returns the URL as a string
     */
    public function getLoginUrl(Server_Account $account = null): string
    {
        $host = $this->_config['host'];
        $port = !empty($this->_config['port']) ? ':' . $this->_config['port'] : ':8090';
        $host = 'https://' . $host;

        if ($account) {
            $token = bin2hex(random_bytes(16));

            // Sanitize username the same way createUserAccount() does,
            // so the SSO token carries the username CP actually stored.
            $username = strtolower(preg_replace('/[^a-z0-9]/i', '', $account->getUsername()));
            $username = substr($username, 0, 16);
            if (empty($username)) {
                $username = 'user' . substr(md5($account->getClient()->getEmail()), 0, 12);
            }

            $ssoData = [
                'host'     => rtrim($host . $port, '/'),
                'username' => $username,
                'password' => $account->getPassword(),
            ];

            $cacheDir = __DIR__ . '/../../../data/cache/';
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }

            file_put_contents($cacheDir . 'sso_' . $token, json_encode($ssoData));

            // Token expires after 5 minutes — clean up old tokens
            foreach (glob($cacheDir . 'sso_*') as $f) {
                if (filemtime($f) < time() - 300) {
                    @unlink($f);
                }
            }

            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            return $protocol . $_SERVER['HTTP_HOST'] . '/cyberpanel_sso.php?token=' . $token;
        }

        return $host . $port;
    }

    /**
     * Returns the URL for reseller account management.
     *
     * @param Server_Account|null $account the account for which the URL is generated
     *
     * @return string returns the URL as a string
     */
    public function getResellerLoginUrl(Server_Account $account = null): string
    {
        return $this->getLoginUrl();
    }

    /**
     * Tests the connection to the server.
     *
     * @return bool returns true if the connection is successful
     */
    public function testConnection(): bool
    {
        $request = $this->request('verifyConn', []);

        $response = json_decode($request->getContent());

        if (! $response->verifyConn) {
            throw new Server_Exception('Invalid username or password.');
        }

        return true;

    }

    /**
     * Synchronizes the account with the server.
     *
     * @param Server_Account $account the account to be synchronized
     *
     * @return Server_Account returns the synchronized account
     */
    public function synchronizeAccount(Server_Account $account): Server_Account
    {
        throw new Server_Exception(':type: does not support :action:', [':type:' => 'Cyberpanel', ':action:' => __trans('account synchronization')]);
    }

    /**
     * Creates a new account on the server.
     *
     * @param Server_Account $account the account to be created
     *
     * @return bool returns true if the account is successfully created
     */
    public function createAccount(Server_Account $account): bool
    {
        $client  = $account->getClient();
        $package = $account->getPackage();

        // Create the CP user; if it already exists, continue gracefully
        try {
            $this->createUserAccount($account);
        } catch (Server_Exception $e) {
            if (stripos($e->getMessage(), 'already') === false) {
                throw $e;
            }
            error_log('[CyberPanel] User already exists, skipping createUserAccount: ' . $account->getUsername());
        }

        $acl = $account->getReseller()
            ? ($package->getCustomValue('ACL') ?? 'reseller')
            : ($package->getCustomValue('ACL') ?? 'user');

        $request = $this->request('createWebsite', [
            'domainName'    => $account->getDomain(),
            'ownerEmail'    => $client->getEmail(),
            'packageName'   => $package->getName(),
            'websiteOwner'  => $account->getUsername(),
            'ownerPassword' => $account->getPassword(),
            'acl'           => $acl,
        ]);

        $response = json_decode($request->getContent());

        if (!$response->status) {
            // Treat duplicate website as a success (idempotent)
            if (stripos($response->error_message ?? '', 'already') !== false) {
                error_log('[CyberPanel] Website already exists for domain: ' . $account->getDomain());
                return true;
            }
            error_log('[CyberPanel] createWebsite failed for ' . $account->getDomain() . ': ' . $response->error_message);
            throw new Server_Exception($response->error_message);
        }

        error_log('[CyberPanel] Account provisioned successfully: ' . $account->getUsername() . ' / ' . $account->getDomain());
        return true;
    }

    /**
     * Suspends an account on the server.
     *
     * @param Server_Account $account the account to be suspended
     *
     * @return bool returns true if the account is successfully suspended
     */
    public function suspendAccount(Server_Account $account): bool
    {
        $request = $this->request('submitWebsiteStatus', [
            'websiteName' => $account->getDomain(),
            'state' => 'Suspend'
        ]);

        $response = json_decode($request->getContent());

        if (! $response->websiteStatus) {
            throw new Server_Exception($response->error_message);
        }

        return true;
    }

    /**
     * Unsuspends an account on the server.
     *
     * @param Server_Account $account the account to be unsuspended
     *
     * @return bool returns true if the account is successfully unsuspended
     */
    public function unsuspendAccount(Server_Account $account): bool
    {
        $request = $this->request('submitWebsiteStatus', [
            'websiteName' => $account->getDomain(),
            'state' => 'Activate'
        ]);

        $response = json_decode($request->getContent());

        if (! $response->websiteStatus) {
            throw new Server_Exception($response->error_message);
        }

        return true;
    }

    /**
     * Cancels an account on the server.
     *
     * @param Server_Account $account the account to be cancelled
     *
     * @return bool returns true if the account is successfully cancelled
     */
    public function cancelAccount(Server_Account $account): bool
    {
        // Delete the website.
        $request = $this->request('deleteWebsite', [
            'domainName' => $account->getDomain()
        ]);

        $response = json_decode($request->getContent());

        if (! $response->websiteDeleteStatus) {
            throw new Server_Exception($response->error_message);
        }

        // Sleep for 2 seconds to ensure that delete website command finishes.
        sleep(2);

        // Delete the client
        $request = $this->request('submitUserDeletion', [
            'accountUsername' => $account->getUsername()
        ]);

        $response = json_decode($request->getContent());

        if (! $response->status) {
            throw new Server_Exception($response->error_message);
        }

        return true;
    }

    /**
     * Changes the package of an account on the server.
     *
     * @param Server_Account $account the account for which the package is to be changed
     * @param Server_Package $package the new package
     *
     * @return bool returns true if the package is successfully changed
     */
    public function changeAccountPackage(Server_Account $account, Server_Package $package): bool
    {
        $request = $this->request('changePackageAPI', [
            'websiteName' => $account->getDomain(),
            'packageName' => $package->getName(),
        ]);

        $response = json_decode($request->getContent());

        if (! $response->changePackage) {
            throw new Server_Exception($response->error_message);
        }

        return true;
    }

    /**
     * Changes the username of an account on the server.
     *
     * @param Server_Account $account     the account for which the username is to be changed
     * @param string         $newUsername the new username
     *
     * @return bool returns true if the username is successfully changed
     */
    public function changeAccountUsername(Server_Account $account, string $newUsername): bool
    {
        throw new Server_Exception(':type: does not support :action:', [':type:' => 'Cyberpanel', ':action:' => __trans('username changes')]);

    }

    /**
     * Changes the domain of an account on the server.
     *
     * @param Server_Account $account   the account for which the domain is to be changed
     * @param string         $newDomain the new domain
     *
     * @return bool returns true if the domain is successfully changed
     */
    public function changeAccountDomain(Server_Account $account, string $newDomain): bool
    {
        throw new Server_Exception(':type: does not support :action:', [':type:' => 'Cyberpanel', ':action:' => __trans('changing the account domain')]);
    }

    /**
     * Changes the password of an account on the server.
     *
     * @param Server_Account $account     the account for which the password is to be changed
     * @param string         $newPassword the new password
     *
     * @return bool returns true if the password is successfully changed
     */
    public function changeAccountPassword(Server_Account $account, string $newPassword): bool
    {
        $request = $this->request('changeUserPassAPI', [
            'websiteOwner' => $account->getUsername(),
            'ownerPassword' => $newPassword
        ]);

        $response = json_decode($request->getContent());

        if (! $response->changeStatus) {
            throw new Server_Exception($response->error_message);
        }

        return true;
    }

    /**
     * Changes the IP of an account on the server.
     *
     * @param Server_Account $account the account for which the IP is to be changed
     * @param string         $newIp   the new IP
     *
     * @return bool returns true if the IP is successfully changed
     */
    public function changeAccountIp(Server_Account $account, string $newIp): bool
    {
        throw new Server_Exception(':type: does not support :action:', [':type:' => 'Cyberpanel', ':action:' => __trans('changing the account IP')]);
    }


    /**
     * Private Functions
     */

    private function createUserAccount(Server_Account $account): bool
    {
        $acl = $account->getReseller()
            ? ($account->getPackage()->getCustomValue('ACL') ?? 'reseller')
            : ($account->getPackage()->getCustomValue('ACL') ?? 'user');

        list($firstName, $lastName) = $this->getName($account);

        // CyberPanel usernames: lowercase, alphanumeric only, max 16 chars
        $username = strtolower(preg_replace('/[^a-z0-9]/i', '', $account->getUsername()));
        $username = substr($username, 0, 16);
        if (empty($username)) {
            $username = 'user' . substr(md5($account->getClient()->getEmail()), 0, 12);
        }

        $request = $this->request('submitUserCreation', [
            'firstName'     => $firstName,
            'lastName'      => $lastName ?: 'Unknown',
            'email'         => $account->getClient()->getEmail(),
            'userName'      => $username,
            'password'      => $account->getPassword(),
            'websitesLimit' => $account->getPackage()->getMaxDomains() ?: 0,
            'selectedACL'   => $acl,
            'securityLevel' => 'HIGH',
        ]);

        $response = json_decode($request->getContent());

        if (!$response->status) {
            throw new Server_Exception($response->error_message);
        }

        return true;
    }

    private function getName(Server_Account $account): array
    {
        $fullName = $account->getClient()->getFullname();

        $parts = explode(' ', $fullName, 2);

        if (count($parts) == 1) {
            return array($parts[0], '');
        }

        return $parts;
    }

    private function request(string $action, array $params)
    {
        $host    = $this->_config['host'];
        $port    = !empty($this->_config['port']) ? ':' . $this->_config['port'] . '/' : ':8090/';
        $host    = 'https://' . $host;
        $restUrl = $host . $port . 'api/';

        $client = $this->getHttpClient()->withOptions([
            'verify_peer' => false,
            'verify_host' => false,
            'timeout'     => 60,
        ]);

        $payload = array_merge([
            'adminUser' => $this->_config['username'],
            'adminPass' => $this->_config['password'],
        ], $params);

        $endpoint = $restUrl . $action;
        error_log('[CyberPanel] API call: POST ' . $endpoint . ' | params: ' . json_encode(array_diff_key($params, ['ownerPassword' => '', 'password' => ''])));

        try {
            $response = $client->request('POST', $endpoint, ['json' => $payload]);
        } catch (\Exception $e) {
            error_log('[CyberPanel] HTTP request failed for ' . $action . ': ' . $e->getMessage());
            throw new Server_Exception('CyberPanel API connection failed: ' . $e->getMessage());
        }

        error_log('[CyberPanel] API response for ' . $action . ': ' . $response->getContent(false));

        return $response;
    }
}
