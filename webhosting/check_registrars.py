import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("mysql -e 'USE fossbilling; SELECT id, tld, tld_registrar_id FROM tld;'")
print("OUT TLD:\n", stdout.read().decode('utf-8'))

stdin, stdout, stderr = client.exec_command("mysql -e 'USE fossbilling; SELECT id, name FROM tld_registrar;'")
print("OUT REGISTRAR:\n", stdout.read().decode('utf-8'))
