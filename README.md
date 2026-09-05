# 🌐 McJim Cyberworks

[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-4+-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Jitsi](https://img.shields.io/badge/Jitsi-Meet-1D76BA?style=for-the-badge&logo=jitsi&logoColor=white)](https://jitsi.org)

**McJim Cyberworks** is a comprehensive digital ecosystem, software development framework, and cloud deployment workspace. It is designed as a fully integrated platform for freelance IT operations, serverless automation, media streaming, and modern web application management.

## ✨ Key Features

### 🔐 Robust User Identity & Access
*   **Authentication:** Secure registration and login workflows using modern PHP password hashing.
*   **Profile Management:** Customizable user profiles with avatar uploads and real-time active status tracking.
*   **Access Control:** Layered permission roles with a dedicated administrative dashboard for managing users.

### 💬 Real-Time Communications (RTC)
*   **Instant Messaging:** A full-featured chat ecosystem supporting private direct messages (DMs) and group chats.
*   **Rich Messaging:** Support for file attachments, images, and message reactions.
*   **WebRTC Integration:** Built-in audio and video calling powered by the Jitsi Meet API, complete with custom ringing overlays and in-app call invitations.

### 🚀 Dynamic Project Portfolio & Management
*   **Showcase Grid:** A dynamic, database-driven grid displaying web development projects.
*   **Deep Dives:** Detailed project pages complete with image galleries, tech stack breakdowns, and live demo links.
*   **Admin CRUD:** A backend management system allowing administrators to easily add, edit, or remove portfolio items.

### 💼 Business Operations & Admin Dashboard
*   **Centralized Dashboard:** A unified `dashboard.php` providing a high-level overview of system metrics, active users, and quick links.
*   **Support Ticket System:** A complete helpdesk module allowing users to create tickets, and admins to reply, close, and manage support requests.
*   **Kanban Task Management:** A drag-and-drop Kanban board (`kanban.php`) for tracking internal tasks and development progress.
*   **Invoicing & Billing:** Generate, track, and manage client invoices directly through the admin portal.
*   **Documentation & File Sharing:** Dedicated modules for managing technical documentation (`docs.php`) and secure file drops (`file-drop.php`).

### 📰 Social Feed & Blogging
*   **Community Posts:** An interactive social feed allowing users to share text, images, and thoughts.
*   **Engagement:** Real-time commenting, editing, and deletion using asynchronous AJAX handlers.

### 🎬 Media Server Integration
*   **Jellyfin Ecosystem:** Native integration with a self-hosted Jellyfin media server.
*   **Automated Provisioning:** Automatic user token generation and integration for seamless media access.

### ☁️ Cloud & Infrastructure Automation
*   **Serverless Forms:** Contact channels utilize Web3Forms API wrappers to bypass traditional, vulnerable server-side SMTP overhead.
*   **Analytics & Monetization:** Ready-to-go Google Analytics `gtag.js` and verified Google AdSense integrations.

## 🛠️ Architecture & Tech Stack

*   **Backend:** Object-Oriented & Procedural PHP (8.0+)
*   **Database:** MySQL / MariaDB (InnoDB engine)
*   **Frontend:** HTML5, CSS3, JavaScript (jQuery + AJAX), Bootstrap
*   **Media Processing:** Hardware-accelerated Lightbox2 and native HTML5 video
*   **Communication:** Jitsi Meet External API for WebRTC calls
*   **Caching Strategy:** Global dynamic cache-busting driven by `SITE_VERSION` (`version.php`) for seamless CSS/JS updates.

## ⚙️ Environment Requirements

Ensure your server is configured with the following minimums in `php.ini` to support rich media uploads and sustained operations:

```ini
max_execution_time = 300
max_input_time = 300
memory_limit = 512M
post_max_size = 120M
upload_max_filesize = 120M
max_file_uploads = 200
```

## 🚀 Installation & Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/McJim69/main.git .
   ```

2. **Configure Environment:**
   Copy the example connection template and input your database credentials:
   ```bash
   cp connect.php.example connect.php
   ```
   *Edit `connect.php` to include your DB host, user, password, and Web3Forms API keys.*

3. **Database Initialization:**
   Run the `setup_db.php` script (or import the provided SQL dumps) to build the required tables for users, chat, projects, and posts.

4. **Directory Permissions:**
   Ensure your web server has write access to the `uploads/`, `images/users/`, and `images/posts/` directories for media processing.

## 🛡️ Security & Privacy
McJim Cyberworks adheres to strict security standards. Sensitive configurations (like `connect.php`, `config.json`, and cloud keys) are strictly ignored in the version control tree via `.gitignore` to prevent credential leakage.

---
*Designed, engineered, and maintained securely by McJim Cyberworks.*
