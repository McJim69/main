import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('grep -n -C 5 "shutil.copy" /usr/local/CyberCP/plogical/vhost.py')
print("STDOUT:", stdout.read().decode())
ssh.close()
