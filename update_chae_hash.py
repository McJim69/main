import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')

full_hash = "$2y$10$ll9hiwxArWQHQIedDCGh4On.h6jPVvfMeEWr9NDIYmiJVDVlpxrGq"

sql = f"""
USE fossbilling;
UPDATE client SET pass='{full_hash}' WHERE email='chae@mcjim-server.com';
"""

sftp = ssh.open_sftp()
with sftp.file('/tmp/update_hash.sql', 'w') as f:
    f.write(sql)
sftp.close()

stdin, stdout, stderr = ssh.exec_command('mysql -u fossbilling -pfossbilling_pass < /tmp/update_hash.sql')
print("Hash updated!")

ssh.close()
