import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
local_css = r'd:\Server\www\webhosting\styles.css'
remote_css = '/usr/local/lsws/Example/html/webhosting/styles.css'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    sftp = client.open_sftp()
    
    print(f"Uploading {local_css} to {remote_css}...")
    sftp.put(local_css, remote_css)
    print("Upload complete!")
    sftp.close()
    
    # Also add cache buster to index.html to ensure they see it!
    cmd = 'sed -i \'s/href="\\/webhosting\\/styles.css"/href="\\/webhosting\\/styles.css?v=3"/g\' /usr/local/lsws/Example/html/index.html'
    client.exec_command(cmd)
    
    client.close()
except Exception as e:
    print(f"Error: {e}")
