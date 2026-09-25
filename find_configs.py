import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

print("Victory configs:")
stdin, stdout, stderr = ssh.exec_command('find /home/victoryfreewifi.net/public_html -name "connect.php" -o -name "config.php"')
print(stdout.read().decode())

print("Louie configs:")
stdin, stdout, stderr = ssh.exec_command('find /home/louiecaraircon.com/public_html -name "connect.php" -o -name "config.php"')
print(stdout.read().decode())
