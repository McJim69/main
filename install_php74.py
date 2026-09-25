import paramiko
import sys
import time

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

print("Installing lsphp74...")
stdin, stdout, stderr = ssh.exec_command('apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y lsphp74 lsphp74-common lsphp74-mysql lsphp74-opcache lsphp74-curl lsphp74-imagick lsphp74-redis lsphp74-memcached lsphp74-intl lsphp74-json lsphp74-sybase')

# wait for command to finish
exit_status = stdout.channel.recv_exit_status()

print("STDOUT:")
print(stdout.read().decode())
print("STDERR:")
print(stderr.read().decode())

ssh.close()
