import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

cmd = """
mysql -u root -e "
SELECT * FROM guestcounter.users WHERE username = 'chae@mcjim-server.com';
"
"""
stdin, stdout, stderr = ssh.exec_command(cmd)
print(stdout.read().decode())
ssh.close()
