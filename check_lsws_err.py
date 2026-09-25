import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('ls -la /home/louiecaraircon.com/public_html/')
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())

stdin, stdout, stderr = ssh.exec_command('tail -n 100 /usr/local/lsws/logs/error.log')
print("STDOUT LSWS ERR:", stdout.read().decode())
ssh.close()
