import paramiko
import os

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
local_dir = r'd:\Server\www\images'
remote_dir = '/usr/local/lsws/Example/html/images'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    sftp = client.open_sftp()
    
    # Create remote directory if it doesn't exist
    try:
        sftp.stat(remote_dir)
    except FileNotFoundError:
        sftp.mkdir(remote_dir)
    
    # Upload files
    for item in os.listdir(local_dir):
        local_path = os.path.join(local_dir, item)
        if os.path.isfile(local_path):
            remote_path = f"{remote_dir}/{item}"
            print(f"Uploading {item}...")
            sftp.put(local_path, remote_path)
            
    print("Images uploaded successfully!")
    sftp.close()
    client.close()
except Exception as e:
    print(f"Error: {e}")
