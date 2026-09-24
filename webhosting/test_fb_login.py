import urllib.request
import urllib.parse
import json
import ssl

context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

url = "https://10.0.10.52/api/guest/client/login"
data = {
    'email': 'louieca8@gmail.com', # Need the real email, maybe we can just see the response
    'password': 'password123'
}

req = urllib.request.Request(url, data=urllib.parse.urlencode(data).encode('utf-8'), method='POST')
req.add_header('Host', 'billing.mcjim-server.com')

try:
    with urllib.request.urlopen(req, context=context) as response:
        print("Status:", response.status)
        print("Headers:", response.getheaders())
        print("Body:", response.read().decode('utf-8'))
except urllib.error.HTTPError as e:
    print("HTTP Error:", e.code)
    print("Headers:", e.headers)
    print("Body:", e.read().decode('utf-8'))
except Exception as e:
    print("Error:", e)
