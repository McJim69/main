import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

# Find CyberPanel SSL tools
stdin, stdout, stderr = client.exec_command("find /usr/local/CyberCP -name '*ssl*' -o -name '*acme*' -o -name '*letsencrypt*' 2>/dev/null | head -20")
print("SSL tools:", stdout.read().decode('utf-8', errors='replace'))

# Check if acme.sh is installed
stdin, stdout, stderr = client.exec_command("ls ~/.acme.sh/ 2>/dev/null || echo 'not found'")
print("acme.sh:", stdout.read().decode('utf-8', errors='replace').strip())

# Check cyberpanel manage scripts
stdin, stdout, stderr = client.exec_command("ls /usr/local/CyberCP/plogical/ | head -30")
print("plogical:", stdout.read().decode('utf-8', errors='replace'))

client.close()
