import re
import time

html_file = r'd:\Server\www\webhosting.html'
with open(html_file, 'r', encoding='utf-8') as f:
    content = f.read()

cb = str(int(time.time()))

# replace styles.css?v=X with styles.css?v=TIMESTAMP
content = re.sub(r'styles\.css\?v=\d+', f'styles.css?v={cb}', content)
# if styles.css didn't have v=X, replace styles.css" with styles.css?v=TIMESTAMP"
content = re.sub(r'styles\.css"', f'styles.css?v={cb}"', content)

content = re.sub(r'script\.js\?v=\d+', f'script.js?v={cb}', content)
content = re.sub(r'script\.js"', f'script.js?v={cb}"', content)

with open(html_file, 'w', encoding='utf-8') as f:
    f.write(content)

print(f"Added cache buster v={cb}")
