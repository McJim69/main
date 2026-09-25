import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
remote_path = '/usr/local/CyberCP/index.html'
local_path = r'd:\Server\www\cyberpanel_default_index.html'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    sftp = ssh.open_sftp()
    sftp.get(remote_path, local_path)
    sftp.close()
    print(f"Successfully downloaded {remote_path} to {local_path}")
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
