import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("mysql -e 'USE fossbilling; DESCRIBE service_hosting; SELECT * FROM service_hosting;'")
print("OUT:", stdout.read().decode('utf-8'))
