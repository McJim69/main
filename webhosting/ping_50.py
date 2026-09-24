import subprocess
result = subprocess.run(['ping', '-n', '2', '10.0.10.50'], capture_output=True, text=True)
print(result.stdout)
