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
  <meta property="og:image" content="https://attral.org/images/og-image.jpg">
  <meta property="og:url" content="https://attral.org/contact.html">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="ATTRAL Contact">
  <meta name="twitter:description" content="Contact ATTRAL for PCB design, fabrication, web development, and AI automation services.">
  <meta name="twitter:image" content="https://attral.org/images/og-image.jpg">

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
  <section class="section" style="background:var(--color-bg-secondary);">
    <div class="container">
      <h1>Start Your Project</h1>
      <p>Fill in the form below and our team will get back to you within 24 business hours.</p>
    </div>
  </section>

  <section class="section">
    <div class="container contact-two-col" style="gap:24px;">
      <div class="card" style="box-shadow:0 4px 24px rgba(0,0,0,0.06);">
        <form id="contact-form" action="./php/contact.php" method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Full Name *</label>
              <input type="text" id="name" name="name" placeholder="John Smith" required>
            </div>
            <div class="form-group">
              <label for="email">Business Email *</label>
              <input type="email" id="email" name="email" placeholder="john@company.com" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="phone">Phone Number *</label>
              <input type="tel" id="phone" name="phone" placeholder="+91 9876543210" required>
            </div>
            <div class="form-group">
              <label for="company">Company Name</label>
              <input type="text" id="company" name="company" placeholder="ACME Corp">
            </div>
          </div>

          <div class="form-group">
            <label for="service">Service Required *</label>
            <select id="service" name="service" required>
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

          <div class="form-group">
            <label for="message">Project Description *</label>
            <textarea id="message" name="message" rows="5" placeholder="Describe your project, requirements, timeline, or any specific technical details..." required></textarea>
          </div>

          <div class="form-group" id="file-upload-group">
            <label for="file">Attach Files</label>
            <div class="file-upload-area" id="drop-zone">
              <input type="file" id="file" name="attachment" accept=".pdf,.zip,.rar,.gbr,.brd,.sch,.step,.png,.jpg">
              <p>Drag & drop files here, or <span>click to browse</span></p>
              <small>Accepted: PDF, ZIP, Gerber (.gbr), Eagle (.brd/.sch), STEP, Images · Max 10MB</small>
            </div>
          </div>

          <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

          <button type="submit" class="btn-primary btn--full">Send Inquiry →</button>

          <p class="form-note" style="margin-top:12px;color:var(--color-text-muted);">Your information is kept confidential. We never share your data with third parties.</p>
        </form>

        <div class="form-success" id="success-message">
          <div class="success-icon" style="font-size:24px;color:var(--color-success);">✓</div>
          <h3>Inquiry Received!</h3>
          <p>Thank you for reaching out. Our team will respond to <strong id="confirm-email"></strong> within 24 business hours.</p>
          <p>For urgent matters, WhatsApp us at <a href="https://wa.me/918903479870">+91 8903479870</a>.</p>
        </div>

        <div class="form-error" id="error-message">
          <p>Something went wrong while sending your message. Please try again or email us directly at <a href="mailto:info@attral.org">info@attral.org</a>.</p>
        </div>
      </div>

      <aside class="card" style="box-shadow:0 4px 24px rgba(0,0,0,0.06);">
        <h3>Contact Info</h3>
        <p>📍 Phase-2 Sathuvachari,<br>Vellore 632009,<br>Tamil Nadu, India</p>
        <div style="margin-top:16px;">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.0!2d79.131!3d12.971!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bad47a!2sPhase-2%20Sathuvachari%2C%20Vellore!5e0!3m2!1sen!2sin!4v1234567890!5m2!1sen!2sin" width="100%" height="200" style="border:0;border-radius:8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p>📧 General: <a href="mailto:info@attral.org">info@attral.org</a><br>📧 Projects: <a href="mailto:projects@attral.org">projects@attral.org</a></p>
        <p>📞 +91 8903479870</p>
        <p><a class="btn-primary" href="https://wa.me/918903479870" target="_blank" rel="noopener">WhatsApp Us →</a></p>
        <p style="margin-top:12px;color:var(--color-text-muted);">⏱ Response Time: Within 24 business hours</p>
      </aside>
    </div>
  </section>
</main>

<script src="js/contact.js" defer></script>
<?php include 'includes/footer.php'; ?>