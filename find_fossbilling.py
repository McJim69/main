import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

print("Fossbilling in victoryfreewifi.net:")
stdin, stdout, stderr = ssh.exec_command("find /home/victoryfreewifi.net/public_html -name '*fossbilling*'")
print(stdout.read().decode())

ssh.close()
