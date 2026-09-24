import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
new_password = 'R3str1ct3d@1991'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    print("Changing CyberPanel admin password...")
    stdin, stdout, stderr = client.exec_command(f'adminPass {new_password}')
    out = stdout.read().decode('utf-8')
    err = stderr.read().decode('utf-8')
    print("STDOUT:", out)
    if err:
        print("STDERR:", err)
        
    client.close()
except Exception as e:
    print(f"Error: {e}")
