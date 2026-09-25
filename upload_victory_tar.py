import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
tar_file = r'd:\Server\www\victory.tar'
remote_tar = '/home/victoryfreewifi.net/victory.tar'
remote_dir = '/home/victoryfreewifi.net/public_html'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    print(f"Connecting to {host}...")
    ssh.connect(host, username=user, password=password)
    sftp = ssh.open_sftp()
    
    print(f"Uploading tarball to {remote_tar}...")
    sftp.put(tar_file, remote_tar)
    
    print("Extracting tarball on server...")
    stdin, stdout, stderr = ssh.exec_command(f'tar -xf {remote_tar} -C {remote_dir}')
    stdout.channel.recv_exit_status() # wait for it
    err = stderr.read().decode()
    if err:
        print("Tar extraction warnings:", err)
        
    print("Cleaning up tarball...")
    ssh.exec_command(f'rm {remote_tar}')
    
    print("Fixing permissions...")
    stdin, stdout, stderr = ssh.exec_command("stat -c '%U:%G' /home/victoryfreewifi.net")
    owner = stdout.read().decode().strip()
    if owner and 'no such file' not in owner.lower():
        ssh.exec_command(f"chown -R {owner} {remote_dir}")
        
    print("Victory Migration complete!")
    
except Exception as e:
    print(f"Error: {e}")
finally:
    try:
        sftp.close()
    except: pass
    ssh.close()
