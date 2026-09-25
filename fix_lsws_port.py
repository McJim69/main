import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

sftp = ssh.open_sftp()
remote_path = '/usr/local/lsws/conf/httpd_config.conf'
with sftp.file(remote_path, 'r') as f:
    config = f.read().decode('utf-8')

# Replace port 8088 with 80
config = config.replace('address                  *:8088', 'address                  *:80')

with sftp.file(remote_path, 'w') as f:
    f.write(config.encode('utf-8'))

sftp.close()

# test and restart lsws
stdin, stdout, stderr = ssh.exec_command('systemctl restart lsws')
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())
ssh.close()
