import paramiko, time

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=30)

# Check existing cert
stdin, stdout, stderr = client.exec_command("ls -la ~/.acme.sh/louiecaraircon.com_ecc/")
print("Existing cert:", stdout.read().decode('utf-8', errors='replace'))

# Issue/renew via acme.sh with webroot
print("\n=== Issuing SSL ===")
cmd = (
    "~/.acme.sh/acme.sh --issue "
    "-d louiecaraircon.com -d www.louiecaraircon.com "
    "--webroot /usr/local/lsws/conf/vhosts/louiecaraircon.com/html "
    "--server letsencrypt "
    "--force 2>&1"
)
stdin, stdout, stderr = client.exec_command(cmd, timeout=120)
time.sleep(30)
out = stdout.read().decode('utf-8', errors='replace')
print("OUT:", out[-2000:])

client.close()
