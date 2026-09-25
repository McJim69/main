import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

cmd = """
# Dump from 111
mysqldump -h 10.0.10.111 -u McJim -pRestricted654123 zdsfreewifi > /root/zdsfreewifi.sql
mysqldump -h 10.0.10.111 -u McJim -pRestricted654123 inventory > /root/inventory.sql
mysqldump -h 10.0.10.111 -u McJim -pRestricted654123 guestcounter > /root/guestcounter.sql

# Dump from 200
mysqldump -h 10.0.10.200 -u McJim -pRestricted654123 louie_car > /root/louie_car.sql

# Create DBs locally
mysql -e "CREATE DATABASE IF NOT EXISTS zdsfreewifi;"
mysql -e "CREATE DATABASE IF NOT EXISTS inventory;"
mysql -e "CREATE DATABASE IF NOT EXISTS guestcounter;"
mysql -e "CREATE DATABASE IF NOT EXISTS louie_car;"

# Import locally
mysql zdsfreewifi < /root/zdsfreewifi.sql
mysql inventory < /root/inventory.sql
mysql guestcounter < /root/guestcounter.sql
mysql louie_car < /root/louie_car.sql

# Grant privileges to the cyberpanel users we created!
mysql -e "GRANT ALL PRIVILEGES ON zdsfreewifi.* TO 'victory_usr'@'localhost';"
mysql -e "GRANT ALL PRIVILEGES ON inventory.* TO 'victory_usr'@'localhost';"
mysql -e "GRANT ALL PRIVILEGES ON guestcounter.* TO 'victory_usr'@'localhost';"
mysql -e "GRANT ALL PRIVILEGES ON louie_car.* TO 'louie_usr'@'localhost';"

# Also Louie uses louie_car inside Victory for some reason? Let's just grant it to both just in case!
mysql -e "GRANT ALL PRIVILEGES ON louie_car.* TO 'victory_usr'@'localhost';"

mysql -e "FLUSH PRIVILEGES;"
"""
print("Starting database migration...")
stdin, stdout, stderr = ssh.exec_command(cmd)
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())
ssh.close()
