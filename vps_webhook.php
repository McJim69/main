<?php
/**
 * vps_webhook.php
 * Receives an HTTP request to provision a VM via govc.
 * 
 * To test manually:
 * curl -X GET "https://billing.mcjim-server.com/vps_webhook.php?secret=McJimESXi123!&order_id=123"
 */

$secret_key = "McJimESXi123!";
$passed_secret = isset($_GET['secret']) ? $_GET['secret'] : '';

if ($passed_secret !== $secret_key) {
    http_response_code(401);
    die(json_encode(["error" => "Unauthorized. Invalid secret key."]));
}

// Get order ID to uniquely name the VM
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : (isset($_POST['order_id']) ? intval($_POST['order_id']) : rand(1000, 9999));
$vm_name = "VPS-" . $order_id;

// Default resources for the Pro Plan (CloudVPS)
$vcpu = 4;
$ram_mb = 8192;

// Ensure the shell script exists and is executable
$script_path = "/var/www/html/billing/provision_vps.sh";
if (!file_exists($script_path)) {
    http_response_code(500);
    die(json_encode(["error" => "Provisioning script not found on the server!"]));
}

// Execute the bash script in the background to avoid timing out the webhook request
$cmd = escapeshellcmd($script_path) . " " . escapeshellarg($vm_name) . " " . escapeshellarg($vcpu) . " " . escapeshellarg($ram_mb) . " > /tmp/provision_${vm_name}.log 2>&1 &";
exec($cmd);

http_response_code(200);
echo json_encode([
    "status" => "success", 
    "message" => "VM Provisioning started for $vm_name in the background.",
    "log_file" => "/tmp/provision_${vm_name}.log"
]);
