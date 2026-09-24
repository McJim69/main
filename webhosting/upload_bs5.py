import paramiko
import os

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)
sftp = client.open_sftp()

base_local = r'd:\Server\www\vendor\bootstrap'
base_remote = '/usr/local/lsws/Example/html/vendor/bootstrap'

files = [
    ('css/bootstrap.min.css', 'css/bootstrap.min.css'),
    ('css/bootstrap.css', 'css/bootstrap.css'),
    ('js/bootstrap.bundle.min.js', 'js/bootstrap.bundle.min.js'),
    ('js/bootstrap.bundle.js', 'js/bootstrap.bundle.js'),
]

for local_rel, remote_rel in files:
    local_path = os.path.join(base_local, local_rel.replace('/', '\\'))
    remote_path = f"{base_remote}/{remote_rel}"
    print(f"Uploading {local_rel}...")
    sftp.put(local_path, remote_path)
    print(f"  Done -> {remote_path}")

sftp.close()
client.close()
print("\nAll Bootstrap 5 files uploaded!")
