import urllib.request, json, ssl, paramiko

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
            try: return json.loads(body)
            except: return body[:300]
    except urllib.error.HTTPError as e:
        return f"HTTP {e.code}: {e.read().decode('utf-8', errors='replace')[:300]}"
    except Exception as e:
        return f"ERR: {e}"

# CyberPanel cloudAPI requires serverUserName + adminPass
base_auth = {
    "serverUserName": ADMIN_USER,
    "adminPass": ADMIN_PASS,
}

print("=== Creating DNS Zone ===")
r = post("/cloudAPI/", {
    **base_auth,
    "controller": "DNS",
    "action": "createZone",
    "data": json.dumps({
        "domainName": DOMAIN,
        "nameServer": "ns1.mcjim-server.com",
        "adminEmail": "admin@mcjim-server.com"
    })
})
print(r)

if isinstance(r, dict) and r.get('status') == 1:
    print("\n=== Adding A record (root) ===")
    r2 = post("/cloudAPI/", {
        **base_auth,
        "controller": "DNS",
        "action": "addRecord",
        "data": json.dumps({
            "domainName": DOMAIN,
            "type": "A",
            "name": DOMAIN + ".",
            "value": SERVER_IP,
            "ttl": 3600
        })
    })
    print(r2)

    print("\n=== Adding A record (www) ===")
    r3 = post("/cloudAPI/", {
        **base_auth,
        "controller": "DNS",
        "action": "addRecord",
        "data": json.dumps({
            "domainName": DOMAIN,
            "type": "A",
            "name": f"www.{DOMAIN}.",
            "value": SERVER_IP,
            "ttl": 3600
        })
    })
    print(r3)

    print("\n=== Adding NS records ===")
    for ns in ["ns1.mcjim-server.com.", "ns2.mcjim-server.com."]:
        r4 = post("/cloudAPI/", {
            **base_auth,
            "controller": "DNS",
            "action": "addRecord",
            "data": json.dumps({
                "domainName": DOMAIN,
                "type": "NS",
                "name": DOMAIN + ".",
                "value": ns,
                "ttl": 3600
            })
        })
        print(f"  {ns}: {r4}")
else:
    # Fallback: use PowerDNS CLI directly via SSH
    print("\n=== Fallback: Creating zone via pdnsutil on server ===")
    client = paramiko.SSHClient()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

    cmds = [
        f"pdnsutil create-zone {DOMAIN} ns1.mcjim-server.com",
        f"pdnsutil add-record {DOMAIN} @ A 3600 {SERVER_IP}",
        f"pdnsutil add-record {DOMAIN} www A 3600 {SERVER_IP}",
        f"pdnsutil add-record {DOMAIN} @ NS 3600 ns1.mcjim-server.com",
        f"pdnsutil add-record {DOMAIN} @ NS 3600 ns2.mcjim-server.com",
        f"pdnsutil rectify-zone {DOMAIN}",
    ]
    for cmd in cmds:
        stdin, stdout, stderr = client.exec_command(cmd)
        out = stdout.read().decode('utf-8', errors='replace').strip()
        err = stderr.read().decode('utf-8', errors='replace').strip()
        print(f"CMD: {cmd}")
        if out: print(f"  OUT: {out}")
        if err: print(f"  ERR: {err}")

    client.close()
    print("\nDone via pdnsutil!")
