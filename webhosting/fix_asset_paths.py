import os, shutil, paramiko, time

# ---- Move local files to correct location ----
os.makedirs(r'd:\Server\www\assets\fonts', exist_ok=True)
os.makedirs(r'd:\Server\www\assets\css', exist_ok=True)

# Move all font files
font_src = r'd:\Server\www\webhosting\assets\fonts'
font_dst = r'd:\Server\www\assets\fonts'
for f in os.listdir(font_src):
    shutil.copy2(os.path.join(font_src, f), os.path.join(font_dst, f))
print("Fonts moved to d:\\Server\\www\\assets\\fonts\\")

# Rewrite fonts.css with correct paths
with open(r'd:\Server\www\webhosting\assets\css\fonts.css', 'r') as f:
    css = f.read()

css = css.replace('/webhosting/assets/fonts/', '/assets/fonts/')

with open(r'd:\Server\www\assets\css\fonts.css', 'w') as f:
    f.write(css)
print("fonts.css written to d:\\Server\\www\\assets\\css\\fonts.css")

# ---- Update HTML references ----
for file_path in [r'd:\Server\www\webhosting.html', r'd:\Server\www\webhosting\index.php']:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    content = content.replace(
        '<link rel="stylesheet" href="/webhosting/assets/css/fonts.css">',
        '<link rel="stylesheet" href="/assets/css/fonts.css">'
    )
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Updated: {file_path}")

# ---- Upload to production Node 1 ----
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)
sftp = client.open_sftp()

client.exec_command("mkdir -p /usr/local/lsws/Example/html/assets/fonts")
client.exec_command("mkdir -p /usr/local/lsws/Example/html/assets/css")
time.sleep(1)

# Upload fonts.css
sftp.put(r'd:\Server\www\assets\css\fonts.css',
         '/usr/local/lsws/Example/html/assets/css/fonts.css')
print("Uploaded assets/css/fonts.css")

# Upload font files
for fname in os.listdir(r'd:\Server\www\assets\fonts'):
    sftp.put(
        os.path.join(r'd:\Server\www\assets\fonts', fname),
        f'/usr/local/lsws/Example/html/assets/fonts/{fname}'
    )
    print(f"  Uploaded: {fname}")

# Upload updated webhosting.html
sftp.put(r'd:\Server\www\webhosting.html',
         '/usr/local/lsws/Example/html/webhosting.html')
print("Uploaded webhosting.html")

sftp.close()
client.close()
print("\nAll done! Paths corrected to /assets/")
