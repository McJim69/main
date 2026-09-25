import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

print("Users:")
stdin, stdout, stderr = ssh.exec_command('mysql -e "SELECT User, Host FROM mysql.user;"')
print(stdout.read().decode())
print(stderr.read().decode())

ssh.close()
