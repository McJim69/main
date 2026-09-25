import paramiko
import re

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')
sftp = ssh.open_sftp()
sftp.get('/var/www/html/billing/themes/huraga/html/layout_default.html.twig', 'd:\\Server\\www\\layout_default.html.twig')
sftp.close()
ssh.close()
print("Downloaded layout_default.html.twig")
