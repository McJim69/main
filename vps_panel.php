<?php
$token = $_GET['token'] ?? '';
if (empty($token) || !preg_match('/^[a-f0-9]{32}$/i', $token)) {
    die("Invalid token.");
}

$cacheDir = __DIR__ . '/library/Server/Manager/cache/';
$tokenFile = $cacheDir . 'vps_sso_' . $token;

if (!file_exists($tokenFile)) {
    die("Session expired or invalid. Please re-login from the Client Area.");
}

$data = json_decode(file_get_contents($tokenFile), true);
$vps_name = $data['vps_name'] ?? '';

if (empty($vps_name)) {
    die("Invalid VPS data.");
}

// Handle AJAX SSH Terminal commands
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ssh_cmd'])) {
    header('Content-Type: text/plain');
    $cmd = $_POST['ssh_cmd'];
    $ip = $data['ip'] ?? '';
    $pass = $data['password'] ?? '';
    
    if (empty($ip) || empty($pass)) {
        echo "Error: IP or Password missing from SSO session. Please regenerate SSO token from client area.";
        exit;
    }
    
    // Using timeout so interactive commands don't hang the PHP process indefinitely
    $safe_cmd = 'timeout 15 ' . escapeshellarg($cmd);
    $ssh_exec = "sshpass -p " . escapeshellarg($pass) . " ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -o ConnectTimeout=5 ubuntu@" . escapeshellarg($ip) . " " . $safe_cmd . " 2>&1";
    
    exec($ssh_exec, $out, $ret);
    echo implode("\n", $out);
    exit;
}

