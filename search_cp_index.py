import paramiko
import sys

# Fix console printing encoding
sys.stdout.reconfigure(encoding='utf-8')

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    # Search for the string in /usr/local/CyberCP and /home
    stdin, stdout, stderr = ssh.exec_command('grep -rn "View CyberPanel Documentation" /usr/local/CyberCP /home')
    out = stdout.read().decode('utf-8', errors='replace')
    print("Search Results:")
    print(out)
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
