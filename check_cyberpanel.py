import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

cmd = """
mysql -u root -e "
SELECT email FROM cyberpanel.e_users WHERE email LIKE '%chae%';
SELECT emailOwner_id FROM cyberpanel.e_users WHERE emailOwner_id LIKE '%chae%';
SELECT owner_email FROM cyberpanel.wm_contacts WHERE owner_email LIKE '%chae%';
"
"""
stdin, stdout, stderr = ssh.exec_command(cmd)
print(stdout.read().decode())
ssh.close()
