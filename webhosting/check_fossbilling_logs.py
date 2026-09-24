import paramiko
import traceback

host = '10.0.10.52'
user = 'root'
password = 'McJim654123'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    
    print("--- Checking FOSSBilling Logs ---")
    stdin, stdout, stderr = client.exec_command('find /var/www/html/billing/data/log -type f -name "*.log" -exec tail -n 20 {} +')
    print(stdout.read().decode('utf-8', errors='replace'))
    
    print("--- Checking for Exception Logs ---")
    stdin, stdout, stderr = client.exec_command('find /var/www/html/billing/data/log -type f -name "exception*" -exec tail -n 20 {} +')
    print(stdout.read().decode('utf-8', errors='replace'))
    
    client.close()
except Exception as e:
    print(f"Connection failed: {e}")
    traceback.print_exc()
