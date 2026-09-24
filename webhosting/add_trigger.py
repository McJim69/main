import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

sql = """
mysql -u root cyberpanel -e "
DROP TRIGGER IF EXISTS set_api_true;
DELIMITER //
CREATE TRIGGER set_api_true BEFORE INSERT ON loginSystem_administrator
FOR EACH ROW
BEGIN
    SET NEW.api = 1;
END;//
DELIMITER ;
"
"""

stdin, stdout, stderr = client.exec_command(sql)
print("OUT:", stdout.read().decode('utf-8'))
print("ERR:", stderr.read().decode('utf-8'))

# update existing users
stdin, stdout, stderr = client.exec_command('mysql -u root cyberpanel -e "UPDATE loginSystem_administrator SET api=1;"')
print("UPDATE OUT:", stdout.read().decode('utf-8'))
print("UPDATE ERR:", stderr.read().decode('utf-8'))
