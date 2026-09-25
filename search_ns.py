import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')

cmd = 'grep -rn "ns3.yourdomain.com" /var/www/html/billing/ --exclude-dir=cache'
stdin, stdout, stderr = ssh.exec_command(cmd)
print(stdout.read().decode())

ssh.close()
