
USE fossbilling;

-- Create Categories
INSERT INTO product_category (title, description, created_at, updated_at) VALUES 
('Domain Registrations', 'Register a new domain name', NOW(), NOW()),
('Premium Web Services', 'Custom services such as SEO, SSL, and Design', NOW(), NOW()),
('Digital Products', 'Downloadable files, scripts, and software', NOW(), NOW());

-- Get Category IDs (Assuming they are the latest 3)
SET @cat_domains = (SELECT id FROM product_category WHERE title = 'Domain Registrations' LIMIT 1);
SET @cat_services = (SELECT id FROM product_category WHERE title = 'Premium Web Services' LIMIT 1);
SET @cat_downloads = (SELECT id FROM product_category WHERE title = 'Digital Products' LIMIT 1);

-- Insert Product Payments (Pricing models)
INSERT INTO product_payment (type, once_price, w_enabled, m_enabled, q_enabled, b_enabled, a_enabled, bia_enabled, tria_enabled) VALUES 
('once', 14.99, 0,0,0,0,0,0,0), -- domain
('once', 199.99, 0,0,0,0,0,0,0), -- SEO
('once', 24.50, 0,0,0,0,0,0,0); -- Download

SET @pay_domain = LAST_INSERT_ID() - 2;
SET @pay_seo = LAST_INSERT_ID() - 1;
SET @pay_dl = LAST_INSERT_ID();

-- Insert Products
INSERT INTO product (product_category_id, product_payment_id, title, slug, description, unit, active, status, hidden, setup, type, created_at, updated_at) VALUES
(@cat_domains, @pay_domain, '.com Domain Registration', 'com-domain-registration', 'Register your professional .com domain name today.', 'domain', 1, 'enabled', 0, 'after_payment', 'domain', NOW(), NOW()),
(@cat_services, @pay_seo, 'Complete SEO Optimization', 'complete-seo-optimization', 'Full on-page and off-page SEO optimization package for your website.', 'service', 1, 'enabled', 0, 'after_payment', 'custom', NOW(), NOW()),
(@cat_downloads, @pay_dl, 'Premium Website Template', 'premium-website-template', 'Download our premium HTML/CSS website template instantly after purchase.', 'download', 1, 'enabled', 0, 'after_payment', 'downloadable', NOW(), NOW());
