import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

victory_pass = '1g8qR5XzEWM5eQLP'
louie_pass = 'E6tJIn1EU4lBrpgJ'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

cmd = f"""
# Create users explicitly if they don't exist for both localhost and 127.0.0.1
mysql -e "CREATE USER IF NOT EXISTS 'victory_usr'@'localhost' IDENTIFIED BY '{victory_pass}';"
mysql -e "CREATE USER IF NOT EXISTS 'victory_usr'@'127.0.0.1' IDENTIFIED BY '{victory_pass}';"

mysql -e "CREATE USER IF NOT EXISTS 'louie_usr'@'localhost' IDENTIFIED BY '{louie_pass}';"
mysql -e "CREATE USER IF NOT EXISTS 'louie_usr'@'127.0.0.1' IDENTIFIED BY '{louie_pass}';"

# Set passwords in case they are wrong
mysql -e "ALTER USER 'victory_usr'@'localhost' IDENTIFIED BY '{victory_pass}';"
mysql -e "ALTER USER 'victory_usr'@'127.0.0.1' IDENTIFIED BY '{victory_pass}';"
mysql -e "ALTER USER 'louie_usr'@'localhost' IDENTIFIED BY '{louie_pass}';"
mysql -e "ALTER USER 'louie_usr'@'127.0.0.1' IDENTIFIED BY '{louie_pass}';"

# Grant privileges
for host in ['localhost', '127.0.0.1']:
    for db in ['zdsfreewifi', 'inventory', 'guestcounter', 'louie_car']:
        mysql -e "GRANT ALL PRIVILEGES ON ${{db}}.* TO 'victory_usr'@'${{host}}';"
    
    mysql -e "GRANT ALL PRIVILEGES ON louie_car.* TO 'louie_usr'@'${{host}}';"

mysql -e "FLUSH PRIVILEGES;"
"""
# Rewrite the loop to raw bash
cmd = f"""
mysql -e "ALTER USER 'victory_usr'@'localhost' IDENTIFIED BY '{victory_pass}';"
mysql -e "ALTER USER 'victory_usr'@'127.0.0.1' IDENTIFIED BY '{victory_pass}';"
mysql -e "ALTER USER 'louie_usr'@'localhost' IDENTIFIED BY '{louie_pass}';"
mysql -e "ALTER USER 'louie_usr'@'127.0.0.1' IDENTIFIED BY '{louie_pass}';"

for h in "localhost" "127.0.0.1"; do
  mysql -e "GRANT ALL PRIVILEGES ON zdsfreewifi.* TO 'victory_usr'@'$h';"
  mysql -e "GRANT ALL PRIVILEGES ON inventory.* TO 'victory_usr'@'$h';"
  mysql -e "GRANT ALL PRIVILEGES ON guestcounter.* TO 'victory_usr'@'$h';"
  mysql -e "GRANT ALL PRIVILEGES ON louie_car.* TO 'victory_usr'@'$h';"
  mysql -e "GRANT ALL PRIVILEGES ON louie_car.* TO 'louie_usr'@'$h';"
done

mysql -e "FLUSH PRIVILEGES;"
"""

stdin, stdout, stderr = ssh.exec_command(cmd)
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())

ssh.close()
