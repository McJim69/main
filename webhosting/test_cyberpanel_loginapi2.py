import urllib.request
import urllib.parse
import ssl

context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

url = "https://10.0.10.51:8090/api/loginAPI"
data = urllib.parse.urlencode({
    'username': 'admin',
    'password': 'R3str1ct3d@1991' 
}).encode('utf-8')

class NoRedirectHandler(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None

opener = urllib.request.build_opener(NoRedirectHandler)
urllib.request.install_opener(opener)

try:
    req = urllib.request.Request(url, data=data, method='POST')
    with urllib.request.urlopen(req, context=context) as response:
        print("Status:", response.getcode())
        print("Response:", response.read().decode('utf-8'))
        print("Headers:", response.headers)
except urllib.error.HTTPError as e:
    print("HTTP Error:", e.code)
    print("Headers:", e.headers)
    print("Response:", e.read().decode('utf-8'))
except Exception as e:
    print("Error:", e)
