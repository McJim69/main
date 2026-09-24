import paramiko, time

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

# CyberPanel has its own SSL issuance tool
print("=== Issuing SSL via CyberPanel CLI ===")
stdin, stdout, stderr = client.exec_command(
    "python3 /usr/local/CyberCP/plogical/acmeHandler.py --type 1 --domain louiecaraircon.com 2>&1",
    timeout=120
)
time.sleep(5)
out = stdout.read().decode('utf-8', errors='replace')
err = stderr.read().decode('utf-8', errors='replace')
print("OUT:", out[:1000])
print("ERR:", err[:500])

client.close()
