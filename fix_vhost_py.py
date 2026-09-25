import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Fix vhost.py
script = """
sed -i 's/chown -R {virtualHostUser}:{virtualHostUser}/chown -R {virtualHostUser}:nogroup/g' /usr/local/CyberCP/plogical/vhost.py
sed -i 's/chown -R {virtualHostUser}:{virtualHostUser}/chown -R {virtualHostUser}:nogroup/g' /usr/local/CyberCP/plogical/virtualHostUtilities.py
"""
stdin, stdout, stderr = ssh.exec_command(script)
sys.stdout.buffer.write(stdout.read())
sys.stdout.buffer.write(stderr.read())

ssh.close()
