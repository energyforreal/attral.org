# ATTRAL Website — attral.org

B2B engineering company website. Static HTML/CSS/PHP.

## Stack
- HTML5, CSS3, Vanilla JS (no frameworks)
- PHP 8+ (contact form backend)
- Hosted on Hostinger shared hosting

## Local Development
1. Clone the repo
2. Open `public_html/index.html` in a browser for HTML/CSS work
3. For PHP testing: use XAMPP or MAMP to run locally
   - Point document root to `/public_html`
   - Test contact form at localhost/contact.html

## Deployment
Upload `public_html/` contents to Hostinger `/public_html/` via File Manager.
Ensure `/uploads/.htaccess` is in place before going live.

## File Structure
- `public_html/` — Web root
  - `css/` — Stylesheets (variables.css first, then reset.css, etc.)
  - `js/` — Scripts (deferred)
  - `php/` — Backend scripts
  - `uploads/` — File uploads (protected by .htaccess)
  - `images/` — Static images
  - HTML pages
- `.htaccess` — Apache config (HTTPS, caching, compression)
- `robots.txt` — Crawler rules
- `sitemap.xml` — URL index

## Key Features
- Responsive design with mobile nav
- AJAX contact form with file upload
- Scroll animations
- Project filtering
- WhatsApp integration
- SEO optimized (meta tags, schema, canonical)

## Contact
info@attral.org | +91 8903479870
