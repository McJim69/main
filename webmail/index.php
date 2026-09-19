<?php
	// Dynamic Cache Buster
	$cssVersion = file_exists('style.css') ? filemtime('style.css') : time();
	$jsVersion = file_exists('app.js') ? filemtime('app.js') : time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Portal | mcjim-server.com</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?= $cssVersion ?>">
	<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body>
    <div class="background-animation">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <div class="container">
        <div class="glass-panel">
            <header class="header">
                <img src="../images/logo1.webp" style="width:100%">
                <p>Mail Portal</p>
            </header>

            <div class="tabs">
                <button class="tab-btn active" data-target="login-form">Log In</button>
                <button class="tab-btn" data-target="create-form">Create Account</button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="form-section active" style="text-align: center; padding: 30px 0;">
                <p style="margin-bottom: 25px; color: rgba(255, 255, 255, 0.9); font-size: 15px; line-height: 1.5;">Access your inbox and manage your account securely through the official webmail portal.</p>
                <a href="https://mail.mcjim-server.com/" class="submit-btn" style="text-decoration: none; display: block; text-align: center; box-sizing: border-box;">Go to Webmail</a>
            </div>

            <!-- Create Account Form -->
            <form id="create-form" class="form-section hidden">
                <div class="input-group">
                    <label for="create-email">New Email Address</label>
                    <div class="input-suffix">
                        <input type="text" id="create-email" placeholder="username" required>
                        <span class="suffix"><small>@mcjimserver.com</small></span>
                    </div>
                </div>
                <div class="input-group">
                    <label for="create-password">Password</label>
                    <div class="input-suffix">
                        <input type="password" id="create-password" placeholder="********" required>
                        <button type="button" class="suffix toggle-password" id="toggle-password" style="cursor: pointer; border: none; outline: none; font-weight: 600; transition: color 0.2s;">Show</button>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Create Mailbox</button>
                <div id="create-message" class="message"></div>
            </form>
        </div>
    </div>

    <script src="app.js?v=<?= $jsVersion ?>"></script>
</body>
</html>
