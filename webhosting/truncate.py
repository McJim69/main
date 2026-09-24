import os

file_path = r'd:\Server\www\webhosting.html'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Truncate .00
content = content.replace('.00</span>', '</span>')
# Truncate the ext (.com to com)? No, usually TLDs include the dot. But maybe "truncate ext" means remove the dot?
# "Truncate ext and price" -> let's remove the dot!
content = content.replace('<span class="tld">.com</span>', '<span class="tld">com</span>')
content = content.replace('<span class="tld">.net</span>', '<span class="tld">net</span>')
content = content.replace('<span class="tld">.org</span>', '<span class="tld">org</span>')
content = content.replace('<span class="tld">.io</span>', '<span class="tld">io</span>')
content = content.replace('<span class="tld">.co</span>', '<span class="tld">co</span>')
content = content.replace('<span class="tld">.ph</span>', '<span class="tld">ph</span>')
content = content.replace('<span class="tld">.dev</span>', '<span class="tld">dev</span>')
content = content.replace('<span class="tld">.tech</span>', '<span class="tld">tech</span>')

# Also update styles if needed
with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)
print("Truncated webhosting.html")
