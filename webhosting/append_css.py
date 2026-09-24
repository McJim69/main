import os

css_path = r'd:\Server\www\webhosting\styles.css'

modal_css = """

/* Login Modal */
.modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}
.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}
.modal-content {
    width: 100%;
    max-width: 400px;
    padding: 40px;
    position: relative;
    transform: translateY(20px);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.modal-overlay.active .modal-content {
    transform: translateY(0);
}
.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.5rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: color 0.2s;
}
.close-modal:hover { color: white; }
.modal-header h3 { font-size: 1.8rem; margin-bottom: 5px; }
.modal-header p { color: var(--text-muted); margin-bottom: 25px; font-size: 0.9rem; }
.input-group { margin-bottom: 20px; text-align: left; }
.input-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-muted); }
.input-group input {
    width: 100%;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(10, 10, 15, 0.5);
    color: white;
    font-family: var(--font-main);
    outline: none;
    transition: all 0.3s ease;
}
.input-group input:focus {
    border-color: var(--accent-blue);
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
}
"""

with open(css_path, 'a', encoding='utf-8') as f:
    f.write(modal_css)

print("CSS appended")
