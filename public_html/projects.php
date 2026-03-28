<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ATTRAL — Projects | Portfolio</title>
  <meta name="description" content="Portfolio of ATTRAL projects in PCB engineering, web development, and AI solutions.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://attral.org/projects.html">

  <meta property="og:title" content="ATTRAL Projects">
  <meta property="og:description" content="Portfolio of ATTRAL projects in PCB engineering, web development, and AI solutions.">
  <meta property="og:image" content="https://attral.org/images/attral-logo.svg">
  <meta property="og:url" content="https://attral.org/projects.html">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="ATTRAL Projects">
  <meta name="twitter:description" content="Portfolio of ATTRAL projects in PCB engineering, web development, and AI solutions.">
  <meta name="twitter:image" content="https://attral.org/images/attral-logo.svg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Anta:wght@400&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="icon" type="image/svg+xml" href="images/favicon.svg">
  <link rel="apple-touch-icon" href="images/favicon.svg">
  <meta name="theme-color" content="#FF6600">

  <link rel="stylesheet" href="output.css">
</head>
<body class="font-sans bg-grey-50">
<?php include 'includes/header.php'; ?>

<main id="main-content">
  <section class="py-24 bg-gradient-subtle">
    <div class="container mx-auto px-4">
      <div class="text-center">
        <h1 class="heading-xl text-secondary mb-6">Our Work</h1>
        <p class="body-lg text-grey-600 max-w-3xl mx-auto leading-relaxed">Real projects. Measurable outcomes.</p>
      </div>
    </div>
  </section>

  <section class="sticky top-16 z-40 bg-white border-b border-grey-200">
    <div class="container mx-auto px-4 py-4" role="group" aria-label="Project filters">
      <div class="flex flex-wrap gap-3 justify-center">
        <button class="filter-btn active btn-premium btn-lg btn-base border border-grey-300" data-category="all" aria-pressed="true" aria-controls="projects-grid">All</button>
        <button class="filter-btn btn-premium btn-lg btn-base border border-grey-300" data-category="pcb" aria-pressed="false" aria-controls="projects-grid">PCB & Electronics</button>
        <button class="filter-btn btn-premium btn-lg btn-base border border-grey-300" data-category="web" aria-pressed="false" aria-controls="projects-grid">Web Dev</button>
        <button class="filter-btn btn-premium btn-lg btn-base border border-grey-300" data-category="ai" aria-pressed="false" aria-controls="projects-grid">AI Solutions</button>
      </div>
    </div>
    <p id="projects-filter-status" class="sr-only" aria-live="polite"></p>
  </section>

  <section class="py-24 bg-white">
    <div class="container mx-auto px-4">
      <div id="projects-grid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
        <article class="card-hover bg-white rounded-xl shadow-medium border border-grey-200 overflow-hidden flex flex-col project-item" data-category="pcb">
          <img src="images/pcb-project.svg" alt="Industrial Controller Board — custom PCB design with EMI control" class="w-full h-auto object-cover" width="800" height="500" loading="eager" fetchpriority="high" decoding="async">
          <div class="p-8 flex flex-col h-full">
            <div class="text-sm text-grey-500 font-medium mb-2">PCB & Electronics</div>
            <h3 class="text-xl font-semibold text-secondary mb-3">Industrial Controller Board</h3>
            <p class="text-grey-600 mb-6 flex-grow leading-relaxed">Custom design with EMI control and power distribution for manufacturing automation.</p>
            <a class="btn-outline btn-lg btn-base w-full mt-auto" href="contact.html">Discuss Your Project</a>
          </div>
        </article>
        <article class="card-hover bg-white rounded-xl shadow-medium border border-grey-200 overflow-hidden flex flex-col project-item" data-category="web">
          <img src="images/web-app-project.svg" alt="Supply Chain Management Platform — web application with real-time tracking" class="w-full h-auto object-cover" width="800" height="500" loading="lazy" decoding="async">
          <div class="p-8 flex flex-col h-full">
            <div class="text-sm text-grey-500 font-medium mb-2">Web Development</div>
            <h3 class="text-xl font-semibold text-secondary mb-3">Supply Chain Management Platform</h3>
            <p class="text-grey-600 mb-6 flex-grow leading-relaxed">High-performance portal with tracking, reporting, and real-time APIs.</p>
            <a class="btn-outline btn-lg btn-base w-full mt-auto" href="contact.html">Discuss Your Project</a>
          </div>
        </article>
        <article class="card-hover bg-white rounded-xl shadow-medium border border-grey-200 overflow-hidden flex flex-col project-item" data-category="ai">
          <img src="images/ai-automation-project.svg" alt="Process Automation Pipeline — document ingestion with LLM summarization" class="w-full h-auto object-cover" width="800" height="500" loading="lazy" decoding="async">
          <div class="p-8 flex flex-col h-full">
            <div class="text-sm text-grey-500 font-medium mb-2">AI Solutions</div>
            <h3 class="text-xl font-semibold text-secondary mb-3">Process Automation Pipeline</h3>
            <p class="text-grey-600 mb-6 flex-grow leading-relaxed">Document ingestion and automated ticket routing with LLM summarization.</p>
            <a class="btn-outline btn-lg btn-base w-full mt-auto" href="contact.html">Discuss Your Project</a>
          </div>
        </article>
        <article class="card-hover bg-white rounded-xl shadow-medium border border-grey-200 overflow-hidden flex flex-col project-item" data-category="pcb">
          <img src="images/pcb-assembly-project.svg" alt="Medical-Grade Sensor Module — certified PCB assembly" class="w-full h-auto object-cover" width="800" height="500" loading="lazy" decoding="async">
          <div class="p-8 flex flex-col h-full">
            <div class="text-sm text-grey-500 font-medium mb-2">PCB & Electronics</div>
            <h3 class="text-xl font-semibold text-secondary mb-3">Medical-Grade Sensor Module</h3>
            <p class="text-grey-600 mb-6 flex-grow leading-relaxed">Certified assembly, test controls, and compliance documentation.</p>
            <a class="btn-outline btn-lg btn-base w-full mt-auto" href="contact.html">Discuss Your Project</a>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section class="py-24 bg-grey-50">
    <div class="container mx-auto px-4 text-center">
      <h2 class="heading-lg text-secondary mb-6">Seen enough? Let’s build yours.</h2>
      <p class="body-lg text-grey-600 max-w-2xl mx-auto leading-relaxed mb-10">Share requirements and we’ll propose a clear scope, timeline, and deliverables.</p>
      <a class="btn-hero btn-xl btn-base group" href="contact.html">
        Start a Project
        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
      </a>
    </div>
  </section>
</main>

<script src="js/projects-filter.js" defer></script>
<?php include 'includes/footer.php'; ?>