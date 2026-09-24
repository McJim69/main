import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    stdin, stdout, stderr = client.exec_command('ls -la /usr/local/lsws/Example/html/')
    print(stdout.read().decode('utf-8'))
    client.close()
except Exception as e:
    print(f"Error: {e}")
