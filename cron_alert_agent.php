<?php
    // cron_alert_agent.php
    // Pagpadagan niini pinaagi sa Cron Job: php /path/to/cron_alert_agent.php

    // Siguraduhon nga dili mag-timeout kung daghan ang gina-ping nga servers
    set_time_limit(300);

    // I-include ang imong database connection array parameters
    require_once(__DIR__ . "/connect.php"); 

    // EMAIL CONFIGURATION TARGET
    define('ALERT_TO_EMAIL', 'info@mcjim-server.com');
    define('ALERT_FROM_EMAIL', 'monitor@mcjim-server.com');

    // 1. Pag-fetch sa tanang monitored servers gikan sa database
    $query = "SELECT id, server_name, url, status AS old_status FROM mcjim_monitored_servers";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }

    while ($server = mysqli_fetch_assoc($result)) {
        $id = $server['id'];
        $name = $server['server_name'];
        $url = $server['url'];
        $old_status = $server['old_status'];

        // 2. Pag-execute sa cURL network validation rule check
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'McJim Infrastructure Monitor/1.0');

        $start = microtime(true);
        curl_exec($ch);
        $end = microtime(true);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // 3. Pag-determinar sa bag-ong status base sa network data application
        $new_status = 'Offline';
        if ($http_code >= 200 && $http_code < 400 && empty($curl_error)) {
            $new_status = 'Online';
        }

        $response_time = intval(($end - $start) * 1000);
        $now = date('Y-m-d H:i:s');

        // 4. Pag-update sa database para sa pinakabag-ong state
        $stmt = $conn->prepare("UPDATE mcjim_monitored_servers SET status = ?, response_time_ms = ?, last_checked = ? WHERE id = ?");
        $stmt->bind_param("sisi", $new_status, $response_time, $now, $id);
        $stmt->execute();
        $stmt->close();

        // 5. CRITIKAL: Kon nausab ang status, awtomatikong ipadala ang email alerto!
        if ($old_status !== $new_status) {
            sendEmailAlert($name, $url, $old_status, $new_status, $response_time, $http_code);
        }
    }

    // Pamaagi sa pag-render ug pagpadala sa HTML Email Alert
    function sendEmailAlert($name, $url, $from, $to, $ping, $code) {
        $subject = ($to === 'Offline') ? "🚨 CRITICAL: Server {$name} is OFFLINE!" : "✅ RESOLVED: Server {$name} is ONLINE";
        
        $badge_color = ($to === 'Offline') ? '#d9383a' : '#28a745';
        
        // Hapsay nga HTML template layout nga haom sa imong McJim Cyberworks design standards
        $message = "
        <html>
        <head>
            <title>{$subject}</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                <div style='background-color: {$badge_color}; padding: 20px; text-align: center; color: #ffffff;'>
                    <h2 style='margin: 0; font-size: 22px; font-weight: bold;'>Infrastructure Monitor Alert</h2>
                </div>
                <div style='padding: 25px;'>
                    <p style='font-size: 16px;'>Adunay nakit-an nga kabag-ohan sa dagan sa imong system network:</p>
                    <table style='width: 100%; border-collapse: collapse; margin-top: 15px;'>
                        <tr>
                            <td style='padding: 10px; font-weight: bold; border-bottom: 1px solid #eee; width: 35%;'>Server Name:</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>{$name}</strong></td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; font-weight: bold; border-bottom: 1px solid #eee;'>Target URL:</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><a href='{$url}' target='_blank' style='color: #007acc;'>{$url}</a></td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; font-weight: bold; border-bottom: 1px solid #eee;'>Status Event:</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>
                                <span style='background-color: #6c757d; color: white; padding: 3px 8px; border-radius: 4px; font-size: 13px;'>{$from}</span> 
                                &rarr; 
                                <span style='background-color: {$badge_color}; color: white; padding: 3px 8px; border-radius: 4px; font-size: 13px; font-weight: bold;'>{$to}</span>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; font-weight: bold; border-bottom: 1px solid #eee;'>HTTP Response:</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>Code {$code}</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; font-weight: bold; border-bottom: 1px solid #eee;'>Latency Delay:</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>{$ping} ms</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; font-weight: bold; border-bottom: 1px solid #eee;'>Timestamp:</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; color: #666;'>" . date('Y-m-d H:i:s') . "</td>
                        </tr>
                    </table>
                </div>
                <div style='background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee;'>
                    Automated report engine processed by McJim Cyberworks Infrastructure Agent.
                </div>
            </div>
        </body>
        </html>";

        // Meticulous validation headers para sa luwas nga delivery protocol routing
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: McJim Monitor <" . ALERT_FROM_EMAIL . ">" . "\r\n";
        $headers .= "Reply-To: " . ALERT_FROM_EMAIL . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        // Pagpadala sa email framework
        if (!mail(ALERT_TO_EMAIL, $subject, $message, $headers)) {
            error_log("CRITICAL ERROR: Failed to execute mail alert pipe dispatch routing.");
        }
    }
?>
