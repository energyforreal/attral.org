/**
 * Enhanced Interactions & Visual Effects
 */

// Card hover effects
document.addEventListener('DOMContentLoaded', function() {
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const cards = document.querySelectorAll('.card-hover');
  
  if (!prefersReducedMotion) {
    cards.forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px)';
        this.style.boxShadow = '0 20px 48px rgba(0, 0, 0, 0.12)';
        this.style.transition = 'all 300ms cubic-bezier(0.4, 0, 0.2, 1)';
      });
      
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.06), 0 8px 24px rgba(0, 0, 0, 0.04)';
      });
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href !== '#' && document.querySelector(href)) {
        e.preventDefault();
        document.querySelector(href).scrollIntoView({
          behavior: prefersReducedMotion ? 'auto' : 'smooth',
          block: 'start'
        });
      }
    });
  });

});

// Form interaction enhancements
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contact-form');
  if (form) {
    // Real-time validation feedback
    form.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
      field.addEventListener('blur', function() {
        validateField(this);
      });
      
      field.addEventListener('focus', function() {
        this.parentElement?.classList.remove('error');
        const errorMsg = this.parentElement?.querySelector('.error-message');
        if (errorMsg) errorMsg.remove();
      });
    });

    form.addEventListener('submit', function(e) {
      const fields = form.querySelectorAll('input[required], textarea[required], select[required]');
      let isValid = true;

      fields.forEach(field => {
        if (!validateField(field)) {
          isValid = false;
        }
      });

      if (!isValid) {
        e.preventDefault();
      }
    });
  }
});

function validateField(field) {
  const value = field.value.trim();
  
  if (field.type === 'email') {
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    setFieldValidation(field, isValid, 'Please enter a valid email address');
    return isValid;
  } else if (field.type === 'tel') {
    const isValid = /^[\d\s\-\+\(\)]{8,}$/.test(value);
    setFieldValidation(field, isValid, 'Please enter a valid phone number');
    return isValid;
  } else if (field.value.length === 0) {
    setFieldValidation(field, false, 'This field is required');
    return false;
  } else {
    setFieldValidation(field, true);
    return true;
  }
}

function setFieldValidation(field, isValid, errorMessage) {
  const parent = field.parentElement;
  
  // Remove existing error message
  const existingError = parent?.querySelector('.error-message');
  if (existingError) existingError.remove();
  
  if (!isValid) {
    parent?.classList.add('error');
    field.setAttribute('aria-invalid', 'true');
    
    if (errorMessage) {
      const errorEl = document.createElement('small');
      errorEl.className = 'error-message text-red-500 block mt-1 text-xs';
      errorEl.textContent = errorMessage;
      parent?.appendChild(errorEl);
    }
  } else {
    parent?.classList.remove('error');
    field.setAttribute('aria-invalid', 'false');
  }
}

// Add loading state to buttons
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('form').forEach(form => {
    if (form.id === 'contact-form') {
      return;
    }

    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
      form.addEventListener('submit', function() {
        const isValid = Array.from(this.querySelectorAll('[required]')).every(field => {
          return field.value.trim() !== '';
        });
        
        if (isValid) {
          submitBtn.disabled = true;
          submitBtn.style.opacity = '0.6';
          submitBtn.textContent = 'Sending...';
        }
      });
    }
  });
});