// Handle power actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'] ?? '';
    
    putenv("GOVC_URL=esxi.mcjim-server.com");
    putenv("GOVC_USERNAME=McJim");
    putenv("GOVC_PASSWORD=Last@Final654123");
    putenv("GOVC_INSECURE=1");
    putenv("GOVC_PERSIST_SESSION=false");
    
    $cmd = "";
    if ($action === 'reboot') {
        $cmd = "/usr/local/bin/govc vm.power -r " . escapeshellarg($vps_name);
    } elseif ($action === 'poweron') {
        $cmd = "/usr/local/bin/govc vm.power -on " . escapeshellarg($vps_name);
    } elseif ($action === 'poweroff') {
        $cmd = "/usr/local/bin/govc vm.power -off " . escapeshellarg($vps_name);
    }
    
    if ($cmd) {
        exec($cmd . " 2>&1", $out, $ret);
        $message = "Action executed: " . implode(" ", $out);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VPS Management Panel</title>
    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Roboto', sans-serif; 
            background: #101010 url('https://mcjim-server.com/images/mcjim-cyberworks1.webp') no-repeat center center fixed; 
            background-size: cover;
            color: #fff; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }
        .overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(16, 16, 16, 0.85);
            z-index: -1;
        }
        .panel { 
            background: rgba(30, 30, 30, 0.7); 
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 15px; 
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            text-align: center; 
            width: 100%; 
            max-width: 450px; 
        }
        h1 { margin-top: 0; font-size: 28px; font-weight: 900; letter-spacing: 1px; color: #f48840; text-transform: uppercase; }
        p.vps { font-size: 20px; font-weight: 300; color: #ddd; margin-bottom: 30px; }
        .btn-custom { 
            display: block; width: 100%; padding: 12px; margin-bottom: 15px; 
            border-radius: 30px; font-size: 15px; font-weight: 700; text-transform: uppercase; 
            letter-spacing: 1px; transition: all 0.3s; color: #fff; border: none;
        }
        .btn-on { background: #28a745; } 
        .btn-on:hover { background: #218838; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(40,167,69,0.4); }
        .btn-reboot { background: #f48840; } 
        .btn-reboot:hover { background: #e07730; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(244,136,64,0.4); }
        .btn-off { background: #dc3545; } 
        .btn-off:hover { background: #c82333; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(220,53,69,0.4); }
        .btn-console { background: #007bff; }
        .btn-console:hover { background: #0069d9; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,123,255,0.4); }
        .btn-back { background: #6c757d; }
        .btn-back:hover { background: #5a6268; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(108,117,125,0.4); }
        .msg { margin-bottom: 20px; padding: 15px; border-radius: 8px; background: rgba(40,167,69,0.2); border: 1px solid #28a745; color: #28a745; font-size: 14px; font-weight: 500; }
        .icon { font-size: 40px; margin-bottom: 15px; color: #f48840; }

        /* Terminal CSS */
        .terminal-modal .modal-content {
            background-color: #1e1e1e;
            color: #00ff00;
            border: 1px solid #333;
            border-radius: 10px;
        }
        .terminal-modal .modal-header {
            border-bottom: 1px solid #333;
            padding: 10px 20px;
        }
        .terminal-modal .modal-title {
            color: #fff;
            font-family: monospace;
            font-size: 16px;
        }
        .terminal-body {
            padding: 20px;
            height: 400px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 14px;
        }
        #terminal-output {
            white-space: pre-wrap;
            margin-bottom: 10px;
        }
        .terminal-input-row {
            display: flex;
            align-items: center;
        }
        .terminal-prompt {
            color: #f48840;
            margin-right: 10px;
        }
        #terminal-input {
            background: transparent;
            border: none;
            color: #00ff00;
            flex-grow: 1;
            font-family: monospace;
            font-size: 14px;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="panel">
        <div class="icon"><i class="fas fa-server"></i></div>
        <h1>VPS Management</h1>
        <p class="vps"><i class="fas fa-hdd me-2"></i><?php echo htmlspecialchars($vps_name); ?></p>
        
        <?php if (!empty($message)): ?>
            <div class="msg"><i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <button type="button" class="btn-custom btn-console" data-bs-toggle="modal" data-bs-target="#terminalModal"><i class="fas fa-terminal me-2"></i>Web Console</button>
            <button type="submit" name="action" value="poweron" class="btn-custom btn-on"><i class="fas fa-power-off me-2"></i>Power On</button>
            <button type="submit" name="action" value="reboot" class="btn-custom btn-reboot"><i class="fas fa-sync-alt me-2"></i>Reboot</button>
            <button type="submit" name="action" value="poweroff" class="btn-custom btn-off"><i class="fas fa-stop-circle me-2"></i>Power Off</button>
        </form>
        <div style="margin-top: 20px;">
            <a href="https://billing.mcjim-server.com/" class="btn-custom btn-back text-decoration-none d-block"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
        </div>
    </div>

    <!-- Terminal Modal -->
    <div class="modal fade terminal-modal" id="terminalModal" tabindex="-1" aria-labelledby="terminalModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="terminalModalLabel">ubuntu@<?php echo htmlspecialchars($data['ip'] ?? 'unknown'); ?>:~</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body terminal-body" id="terminal-body" onclick="document.getElementById('terminal-input').focus()">
            <div id="terminal-output">Welcome to Web Console. Type a command and press Enter.<br></div>
            <div class="terminal-input-row">
                <span class="terminal-prompt">ubuntu@vps:~$</span>
                <input type="text" id="terminal-input" autocomplete="off" spellcheck="false">
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const terminalInput = document.getElementById('terminal-input');
        const terminalOutput = document.getElementById('terminal-output');
        const terminalBody = document.getElementById('terminal-body');

        terminalInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const cmd = terminalInput.value.trim();
                terminalInput.value = '';
                
                if(cmd === 'clear') {
                    terminalOutput.innerHTML = '';
                    return;
                }

                if (cmd !== '') {
                    terminalOutput.innerHTML += '<span style="color:#f48840;">ubuntu@vps:~$</span> ' + escapeHtml(cmd) + '<br>';
                    scrollToBottom();
                    
                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'ssh_cmd=' + encodeURIComponent(cmd)
                    })
                    .then(response => response.text())
                    .then(data => {
                        if(data) {
                            terminalOutput.innerHTML += escapeHtml(data) + '<br>';
                        }
                        scrollToBottom();
                    })
                    .catch(error => {
                        terminalOutput.innerHTML += '<span style="color:red;">Error executing command.</span><br>';
                        scrollToBottom();
                    });
                }
            }
        });

        function scrollToBottom() {
            terminalBody.scrollTop = terminalBody.scrollHeight;
        }

        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
        }
        
        // Focus input when modal is opened
        const terminalModal = document.getElementById('terminalModal');
        terminalModal.addEventListener('shown.bs.modal', function () {
            terminalInput.focus();
        });
    </script>
</body>
</html>
