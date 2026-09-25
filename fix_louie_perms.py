import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    ssh.connect(host, username=user, password=password)
    # Get owner of the domain folder
    stdin, stdout, stderr = ssh.exec_command("stat -c '%U:%G' /home/louiecaraircon.com")
    owner = stdout.read().decode().strip()
    if owner and 'no such file' not in owner.lower():
        print(f"Owner is {owner}. Fixing permissions for public_html...")
        ssh.exec_command(f"chown -R {owner} /home/louiecaraircon.com/public_html")
        print("Permissions fixed.")
    else:
        print("Could not determine owner.")
except Exception as e:
    print(f"Error: {e}")
finally:
    ssh.close()
