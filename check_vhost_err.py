import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('cat /home/louiecaraircon.com/logs/louiecaraircon.com.error_log')
print("STDOUT err:", stdout.read().decode())

ssh.close()
