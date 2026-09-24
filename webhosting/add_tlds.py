import paramiko
import os

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

queries = [
    "INSERT IGNORE INTO tld (tld, price_registration, price_renew, price_transfer, active, allow_register, allow_transfer, created_at, updated_at) VALUES ('.co', 15.00, 15.00, 15.00, 1, 1, 1, NOW(), NOW());",
    "INSERT IGNORE INTO tld (tld, price_registration, price_renew, price_transfer, active, allow_register, allow_transfer, created_at, updated_at) VALUES ('.io', 40.00, 40.00, 40.00, 1, 1, 1, NOW(), NOW());",
    "INSERT IGNORE INTO tld (tld, price_registration, price_renew, price_transfer, active, allow_register, allow_transfer, created_at, updated_at) VALUES ('.ph', 35.00, 35.00, 35.00, 1, 1, 1, NOW(), NOW());",
    "INSERT IGNORE INTO tld (tld, price_registration, price_renew, price_transfer, active, allow_register, allow_transfer, created_at, updated_at) VALUES ('.dev', 14.00, 14.00, 14.00, 1, 1, 1, NOW(), NOW());",
    "INSERT IGNORE INTO tld (tld, price_registration, price_renew, price_transfer, active, allow_register, allow_transfer, created_at, updated_at) VALUES ('.tech', 5.00, 5.00, 5.00, 1, 1, 1, NOW(), NOW());"
]

for query in queries:
    stdin, stdout, stderr = client.exec_command(f"mysql -e \"USE fossbilling; {query}\"")
    print(stdout.read().decode('utf-8'))
    print(stderr.read().decode('utf-8'))

print("Finished inserting TLDs.")
