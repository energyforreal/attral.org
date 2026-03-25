document.addEventListener('DOMContentLoaded', () => {
  const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
  const navLinks = document.querySelectorAll('header nav a[href]');

  navLinks.forEach((link) => {
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('http')) {
      return;
    }

    const normalizedHref = href.replace(/^\.\//, '');
    let isActive = false;

    if (normalizedHref === 'index.html') {
      isActive = currentPath === '/' || currentPath.endsWith('/index.html') || currentPath.endsWith('/index.php');
    } else {
      const basename = currentPath.split('/').pop() || '';
      isActive = basename === normalizedHref;
    }

    if (isActive) {
      link.classList.add('text-brand');
      link.setAttribute('aria-current', 'page');
    }
  });
});
