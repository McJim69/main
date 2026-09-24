import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("cat /usr/local/lsws/Example/html/index.html | grep -i 'bootstrap\\|jquery\\|script\\|link' | head -30")
print("index.html refs:", stdout.read().decode())

stdin, stdout, stderr = client.exec_command("ls /usr/local/lsws/Example/html/css/")
print("\nCSS dir:", stdout.read().decode())

client.close()
