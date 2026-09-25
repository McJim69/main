import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')

print("Find layout_default:")
stdin, stdout, stderr = ssh.exec_command('find /var/www/html/billing/themes/huraga -name "layout_default.html.twig"')
print(stdout.read().decode())
print(stderr.read().decode())

ssh.close()
