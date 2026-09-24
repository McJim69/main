import os

html_path = r'd:\Server\www\webhosting.html'

with open(html_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace login button
old_btn = '<a href="https://billing.mcjim-server.com/login" class="login-btn"><strong>Client Login</strong></a>'
new_btn = '<a href="#" class="login-btn" onclick="document.getElementById(\'loginModal\').classList.add(\'active\'); return false;"><strong>Client Login</strong></a>'
content = content.replace(old_btn, new_btn)

# Add modal HTML before closing body
modal_html = """
    <!-- Login Modal -->
    <div class="modal-overlay" id="loginModal">
        <div class="modal-content glass-panel">
            <span class="close-modal" onclick="document.getElementById('loginModal').classList.remove('active');">&times;</span>
            <div class="modal-header">
                <h3>Client Login</h3>
                <p>Access your McJim Server dashboard</p>
            </div>
            <form action="https://billing.mcjim-server.com/sso.php" method="POST" class="login-form">
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="btn btn-primary btn-block glow-effect">Login</button>
            </form>
            <div id="login-error" style="color: #ef4444; margin-top: 15px; font-size: 0.9rem; display: none;">Invalid credentials. Please try again.</div>
        </div>
    </div>
    
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error')) {
            document.getElementById('loginModal').classList.add('active');
            document.getElementById('login-error').style.display = 'block';
        }
    </script>
"""

if "id=\"loginModal\"" not in content:
    content = content.replace('</body>', modal_html + '\n</body>')

with open(html_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("HTML updated")
