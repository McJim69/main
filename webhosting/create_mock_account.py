import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    print("Creating mock website test-mcjim.com...")
    # Create the website
    # Usage: cyberpanel createWebsite --package Default --owner admin --domainName test-mcjim.com --email admin@test-mcjim.com --php 8.1
    stdin, stdout, stderr = client.exec_command('cyberpanel createWebsite --package Default --owner admin --domainName test-mcjim.com --email admin@test-mcjim.com --php 8.1')
    out = stdout.read().decode('utf-8')
    err = stderr.read().decode('utf-8')
    print("STDOUT:", out)
    if err:
        print("STDERR:", err)
        
    client.close()
except Exception as e:
    print(f"Error: {e}")
