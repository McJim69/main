import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')

php_script = """
<?php
$hash = password_hash('Chaechae123!', PASSWORD_BCRYPT);
echo $hash;
"""
sftp = ssh.open_sftp()
with sftp.file('/tmp/hash.php', 'w') as f:
    f.write(php_script)

stdin, stdout, stderr = ssh.exec_command('php /tmp/hash.php')
bcrypt_hash = stdout.read().decode().strip()

sql = f"""
USE fossbilling;

INSERT INTO client (email, first_name, last_name, role, status, pass, created_at, updated_at)
VALUES ('chae@mcjim-server.com', 'Chaechae', 'Chae', 'client', 'active', '{bcrypt_hash}', NOW(), NOW())
ON DUPLICATE KEY UPDATE first_name='Chaechae', last_name='Chae', pass='{bcrypt_hash}';
"""
with sftp.file('/tmp/insert_client.sql', 'w') as f:
    f.write(sql)
sftp.close()

stdin, stdout, stderr = ssh.exec_command('mysql -u fossbilling -pfossbilling_pass < /tmp/insert_client.sql')
print("Import complete.")

ssh.close()
