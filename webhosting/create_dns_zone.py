import urllib.request
import urllib.parse
import json
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

CYBERPANEL_HOST = "https://10.0.10.51:8090"
ADMIN_USER = "admin"
ADMIN_PASS = "McJim654123"
DOMAIN = "louiecaraircon.com"
SERVER_IP = "180.193.203.22"

def api_call(endpoint, data):
    url = f"{CYBERPANEL_HOST}{endpoint}"
    payload = json.dumps(data).encode('utf-8')
    req = urllib.request.Request(url, data=payload, method='POST')
    req.add_header('Content-Type', 'application/json')
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=10) as r:
            return json.loads(r.read().decode())
    except Exception as e:
        return {"error": str(e)}

# Step 1: Create DNS zone
print(f"Creating DNS zone for {DOMAIN}...")
result = api_call("/api/createZone", {
    "adminUser": ADMIN_USER,
    "adminPass": ADMIN_PASS,
    "domainName": DOMAIN
})
print("Create zone:", result)

# Step 2: Add A record for root domain
print(f"\nAdding A record for {DOMAIN} -> {SERVER_IP}...")
result = api_call("/api/addRecord", {
    "adminUser": ADMIN_USER,
    "adminPass": ADMIN_PASS,
    "domainName": DOMAIN,
    "type": "A",
    "name": DOMAIN + ".",
    "value": SERVER_IP,
    "ttl": 3600
})
print("A record:", result)

# Step 3: Add A record for www
print(f"\nAdding A record for www.{DOMAIN} -> {SERVER_IP}...")
result = api_call("/api/addRecord", {
    "adminUser": ADMIN_USER,
    "adminPass": ADMIN_PASS,
    "domainName": DOMAIN,
    "type": "A",
    "name": f"www.{DOMAIN}.",
    "value": SERVER_IP,
    "ttl": 3600
})
print("www A record:", result)

# Step 4: Add NS records
for ns in ["ns1.mcjim-server.com.", "ns2.mcjim-server.com."]:
    print(f"\nAdding NS record: {ns}...")
    result = api_call("/api/addRecord", {
        "adminUser": ADMIN_USER,
        "adminPass": ADMIN_PASS,
        "domainName": DOMAIN,
        "type": "NS",
        "name": DOMAIN + ".",
        "value": ns,
        "ttl": 3600
    })
    print("NS record:", result)

print("\nDone!")
