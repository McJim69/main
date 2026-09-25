import paramiko

host = '10.0.10.15'
user = 'root'
password = 'McJim654123'

local_path = r'd:\Server\www\index.php'
remote_path = '/var/www/mcjim-server/index.php'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

sftp = ssh.open_sftp()
sftp.put(local_path, remote_path)
sftp.close()

print("Restored index.php from d:\\Server\\www\\index.php to mcjim-server.com")
ssh.close()
