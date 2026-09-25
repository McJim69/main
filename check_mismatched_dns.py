import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check all mismatched domain_ids
sql = """
USE cyberpanel;
SELECT r.id, r.domain_id, r.name, d.id as actual_domain_id, d.name as domain_name
FROM records r
JOIN domains d ON r.name LIKE CONCAT('%', d.name, '%')
WHERE r.domain_id != d.id;
"""
stdin, stdout, stderr = ssh.exec_command(f'mysql -u root -p$(cat /etc/cyberpanel/mysqlPassword) -e "{sql}"')
sys.stdout.buffer.write(stdout.read())

ssh.close()
