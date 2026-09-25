import paramiko
import sys

host = '10.0.10.15'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

sftp = ssh.open_sftp()
remote_path = '/etc/nginx/sites-enabled/proxy-services'
with sftp.file(remote_path, 'r') as f:
    config = f.read().decode('utf-8')

# Revert proxy_pass http://10.0.10.51:8088 back to 80
config = config.replace('proxy_pass http://10.0.10.51:8088;', 'proxy_pass http://10.0.10.51:80;')

with sftp.file(remote_path, 'w') as f:
    f.write(config.encode('utf-8'))

sftp.close()

# reload nginx
stdin, stdout, stderr = ssh.exec_command('nginx -t && systemctl reload nginx')
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())
ssh.close()
