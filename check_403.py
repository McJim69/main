import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('grep "403" /usr/local/lsws/logs/error.log | tail -n 50')
print("STDOUT err:", stdout.read().decode())
print("STDERR err:", stderr.read().decode())

stdin, stdout, stderr = ssh.exec_command('tail -n 50 /usr/local/lsws/logs/error.log')
print("STDOUT tail:", stdout.read().decode())
ssh.close()
