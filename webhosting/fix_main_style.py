import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'
remote_file = '/usr/local/lsws/Example/html/assets/css/style.css'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, username=user, password=password, timeout=10)
    
    append_css = """
/* Appended by Agent to fix footer */
body {
    display: flex !important;
    flex-direction: column !important;
}
footer {
    margin-top: auto !important;
}
"""
    
    stdin, stdout, stderr = client.exec_command(f'echo "{append_css}" >> {remote_file}')
    print(stdout.read().decode('utf-8'))
    print(stderr.read().decode('utf-8'))
    
    client.close()
    print("Successfully appended CSS.")
except Exception as e:
    print(f"Error: {e}")
