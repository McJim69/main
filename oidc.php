<?php
// oidc.php - Minimal OpenID Connect Provider for Jellyfin SSO
session_start();
require("connect.php");

define('OIDC_ISSUER', 'https://mcjim-server.com');
define('OIDC_CLIENT_ID', 'jellyfin');
define('OIDC_CLIENT_SECRET', 'jellyfin_secret'); // You can change this secret
define('OIDC_KEYS_FILE', __DIR__ . '/oidc_keys.json');

// --- Helper Functions ---
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function base64url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function get_keys() {
    if (!file_exists(OIDC_KEYS_FILE)) {
        // Generate new RSA 2048 key
        $config = array(
            "digest_alg" => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $privKey);
        $pubKeyDetails = openssl_pkey_get_details($res);
        
        $keys = [
            'private' => $privKey,
            'public'  => $pubKeyDetails["key"],
            'kid'     => bin2hex(random_bytes(8))
        ];
        file_put_contents(OIDC_KEYS_FILE, json_encode($keys));
        return $keys;
    }
    return json_decode(file_get_contents(OIDC_KEYS_FILE), true);
}

function create_jwt($payload) {
    $keys = get_keys();
    
    $header = [
        'typ' => 'JWT',
        'alg' => 'RS256',
        'kid' => $keys['kid']
    ];
    
    $segments = [];
    $segments[] = base64url_encode(json_encode($header));
    $segments[] = base64url_encode(json_encode($payload));
    $signing_input = implode('.', $segments);
    
    openssl_sign($signing_input, $signature, $keys['private'], OPENSSL_ALGO_SHA256);
    $segments[] = base64url_encode($signature);
    
    return implode('.', $segments);
}

function verify_jwt($jwt) {
    $parts = explode('.', $jwt);
    if (count($parts) !== 3) return false;
    
    $payload = json_decode(base64url_decode($parts[1]), true);
    $signature = base64url_decode($parts[2]);
    $keys = get_keys();
    
    $signing_input = $parts[0] . '.' . $parts[1];
    $verified = openssl_verify($signing_input, $signature, $keys['public'], OPENSSL_ALGO_SHA256);
    
    if ($verified === 1 && $payload['exp'] >= time()) {
        return $payload;
    }
    return false;
}

function get_jwks() {
    $keys = get_keys();
    $res = openssl_pkey_get_private($keys['private']);
    $details = openssl_pkey_get_details($res);
    
    return [
        'keys' => [
            [
                'kty' => 'RSA',
                'alg' => 'RS256',
                'use' => 'sig',
                'kid' => $keys['kid'],
                'n'   => base64url_encode($details['rsa']['n']),
                'e'   => base64url_encode($details['rsa']['e'])
            ]
        ]
    ];
}

// --- OIDC Endpoints ---
$action = $_GET['action'] ?? 'discovery';

if ($action === 'discovery') {
    header('Content-Type: application/json');
    echo json_encode([
        'issuer' => OIDC_ISSUER,
        'authorization_endpoint' => OIDC_ISSUER . '/oidc.php?action=authorize',
        'token_endpoint' => OIDC_ISSUER . '/oidc.php?action=token',
        'userinfo_endpoint' => OIDC_ISSUER . '/oidc.php?action=userinfo',
        'jwks_uri' => OIDC_ISSUER . '/oidc.php?action=jwks',
        'response_types_supported' => ['code'],
        'subject_types_supported' => ['public'],
        'id_token_signing_alg_values_supported' => ['RS256'],
        'scopes_supported' => ['openid', 'profile'],
        'token_endpoint_auth_methods_supported' => ['client_secret_post', 'client_secret_basic']
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

if ($action === 'jwks') {
    header('Content-Type: application/json');
    echo json_encode(get_jwks());
    exit;
}

if ($action === 'authorize') {
    // If not logged in, send them to login.php with a return URI
    if (empty($_SESSION['uno'])) {
        $return_url = urlencode($_SERVER['REQUEST_URI']);
        header("Location: login.php?return=$return_url");
        exit;
    }
    
    $redirect_uri = $_GET['redirect_uri'] ?? '';
    $state = $_GET['state'] ?? '';
    
    // Issue a short-lived authorization code (represented as a self-contained JWT for stateless backend processing)
    $code_payload = [
        'user' => $_SESSION['user'],
        'exp' => time() + 300 // 5 minutes
    ];
    $code = create_jwt($code_payload);
    
    $url = $redirect_uri . '?code=' . $code . '&state=' . urlencode($state);
    header("Location: $url");
    exit;
}

if ($action === 'token') {
    // Basic Auth or POST Auth handling
    $client_id = $_POST['client_id'] ?? '';
    $client_secret = $_POST['client_secret'] ?? '';
    if (empty($client_id) && isset($_SERVER['PHP_AUTH_USER'])) {
        $client_id = $_SERVER['PHP_AUTH_USER'];
        $client_secret = $_SERVER['PHP_AUTH_PW'];
    }
    
    // Validate Client Credentials
    if ($client_id !== OIDC_CLIENT_ID || $client_secret !== OIDC_CLIENT_SECRET) {
        http_response_code(401);
        echo json_encode(['error' => 'invalid_client']);
        exit;
    }
    
    // Validate Authorization Code
    $code = $_POST['code'] ?? '';
    $code_data = verify_jwt($code);
    if (!$code_data) {
        http_response_code(400);
        echo json_encode(['error' => 'invalid_grant']);
        exit;
    }
    
    $username = $code_data['user'];
    
    // Generate Access Token (Using a JWT so we can read it statelessly in userinfo)
    $access_token_payload = [
        'user' => $username,
        'exp' => time() + 3600
    ];
    $access_token = create_jwt($access_token_payload);
    
    // Generate ID Token
    $id_token_payload = [
        'iss' => OIDC_ISSUER,
        'sub' => $username,
        'aud' => OIDC_CLIENT_ID,
        'exp' => time() + 3600,
        'iat' => time(),
        'auth_time' => time(),
        'preferred_username' => $username
    ];
    $id_token = create_jwt($id_token_payload);
    
    header('Content-Type: application/json');
    echo json_encode([
        'access_token' => $access_token,
        'token_type' => 'Bearer',
        'expires_in' => 3600,
        'id_token' => $id_token
    ]);
    exit;
}

if ($action === 'userinfo') {
    $headers = getallheaders();
    $auth = $headers['Authorization'] ?? '';
    
    if (preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
        $token = $matches[1];
        $token_data = verify_jwt($token);
        
        if ($token_data) {
            header('Content-Type: application/json');
            echo json_encode([
                'sub' => $token_data['user'],
                'preferred_username' => $token_data['user'],
            ]);
            exit;
        }
    }
    
    http_response_code(401);
    exit;
}
?>
