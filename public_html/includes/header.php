<a href="#main-content" class="skip-link">Skip to main content</a>
<?php $hideHeaderCta = !empty($hideHeaderCta); ?>

<nav class="bg-white border-b border-grey-200 sticky top-0 z-50">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16">

      <!-- Logo -->
      <a href="index.html" class="flex items-center gap-3">
        <img src="images/attral-logo.svg" alt="ATTRAL" class="h-10 w-10 object-contain" width="40" height="40" loading="eager" fetchpriority="high" decoding="async" />
        <span class="text-xl font-bold text-secondary" style="font-family: 'Anta', sans-serif;">ATTRAL</span>
      </a>

      <!-- Desktop nav links -->
      <div class="hidden md:flex items-center gap-6">
        <a href="index.html" class="text-grey-600 hover:text-primary transition-colors">Home</a>
        <a href="services.html" class="text-grey-600 hover:text-primary transition-colors">Services</a>
        <a href="projects.html" class="text-grey-600 hover:text-primary transition-colors">Projects</a>
        <a href="contact.html" class="text-grey-600 hover:text-primary transition-colors">Contact</a>
      </div>

      <?php if (!$hideHeaderCta): ?>
      <!-- CTA buttons -->
      <div class="hidden md:flex items-center gap-4">
        <a href="contact.html" class="btn-hero btn-sm btn-base">Get Started</a>
      </div>
      <?php endif; ?>

      <!-- Mobile hamburger -->
      <button id="nav-toggle" class="md:hidden p-2 text-grey-600" aria-label="Toggle menu" aria-expanded="false">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>

    </div>
  </div>

  <!-- Mobile menu -->
  <div id="nav-mobile" class="hidden md:hidden bg-white border-t border-grey-200" aria-label="Mobile navigation">
    <div class="container mx-auto px-4 py-4 space-y-3">
      <a href="index.html" class="block text-grey-600 py-2 hover:text-primary transition-colors">Home</a>
      <a href="services.html" class="block text-grey-600 py-2 hover:text-primary transition-colors">Services</a>
      <a href="projects.html" class="block text-grey-600 py-2 hover:text-primary transition-colors">Projects</a>
      <a href="contact.html" class="block text-grey-600 py-2 hover:text-primary transition-colors">Contact</a>
      <?php if (!$hideHeaderCta): ?>
      <a href="contact.html" class="btn-hero btn-lg btn-base w-full justify-center">Get Started</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<script>
  const navToggle = document.getElementById('nav-toggle');
  const navMobile = document.getElementById('nav-mobile');
  
  navToggle?.addEventListener('click', () => {
    if (!navMobile) return;
    const isHidden = navMobile.classList.contains('hidden');
    if (isHidden) {
      navMobile.classList.remove('hidden');
      navToggle.setAttribute('aria-expanded', 'true');
    } else {
      navMobile.classList.add('hidden');
      navToggle.setAttribute('aria-expanded', 'false');
    }
  });

  // Close mobile menu when a link is clicked
  document.querySelectorAll('#nav-mobile a').forEach(link => {
    link.addEventListener('click', () => {
      navMobile.classList.add('hidden');
      navToggle.setAttribute('aria-expanded', 'false');
    });
  });
</script>