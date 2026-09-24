import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

commands = [
    'cp /usr/local/lsws/Example/html/webhosting.html /usr/local/lsws/Example/html/index.html',
    'systemctl restart lsws'
]
for cmd in commands:
    client.exec_command(cmd)

print("Updated landing and restarted lsws.")
