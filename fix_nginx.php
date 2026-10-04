<?php
$c = file_get_contents('/etc/nginx/nginx.conf');
$c = str_replace("http {\\n\\tclient_max_body_size 100M;", "http {\n\tclient_max_body_size 100M;", $c);
file_put_contents('/etc/nginx/nginx.conf', $c);
