<?php
/**
 * Custom FOSSBilling ESXi Server Manager Module
 */

class Server_Manager_Esxi extends Server_Manager
{
    public static function getForm(): array
    {
        return [
            'label' => 'ESXi vCenter / Standalone',
        ];
    }

    public function getLoginUrl(Server_Account $account = null): string
    {
        if ($account) {
            $vps_name = $account->getDomain() ?: $account->getUsername();
            $token = bin2hex(random_bytes(16));
            
            $config = include '/var/www/html/billing/config.php';
            $pdo = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'], $config['db']['user'], $config['db']['password']);
            $stmt = $pdo->prepare("SELECT ip FROM service_hosting WHERE username = :user");
            $stmt->execute(['user' => $account->getUsername()]);
            $ip = $stmt->fetchColumn();

            $ssoData = [
                'vps_name' => $vps_name,
                'client_id' => $account->getClient()->getId(),
                'ip' => $ip,
                'password' => $account->getPassword(),
            ];
            
            $cacheDir = __DIR__ . '/cache/';
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }
            
            file_put_contents($cacheDir . 'vps_sso_' . $token, json_encode($ssoData));
            
            return 'https://' . $_SERVER['HTTP_HOST'] . '/vps_panel.php?token=' . $token;
        }
        return 'https://billing.mcjim-server.com/client'; 
    }

    public function getResellerLoginUrl(Server_Account $account = null): string
    {
        return $this->getLoginUrl();
    }

    public function testConnection(): bool
    {
        return true;
    }

    public function synchronizeAccount(Server_Account $account): Server_Account
    {
        return $account;
    }

    public function createAccount(Server_Account $account): bool
    {
        $vps_name = $account->getDomain() ?: $account->getUsername();
        
        $vcpu = 4;
        $ram = 8192;
        
        // Grab IP from pool
        $ip = trim(shell_exec("head -n 1 /var/www/html/billing/ip_pool.txt"));
        if (empty($ip)) {
            throw new Server_Exception("No IPs available in the pool!");
        }
        shell_exec("sed -i '1d' /var/www/html/billing/ip_pool.txt");

        // Save IP back to FOSSBilling database so client can see it in their panel & emails
        $config = include '/var/www/html/billing/config.php';
        $pdo = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'], $config['db']['user'], $config['db']['password']);
        $stmt = $pdo->prepare("UPDATE service_hosting SET ip = :ip WHERE username = :user");
        $stmt->execute(['ip' => $ip, 'user' => $account->getUsername()]);

        // Run the provision script with IP and FOSSBilling's generated Password
        $cmd = "/var/www/html/billing/provision_vps.sh " . escapeshellarg($vps_name) . " " . $vcpu . " " . $ram . " " . escapeshellarg($ip) . " " . escapeshellarg($account->getPassword()) . " > /tmp/provision_" . escapeshellarg($vps_name) . ".log 2>&1 &";
        exec($cmd);
        
        return true;
    }

    public function suspendAccount(Server_Account $account): bool
    {
        $vps_name = $account->getDomain() ?: $account->getUsername();
        exec("export GOVC_URL='esxi.mcjim-server.com' GOVC_USERNAME='McJim' GOVC_PASSWORD='Last@Final654123' GOVC_INSECURE=1 GOVC_PERSIST_SESSION=false && /usr/local/bin/govc vm.power -s " . escapeshellarg($vps_name));
        return true;
    }

    public function unsuspendAccount(Server_Account $account): bool
    {
        $vps_name = $account->getDomain() ?: $account->getUsername();
        exec("export GOVC_URL='esxi.mcjim-server.com' GOVC_USERNAME='McJim' GOVC_PASSWORD='Last@Final654123' GOVC_INSECURE=1 GOVC_PERSIST_SESSION=false && /usr/local/bin/govc vm.power -on " . escapeshellarg($vps_name));
        return true;
    }

    public function cancelAccount(Server_Account $account): bool
    {
        $vps_name = $account->getDomain() ?: $account->getUsername();
        exec("export GOVC_URL='esxi.mcjim-server.com' GOVC_USERNAME='McJim' GOVC_PASSWORD='Last@Final654123' GOVC_INSECURE=1 GOVC_PERSIST_SESSION=false && /usr/local/bin/govc vm.power -off " . escapeshellarg($vps_name));
        sleep(2);
        exec("export GOVC_URL='esxi.mcjim-server.com' GOVC_USERNAME='McJim' GOVC_PASSWORD='Last@Final654123' GOVC_INSECURE=1 GOVC_PERSIST_SESSION=false && /usr/local/bin/govc vm.destroy " . escapeshellarg($vps_name));
        return true;
    }

    public function changeAccountPackage(Server_Account $account, Server_Package $package): bool
    {
        return true;
    }

    public function changeAccountUsername(Server_Account $account, string $newUsername): bool
    {
        return true;
    }

    public function changeAccountDomain(Server_Account $account, string $newDomain): bool
    {
        return true;
    }

    public function changeAccountPassword(Server_Account $account, string $newPassword): bool
    {
        return true;
    }

    public function changeAccountIp(Server_Account $account, string $newIp): bool
    {
        return true;
    }
}
