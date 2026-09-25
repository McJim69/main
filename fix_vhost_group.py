import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Fix the ownership of existing site
stdin, stdout, stderr = ssh.exec_command('chown louie5891:nobody /home/louiecaraircon.com/public_html')
stdout.read()

# Fix the patch in vhost.py
script = """
import re
with open('/usr/local/CyberCP/plogical/vhost.py', 'r') as f:
    content = f.read()

# Replace chown -R user:user with chown -R user:nobody
content = content.replace("f'{virtualHostUser}:{virtualHostUser}'", "f'{virtualHostUser}:nobody'")

with open('/usr/local/CyberCP/plogical/vhost.py', 'w') as f:
    f.write(content)
"""

stdin, stdout, stderr = ssh.exec_command('python3 -c "{}"'.format(script.replace('"', '\\"')))
print("STDOUT patch:", stdout.read().decode())
print("STDERR patch:", stderr.read().decode())

ssh.close()
