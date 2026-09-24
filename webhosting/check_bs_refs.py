import paramiko, os

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

# Check header/footer references
stdin, stdout, stderr = client.exec_command("grep -r 'bootstrap' /usr/local/lsws/Example/html/header.php /usr/local/lsws/Example/html/footer.php 2>/dev/null")
print("References:", stdout.read().decode())

# Also check what other JS files are there
stdin, stdout, stderr = client.exec_command("ls /usr/local/lsws/Example/html/vendor/ 2>/dev/null; ls /usr/local/lsws/Example/html/js/ 2>/dev/null")
print("Dirs:", stdout.read().decode())

client.close()
