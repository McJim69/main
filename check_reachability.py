import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    # Check if we can ping 10.0.10.111
    stdin, stdout, stderr = ssh.exec_command('ping -c 2 10.0.10.111')
    print("Ping Output:")
    print(stdout.read().decode())
    
    # Check if we can reach SSH port
    stdin, stdout, stderr = ssh.exec_command('nc -vz 10.0.10.111 22')
    print("NC Output:")
    print(stderr.read().decode()) # nc output is usually on stderr
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
