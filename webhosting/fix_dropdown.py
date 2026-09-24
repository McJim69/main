import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

# Read the file
stdin, stdout, stderr = client.exec_command("cat /usr/local/lsws/Example/html/menunav.php")
content = stdout.read().decode('utf-8')

# Fix: replace Bootstrap 5 data-bs-toggle with Bootstrap 4 data-toggle
content = content.replace(
    'data-bs-toggle="dropdown" aria-expanded="false"',
    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"'
)

# Write back
sftp = client.open_sftp()
remote_path = '/usr/local/lsws/Example/html/menunav.php'
with sftp.file(remote_path, 'w') as f:
    f.write(content)

print("Done!")
sftp.close()
client.close()
