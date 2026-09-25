import re
import paramiko

with open('d:\\Server\\www\\layout_default_updated.html.twig', 'r', encoding='utf-8') as f:
    html = f.read()

# Replace the include parameters
html = html.replace("company: company,", "link_url: 'https://mcjim-server.com', company: company,")

with open('d:\\Server\\www\\layout_default_updated.html.twig', 'w', encoding='utf-8') as f:
    f.write(html)

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')
sftp = ssh.open_sftp()
sftp.put('d:\\Server\\www\\layout_default_updated.html.twig', '/var/www/html/billing/themes/huraga/html/layout_default.html.twig')
sftp.close()

# Clear the FOSSBilling cache so twig recompiles
ssh.exec_command('rm -rf /var/www/html/billing/data/cache/*')
ssh.close()
print("Updated logo link, uploaded and cache cleared!")
