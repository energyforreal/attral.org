const contactForm = document.getElementById('contact-form');
const successMessage = document.getElementById('success-message');
const errorMessage = document.getElementById('error-message');
const errorDetail = document.getElementById('error-detail');
const confirmEmail = document.getElementById('confirm-email');
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file');
const fileSelected = document.getElementById('file-selected');
const fileSelectedName = document.getElementById('file-selected-name');
const fileClearBtn = document.getElementById('file-clear');
const csrfInput = document.getElementById('csrf-token');

function updateFileSelectionDisplay() {
  if (!fileInput) {
    return;
  }
  const file = fileInput.files?.[0];
  if (file && fileSelected && fileSelectedName) {
    fileSelectedName.textContent = file.name;
    fileSelectedName.title = file.name;
    fileSelected.style.display = 'flex';
    fileSelected.setAttribute('aria-hidden', 'false');
  } else if (fileSelected && fileSelectedName) {
    fileSelectedName.textContent = '';
    fileSelectedName.title = '';
    fileSelected.style.display = 'none';
    fileSelected.setAttribute('aria-hidden', 'true');
  }
}

const FRIENDLY_ERRORS = {
  RATE_LIMIT: 'Please wait a moment before sending another inquiry.',
  CSRF_INVALID: 'Your session expired. Refresh the page and try again.',
  FILE_TOO_LARGE: 'Attachment must be 10MB or smaller.',
  FILE_TYPE_NOT_ALLOWED: 'This attachment type is not supported.',
  FILE_MIME_MISMATCH: 'The selected file content does not match its extension.',
  INVALID_EMAIL: 'Please enter a valid email address.',
  INVALID_SERVICE: 'Please select a valid service.',
  CAPTCHA_FAILED: 'Captcha validation failed. Please try again.',
  MAIL_DELIVERY_FAILED: 'We could not send your inquiry right now. Please try again shortly.',
};

function setSubmitting(button, isSubmitting) {
  if (!button) {
    return;
  }
  button.disabled = isSubmitting;
  button.textContent = isSubmitting ? 'Sending...' : 'Send Inquiry →';
}

function setErrorMessage(message) {
  if (!errorMessage) {
    return;
  }
  errorMessage.style.display = 'block';
  errorMessage.setAttribute('aria-hidden', 'false');
  if (errorDetail) {
    errorDetail.textContent = message || '';
    errorDetail.style.display = message ? 'block' : 'none';
  }
  if (successMessage) {
    successMessage.style.display = 'none';
    successMessage.setAttribute('aria-hidden', 'true');
  }
}

function clearFeedback() {
  if (errorMessage) {
    errorMessage.style.display = 'none';
    errorMessage.setAttribute('aria-hidden', 'true');
  }
  if (errorDetail) {
    errorDetail.textContent = '';
    errorDetail.style.display = 'none';
  }
}

function parseServerError(payload) {
  const code = payload?.error?.code || '';
  const serverMessage = payload?.error?.message || '';
  return FRIENDLY_ERRORS[code] || serverMessage || 'Something went wrong while sending your message.';
}

async function requestCsrfToken() {
  if (!csrfInput) {
    return true;
  }
  try {
    const response = await fetch('./php/contact.php?csrf=1', {
      method: 'GET',
      headers: { Accept: 'application/json' },
    });
    const contentType = response.headers.get('content-type') || '';
    if (!response.ok || !contentType.includes('application/json')) {
      return false;
    }
    const payload = await response.json();
    if (payload?.success && payload?.csrfToken) {
      csrfInput.value = payload.csrfToken;
      return true;
    }
  } catch (error) {
    return false;
  }
  return false;
}

if (dropZone && fileInput) {
  dropZone.addEventListener('click', () => fileInput.click());

  dropZone.addEventListener('dragover', (event) => {
    event.preventDefault();
    dropZone.style.borderColor = 'hsl(var(--primary))';
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = 'hsl(var(--grey-300))';
  });

  dropZone.addEventListener('drop', (event) => {
    event.preventDefault();
    dropZone.style.borderColor = 'hsl(var(--grey-300))';
    if (event.dataTransfer.files.length) {
      fileInput.files = event.dataTransfer.files;
      updateFileSelectionDisplay();
    }
  });
}

if (fileInput) {
  fileInput.addEventListener('change', updateFileSelectionDisplay);
}

if (fileClearBtn && fileInput) {
  fileClearBtn.addEventListener('click', (event) => {
    event.preventDefault();
    event.stopPropagation();
    fileInput.value = '';
    updateFileSelectionDisplay();
  });
}

if (contactForm) {
  requestCsrfToken();

  contactForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    clearFeedback();

    const submitBtn = contactForm.querySelector('button[type="submit"]');
    if (!submitBtn) {
      return;
    }

    if (!csrfInput?.value) {
      const tokenReady = await requestCsrfToken();
      if (!tokenReady) {
        setErrorMessage('Unable to initialize secure submission. Please refresh and try again.');
        return;
      }
    }

    const formData = new FormData(contactForm);
    setSubmitting(submitBtn, true);

    try {
      const response = await fetch('./php/contact.php', {
        method: 'POST',
        body: formData,
      });
      const contentType = response.headers.get('content-type') || '';
      if (!contentType.includes('application/json')) {
        throw new Error('Unexpected server response. Please try again.');
      }

      const payload = await response.json();
      if (!response.ok || !payload?.success) {
        setErrorMessage(parseServerError(payload));
        if (payload?.error?.code === 'CSRF_INVALID') {
          requestCsrfToken();
        }
        return;
      }

      contactForm.style.display = 'none';
      if (successMessage) {
        successMessage.style.display = 'block';
        successMessage.setAttribute('aria-hidden', 'false');
      }
      if (confirmEmail) {
        confirmEmail.textContent = formData.get('email');
      }
    } catch (error) {
      setErrorMessage(error.message || 'Something went wrong while sending your message.');
    } finally {
      setSubmitting(submitBtn, false);
    }
  });
}
