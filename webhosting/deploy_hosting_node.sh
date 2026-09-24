#!/bin/bash

# ==============================================================================
# McJim Server - Hosting Node Deployment Script
# Target OS: Ubuntu 22.04 LTS
# Purpose: Installs CyberPanel (Free, LiteSpeed-based Control Panel)
# ==============================================================================

echo "========================================"
echo "Starting McJim Server Hosting Node Setup"
echo "========================================"

# 1. Update the system
echo "[1/3] Updating system packages..."
sudo apt update && sudo apt upgrade -y

# 2. Install essential packages
echo "[2/3] Installing prerequisites..."
sudo apt install wget curl nano wget net-tools sudo -y

# 3. Download and execute CyberPanel installation script
# CyberPanel includes OpenLiteSpeed, MariaDB, PHP, and DNS/Email services automatically.
echo "[3/3] Initiating CyberPanel Installation..."
echo "NOTE: When prompted by the installer:"
echo " - Select '1' to Install CyberPanel"
echo " - Select '1' to Install CyberPanel with OpenLiteSpeed"
echo " - Select 'Y' for full installation (PowerDNS, Postfix, Pure-FTPd)"
echo " - Press ENTER to use a random password (or type a specific one)"

sh <(curl https://cyberpanel.net/install.sh || wget -O - https://cyberpanel.net/install.sh)

echo "=========================================================================="
echo "Installation Initiated. Please follow the on-screen prompts from CyberPanel."
echo "Save your admin password and login URL when the script completes!"
echo "=========================================================================="
