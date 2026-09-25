import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Fix the patch in vhost.py to also do chmod -R 755
script = """
import re
with open('/usr/local/CyberCP/plogical/vhost.py', 'r') as f:
    content = f.read()

# Replace the previous chown line with a chown + chmod
old_str = "subprocess.call(['chown', '-R', f'{virtualHostUser}:nobody', virtualHostPath + '/public_html'])"
new_str = "subprocess.call(['chown', '-R', f'{virtualHostUser}:nobody', virtualHostPath + '/public_html'])\\n            subprocess.call(['chmod', '-R', '755', virtualHostPath + '/public_html'])"

content = content.replace(old_str, new_str)

with open('/usr/local/CyberCP/plogical/vhost.py', 'w') as f:
    f.write(content)
"""

stdin, stdout, stderr = ssh.exec_command('python3 -c "{}"'.format(script.replace('"', '\\"')))
print("STDOUT patch:", stdout.read().decode())
print("STDERR patch:", stderr.read().decode())

ssh.close()
