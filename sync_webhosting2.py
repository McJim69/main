import paramiko
import os
import time

host = '10.0.10.15'
user = 'root'
password = 'McJim654123'

local_dir = r'd:\Server\www\webhosting'
remote_dir = '/var/www/mcjim-server'

def get_sftp():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(host, username=user, password=password)
    return ssh, ssh.open_sftp()

ssh, sftp = get_sftp()

for root, dirs, files in os.walk(local_dir):
    for file in files:
        if file.endswith('.py'): continue # Skip python scripts
        local_path = os.path.join(root, file)
        relative_path = os.path.relpath(local_path, local_dir)
        remote_path = remote_dir + '/' + relative_path.replace('\\', '/')
        print(f"Uploading {relative_path}...")
        
        # Create directories if missing
        remote_parent = remote_path.rsplit('/', 1)[0]
        try:
            sftp.stat(remote_parent)
        except IOError:
            ssh.exec_command(f'mkdir -p "{remote_parent}"')
            
        success = False
        for _ in range(3):
            try:
                sftp.put(local_path, remote_path)
                success = True
                break
            except Exception as e:
                print(f"Reconnect due to: {e}")
                try:
                    sftp.close()
                    ssh.close()
                except: pass
                time.sleep(1)
                ssh, sftp = get_sftp()
        if not success:
            print(f"Failed to upload {relative_path}")

sftp.close()
ssh.close()
