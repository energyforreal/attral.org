<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ATTRAL — Contact | Start Your Project</title>
  <meta name="description" content="Contact ATTRAL for PCB design, fabrication, web development, and AI automation services.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://attral.org/contact.html">

  <meta property="og:title" content="ATTRAL Contact">
  <meta property="og:description" content="Contact ATTRAL for PCB design, fabrication, web development, and AI automation services.">
  <meta property="og:image" content="https://attral.org/images/attral-logo.svg">
  <meta property="og:url" content="https://attral.org/contact.html">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="ATTRAL Contact">
  <meta name="twitter:description" content="Contact ATTRAL for PCB design, fabrication, web development, and AI automation services.">
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
<?php $hideHeaderCta = true; ?>
<?php include 'includes/header.php'; ?>

<main id="main-content">
  <section class="py-24 bg-gradient-subtle">
    <div class="container mx-auto px-4">
      <div class="text-center">
        <h1 class="heading-xl text-secondary mb-6">Start Your Project</h1>
        <p class="body-lg text-grey-600 max-w-3xl mx-auto leading-relaxed">Fill in the form below and our team will get back to you within 24 business hours.</p>
      </div>
    </div>
  </section>

  <section class="py-24 bg-grey-50">
    <div class="container mx-auto px-4">
      <div class="grid lg:grid-cols-2 gap-12 items-start max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-large border border-grey-200 p-8">
          <form id="contact-form" action="./php/contact.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid sm:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-grey-700">Full Name *</label>
                <input type="text" id="name" name="name" placeholder="John Smith" required class="w-full px-3 py-2 border border-grey-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              </div>
              <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-grey-700">Business Email *</label>
                <input type="email" id="email" name="email" placeholder="john@company.com" required class="w-full px-3 py-2 border border-grey-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="phone" class="text-sm font-medium text-grey-700">Phone Number *</label>
                <input type="tel" id="phone" name="phone" placeholder="+91 9876543210" required class="w-full px-3 py-2 border border-grey-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              </div>
              <div class="space-y-2">
                <label for="company" class="text-sm font-medium text-grey-700">Company Name</label>
                <input type="text" id="company" name="company" placeholder="ACME Corp" class="w-full px-3 py-2 border border-grey-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
              </div>
            </div>

            <div class="space-y-2">
              <label for="service" class="text-sm font-medium text-grey-700">Service Required *</label>
              <select id="service" name="service" required class="w-full px-3 py-2 border border-grey-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white">
                <option value="" disabled selected>Select a service...</option>
                <optgroup label="PCB & Electronics Engineering">
                  <option value="pcb-design">PCB Design</option>
                  <option value="pcb-fabrication">PCB Fabrication & Assembly</option>
                </optgroup>
                <optgroup label="Software & AI Solutions">
                  <option value="web-development">Full Stack Web Development</option>
                  <option value="ai-agent">AI Agent Development</option>
                  <option value="ai-automation">AI Workflow Automation</option>
                </optgroup>
                <option value="other">Other / General Inquiry</option>
              </select>
            </div>

            <div class="space-y-2">
              <label for="message" class="text-sm font-medium text-grey-700">Project Description *</label>
              <textarea id="message" name="message" rows="5" placeholder="Describe your project, requirements, timeline, or any specific technical details..." required class="w-full px-3 py-2 border border-grey-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
            </div>

            <div class="space-y-2" id="file-upload-group">
              <label for="file" class="text-sm font-medium text-grey-700">Attach Files</label>
              <div id="drop-zone" class="border border-grey-300 rounded-lg p-4 text-center cursor-pointer hover:border-primary transition-colors">
                <input type="file" id="file" name="attachment" accept=".pdf,.zip,.rar,.gbr,.brd,.sch,.step,.png,.jpg,.jpeg" class="hidden">
                <p class="text-grey-700">Drag & drop files here, or <span class="text-primary font-medium">click to browse</span></p>
                <small class="text-grey-500 block mt-2">Accepted: PDF, ZIP, Gerber (.gbr), Eagle (.brd/.sch), STEP, Images · Max 10MB</small>
              </div>
            </div>

            <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">
            <input type="hidden" name="csrf_token" id="csrf-token" value="">

            <button type="submit" class="btn-hero btn-lg btn-base w-full justify-center">Send Inquiry →</button>
            <p class="text-sm text-grey-500">Your information is kept confidential. We never share your data with third parties.</p>
          </form>

          <div id="success-message" role="status" aria-live="polite" aria-hidden="true" style="display:none;" class="mt-6">
            <div class="bg-grey-50 border border-grey-200 rounded-xl p-6">
              <div class="text-2xl font-bold text-secondary mb-2">Inquiry Received!</div>
              <p class="text-grey-600 leading-relaxed">Thank you for reaching out. Our team will respond to <strong id="confirm-email"></strong> within 24 business hours.</p>
              <p class="text-grey-600 leading-relaxed mt-3">For urgent matters, WhatsApp us at <a class="text-primary font-medium" href="https://wa.me/918903479870">+91 8903479870</a>.</p>
            </div>
          </div>

          <div id="error-message" role="alert" aria-live="assertive" aria-hidden="true" style="display:none;" class="mt-6">
            <div class="bg-grey-50 border border-grey-200 rounded-xl p-6">
              <p class="text-grey-700">Something went wrong while sending your message. Please try again or email us directly at <a class="text-primary font-medium" href="mailto:info@attral.org">info@attral.org</a>.</p>
              <p id="error-detail" class="text-grey-600 text-sm mt-3"></p>
            </div>
          </div>
        </div>

        <aside class="bg-white rounded-xl shadow-large border border-grey-200 p-8">
          <h2 class="heading-sm text-secondary mb-6">Contact Info</h2>
          <div class="space-y-4 text-grey-600 leading-relaxed">
            <div>
              <div class="text-sm font-semibold text-grey-700">Location</div>
              <div>Phase-2 Sathuvachari,<br>Vellore 632009,<br>Tamil Nadu, India</div>
            </div>
            <div>
              <div class="text-sm font-semibold text-grey-700">Email</div>
              <div>General: <a class="text-primary font-medium" href="mailto:info@attral.org">info@attral.org</a></div>
              <div>Projects: <a class="text-primary font-medium" href="mailto:projects@attral.org">projects@attral.org</a></div>
            </div>
            <div>
              <div class="text-sm font-semibold text-grey-700">Phone</div>
              <div><a class="text-primary font-medium" href="tel:+918903479870">+91 8903479870</a></div>
            </div>
            <div class="pt-2">
              <a class="btn-premium btn-lg btn-base w-full justify-center" href="https://wa.me/918903479870" target="_blank" rel="noopener">WhatsApp Us</a>
            </div>
            <div class="text-sm text-grey-500">Response Time: Within 24 business hours</div>
          </div>
        </aside>
      </div>
    </div>
  </section>
</main>

<script src="js/contact.js" defer></script>
<?php include 'includes/footer.php'; ?>