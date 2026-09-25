import paramiko
import os
import shutil

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

local_dir = r'\\10.0.10.111\Server\www'
remote_dir = '/home/victoryfreewifi.net/public_html'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    print(f"Connecting to {host}...")
    ssh.connect(host, username=user, password=password)
    sftp = ssh.open_sftp()
    
    # We will upload without stopping on FileNotFoundError
    print(f"Starting robust migration from {local_dir} to {remote_dir}...")
    
    for root, dirs, files in os.walk(local_dir):
        if 'tmp' in dirs: dirs.remove('tmp')
        
        for file in files:
            local_path = os.path.join(root, file)
            relative_path = os.path.relpath(local_path, local_dir)
            remote_path = remote_dir + '/' + relative_path.replace('\\', '/')
            
            try:
                # Ensure remote directory exists
                remote_subdir = os.path.dirname(remote_path)
                try:
                    sftp.stat(remote_subdir)
                except IOError:
                    ssh.exec_command(f'mkdir -p "{remote_subdir}"')
                
                # Check if local file exists (in case it disappeared)
                if os.path.exists(local_path):
                    sftp.put(local_path, remote_path)
            except Exception as e:
                print(f"Skipping {local_path} due to error: {e}")
                
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
