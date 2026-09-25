import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('cat /usr/local/lsws/conf/httpd_config.conf | grep -A 10 "^listener "')
print(stdout.read().decode())
ssh.close()
