import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

victory_pass = '1g8qR5XzEWM5eQLP'
louie_pass = 'E6tJIn1EU4lBrpgJ'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Replace for Victory
cmd_vic = f"""
find /home/victoryfreewifi.net/public_html -name "connect.php" -o -name "config.php" | while read f; do
    sed -i "s/'McJim'/'victory_usr'/g" "$f"
    sed -i 's/"McJim"/"victory_usr"/g' "$f"
    sed -i "s/'Restricted654123'/'{victory_pass}'/g" "$f"
    sed -i 's/"Restricted654123"/"{victory_pass}"/g' "$f"
    sed -i "s/'server'/'victory_db'/g" "$f"
    sed -i 's/"server"/"victory_db"/g' "$f"
done
"""
ssh.exec_command(cmd_vic).channel.recv_exit_status()

# Replace for Louie
cmd_lou = f"""
find /home/louiecaraircon.com/public_html -name "connect.php" -o -name "config.php" | while read f; do
    sed -i "s/'McJim'/'louie_usr'/g" "$f"
    sed -i 's/"McJim"/"louie_usr"/g' "$f"
    sed -i "s/'Restricted654123'/'{louie_pass}'/g" "$f"
    sed -i 's/"Restricted654123"/"{louie_pass}"/g' "$f"
    sed -i "s/'server'/'louie_db'/g" "$f"
    sed -i 's/"server"/"louie_db"/g' "$f"
done
"""
ssh.exec_command(cmd_lou).channel.recv_exit_status()

print("All done!")
ssh.close()
