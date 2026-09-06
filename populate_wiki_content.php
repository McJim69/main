<?php
require 'connect.php';

// First, find the admin user ID to attribute articles to them
$stmt = $conn->prepare("SELECT uno FROM users WHERE access = 'Admin' LIMIT 1");
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$adminId = $res ? $res['uno'] : 1;
$now = date('Y-m-d H:i:s');

function addCategory($conn, $title, $description) {
    $stmt = $conn->prepare("INSERT INTO mcjim_wiki_categories (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $description);
    $stmt->execute();
    return $conn->insert_id;
}

function addArticle($conn, $catId, $title, $slug, $content, $adminId, $now) {
    $stmt = $conn->prepare("INSERT INTO mcjim_wiki_articles (category_id, title, slug, content, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiss", $catId, $title, $slug, $content, $adminId, $now, $now);
    $stmt->execute();
}

// Clear existing test data if any
$conn->query("DELETE FROM mcjim_wiki_categories");
$conn->query("DELETE FROM mcjim_wiki_articles");

// --- Category 1: General Services ---
$cat1 = addCategory($conn, 'General Services', 'Documentation on standard McJim Cyberworks services provided to clients.');

$c1_content1 = "<h3>Custom Web Development</h3><p>We build highly customized, secure, and responsive web applications using modern stacks. Our web solutions scale gracefully from small business landing pages to robust enterprise dashboards.</p><h3>Cloud Hosting</h3><p>We offer reliable and secure cloud hosting infrastructure tailored to ensure 99.9% uptime. Automated backups and DDoS protection are included by default.</p>";
addArticle($conn, $cat1, 'Web Development & Hosting', 'web-dev-hosting', $c1_content1, $adminId, $now);

$c1_content2 = "<h3>Enterprise Networking</h3><p>Our team specializes in designing, deploying, and maintaining secure network infrastructure. We configure enterprise-grade routers, firewalls, and switches to ensure minimal latency and maximum security.</p><p>We also provide VPN configurations and secure tunnel setups for remote workforces.</p>";
addArticle($conn, $cat1, 'Network Infrastructure Setup', 'network-infrastructure-setup', $c1_content2, $adminId, $now);

$c1_content3 = "<h3>24/7 IT Support</h3><p>McJim Cyberworks guarantees around-the-clock IT support for critical infrastructure. Our team actively monitors system health metrics to preemptively resolve issues before they affect end-users.</p><h3>Hardware Maintenance</h3><p>Routine hardware checks and physical server maintenance protocols are executed quarterly to ensure hardware longevity.</p>";
addArticle($conn, $cat1, 'IT Support & Maintenance', 'it-support-maintenance', $c1_content3, $adminId, $now);

// --- Category 2: Internal Systems ---
$cat2 = addCategory($conn, 'Internal Systems', 'Guides and rules for using internal company software and dashboards.');

$c2_content1 = "<h3>Secure Messaging</h3><p>Always use the built-in Chat system for discussing confidential project details or sharing sensitive client data. End-to-end encryption is enforced by default.</p><h3>Jitsi Video Calls</h3><p>For 1-on-1 and group meetings, use the integrated Jitsi call feature. Screen sharing is supported. Remember that closing a 1-on-1 chat window will automatically terminate the call for both parties.</p>";
addArticle($conn, $cat2, 'McJim Secure Chat Usage', 'secure-chat-usage', $c2_content1, $adminId, $now);

echo "Wiki Content Populated Successfully!";
?>
