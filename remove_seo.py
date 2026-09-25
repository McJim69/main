import paramiko

sql = """
USE fossbilling;

-- Delete the product 'Complete SEO Optimization'
DELETE FROM product WHERE title = 'Complete SEO Optimization';

-- Delete the category 'Premium Web Services'
DELETE FROM product_category WHERE title = 'Premium Web Services';
"""

with open('d:\\Server\\www\\remove_seo.sql', 'w') as f:
    f.write(sql)

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')
sftp = ssh.open_sftp()
sftp.put('d:\\Server\\www\\remove_seo.sql', '/tmp/remove_seo.sql')
sftp.close()

stdin, stdout, stderr = ssh.exec_command('mysql -u fossbilling -pfossbilling_pass < /tmp/remove_seo.sql')
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())

ssh.close()
