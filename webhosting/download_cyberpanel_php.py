import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.50', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('cat /var/www/html/billing/library/Server/Manager/CyberPanel.php')
out = stdout.read().decode('utf-8')
with open(r'd:\Server\www\webhosting\CyberPanel.php', 'w', encoding='utf-8') as f:
    f.write(out)
