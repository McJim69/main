import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Query recent domains and records
sql = """
USE cyberpanel;
SELECT id, name FROM domains ORDER BY id DESC LIMIT 5;
"""
stdin, stdout, stderr = ssh.exec_command(f'mysql -u root -p$(cat /etc/cyberpanel/mysqlPassword) -e "{sql}"')
sys.stdout.buffer.write(b"DOMAINS:\n")
sys.stdout.buffer.write(stdout.read())

sql2 = """
USE cyberpanel;
SELECT id, domain_id, name, type FROM records ORDER BY id DESC LIMIT 20;
"""
stdin, stdout, stderr = ssh.exec_command(f'mysql -u root -p$(cat /etc/cyberpanel/mysqlPassword) -e "{sql2}"')
sys.stdout.buffer.write(b"\nRECORDS:\n")
sys.stdout.buffer.write(stdout.read())

ssh.close()
