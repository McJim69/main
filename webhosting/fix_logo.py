import re

html_file = r'd:\Server\www\webhosting.html'
with open(html_file, 'r', encoding='utf-8') as f:
    content = f.read()

target = '''<a href="index.php" class="logo">
				<img src="images/logo2.webp" height="40">
			</a>'''
replacement = '<a href="index.php" class="logo">McJim<span class="gradient-text">Server</span></a>'

content = content.replace(target, replacement)

# Let's also make sure to use cache buster v=4 for styles.css so changes are applied.
content = content.replace('styles.css?v=3', 'styles.css?v=4')

with open(html_file, 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated logo locally.")
