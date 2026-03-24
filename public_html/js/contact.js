const contactForm = document.getElementById('contact-form');
const successMessage = document.getElementById('success-message');
const errorMessage = document.getElementById('error-message');
const confirmEmail = document.getElementById('confirm-email');
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file');

if (dropZone && fileInput) {
  dropZone.addEventListener('click', () => fileInput.click());

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = 'var(--color-orange)';
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = 'var(--color-border)';
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = 'var(--color-border)';
    if (e.dataTransfer.files.length) {
      fileInput.files = e.dataTransfer.files;
    }
  });
}

if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');

    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;

    fetch('./php/contact.php', {
      method: 'POST',
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          contactForm.style.display = 'none';
          successMessage.style.display = 'block';
          if (confirmEmail) {
            confirmEmail.textContent = formData.get('email');
          }
        } else {
          errorMessage.style.display = 'block';
          submitBtn.textContent = 'Send Inquiry →';
          submitBtn.disabled = false;
        }
      })
      .catch(() => {
        errorMessage.style.display = 'block';
        submitBtn.textContent = 'Send Inquiry →';
        submitBtn.disabled = false;
      });
  });
}
