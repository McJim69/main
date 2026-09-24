import paramiko, sys

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("ss -tulnp | grep ':53 '")
print("Port 53:", stdout.read().decode('utf-8', errors='replace'))

stdin, stdout, stderr = client.exec_command("systemctl is-active named pdns dnsmasq 2>/dev/null")
print("DNS active:", stdout.read().decode('utf-8', errors='replace'))

stdin, stdout, stderr = client.exec_command("curl -s --max-time 3 ifconfig.me 2>/dev/null")
print("Public IP:", stdout.read().decode('utf-8', errors='replace').strip())

client.close()
