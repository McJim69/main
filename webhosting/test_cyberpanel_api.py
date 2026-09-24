import requests
import json

# CyberPanel API endpoint
url = "https://10.0.10.51:8090/api/verifyLogin"

payload = {
    "adminUser": "admin",
    "adminPass": "R3str1ct3d@1991"
}

headers = {
    'Content-Type': 'application/json'
}

try:
    print("Testing CyberPanel API Connection...")
    response = requests.post(url, data=json.dumps(payload), headers=headers, verify=False, timeout=10)
    print("Status Code:", response.status_code)
    print("Response:", response.text)
except Exception as e:
    print("Error connecting to API:", e)
