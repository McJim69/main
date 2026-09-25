import paramiko

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Fix Victory DB names
cmd_vic = """
find /home/victoryfreewifi.net/public_html -name "connect.php" -o -name "config.php" | while read f; do
    sed -i "s/'victory_db'/'zdsfreewifi'/g" "$f"
    sed -i 's/"victory_db"/"zdsfreewifi"/g' "$f"
    sed -i "s/'server'/'zdsfreewifi'/g" "$f"
    sed -i 's/"server"/"zdsfreewifi"/g' "$f"
done

# Specifically fix guestcounter and inventory which we might have overwritten
sed -i "s/'zdsfreewifi'/'guestcounter'/g" /home/victoryfreewifi.net/public_html/eventcounter/connect.php
sed -i 's/"zdsfreewifi"/"guestcounter"/g' /home/victoryfreewifi.net/public_html/eventcounter/connect.php

sed -i "s/'zdsfreewifi'/'inventory'/g" /home/victoryfreewifi.net/public_html/inventory/connect.php
sed -i 's/"zdsfreewifi"/"inventory"/g' /home/victoryfreewifi.net/public_html/inventory/connect.php

# Specifically fix admin2 which uses louie_car
sed -i "s/'zdsfreewifi'/'louie_car'/g" /home/victoryfreewifi.net/public_html/admin2/connect.php
sed -i 's/"zdsfreewifi"/"louie_car"/g' /home/victoryfreewifi.net/public_html/admin2/connect.php
"""
ssh.exec_command(cmd_vic).channel.recv_exit_status()

# Fix Louie DB names
cmd_lou = """
find /home/louiecaraircon.com/public_html -name "connect.php" -o -name "config.php" | while read f; do
    sed -i "s/'louie_db'/'louie_car'/g" "$f"
    sed -i 's/"louie_db"/"louie_car"/g' "$f"
    sed -i "s/'server'/'louie_car'/g" "$f"
    sed -i 's/"server"/"louie_car"/g' "$f"
done
"""
ssh.exec_command(cmd_lou).channel.recv_exit_status()

print("DB names fixed!")
ssh.close()
