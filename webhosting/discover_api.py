import urllib.request
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

# Check what API endpoints are available
for port in [8090, 8088, 80, 443]:
    for path in ["/api/", "/api", "/", "/v1/"]:
        try:
            url = f"https://10.0.10.51:{port}{path}"
            req = urllib.request.Request(url, method='GET')
            with urllib.request.urlopen(req, context=ctx, timeout=5) as r:
                print(f"PORT {port} PATH {path}: {r.status} - {r.read()[:200].decode('utf-8', errors='replace')}")
        except urllib.error.HTTPError as e:
            print(f"PORT {port} PATH {path}: HTTP {e.code}")
        except Exception as e:
            print(f"PORT {port} PATH {path}: {type(e).__name__}: {str(e)[:60]}")
