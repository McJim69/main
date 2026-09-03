<?php
/**
 * McJim Cyberworks — Automated Infrastructure Diagnostics
 * Verifies system paths, directory permissions, and php.ini configurations.
 */

header('Content-Type: text/plain; charset=utf-8');
echo "=== MCJIM CYBERWORKS SYSTEM DIAGNOSTICS ===\n\n";

// 1. Check Directory Permissions
$required_directories = [
    'images/' => 'read/write',
    'images/users/' => 'read/write',
    'uploads/' => 'read/write'
];

echo "[+] Verifying Directory Permissions:\n";
foreach ($required_directories as $dir => $type) {
    if (!file_exists($dir)) {
        echo "  [-] ERROR: '{$dir}' does not exist. Creating it now...\n";
        mkdir($dir, 0755, true);
    }
    
    if (is_writable($dir)) {
        echo "  [✓] '{$dir}' is writeable (0755/0777 equivalent).\n";
    } else {
        echo "  [!] WARNING: '{$dir}' is NOT writeable. Fix permissions via chmod.\n";
    }
}

// 2. Check php.ini Threshold Settings
$expected_configs = [
    'max_execution_time' => 300,
    'max_input_time'     => 300,
    'memory_limit'       => '512M',
    'post_max_size'      => '120M',
    'upload_max_filesize'=> '120M',
    'max_file_uploads'   => 200
];

echo "\n[+] Auditing Runtime Engine Configuration:\n";
foreach ($expected_configs as $setting => $expected_val) {
    $current_val = ini_get($setting);
    if ($current_val == $expected_val || (int)$current_val >= (int)$expected_val) {
        echo "  [✓] {$setting}: Current '{$current_val}' meets target requirement.\n";
    } else {
        echo "  [!] ALERT: {$setting} is '{$current_val}'. Recommended target is '{$expected_val}'.\n";
    }
}

// 3. Verify Vital File Placement
echo "\n[+] Verifying Asset Integrity:\n";
$critical_files = ['connect.php', 'ads.txt'];
foreach ($critical_files as $file) {
    if (file_exists($file)) {
        echo "  [✓] Global core file '{$file}' located.\n";
    } else {
        echo "  [!] MISSING: '{$file}' was not found in root path.\n";
    }
}

echo "\n=== DIAGNOSTICS COMPLETE ===";
