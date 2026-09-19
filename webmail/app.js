document.addEventListener('DOMContentLoaded', () => {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const formSections = document.querySelectorAll('.form-section');

    const createForm = document.getElementById('create-form');
    const createMessage = document.getElementById('create-message');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            formSections.forEach(f => {
                f.classList.remove('active');
                f.classList.add('hidden');
            });

            btn.classList.add('active');
            
            const targetId = btn.getAttribute('data-target');
            const targetForm = document.getElementById(targetId);
            
            targetForm.classList.remove('hidden');
            targetForm.classList.add('active');
            
            if (createMessage) createMessage.textContent = '';
        });
    });

    const togglePasswordBtn = document.getElementById('toggle-password');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', () => {
            const passInput = document.getElementById('create-password');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                togglePasswordBtn.textContent = 'Hide';
                togglePasswordBtn.style.color = '#fff';
            } else {
                passInput.type = 'password';
                togglePasswordBtn.textContent = 'Show';
                togglePasswordBtn.style.color = '';
            }
        });
    }

    if (createForm) {
        createForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('create-email').value;
            const password = document.getElementById('create-password').value;
            const submitBtn = createForm.querySelector('.submit-btn');

            createMessage.textContent = 'Creating mailbox...';
            createMessage.className = 'message';
            submitBtn.disabled = true;

            try {
                const response = await fetch('api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'create-account', email, password })
                });

                const data = await response.json();

                if (data.success) {
                    createMessage.textContent = data.message;
                    createMessage.className = 'message success';
                    createForm.reset();
                } else {
                    createMessage.textContent = data.message || 'Failed to create mailbox.';
                    createMessage.className = 'message error';
                }
            } catch (error) {
                createMessage.textContent = 'A network error occurred.';
                createMessage.className = 'message error';
            } finally {
                submitBtn.disabled = false;
            }
        });
    }
});
