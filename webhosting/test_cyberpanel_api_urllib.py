import urllib.request
import urllib.error
import json
import ssl

url = "https://10.0.10.51:8090/api/verifyLogin"
payload = json.dumps({
    "adminUser": "admin",
    "adminPass": "R3str1ct3d@1991"
}).encode('utf-8')

headers = {
    'Content-Type': 'application/json'
}

context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

req = urllib.request.Request(url, data=payload, headers=headers, method='POST')

try:
    print("Testing CyberPanel API Connection...")
    with urllib.request.urlopen(req, context=context, timeout=10) as response:
        print("Status Code:", response.getcode())
        print("Response:", response.read().decode('utf-8'))
except urllib.error.URLError as e:
    print("Error connecting to API:", e)
