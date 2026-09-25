import paramiko
import re

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    
    print("Mounting CIFS share...")
    ssh.exec_command('mkdir -p /mnt/victory')
    stdin, stdout, stderr = ssh.exec_command('mount -t cifs //10.0.10.111/Server /mnt/victory -o guest,vers=3.0 || mount -t cifs //10.0.10.111/Server /mnt/victory -o guest,vers=2.0')
    err = stderr.read().decode()
    if err:
        print("Mount error:", err)
        
    print("Copying files locally on server...")
    stdin, stdout, stderr = ssh.exec_command('rsync -a --ignore-errors /mnt/victory/www/ /home/victoryfreewifi.net/public_html/')
    stdout.channel.recv_exit_status() # Wait for it to finish
    err = stderr.read().decode()
    if err:
        print("Rsync warnings:", err)
        
    print("Fixing permissions...")
    stdin, stdout, stderr = ssh.exec_command("stat -c '%U:%G' /home/victoryfreewifi.net")
    owner = stdout.read().decode().strip()
    if owner and 'no such file' not in owner.lower():
        ssh.exec_command(f"chown -R {owner} /home/victoryfreewifi.net/public_html")
        
    print("Unmounting...")
    ssh.exec_command('umount /mnt/victory')
    
    print("Migration complete!")
    
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
