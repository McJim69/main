#!/bin/bash

# ==============================================================================
# McJim Server - Billing & Portal Deployment Script
# Target OS: Ubuntu 22.04 LTS
# Purpose: Installs Nginx and prepares the server for the Frontend and WHMCS/Blesta
# ==============================================================================

echo "==========================================="
echo "Starting McJim Server Billing/Portal Setup"
echo "==========================================="

# 1. Update the system
echo "[1/4] Updating system packages..."
sudo apt update && sudo apt upgrade -y

# 2. Install LEMP Stack (Linux, Nginx, MySQL, PHP)
# WHMCS and Blesta typically require PHP 8.1+ and ionCube loaders
echo "[2/4] Installing Nginx, MariaDB, and PHP..."
sudo apt install nginx mariadb-server php-fpm php-mysql php-curl php-gd php-mbstring php-xml php-bcmath php-zip -y

# 3. Secure MariaDB Installation (Interactive)
echo "[3/4] Securing Database (Please answer the prompts)..."
sudo mysql_secure_installation

# 4. Set up the web root directory
echo "[4/4] Setting up Web Directory (/var/www/html)..."
sudo chown -R $USER:$USER /var/www/html
sudo chmod -R 755 /var/www/html

echo "=========================================================================="
echo "Setup Complete!"
echo "Next Steps:"
echo "1. Upload your index.html, styles.css, and script.js to /var/www/html"
echo "2. Install your billing software (WHMCS/Blesta) in a subfolder like /var/www/html/billing"
echo "=========================================================================="
