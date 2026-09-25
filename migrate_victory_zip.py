import paramiko
import os
import shutil

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

local_dir = r'\\10.0.10.111\Server\www'
remote_dir = '/home/victoryfreewifi.net/public_html'
zip_path = r'd:\Server\www\victory_temp.zip'

print("Zipping files (this is much faster for thousands of small files)...")
shutil.make_archive(r'd:\Server\www\victory_temp', 'zip', local_dir)

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    print(f"Connecting to {host}...")
    ssh.connect(host, username=user, password=password)
    sftp = ssh.open_sftp()
    
    remote_zip = '/home/victoryfreewifi.net/victory_temp.zip'
    print(f"Uploading zip to {remote_zip}...")
    sftp.put(zip_path, remote_zip)
    
    print("Unzipping on server...")
    stdin, stdout, stderr = ssh.exec_command(f'unzip -o {remote_zip} -d {remote_dir}')
    stdout.channel.recv_exit_status() # wait for completion
    
    print("Cleaning up zip files...")
    ssh.exec_command(f'rm {remote_zip}')
    os.remove(zip_path)
    
    print("Fixing permissions...")
    stdin, stdout, stderr = ssh.exec_command("stat -c '%U:%G' /home/victoryfreewifi.net")
    owner = stdout.read().decode().strip()
    if owner and 'no such file' not in owner.lower():
        ssh.exec_command(f"chown -R {owner} {remote_dir}")
        
    print("Migration complete!")
    
except Exception as e:
    print(f"Error: {e}")
finally:
    try:
        sftp.close()
    except: pass
    ssh.close()
