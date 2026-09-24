import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("systemctl status named 2>/dev/null | head -5; systemctl status pdns 2>/dev/null | head -5; systemctl status dnsmasq 2>/dev/null | head -5")
print("DNS services:", stdout.read().decode())

stdin, stdout, stderr = client.exec_command("ss -tulnp | grep ':53 '")
print("Port 53:", stdout.read().decode())

stdin, stdout, stderr = client.exec_command("curl -s ifconfig.me 2>/dev/null || wget -qO- ifconfig.me")
print("Public IP:", stdout.read().decode())

client.close()
