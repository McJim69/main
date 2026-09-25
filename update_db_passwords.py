import paramiko
import random
import string
import re

def gen_pass(length=16):
    chars = string.ascii_letters + string.digits
    return ''.join(random.choice(chars) for _ in range(length))

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

louie_pass = gen_pass()
victory_pass = gen_pass()

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    
    # Change DB Passwords on CyberPanel (assuming the DBs were already created)
    # The CLI might not have changeDatabasePassword, wait. Let's just use mysql to set the password directly!
    mysql_cmd_louie = f"mysql -e \"ALTER USER 'louie_usr'@'localhost' IDENTIFIED BY '{louie_pass}';\""
    ssh.exec_command(mysql_cmd_louie)
    
    mysql_cmd_victory = f"mysql -e \"ALTER USER 'victory_usr'@'localhost' IDENTIFIED BY '{victory_pass}';\""
    ssh.exec_command(mysql_cmd_victory)
    
    sftp = ssh.open_sftp()
    
    # Update Louie config
    try:
        louie_conf = '/home/louiecaraircon.com/public_html/config.php'
        f = sftp.file(louie_conf, 'r')
        data = f.read().decode('utf-8')
        f.close()
        
        data = re.sub(r"define\('DB_USER',\s*'.*?'\);", f"define('DB_USER', 'louie_usr');", data)
        data = re.sub(r"define\('DB_PASS',\s*'.*?'\);", f"define('DB_PASS', '{louie_pass}');", data)
        data = re.sub(r"define\('DB_NAME',\s*'.*?'\);", f"define('DB_NAME', 'louie_db');", data)
        
        f = sftp.file(louie_conf, 'w')
        f.write(data)
        f.close()
        print("Updated Louie DB config.")
    except Exception as e:
        print(f"Failed to update Louie config: {e}")
        
    # Update Victory config
    try:
        victory_conf = '/home/victoryfreewifi.net/public_html/connect.php'
        f = sftp.file(victory_conf, 'r')
        data = f.read().decode('utf-8')
        f.close()
        
        data = re.sub(r"define\('DB_USERNAME',\s*'.*?'\);", f"define('DB_USERNAME', 'victory_usr');", data)
        data = re.sub(r"define\('DB_PASSWORD',\s*'.*?'\);", f"define('DB_PASSWORD', '{victory_pass}');", data)
        data = re.sub(r"define\('DB_NAME',\s*'.*?'\);", f"define('DB_NAME', 'victory_db');", data)
        
        f = sftp.file(victory_conf, 'w')
        f.write(data)
        f.close()
        print("Updated Victory DB config.")
    except Exception as e:
        print(f"Failed to update Victory config: {e}")

    sftp.close()
    
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
