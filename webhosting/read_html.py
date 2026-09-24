import os

file_path = r'd:\Server\www\webhosting.html'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

print(content[:1500])
