import paramiko, time

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

# Check if certbot is available
stdin, stdout, stderr = client.exec_command("which certbot 2>/dev/null || echo 'not found'")
print("certbot:", stdout.read().decode('utf-8', errors='replace').strip())

# Check webserver type
stdin, stdout, stderr = client.exec_command("which lsws_ctrl 2>/dev/null || ls /usr/local/lsws/bin/ 2>/dev/null | head -5")
print("lsws:", stdout.read().decode('utf-8', errors='replace').strip())

# Check what's serving louiecaraircon.com
stdin, stdout, stderr = client.exec_command("cat /usr/local/lsws/conf/httpd_config.xml | grep -A5 'louiecaraircon' | head -20")
print("lsws vhost:", stdout.read().decode('utf-8', errors='replace').strip())

# Check nginx/apache vhosts
stdin, stdout, stderr = client.exec_command("ls /etc/nginx/sites-enabled/ 2>/dev/null; ls /etc/apache2/sites-enabled/ 2>/dev/null")
print("vhosts:", stdout.read().decode('utf-8', errors='replace').strip())

# Check CyberPanel virtual hosts
stdin, stdout, stderr = client.exec_command("ls /usr/local/lsws/conf/vhosts/ 2>/dev/null | head -20")
print("cyberpanel vhosts:", stdout.read().decode('utf-8', errors='replace').strip())

client.close()
