import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

# There's only a css/ folder, no vendor/ on this server
# The main site (Node 2 at 10.0.10.52) is where header.php/footer.php lives
# Let's check Node 2
client.close()

client2 = paramiko.SSHClient()
client2.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client2.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client2.exec_command("find /var/www/html -name 'bootstrap.min.css' 2>/dev/null")
print("CSS:", stdout.read().decode())

stdin, stdout, stderr = client2.exec_command("find /var/www/html -name 'bootstrap.bundle.min.js' 2>/dev/null")
print("JS:", stdout.read().decode())

stdin, stdout, stderr = client2.exec_command("grep -r 'bootstrap' /var/www/html/header.php /var/www/html/footer.php 2>/dev/null")
print("References:", stdout.read().decode())

client2.close()
