import os
import zipfile

folder = r'd:\Server\www\webhosting'
zip_path = r'd:\Server\www\webhosting_template.zip'

with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zf:
    for root, dirs, files in os.walk(folder):
        for file in files:
            if file.endswith('.py'): continue
            file_path = os.path.join(root, file)
            arcname = os.path.relpath(file_path, folder)
            zf.write(file_path, arcname)

print("Created zip archive.")
