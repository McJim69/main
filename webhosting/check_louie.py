import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('ls -ld /home/louiecaraircon.com')
out = stdout.read().decode('utf-8')
err = stderr.read().decode('utf-8')

if out:
    print("Found domain folder:")
    print(out)
else:
    print("Domain folder not found.")
    
if err:
    print("Error:", err)
    
# Let's also check if there is a CyberPanel log for this creation recently
stdin, stdout, stderr = client.exec_command('cat /var/log/cyberpanel/main.log | grep "louiecaraircon.com" | tail -n 10')
out_log = stdout.read().decode('utf-8')
if out_log:
    print("Recent logs for this domain:")
    print(out_log)
