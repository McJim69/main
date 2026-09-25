import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Issue SSL using correct webroot for CyberPanel
script = """
/root/.acme.sh/acme.sh --issue -d victoryfreewifi.net -d www.victoryfreewifi.net -w /usr/local/lsws/Example/html -k ec-256 --server letsencrypt --force
/root/.acme.sh/acme.sh --install-cert -d victoryfreewifi.net --ecc --cert-file /etc/letsencrypt/live/victoryfreewifi.net/cert.pem --key-file /etc/letsencrypt/live/victoryfreewifi.net/privkey.pem --fullchain-file /etc/letsencrypt/live/victoryfreewifi.net/fullchain.pem --reloadcmd "systemctl restart lsws"
"""
stdin, stdout, stderr = ssh.exec_command(script)
sys.stdout.buffer.write(stdout.read())
sys.stdout.buffer.write(stderr.read())

ssh.close()
