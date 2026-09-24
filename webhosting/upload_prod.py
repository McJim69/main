import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
local_file = r'd:\Server\www\webhosting.html'
remote_file = '/usr/local/lsws/Example/html/webhosting.html'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    sftp = client.open_sftp()
    
    print(f"Uploading {local_file} to {remote_file}...")
    sftp.put(local_file, remote_file)
    print("Upload complete!")
    
    sftp.close()
    client.close()
except Exception as e:
    print(f"Error: {e}")
