import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

local_path = r'd:\Server\www\webhosting_template.zip'
remote_path = '/usr/local/CyberCP/webhosting_template.zip'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

sftp = ssh.open_sftp()
sftp.put(local_path, remote_path)
sftp.close()

stdin, stdout, stderr = ssh.exec_command('rm -rf /usr/local/CyberCP/webhosting_template && unzip -o /usr/local/CyberCP/webhosting_template.zip -d /usr/local/CyberCP/webhosting_template')
print("Unzip Output:", stdout.read().decode())
print("Unzip Error:", stderr.read().decode())

# Now patch vhost.py
patch_cmd = """
sed -i 's|shutil.copy("/usr/local/CyberCP/index.html", f"/home/{virtualHostName}/public_html/index.html")|subprocess.call(shlex.split(f"cp -r /usr/local/CyberCP/webhosting_template/. /home/{virtualHostName}/public_html/"), stdout=FNULL, stderr=subprocess.STDOUT)|g' /usr/local/CyberCP/plogical/vhost.py

sed -i 's|command = f"chown {virtualHostUser}:{virtualHostUser} /home/{virtualHostName}/public_html/index.html"|command = f"chown -R {virtualHostUser}:{virtualHostUser} /home/{virtualHostName}/public_html"|g' /usr/local/CyberCP/plogical/vhost.py
"""

stdin, stdout, stderr = ssh.exec_command(patch_cmd)
print("Patch Output:", stdout.read().decode())
print("Patch Error:", stderr.read().decode())

ssh.close()
