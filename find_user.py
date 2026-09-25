import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

cmd = """
mysql -e "
SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME 
FROM information_schema.COLUMNS 
WHERE COLUMN_NAME LIKE '%email%' OR COLUMN_NAME LIKE '%user%';
"
"""
# That's too slow. Instead I can just dump all DBs and grep for the email.
cmd = "mysqldump --all-databases | grep 'chae@mcjim-server.com'"
stdin, stdout, stderr = ssh.exec_command(cmd)
print("STDOUT:", stdout.read().decode())
ssh.close()
