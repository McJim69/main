import urllib.request
import urllib.parse
import json
import ssl
import paramiko

# 1. Update CyberPanel via API
context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

url = "https://10.0.10.51:8090/api/changeUserPassAPI"
new_password = "Louieca8!2026Secure"

data = {
    'adminUser': 'admin',
    'adminPass': 'R3str1ct3d@1991',
    'websiteOwner': 'louieca8',
    'ownerPassword': new_password
}
req = urllib.request.Request(url, data=json.dumps(data).encode('utf-8'), method='POST')
req.add_header('Content-Type', 'application/json')

try:
    with urllib.request.urlopen(req, context=context) as response:
        print("CyberPanel API Response:", response.read().decode('utf-8'))
except Exception as e:
    print("CyberPanel API Error:", e)

# 2. Update FOSSBilling database
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command(f"mysql -e \"USE fossbilling; UPDATE service_hosting SET pass='{new_password}' WHERE username='louieca8';\"")
print("FOSSBilling DB Update OUT:", stdout.read().decode('utf-8'))
print("FOSSBilling DB Update ERR:", stderr.read().decode('utf-8'))
