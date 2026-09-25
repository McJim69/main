import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Set public_html back to 750 but group nobody
stdin, stdout, stderr = ssh.exec_command('chown louie5891:nobody /home/louiecaraircon.com/public_html; chmod 750 /home/louiecaraircon.com/public_html')
stdout.read()

# Test again
stdin, stdout, stderr = ssh.exec_command('curl -s -I -H "Host: louiecaraircon.com" http://127.0.0.1/index.php')
print("STDOUT:", stdout.read().decode('utf-8', 'ignore'))
print("STDERR:", stderr.read().decode('utf-8', 'ignore'))

ssh.close()
