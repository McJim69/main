import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    
    commands = [
        'cp /usr/local/lsws/Example/html/index.html /usr/local/lsws/Example/html/index.html.bak',
        'cp /usr/local/lsws/Example/html/webhosting.html /usr/local/lsws/Example/html/index.html'
    ]
    
    for cmd in commands:
        stdin, stdout, stderr = client.exec_command(cmd)
        err = stderr.read().decode('utf-8')
        if err:
            print(f"Error executing {cmd}: {err}")
    
    print("Landing page successfully updated on host.mcjim-server.com!")
    client.close()
except Exception as e:
    print(f"Error: {e}")
