import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    client.connect(host, username=user, password=password, timeout=10)
    stdin, stdout, stderr = client.exec_command('cat /usr/local/lsws/Example/html/index.html')
    content = stdout.read().decode('utf-8')
    if 'McJimHosting' in content:
        print("Found McJimHosting in Example index.html")
        print(content)
    else:
        print("Not found here either.")
    client.close()
except Exception as e:
    print(f"Error: {e}")
