import urllib.request
import re
import os

# Make sure dirs exist
os.makedirs(r'd:\Server\www\webhosting\assets\fonts', exist_ok=True)
os.makedirs(r'd:\Server\www\webhosting\assets\css', exist_ok=True)

# Read the downloaded font CSS
with open(r'd:\Server\www\webhosting\fonts_temp.css', 'r') as f:
    css = f.read()

# Find all font file URLs
font_urls = re.findall(r'url\((https://fonts\.gstatic\.com/[^)]+)\)', css)
print(f"Found {len(font_urls)} font URLs")

url_map = {}
for url in font_urls:
    filename = url.split('/')[-1].split('?')[0]
    local_path = f'd:\\Server\\www\\webhosting\\assets\\fonts\\{filename}'
    if not os.path.exists(local_path):
        print(f"Downloading {filename}...")
        urllib.request.urlretrieve(url, local_path)
    url_map[url] = f'/webhosting/assets/fonts/{filename}'

# Replace all URLs in CSS
for remote_url, local_url in url_map.items():
    css = css.replace(f'url({remote_url})', f'url({local_url})')

# Write the self-hosted fonts CSS
with open(r'd:\Server\www\webhosting\assets\css\fonts.css', 'w') as f:
    f.write(css)

print(f"\nDone! Downloaded {len(url_map)} font files.")
print("Fonts CSS written to assets/css/fonts.css")
