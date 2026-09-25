import paramiko
import os

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password, timeout=30)
    sftp = ssh.open_sftp()
    
    local_file = 'd:\\Server\\www\\victory.tar.gz'
    remote_file = '/home/victoryfreewifi.net/victory.tar.gz'
    
    file_size = os.path.getsize(local_file)
    print(f"Uploading {file_size} bytes...")
    
    sftp.get_channel().settimeout(60.0)
    
    with open(local_file, 'rb') as lf:
        with sftp.file(remote_file, 'wb') as rf:
            rf.set_pipelined(True)
            chunk_size = 1024 * 1024  # 1MB chunks
            transferred = 0
            while True:
                data = lf.read(chunk_size)
                if not data:
                    break
                rf.write(data)
                transferred += len(data)
                if transferred % (10 * 1024 * 1024) == 0:
                    print(f"Uploaded {transferred // (1024*1024)}MB", flush=True)
                    
    print("Upload complete! Now extracting...")
    stdin, stdout, stderr = ssh.exec_command('tar -xzf /home/victoryfreewifi.net/victory.tar.gz -C /home/victoryfreewifi.net/public_html')
    exit_status = stdout.channel.recv_exit_status()
    if exit_status != 0:
        print("Extract failed:")
        print(stderr.read().decode())
    else:
        print("Fixing permissions...")
        stdin, stdout, stderr = ssh.exec_command("stat -c '%U:%G' /home/victoryfreewifi.net")
        owner = stdout.read().decode().strip()
        if owner:
            ssh.exec_command(f"chown -R {owner} /home/victoryfreewifi.net/public_html").channel.recv_exit_status()
        ssh.exec_command('rm -f /home/victoryfreewifi.net/victory.tar.gz')
        print("All done!")
    
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
