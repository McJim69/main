import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

sftp = client.open_sftp()

# --- Fix menunav.php ---
# Revert the BS4 dropdown-toggle we set earlier → back to BS5
with sftp.file('/usr/local/lsws/Example/html/menunav.php', 'r') as f:
    nav = f.read().decode('utf-8')

# Navbar toggler: change BS4 data-toggle/data-target → BS5 data-bs-toggle/data-bs-target
nav = nav.replace(
    'data-toggle="collapse" data-target="#navbarResponsive"',
    'data-bs-toggle="collapse" data-bs-target="#navbarResponsive"'
)
# User dropdown toggle: change BS4 data-toggle → BS5 data-bs-toggle
nav = nav.replace(
    'data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"',
    'data-bs-toggle="dropdown" aria-expanded="false"'
)

with sftp.file('/usr/local/lsws/Example/html/menunav.php', 'w') as f:
    f.write(nav)

print("menunav.php fixed")

# --- Fix footer.php: keep jQuery for custom.js/slick but it's optional ---
# Check if jQuery is still needed by other scripts (slick, accordions use it)
# We will leave jQuery in footer for now as slick.js depends on it
# Just confirm bootstrap.bundle.min.js is the right path
with sftp.file('/usr/local/lsws/Example/html/footer.php', 'r') as f:
    footer = f.read().decode('utf-8')

print("footer.php jQuery present:", 'jquery.js' in footer)
print("footer.php bootstrap present:", 'bootstrap.bundle.min.js' in footer)

sftp.close()
client.close()
