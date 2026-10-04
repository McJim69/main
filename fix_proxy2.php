<?php
$files = [
    '/etc/nginx/sites-enabled/proxy-services',
    '/etc/nginx/sites-available/proxy-services'
];
foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Fix the 443 conflict
    $content = str_replace('listen 443 default_server ssl;', 'listen 127.0.0.1:8443 default_server ssl;', $content);
    
    // Fix the max body size for billing if not already present
    if (strpos($content, 'client_max_body_size 100M;') === false) {
        $content = str_replace("server_name billing.mcjim-server.com;", "server_name billing.mcjim-server.com;\n    client_max_body_size 100M;", $content);
    }
    
    file_put_contents($file, $content);
}
echo "Fixed proxy files.\n";
