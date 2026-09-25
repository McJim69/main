import paramiko
import os
import math
import time

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
local_file = 'd:\\Server\\www\\victory.tar.gz'
remote_dir = '/home/victoryfreewifi.net/'
chunk_size = 50 * 1024 * 1024 # 50MB

def upload_chunk(chunk_id, data):
    remote_file = f"{remote_dir}victory.tar.gz.part{chunk_id}"
    print(f"Uploading part {chunk_id} ({len(data)} bytes)...")
    
    # Connect fresh for each chunk
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(host, username=user, password=password, timeout=30)
    
    try:
        sftp = ssh.open_sftp()
        with sftp.file(remote_file, 'wb') as rf:
            rf.set_pipelined(True)
            # Write in 1MB chunks internally
            for i in range(0, len(data), 1024 * 1024):
                rf.write(data[i:i + 1024 * 1024])
        sftp.close()
    finally:
        ssh.close()
        
    print(f"Part {chunk_id} done.")

with open(local_file, 'rb') as f:
    file_data = f.read()

total_chunks = math.ceil(len(file_data) / chunk_size)

for i in range(total_chunks):
    start = i * chunk_size
    end = start + chunk_size
    data = file_data[start:end]
    retries = 3
    while retries > 0:
        try:
            upload_chunk(i, data)
            break
        except Exception as e:
            print(f"Failed chunk {i}: {e}. Retries left: {retries}")
            retries -= 1
            time.sleep(2)
    if retries == 0:
        print(f"Failed to upload chunk {i} completely!")
        exit(1)

print("All chunks uploaded. Reassembling on server...")
ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password, timeout=30)
try:
    print("Concatenating...")
    ssh.exec_command(f'cat {remote_dir}victory.tar.gz.part* > {remote_dir}victory.tar.gz').channel.recv_exit_status()
    print("Extracting...")
    ssh.exec_command(f'tar -xzf {remote_dir}victory.tar.gz -C {remote_dir}public_html').channel.recv_exit_status()
    print("Fixing permissions...")
    stdin, stdout, stderr = ssh.exec_command(f"stat -c '%U:%G' {remote_dir}")
    owner = stdout.read().decode().strip()
    if owner:
        ssh.exec_command(f"chown -R {owner} {remote_dir}public_html").channel.recv_exit_status()
    print("Cleaning up parts...")
    ssh.exec_command(f'rm -f {remote_dir}victory.tar.gz*')
    print("Migration SUCCESS!")
finally:
    ssh.close()
