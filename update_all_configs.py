import paramiko
import re

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

sftp = ssh.open_sftp()

# Get Victory password
try:
    with sftp.file('/home/victoryfreewifi.net/public_html/connect.php', 'r') as f:
        data = f.read().decode('utf-8')
        victory_pass = re.search(r"define\('DB_PASS',\s*'([^']+)'\)", data).group(1)
except Exception as e:
    print("Could not get Victory password:", e)

# Get Louie password
try:
    with sftp.file('/home/louiecaraircon.com/public_html/config.php', 'r') as f:
        data = f.read().decode('utf-8')
        louie_pass = re.search(r"define\('DB_PASS',\s*'([^']+)'\)", data).group(1)
except Exception as e:
    print("Could not get Louie password:", e)

sftp.close()

# Victory files
victory_files = [
    '/home/victoryfreewifi.net/public_html/inventory/connect.php',
    '/home/victoryfreewifi.net/public_html/eventcounter/connect.php',
    '/home/victoryfreewifi.net/public_html/connect.php',
    '/home/victoryfreewifi.net/public_html/web/connect.php',
    '/home/victoryfreewifi.net/public_html/web/config.php',
    '/home/victoryfreewifi.net/public_html/hotspotmanager/include/config.php',
    '/home/victoryfreewifi.net/public_html/config.php',
    '/home/victoryfreewifi.net/public_html/admin2/connect.php'
]

# Louie files
louie_files = [
    '/home/louiecaraircon.com/public_html/connect.php',
    '/home/louiecaraircon.com/public_html/config.php',
    '/home/louiecaraircon.com/public_html/admin2/connect.php'
]

def update_file(filepath, new_user, new_pass, new_db):
    try:
        cmd = f"""sed -i "s/'McJim'/'{new_user}'/g" {filepath}"""
        ssh.exec_command(cmd).channel.recv_exit_status()
        
        cmd = f"""sed -i "s/'Restricted654123'/'{new_pass}'/g" {filepath}"""
        ssh.exec_command(cmd).channel.recv_exit_status()
        
        cmd = f"""sed -i "s/'server'/'{new_db}'/g" {filepath}"""
        ssh.exec_command(cmd).channel.recv_exit_status()
        
        # In case they use different DB names or variables locally, let's also force DB_USER regex match
        cmd = f"""sed -i "s/define('DB_USER', '.*');/define('DB_USER', '{new_user}');/g" {filepath}"""
        ssh.exec_command(cmd).channel.recv_exit_status()
        cmd = f"""sed -i "s/define('DB_PASS', '.*');/define('DB_PASS', '{new_pass}');/g" {filepath}"""
        ssh.exec_command(cmd).channel.recv_exit_status()
        cmd = f"""sed -i "s/define('DB_NAME', '.*');/define('DB_NAME', '{new_db}');/g" {filepath}"""
        ssh.exec_command(cmd).channel.recv_exit_status()
        
        print(f"Updated {filepath}")
    except Exception as e:
        print(f"Failed {filepath}: {e}")

for f in victory_files:
    update_file(f, 'victory_usr', victory_pass, 'victory_db')
    
for f in louie_files:
    update_file(f, 'louie_usr', louie_pass, 'louie_db')

ssh.close()
print("All configs updated!")
