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
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/variables.css">
  <link rel="stylesheet" href="css/typography.css">
  <link rel="stylesheet" href="css/layout.css">
  <link rel="stylesheet" href="css/components.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<main id="main-content">
  <section class="section" style="background:#FAFAF8;">
    <div class="container">
      <h1>Our Work</h1>
      <p>Real projects. Measurable outcomes.</p>
    </div>
  </section>

  <section class="section" style="position:sticky;top:72px;z-index:900;background:#fff;padding:16px 0;">
    <div class="container" style="display:flex;flex-wrap:wrap;gap:12px;">
      <button class="filter-btn active btn-secondary" data-category="all">All</button>
      <button class="filter-btn btn-secondary" data-category="pcb">PCB & Electronics</button>
      <button class="filter-btn btn-secondary" data-category="web">Web Dev</button>
      <button class="filter-btn btn-secondary" data-category="ai">AI Solutions</button>
    </div>
  </section>

  <section class="section" style="background:#fff;border-top:1px solid var(--color-border);">
    <div class="container card-grid-4">
      <article class="card card--project project-item" data-category="pcb">
        <img class="card__image" src="images/pcb-project.jpg" alt="PCB Project" loading="lazy">
        <div class="card__body">
          <span class="small-uppercase">PCB & Electronics</span>
          <h3>Industrial Controller Board</h3>
          <p>Custom design with EMI control and power distribution for manufacturing automation.</p>
          <a class="btn-text" href="contact.html">Discuss Your Project →</a>
        </div>
      </article>
      <article class="card card--project project-item" data-category="web">
        <img class="card__image" src="images/web-app-project.jpg" alt="Web App" loading="lazy">
        <div class="card__body">
          <span class="small-uppercase">Web Development</span>
          <h3>Supply Chain Management Platform</h3>
          <p>High-performance portal with tracking, reporting, and real-time APIs.</p>
          <a class="btn-text" href="contact.html">Discuss Your Project →</a>
        </div>
      </article>
      <article class="card card--project project-item" data-category="ai">
        <img class="card__image" src="images/ai-automation-project.jpg" alt="AI Automation" loading="lazy">
        <div class="card__body">
          <span class="small-uppercase">AI Solutions</span>
          <h3>Process Automation Pipeline</h3>
          <p>Document ingestion and automated ticket routing with LLM summarization.</p>
          <a class="btn-text" href="contact.html">Discuss Your Project →</a>
        </div>
      </article>
      <article class="card card--project project-item" data-category="pcb">
        <img class="card__image" src="images/pcb-assembly-project.jpg" alt="PCB Assembly" loading="lazy">
        <div class="card__body">
          <span class="small-uppercase">PCB & Electronics</span>
          <h3>Medical-Grade Sensor Module</h3>
          <p>CERAs for assembly, test controls, and compliance documentation.</p>
          <a class="btn-text" href="contact.html">Discuss Your Project →</a>
        </div>
      </article>
    </div>
  </section>

  <section class="section" style="background:var(--color-orange);color:#fff;">
    <div class="container" style="text-align:center;">
      <h2>Seen enough? Let's build yours.</h2>
      <a class="btn-primary" href="contact.html">Start a Project →</a>
    </div>
  </section>
</main>

<script src="js/projects-filter.js" defer></script>
<?php include 'includes/footer.php'; ?>