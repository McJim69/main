import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Query the cyberpanel database for domains
stdin, stdout, stderr = ssh.exec_command('mysql -u root -p$(cat /etc/cyberpanel/mysqlPassword) -e "USE cyberpanel; SELECT id, name, master, last_check, type, notified_serial, account FROM domains WHERE name LIKE \'%louiecaraircon.com%\';"')
sys.stdout.buffer.write(stdout.read())

ssh.close()
