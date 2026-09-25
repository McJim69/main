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
    
    local_file = 'd:\\Server\\www\\victory.tar'
    remote_file = '/home/victoryfreewifi.net/victory.tar'
    
    file_size = os.path.getsize(local_file)
    print(f"Uploading {file_size} bytes...")
    
    def print_progress(transferred, total):
        if transferred % (10 * 1024 * 1024) == 0:
            print(f"Uploaded {transferred // (1024*1024)}MB / {total // (1024*1024)}MB", flush=True)

    # Increase packet size to max
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
                if transferred % (20 * 1024 * 1024) == 0:
                    print(f"Uploaded {transferred // (1024*1024)}MB", flush=True)
                    
    print("Upload complete!")
    
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
