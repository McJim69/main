import paramiko

def check_server(host, user, password):
    client = paramiko.SSHClient()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        client.connect(host, username=user, password=password, timeout=10)
        print(f"--- Searching on {host} ---")
        stdin, stdout, stderr = client.exec_command('find /home /var/www /usr/local/lsws -name "webhosting.html" 2>/dev/null')
        print(stdout.read().decode('utf-8'))
        client.close()
    except Exception as e:
        print(f"Error on {host}: {e}")

check_server('10.0.10.51', 'root', 'McJim654123')
check_server('10.0.10.52', 'root', 'McJim654123')
