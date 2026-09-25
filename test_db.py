import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

# Check Victory
print("Testing Victory DB on 10.0.10.111:")
stdin, stdout, stderr = ssh.exec_command('mysql -h 10.0.10.111 -u McJim -pRestricted654123 -e "SHOW DATABASES;"')
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())

# Check Louie
print("Testing Louie DB on 10.0.10.200:")
stdin, stdout, stderr = ssh.exec_command('mysql -h 10.0.10.200 -u McJim -pRestricted654123 -e "SHOW DATABASES;"')
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())

ssh.close()
