import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

print("Tables in zdsfreewifi:")
stdin, stdout, stderr = ssh.exec_command('mysql -e "SHOW TABLES FROM zdsfreewifi;"')
print(stdout.read().decode())

ssh.close()
