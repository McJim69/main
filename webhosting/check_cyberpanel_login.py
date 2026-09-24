import urllib.request
import ssl

context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

try:
    url = "https://10.0.10.51:8090/loginSystem/login"
    req = urllib.request.Request(url)
    with urllib.request.urlopen(req, context=context) as response:
        html = response.read().decode('utf-8')
        
        # simple grep for input names and form action
        for line in html.split('\n'):
            if '<form' in line or 'name="username"' in line or 'name="password"' in line or 'type="password"' in line:
                print(line.strip())
except Exception as e:
    print("Error:", e)
