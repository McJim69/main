import urllib.request
import urllib.parse
import ssl

context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

url = "https://10.0.10.51:8090/api/loginAPI"
data = urllib.parse.urlencode({
    'username': 'louieca8',
    'password': 'password_placeholder' # Wait I don't know the password
}).encode('utf-8')

# I don't know the password, but if admin.api is false, it checks api BEFORE checking password!
# Look at the code:
# if not admin.api or admin.state != 'ACTIVE': return 401 "Could not authorize access to API"
# So any password will trigger the API error IF api is false!

try:
    req = urllib.request.Request(url, data=data, method='POST')
    with urllib.request.urlopen(req, context=context) as response:
        print("Status:", response.getcode())
        print("Response:", response.read().decode('utf-8'))
except urllib.error.HTTPError as e:
    print("HTTP Error:", e.code)
    print("Response:", e.read().decode('utf-8'))
except Exception as e:
    print("Error:", e)
