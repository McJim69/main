import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

local_path = r'd:\Server\www\new_index.php'
remote_path = '/usr/local/CyberCP/webhosting_template/index.php'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Delete existing junk in webhosting_template
stdin, stdout, stderr = ssh.exec_command('rm -rf /usr/local/CyberCP/webhosting_template/*')
stdout.read()

# Upload the new index.php
sftp = ssh.open_sftp()
sftp.put(local_path, remote_path)
# Also save it as index.html just in case CyberPanel looks for that first
sftp.put(local_path, '/usr/local/CyberCP/webhosting_template/index.html')
sftp.close()

ssh.close()
print("Successfully updated webhosting_template.")
