<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-black/5 shadow-sm">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
    
    <!-- Logo -->
    <a href="index.html" class="flex items-center gap-2 flex-shrink-0">
      <img src="images/attral-logo.svg" alt="ATTRAL" class="h-10 w-auto" width="140" height="45" />
    </a>

    <!-- Desktop Nav -->
    <nav class="hidden md:flex items-center gap-8 font-body text-sm font-medium tracking-wide">
      <a href="index.html" class="text-gray-700 hover:text-brand transition-colors">Home</a>
      <a href="services.html" class="text-gray-700 hover:text-brand transition-colors">Services</a>
      <a href="projects.html" class="text-gray-700 hover:text-brand transition-colors">Projects</a>
      <a href="process.html" class="text-gray-700 hover:text-brand transition-colors">Process</a>
      <a href="contact.html" class="text-gray-700 hover:text-brand transition-colors">Contact</a>
      <a href="contact.html" class="bg-brand text-white px-5 py-2 rounded font-semibold hover:bg-orange-600 transition-colors">
        Get a Quote →
      </a>
    </nav>

    <!-- Mobile Hamburger -->
    <button id="nav-toggle" class="md:hidden p-2 text-gray-700" aria-label="Toggle menu" aria-expanded="false">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
  </div>

  <!-- Mobile Menu -->
  <nav id="nav-mobile" class="hidden md:hidden bg-white border-t border-black/5" aria-label="Mobile navigation">
    <div class="px-6 py-4 space-y-3">
      <a href="index.html" class="block text-gray-700 py-2 hover:text-brand transition-colors">Home</a>
      <a href="services.html" class="block text-gray-700 py-2 hover:text-brand transition-colors">Services</a>
      <a href="projects.html" class="block text-gray-700 py-2 hover:text-brand transition-colors">Projects</a>
      <a href="process.html" class="block text-gray-700 py-2 hover:text-brand transition-colors">Process</a>
      <a href="contact.html" class="block text-gray-700 py-2 hover:text-brand transition-colors">Contact</a>
      <a href="contact.html" class="block bg-brand text-white px-4 py-2 rounded font-semibold text-center hover:bg-orange-600 transition-colors mt-2">
        Get a Quote →
      </a>
    </div>
  </nav>
</header>

<script>
  const navToggle = document.getElementById('nav-toggle');
  const navMobile = document.getElementById('nav-mobile');
  
  navToggle?.addEventListener('click', () => {
    const isHidden = navMobile?.classList.contains('hidden');
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