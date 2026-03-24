const header = document.querySelector('.site-header');
const navToggle = document.querySelector('.nav-toggle');
const mobileOverlay = document.querySelector('.nav-mobile-overlay');
const navClose = document.querySelector('.nav-close');

window.addEventListener('scroll', () => {
  if (window.scrollY > 20) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
});

if (navToggle && mobileOverlay) {
  navToggle.addEventListener('click', () => mobileOverlay.classList.add('open'));
}

if (navClose && mobileOverlay) {
  navClose.addEventListener('click', () => mobileOverlay.classList.remove('open'));
}

document.querySelectorAll('.nav-mobile-overlay a').forEach((link) => {
  link.addEventListener('click', () => mobileOverlay.classList.remove('open'));
});

document.querySelectorAll('.nav-link').forEach((a) => {
  const href = a.getAttribute('href');
  if (
    (href === 'index.html' && (window.location.pathname === '/' || window.location.pathname.endsWith('/index.html'))) ||
    window.location.pathname.endsWith(href)
  ) {
    a.classList.add('active');
  }
});
