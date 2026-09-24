import paramiko, os

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("find /usr/local/lsws/Example/html -name '*.css' | grep -i bootstrap")
print("CSS:", stdout.read().decode())

stdin, stdout, stderr = client.exec_command("cat /usr/local/lsws/Example/html/css/bootstrap.min.css | head -c 200")
print("Current version:", stdout.read().decode())

sftp = client.open_sftp()
sftp.put(r'd:\Server\www\vendor\bootstrap\css\bootstrap.min.css', '/usr/local/lsws/Example/html/css/bootstrap.min.css')
print("bootstrap.min.css uploaded")
sftp.close()
client.close()
