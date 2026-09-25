import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    
    print("Downloading tarball via wget...")
    # Add --no-verbose so we don't spam but can see errors, and don't use -q
    stdin, stdout, stderr = ssh.exec_command('wget --show-progress -O /home/victoryfreewifi.net/victory.tar http://10.0.10.7:8000/victory.tar')
    exit_status = stdout.channel.recv_exit_status()
    
    if exit_status != 0:
        print("Wget failed:")
        print(stderr.read().decode())
        print(stdout.read().decode())
    else:
        print("Wget succeeded. Size:")
        stdin, stdout, stderr = ssh.exec_command('ls -lh /home/victoryfreewifi.net/victory.tar')
        print(stdout.read().decode())
        
        print("Extracting tarball...")
        stdin, stdout, stderr = ssh.exec_command('tar -xf /home/victoryfreewifi.net/victory.tar -C /home/victoryfreewifi.net/public_html')
        exit_status = stdout.channel.recv_exit_status()
        
        if exit_status != 0:
            print("Tar failed:")
            print(stderr.read().decode())
        else:
            print("Fixing permissions...")
            stdin, stdout, stderr = ssh.exec_command("stat -c '%U:%G' /home/victoryfreewifi.net")
            owner = stdout.read().decode().strip()
            if owner:
                ssh.exec_command(f"chown -R {owner} /home/victoryfreewifi.net/public_html").channel.recv_exit_status()
                
            print("Cleaning up...")
            ssh.exec_command('rm -f /home/victoryfreewifi.net/victory.tar')
            print("Victory Migration complete via wget!")
    
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
