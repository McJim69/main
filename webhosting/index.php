<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>McJim Server | Premium Web Hosting</title>
    <meta name="description" content="High-performance web hosting, VPS, and domain services. Built for speed and reliability.">
    
    <!-- Self-hosted Fonts -->
    <link rel="stylesheet" href="/assets/css/fonts.css">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="styles.css?v=5">
</head>
<body>
    <!-- Background Glow Effects -->
    <div class="bg-glow top-left"></div>
    <div class="bg-glow bottom-right"></div>
    <div class="bg-glow middle-right"></div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container nav-container">
            <a href="https://mcjim-server.com" class="logo">McJim<span class="gradient-text">Server</span></a>
            <div class="nav-links">
                <a href="#hosting">Hosting</a>
                <a href="#vps">VPS</a>
                <a href="#features">Features</a>
                <a href="#domains">Domains</a>
            </div>
            <div class="nav-actions">
                <a href="/billing_sso.php" class="login-btn">Client Login</a>
                <a href="#pricing" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container hero-container">
            <div class="hero-content reveal">
                <div class="badge-wrapper">
                    <span class="badge">Sale: 75% Off Web Hosting</span>
                </div>
                <h1>Next-Generation Web Hosting for <span class="gradient-text">Visionaries</span></h1>
                <p>Lightning-fast speeds, uncompromised security, and 24/7 expert support. Launch your website today with McJim Server.</p>
                <div class="hero-buttons">
                    <a href="#pricing" class="btn btn-primary btn-large glow-effect">View Plans</a>
                    <a href="#features" class="btn btn-secondary btn-large">Learn More</a>
                </div>
                <div class="trust-indicators">
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> 30-Day Money-Back Guarantee</p>
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> 99.9% Uptime Guarantee</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing">
        <div class="container">
            <div class="section-header reveal">
                <h2>Choose Your Power</h2>
                <p>Scalable hosting plans designed for every stage of your journey.</p>
            </div>
            <div class="pricing-grid">
                <!-- Basic Plan -->
                <div class="pricing-card glass-panel reveal" style="transition-delay: 0.1s;">
                    <div class="card-header">
                        <h3>Starter</h3>
                        <p>Perfect for personal blogs</p>
                        <div class="price"><span>$</span>2.99<span class="period">/mo</span></div>
                    </div>
                    <ul class="features-list">
                        <li><span class="check">✓</span> 1 Website</li>
                        <li><span class="check">✓</span> 50 GB NVMe Storage</li>
                        <li><span class="check">✓</span> Free SSL Certificate</li>
                        <li><span class="check">✓</span> Weekly Backups</li>
                    </ul>
                    <a href="/billing_sso.php?return=/order" class="btn btn-outline btn-block">Add to Cart</a>
                </div>

                <!-- Premium Plan (Highlighted) -->
                <div class="pricing-card glass-panel highlighted reveal" style="transition-delay: 0.2s;">
                    <div class="popular-badge">Most Popular</div>
                    <div class="card-header">
                        <h3>Business</h3>
                        <p>For growing businesses</p>
                        <div class="price"><span>$</span>5.99<span class="period">/mo</span></div>
                    </div>
                    <ul class="features-list">
                        <li><span class="check">✓</span> Unlimited Websites</li>
                        <li><span class="check">✓</span> 200 GB NVMe Storage</li>
                        <li><span class="check">✓</span> Free Domain (1st Year)</li>
                        <li><span class="check">✓</span> Daily Backups</li>
                        <li><span class="check">✓</span> Free CDN Included</li>
                    </ul>
                    <a href="/billing_sso.php?return=/order" class="btn btn-primary btn-block glow-effect">Add to Cart</a>
                </div>

                <!-- VPS Plan -->
                <div class="pricing-card glass-panel reveal" style="transition-delay: 0.3s;">
                    <div class="card-header">
                        <h3>Cloud VPS</h3>
                        <p>Dedicated resources for pros</p>
                        <div class="price"><span>$</span>12.99<span class="period">/mo</span></div>
                    </div>
                    <ul class="features-list">
                        <li><span class="check">✓</span> 4 vCPU Cores</li>
                        <li><span class="check">✓</span> 8 GB RAM</li>
                        <li><span class="check">✓</span> 100 GB NVMe Storage</li>
                        <li><span class="check">✓</span> Root Access</li>
                        <li><span class="check">✓</span> Dedicated IP</li>
                    </ul>
                    <a href="/billing_sso.php?return=/order" class="btn btn-outline btn-block">Add to Cart</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header reveal">
                <h2>Why Choose McJim Server?</h2>
                <p>We built our platform from the ground up for maximum performance and reliability.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card glass-panel reveal" style="transition-delay: 0.1s;">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="url(#blue-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                    </div>
                    <h3>LiteSpeed Web Server</h3>
                    <p>Up to 10x faster than traditional Apache servers. Your website loads in milliseconds.</p>
                </div>
                <div class="feature-card glass-panel reveal" style="transition-delay: 0.2s;">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="url(#blue-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <h3>Advanced Security</h3>
                    <p>Imunify360 protection, free SSL, and automated malware scanning keep you safe.</p>
                </div>
                <div class="feature-card glass-panel reveal" style="transition-delay: 0.3s;">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="url(#blue-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    </div>
                    <h3>Automated Backups</h3>
                    <p>Rest easy knowing your data is backed up daily and can be restored with one click.</p>
                </div>
                <div class="feature-card glass-panel reveal" style="transition-delay: 0.4s;">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="url(#blue-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <h3>24/7 Expert Support</h3>
                    <p>Our team of hosting veterans is available around the clock via live chat and tickets.</p>
                </div>
            </div>
            <!-- SVG Gradients -->
            <svg style="width:0;height:0;position:absolute;" aria-hidden="true" focusable="false">
                <linearGradient id="blue-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#6366f1" />
                    <stop offset="50%" stop-color="#3b82f6" />
                    <stop offset="100%" stop-color="#06b6d4" />
                </linearGradient>
            </svg>
    </section>

    <!-- Domains Section -->
    <section id="domains" class="domains">
        <div class="container">
            <div class="section-header reveal">
                <h2>Find Your Perfect Domain</h2>
                <p>Register or transfer your domain name today. We support all popular extensions.</p>
            </div>
            
            <div class="domain-search-box glass-panel reveal" style="transition-delay: 0.1s;">
                <form action="/billing_sso.php" method="GET" class="domain-form">
                    <input type="hidden" name="return" value="/order">
                    <input type="text" name="domain" placeholder="Enter your perfect domain name..." required class="domain-input">
                    <select name="tld" class="domain-tld">
                        <option value=".com">.com</option>
                        <option value=".net">.net</option>
                        <option value=".org">.org</option>
                        <option value=".co">.co</option>
                        <option value=".io">.io</option>
                        <option value=".ph">.ph</option>
                        <option value=".dev">.dev</option>
                        <option value=".tech">.tech</option>
                    </select>
                    <button type="submit" class="btn btn-primary glow-effect">Search</button>
                </form>
            </div>

            <div class="tld-pricing reveal" style="transition-delay: 0.2s;">
                <div class="tld-item"><span class="tld">.com</span> <span class="price">$11.99</span></div>
                <div class="tld-item"><span class="tld">.net</span> <span class="price">$6.00</span></div>
                <div class="tld-item"><span class="tld">.org</span> <span class="price">$3.00</span></div>
                <div class="tld-item"><span class="tld">.io</span> <span class="price">$40.00</span></div>
                <div class="tld-item"><span class="tld">.co</span> <span class="price">$15.00</span></div>
                <div class="tld-item"><span class="tld">.ph</span> <span class="price">$35.00</span></div>
                <div class="tld-item"><span class="tld">.dev</span> <span class="price">$14.00</span></div>
                <div class="tld-item"><span class="tld">.tech</span> <span class="price">$5.00</span></div>
            </div>

            <!-- CyberPanel Notice -->
            <div class="domain-notice reveal" style="transition-delay: 0.3s;">
                <div class="notice-icon">&#9888;</div>
                <div class="notice-text">
                    <strong>Domain registration does not include web hosting or a CyberPanel account.</strong>
                    To get your CyberPanel control panel, you must also purchase a
                    <a href="#pricing">Hosting Plan</a> (Starter, Business, or Cloud VPS).
                    Hosting orders are automatically provisioned with a CyberPanel account.
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#" class="logo">McJim<span class="gradient-text">Server</span></a>
                    <p>Premium web hosting services powered by cutting-edge cloud technology.</p>
                </div>
                <div class="footer-links">
                    <h4>Hosting</h4>
                    <a href="#">Shared Hosting</a>
                    <a href="#">Cloud Hosting</a>
                    <a href="#">VPS Hosting</a>
                    <a href="#">Dedicated Servers</a>
                </div>
                <div class="footer-links">
                    <h4>Company</h4>
                    <a href="#">About Us</a>
                    <a href="#">Contact</a>
                    <a href="#">Affiliates</a>
                    <a href="#">Careers</a>
                </div>
                <div class="footer-links">
                    <h4>Legal</h4>
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Refund Policy</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Copyright &copy; 2020-<?php echo date("Y");?> | McJim Cyberworks | Pagadian City, Philippines</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="script.js"></script>

</body>
</html>
