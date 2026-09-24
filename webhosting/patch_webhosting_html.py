import os

file_path = r'd:\Server\www\webhosting.html'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

domains_html = """    </section>

    <!-- Domains Section -->
    <section id="domains" class="domains">
        <div class="container">
            <div class="section-header reveal">
                <h2>Find Your Perfect Domain</h2>
                <p>Register or transfer your domain name today. We support all popular extensions.</p>
            </div>
            
            <div class="domain-search-box glass-panel reveal" style="transition-delay: 0.1s;">
                <form action="https://billing.mcjim-server.com/order" method="GET" class="domain-form">
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
        </div>
    </section>
</div>

<style>"""

if "<!-- Domains Section -->" not in content:
    content = content.replace("    </section>\n</div>\n\n<style>", domains_html)
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Patched webhosting.html")
else:
    print("Domains section already exists.")
