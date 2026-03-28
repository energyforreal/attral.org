document.addEventListener('DOMContentLoaded', () => {
  const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
  const currentBasename = currentPath.split('/').pop() || '';
  const navLinks = document.querySelectorAll('nav a[href]');
  const normalizeRoute = (value) => value.replace(/^\.\//, '').replace(/\.php$/, '.html');

  navLinks.forEach((link) => {
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('http')) {
      return;
    }
    if (!link.classList.contains('text-grey-600')) {
      return;
    }

    const normalizedHref = normalizeRoute(href);
    let isActive = false;

    if (normalizedHref === 'index.html') {
      isActive = currentPath === '/' || currentPath.endsWith('/index.html') || currentPath.endsWith('/index.php');
    } else {
      isActive = normalizeRoute(currentBasename) === normalizedHref;
    }

    if (isActive) {
      link.classList.remove('text-grey-600');
      link.classList.add('text-primary', 'font-medium');
      link.setAttribute('aria-current', 'page');
    }
  });

  // Preserve year rendering for pages using #year in footer markup.
  document.querySelectorAll('#year').forEach((yearNode) => {
    yearNode.textContent = new Date().getFullYear();
  });

  // Some legacy assets are PNG files with .svg extension.
  // Retry with a cache-busting query to bypass stale/broken cached responses.
  document.querySelectorAll('img[src$=".svg"]').forEach((image) => {
    image.addEventListener('error', () => {
      if (!image.dataset.retrySvg) {
        image.dataset.retrySvg = '1';
        const separator = image.src.includes('?') ? '&' : '?';
        image.src = `${image.src}${separator}v=png`;
        return;
      }

      // Avoid showing broken-image glyph if retries fail.
      image.style.visibility = 'hidden';
    });
  });
});
