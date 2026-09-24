import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("curl -s -k -X POST -d 'username=admin&password=R3str1ct3d%401991' https://127.0.0.1:8090/api/loginAPI -v")
out = stdout.read().decode('utf-8')
err = stderr.read().decode('utf-8')

print("OUT:", out)
print("ERR:", err)

# also test for a user with api=0
stdin, stdout, stderr = client.exec_command("curl -s -k -X POST -d 'username=louieca8&password=R3str1ct3d%401991' https://127.0.0.1:8090/api/loginAPI")
out2 = stdout.read().decode('utf-8')
print("USER OUT:", out2)
