import urllib.request
import urllib.parse
import json
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

BASE = "https://10.0.10.51:8090"
ADMIN_USER = "admin"
ADMIN_PASS = "McJim654123"
DOMAIN = "louiecaraircon.com"
SERVER_IP = "180.193.203.22"

def post(endpoint, data):
    url = f"{BASE}{endpoint}"
    payload = json.dumps(data).encode('utf-8')
    req = urllib.request.Request(url, data=payload, method='POST')
    req.add_header('Content-Type', 'application/json')
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=10) as r:
            body = r.read().decode('utf-8', errors='replace')
            try:
                return json.loads(body)
            except:
                return body[:300]
    except urllib.error.HTTPError as e:
        return f"HTTP {e.code}: {e.read().decode('utf-8', errors='replace')[:200]}"
    except Exception as e:
        return f"ERR: {e}"

# CyberPanel uses /cloudAPI/ endpoints
print("=== Creating DNS Zone ===")
r = post("/cloudAPI/", {
    "adminUser": ADMIN_USER,
    "adminPass": ADMIN_PASS,
    "controller": "DNS",
    "action": "createZone",
    "data": json.dumps({
        "domainName": DOMAIN,
        "nameServer": "ns1.mcjim-server.com",
        "adminEmail": "admin@mcjim-server.com",
        "soaRefresh": 14400,
        "soaRetry": 7200,
        "soaExpiry": 1209600,
        "soaTtl": 86400
    })
})
print(r)

# Also try the simpler API
print("\n=== Try simpler createZone ===")
r = post("/api/createZone/", {
    "adminUser": ADMIN_USER,
    "adminPass": ADMIN_PASS,
    "domainName": DOMAIN
})
print(r)
