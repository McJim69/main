import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    
    print("Downloading tarball via wget...")
    stdin, stdout, stderr = ssh.exec_command('wget -qO /home/victoryfreewifi.net/victory.tar http://10.0.10.7:8000/victory.tar')
    stdout.channel.recv_exit_status()
    
    print("Extracting tarball...")
    ssh.exec_command('tar -xf /home/victoryfreewifi.net/victory.tar -C /home/victoryfreewifi.net/public_html').channel.recv_exit_status()
    
    print("Fixing permissions...")
    stdin, stdout, stderr = ssh.exec_command("stat -c '%U:%G' /home/victoryfreewifi.net")
    owner = stdout.read().decode().strip()
    if owner:
        ssh.exec_command(f"chown -R {owner} /home/victoryfreewifi.net/public_html")
        
    print("Cleaning up...")
    ssh.exec_command('rm /home/victoryfreewifi.net/victory.tar')
    print("Victory Migration complete via wget!")
    
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
