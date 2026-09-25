import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Fix ownership of EVERYTHING in public_html to louie5891:nobody
# Actually, standard CyberPanel files in public_html are user:user.
# Let's check standard permissions for a working site in CyberPanel.
# But let me just try 755
stdin, stdout, stderr = ssh.exec_command('chmod 755 /home/louiecaraircon.com/public_html')
stdout.read()

stdin, stdout, stderr = ssh.exec_command('curl -s -v -H "Host: louiecaraircon.com" http://127.0.0.1/index.php')
print("STDOUT after chmod:", stdout.read().decode())
print("STDERR after chmod:", stderr.read().decode())

ssh.close()
