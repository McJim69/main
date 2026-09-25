import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Fix DNS records
sql = """
USE cyberpanel;
DELETE FROM records WHERE domain_id != 23 AND name = 'louiecaraircon.com';
INSERT INTO records (domain_id, name, type, content, ttl, prio, disabled) VALUES (23, 'louiecaraircon.com', 'A', '180.193.203.22', 3600, 0, 0);
"""
stdin, stdout, stderr = ssh.exec_command(f'mysql -u root -p$(cat /etc/cyberpanel/mysqlPassword) -e "{sql}"')
sys.stdout.buffer.write(stdout.read())

ssh.close()
