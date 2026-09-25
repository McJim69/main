import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')
sftp = ssh.open_sftp()

files_to_patch = [
    '/var/www/html/billing/modules/Servicehosting/templates/admin/mod_servicehosting_server.html.twig',
    '/var/www/html/billing/modules/Servicehosting/templates/admin/mod_servicehosting_index.html.twig'
]

for remote_path in files_to_patch:
    local_path = remote_path.split('/')[-1]
    sftp.get(remote_path, local_path)
    
    with open(local_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Remove placeholders
    content = content.replace('placeholder="ns1.yourdomain.com"', '')
    content = content.replace('placeholder="ns2.yourdomain.com"', '')
    content = content.replace('placeholder="ns3.yourdomain.com"', '')
    content = content.replace('placeholder="ns4.yourdomain.com"', '')
    
    with open(local_path, 'w', encoding='utf-8') as f:
        f.write(content)
        
    sftp.put(local_path, remote_path)

# Clear cache
ssh.exec_command('rm -rf /var/www/html/billing/data/cache/*')

sftp.close()
ssh.close()
print("Placeholders removed and cache cleared!")
