# McJim Cyberworks — Core IT & Enterprise Infrastructure Platform

McJim Cyberworks is an integrated digital ecosystem, software development framework, and cloud deployment workspace built for full-scale freelance IT operations, serverless system automation, and web application management. 

This platform bridges enterprise networking utilities, modern parameter-sanitized web systems, serverless communication hooks, and automated web directory monetization properties under a unified production environment.

## ??? Integrated Services & Architecture

The architecture consolidates multiple operational nodes into one cohesive infrastructure:

*   **Cloud Architecture & CDN Edge:** High-performance deployments leveraging Google Cloud Platform (GCP) resources coupled with Cloudflare infrastructure for advanced DNS routing, security filtering, and proactive request monitoring.
*   **Serverless Communication Pipes:** Native handling of asynchronous client contact records, telemetry vectors, and web form interactions powered entirely via Web3Forms API wrappers—bypassing traditional server-side SMTP overhead.
*   **Analytics & Verification Layer:** Integrated traffic tracking via the restored Google Analytics `gtag.js` client wrapper alongside continuous public site tracking validation.
*   **Authorized AdSense Monetization:** Fully compliant and verified Google AdSense integration, publishing real-time ad allocations anchored directly by root-level ownership verification engines.
*   **Dynamic UI & Media Asset Pipeline:** A modern, sanitized media processing framework integrating native drag-and-drop client staging spaces with hardware-accelerated Lightbox2 front-end rendering engines.

## ?? Environment Requirements

*   **Runtime Engine:** PHP 8.0+ *(Strict object-oriented patterns, zero-deprecation standard)*
*   **Database Management:** MySQL 8.0+ / MariaDB *(InnoDB transactional engine required)*
*   **Server Stack:** Nginx Reverse-Proxy Configurations *(SSL Enforced via HTTP Strict Transport Security)*
*   **Core Media Upload Thresholds (`php.ini`):**
    ```ini
    max_execution_time = 300
    max_input_time = 300
    memory_limit = 512M
    post_max_size = 120M
    upload_max_filesize = 120M
    max_file_uploads = 200
    ```

## ?? Local Installation & Setup

### 1. Initialize the Working Core
Pull the production codebase cleanly into your default local server directory (`D:\Server\www\`):
```bash
git clone https://github.com/McJim69/mcjim_cyberworks.git .
```

### 2. Configure Local Environment Secrets
To keep system credentials completely isolated from public tracking, copy the connection example file and map out your native relational infrastructure credentials:
```bash
cp connect.php.example connect.php
```

Open `connect.php` and configure your environment-specific fields:
```php
<?php
// connect.php - Core Infrastructure & API Ecosystem Tokens
$host     = "localhost";
$username = "YOUR_LOCAL_DB_USER";
$password = "YOUR_LOCAL_DB_PASSWORD";
$database = "mcjim_cyberworks_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Infrastructure Connection Failure: " . $conn->connect_error);
}

// Global System API Variables
define('WEB3FORMS_ACCESS_KEY', 'your-active-api-key-here');
define('SITE_VERSION', '1.2.0'); 
```

### 3. Verification & Ad Crawling Setup
Ensure your live root directory maps your verified billing profile directly to the crawler. The public verification tree layout requires the following exact mapping in the repository root:
```text
google.com, pub-4818333944764715, DIRECT, f08c47fec0942fa0
```

## ?? Version Isolation Security (`.gitignore`)
The platform explicitly strips environment-specific configurations and backend keys from Git trees to maintain strict data privacy compliance:

```text
# Local Database & Core System Secrets
connect.php
config.json
*.json.key

# Private Cloud Service Accounts & Access Tokens
/config/google-service-account.json

# Persistent Staging Vectors & Dynamic Buffers
uploads/
images/posts/
.idea/
.vscode/

# NOTE: ads.txt and public tracking tags are tracking-active and are NEVER ignored
```

## ?? Operational License
Proprietary Corporate Engine — Designed, engineered, and maintained securely under development by McJim Cyberworks. All rights reserved.
