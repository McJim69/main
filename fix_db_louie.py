import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.51', username='root', password='McJim654123')

cmd_lou = """
find /home/louiecaraircon.com/public_html -name "connect.php" -o -name "config.php" | while read f; do
    sed -i "s/'louie_db'/'louie_car'/g" "$f"
    sed -i 's/"louie_db"/"louie_car"/g' "$f"
    sed -i "s/'server'/'louie_car'/g" "$f"
    sed -i 's/"server"/"louie_car"/g' "$f"
done
"""
stdin, stdout, stderr = ssh.exec_command(cmd_lou)
stdout.channel.recv_exit_status()

print("Done")
ssh.close()
