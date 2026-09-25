import paramiko
import sys
import json

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check cyberpanel main log
stdin, stdout, stderr = ssh.exec_command('tail -n 100 /home/cyberpanel/error-logs.txt')
sys.stdout.buffer.write(b"Error Logs:\n" + stdout.read())

stdin, stdout, stderr = ssh.exec_command('cat /home/cyberpanel/cyberpanel_error.log | tail -n 100')
sys.stdout.buffer.write(b"\n\nCyberpanel Error Log:\n" + stdout.read())

ssh.close()
