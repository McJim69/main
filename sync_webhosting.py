import paramiko
import os

host = '10.0.10.15'
user = 'root'
password = 'McJim654123'

local_dir = r'd:\Server\www\webhosting'
remote_dir = '/var/www/mcjim-server'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

sftp = ssh.open_sftp()

for root, dirs, files in os.walk(local_dir):
    for file in files:
        local_path = os.path.join(root, file)
        relative_path = os.path.relpath(local_path, local_dir)
        remote_path = remote_dir + '/' + relative_path.replace('\\', '/')
        print(f"Uploading {local_path} to {remote_path}")
        try:
            sftp.put(local_path, remote_path)
        except Exception as e:
            print(f"Failed: {e}")

sftp.close()
ssh.close()
