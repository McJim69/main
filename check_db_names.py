import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

print("Victory DB Names:")
stdin, stdout, stderr = ssh.exec_command("grep -rn 'DB_NAME' /home/victoryfreewifi.net/public_html/")
print(stdout.read().decode())

print("Louie DB Names:")
stdin, stdout, stderr = ssh.exec_command("grep -rn 'DB_NAME' /home/louiecaraircon.com/public_html/")
print(stdout.read().decode())

ssh.close()
