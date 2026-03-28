const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// Back-compat: legacy pages used .animate-on-scroll + .is-visible
const legacyAnimatedElements = document.querySelectorAll('.animate-on-scroll');

// New design system: use .reveal-on-scroll and we add .fade-in when visible
const designSystemRevealElements = document.querySelectorAll('.reveal-on-scroll');

const markVisible = (el) => {
  if (el.classList.contains('reveal-on-scroll')) {
    el.classList.add('fade-in');
  } else {
    el.classList.add('is-visible');
  }
};

if (prefersReducedMotion) {
  legacyAnimatedElements.forEach(markVisible);
  designSystemRevealElements.forEach(markVisible);
} else {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        markVisible(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

  legacyAnimatedElements.forEach((el) => observer.observe(el));
  designSystemRevealElements.forEach((el) => observer.observe(el));
}
