import paramiko

host = '10.0.10.111'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password, timeout=5)
    stdin, stdout, stderr = ssh.exec_command('ls -la /var/www /home /usr/local/lsws')
    print("Checking locations on 10.0.10.111:")
    print(stdout.read().decode())
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
