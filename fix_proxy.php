<?php
$file = '/etc/nginx/sites-available/proxy-services';
$content = file_get_contents($file);
if (strpos($content, 'client_max_body_size 100M;') === false) {
    $content = str_replace('server_name billing.mcjim-server.com;', "server_name billing.mcjim-server.com;\n    client_max_body_size 100M;", $content);
    file_put_contents($file, $content);
    echo "Fixed.\n";
} else {
    echo "Already fixed.\n";
}
