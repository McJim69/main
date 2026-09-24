import os, shutil, paramiko

html_path = r'd:\Server\www\webhosting.html'
index_path = r'd:\Server\www\webhosting\index.php'

old_cdn_block = """    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">"""

new_local_block = """    <!-- Self-hosted Fonts -->
    <link rel="stylesheet" href="/webhosting/assets/css/fonts.css">"""

# Fix webhosting.html
with open(html_path, 'r', encoding='utf-8') as f:
    content = f.read()

if 'fonts.googleapis.com' in content:
    content = content.replace(old_cdn_block, new_local_block)
    with open(html_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print("webhosting.html: fonts updated")
else:
    print("webhosting.html: already local or pattern not found")

# Fix index.php
with open(index_path, 'r', encoding='utf-8') as f:
    content2 = f.read()

if 'fonts.googleapis.com' in content2:
    content2 = content2.replace(old_cdn_block, new_local_block)
    with open(index_path, 'w', encoding='utf-8') as f:
        f.write(content2)
    print("index.php: fonts updated")
else:
    print("index.php: already local or pattern not found")

print("\nNow uploading to production...")

# Upload to Node 1
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)
sftp = client.open_sftp()

# Create remote dirs
client.exec_command("mkdir -p /usr/local/lsws/Example/html/webhosting/assets/fonts")
client.exec_command("mkdir -p /usr/local/lsws/Example/html/webhosting/assets/css")
import time; time.sleep(1)

# Upload fonts.css
sftp.put(r'd:\Server\www\webhosting\assets\css\fonts.css',
         '/usr/local/lsws/Example/html/webhosting/assets/css/fonts.css')
print("Uploaded fonts.css")

# Upload all font files
font_dir_local = r'd:\Server\www\webhosting\assets\fonts'
font_dir_remote = '/usr/local/lsws/Example/html/webhosting/assets/fonts'
for fname in os.listdir(font_dir_local):
    sftp.put(os.path.join(font_dir_local, fname), f'{font_dir_remote}/{fname}')
    print(f"  Uploaded font: {fname}")

# Upload updated webhosting.html
sftp.put(html_path, '/usr/local/lsws/Example/html/webhosting.html')
print("Uploaded webhosting.html")

sftp.close()
client.close()
print("\nAll done!")
