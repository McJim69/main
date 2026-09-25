import paramiko

sql = """
USE fossbilling;

-- Create Donation Category
INSERT INTO product_category (title, description, created_at, updated_at) VALUES 
('Donation', 'Support our services with a one-time donation', NOW(), NOW());

SET @cat_donation = LAST_INSERT_ID();

-- Insert Product Payment (Pricing model)
INSERT INTO product_payment (type, once_price, w_enabled, m_enabled, q_enabled, b_enabled, a_enabled, bia_enabled, tria_enabled) VALUES 
('once', 10.00, 0,0,0,0,0,0,0);

SET @pay_donation = LAST_INSERT_ID();

-- Insert Donation Product
INSERT INTO product (product_category_id, product_payment_id, title, slug, description, unit, active, status, hidden, setup, type, allow_quantity_select, created_at, updated_at) VALUES
(@cat_donation, @pay_donation, 'Server Support ($10)', 'server-support-10', 'Thank you for your generous support! Your donation helps keep our servers running and allows us to continuously improve our services.', 'donation', 1, 'enabled', 0, 'after_payment', 'custom', 1, NOW(), NOW());
"""

with open('d:\\Server\\www\\add_donation.sql', 'w') as f:
    f.write(sql)

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('10.0.10.52', username='root', password='McJim654123')
sftp = ssh.open_sftp()
sftp.put('d:\\Server\\www\\add_donation.sql', '/tmp/add_donation.sql')
sftp.close()

stdin, stdout, stderr = ssh.exec_command('mysql -u fossbilling -pfossbilling_pass < /tmp/add_donation.sql')
print("STDOUT:", stdout.read().decode())
print("STDERR:", stderr.read().decode())

ssh.close()
