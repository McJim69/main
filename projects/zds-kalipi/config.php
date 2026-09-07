<?php
/**
 * ZAMBOANGA DEL SUR KALIPI-RIC WOMEN FEDERATION, INC.
 * Production Database & Data Sync Configuration
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'zds_kalipi_db');
define('DB_USER', 'McJim');
define('DB_PASS', 'Restricted654123');
define('DB_CHARSET', 'utf8mb4');

/**
 * Data Synchronization Settings (Localhost <-> Production Server)
 * 
 * 1. Set SYNC_SECRET_KEY to a secure matching token on both local and production servers.
 * 2. Set REMOTE_SERVER_URL on localhost to your live production server API URL.
 */
define('SYNC_SECRET_KEY', 'ZDS_KALIPI_SECRET_TOKEN_2026');
define('REMOTE_SERVER_URL', 'https://your-production-domain.com/api.php');
