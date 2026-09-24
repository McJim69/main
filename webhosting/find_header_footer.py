import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("find /usr/local/lsws/Example/html -name 'header.php' 2>/dev/null")
print("header.php:", stdout.read().decode())

stdin, stdout, stderr = client.exec_command("find /usr/local/lsws/Example/html -name 'footer.php' 2>/dev/null")
print("footer.php:", stdout.read().decode())

stdin, stdout, stderr = client.exec_command("cat /usr/local/lsws/Example/html/css/bootstrap.min.css | head -c 100")
print("CSS version check:", stdout.read().decode())

client.close()
