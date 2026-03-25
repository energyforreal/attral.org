# ATTRAL.org Website — Quick Testing Guide

**Last Updated:** March 25, 2026  
**Environment:** Hostinger Shared Hosting (PHP 8+)

---

## 🏃 Quick Start — 5 Minute Test

### Step 1: Upload Files to Hostinger
```
1. Log into Hostinger File Manager
2. Navigate to public_html/
3. Upload/overwrite these directories:
   - css/ (all files)
   - js/ (all files including new enhancements.js)
   - images/ (all files including new .svg files)
   - includes/ (header.php, footer.php)
4. Replace HTML pages: index.html, services.html, projects.html, etc.
5. Update: robots.txt, sitemap.xml
```

### Step 2: Clear Browser Cache
- Press `Ctrl+F5` (Windows) or `Cmd+Shift+R` (Mac)
- Or clear browser cache completely

### Step 3: Test Homepage
Visit: **https://attral.org**

**Checklist:**
- ✅ Logo appears in sticky header
- ✅ Header stays at top when scrolling
- ✅ Mobile menu button appears on small screens
- ✅ Footer shows at bottom with contact info
- ✅ All section images load (SVG placeholders)
- ✅ Buttons have hover effects (orange color)

---

## 📱 Mobile Testing

### Test on Small Screen (375px)
1. Open DevTools: `F12` (Windows) or `Cmd+Option+I` (Mac)
2. Click Device Toolbar icon (mobile phone icon)
3. Select "iPhone 12" (375px width)

**Check:**
- [ ] Navigation links hidden, hamburger menu visible
- [ ] Click hamburger — menu drops down
- [ ] Click a menu item — menu closes
- [ ] All text readable (no horizontal scroll)
- [ ] Footer links clickable

### Test on Tablet (768px)
- Change device to "iPad" in DevTools
- Desktop nav should reappear (no hamburger)

---

## 🎨 Visual Verification

### Header
```
[Logo] Home Services Projects Process Contact [Get a Quote CTA]
```
- Logo: 40px height, dark text with orange accent
- On mobile: Logo + hamburger only

### Cards (Hover Test)
1. Go to Services section
2. Hover over a service card
3. **Expected:** Card lifts up (translateY -8px) with shadow

### Form (Contact Page)
1. Go to /contact.html
2. Leave "Full Name" empty
3. Click outside the field
4. **Expected:** Red border appears + error message shows

### Images
All should display as light gradient SVG placeholders:
- PCB Board (teal-ish gradient)
- Dashboard (dark-orange gradient)
- Automation (reverse gradient)
- Medical Sensor (vertical gradient)

---

## ⚡ Performance Tests

### Google PageSpeed Insights
```
1. Visit https://pagespeed.web.dev
2. Enter: https://attral.org
3. Run analysis
4. Target: 80+ score (FCP < 1.8s, LCP < 2.5s)
```

### Check Console Errors
1. Open DevTools: `F12`
2. Go to Console tab
3. **Should see:** No red errors

### Network Tab
1. Go to Network tab
2. Refresh page
3. **Look for:**
   - Tailwind CDN loading (~70KB minified)
   - All .jpg → now .svg files
   - No 404 errors on images

---

## 🔗 Link Verification

### Navigation Links
- [ ] Legacy route redirects work (`/services.php` -> `/services.html`, etc.)
- [ ] Home → loads `/index.html`
- [ ] Services → loads `/services.html`
- [ ] Projects → loads `/projects.html`
- [ ] Process → loads `/process.html`
- [ ] Contact → loads `/contact.html`
- [ ] Logo → returns to homepage

### Footer Links
- [ ] Privacy Policy → `/privacy.html`
- [ ] Terms of Use → `/terms.html`
- [ ] All service links work
- [ ] All company links work

### External Links
- [ ] "Get a Quote" CTA → `/contact.html`
- [ ] WhatsApp button → opens WhatsApp with message pre-filled
- [ ] GitHub link (if added) → external site

---

## 📝 Form Testing

### Contact Form
1. Visit `/contact.html`
2. Leave all fields blank
3. Click outside each field — should show error
4. Fill in fields:
   - **Name:** John Smith ✅
   - **Email:** invalid → shows error ❌
   - **Email:** john@example.com ✅
   - **Phone:** 123 → error (too short) ❌
   - **Phone:** +91 8903479870 ✅
5. **Submit:** Should show "Sending..." in button

### Expected Behavior
```
Valid values:
- Email: Must contain @
- Phone: At least 8 characters
- All required fields: Not empty

Errors appear on blur (leave field)
Form blocks submission if any error
Success (after PHP): Redirect or message
```

---

## 🔍 SEO Verification

### Favicon
- [ ] Appears in browser tab
- [ ] iOS: Save homepage to home screen → apple icon appears

### Meta Tags
1. Right-click page → "View Page Source"
2. Search for `<meta` tags
3. **Should find:**
   ```
   <meta name="description" content="...">
   <meta property="og:title" content="...">
   <meta property="og:image" content="https://attral.org/images/attral-logo.svg">
   <meta name="theme-color" content="#FFA500">
   <link rel="icon" type="image/svg+xml" href="images/favicon.svg">
   ```

### Robots.txt
1. Visit https://attral.org/robots.txt
2. **Should see:**
   ```
   User-agent: *
   Allow: /
   Disallow: /php/
   Disallow: /uploads/
   
   Sitemap: https://attral.org/sitemap.xml
   ```

### Sitemap.xml
1. Visit https://attral.org/sitemap.xml
2. **Should show 7 URLs:**
   - / (priority 1.0)
   - /services.html (priority 0.9)
   - /projects.html (priority 0.8)
   - /process.html (priority 0.7)
   - /contact.html (priority 0.9)
   - /privacy.html (priority 0.5)
   - /terms.html (priority 0.5)
3. All should have `<lastmod>2026-03-25</lastmod>`

---

## ♿ Accessibility Check

### Screen Reader Test (Windows)
Use NVDA (free): https://www.nvaccess.org/download/

### Keyboard Navigation
1. Open page
2. Press `Tab` repeatedly
3. **Expected:** Focus visible on all links/buttons (orange outline)
4. Press `Enter`on focused link — should navigate

### Color Contrast
1. Open DevTools
2. Inspect any text element
3. Check contrast ratio in Accessibility panel
4. **Target:** 4.5:1 for normal text, 3:1 for large text

### Alt Text
1. Right-click image
2. Select "Inspect"
3. **Find:** `alt="..."` attribute with descriptive text
4. **Example:** `alt="Autonomous Sensor Board — low-power wireless IoT"`

---

## 🐛 Common Issues & Solutions

### Issue: Logo doesn't load
**Cause:** Wrong path in header.php  
**Fix:** Verify `src="images/attral-logo.svg"` is correct

### Issue: Hamburger menu doesn't work
**Cause:** JavaScript error  
**Fix:** Check DevTools Console tab for JS errors

### Issue: Images show as broken
**Cause:** Old browser cache  
**Fix:** Hard refresh `Ctrl+F5` or clear browser cache

### Issue: Tailwind styles not applying
**Cause:** CDN slow or blocked  
**Fix:** Wait 30 seconds, refresh again. Check Network tab.

### Issue: Form doesn't submit
**Cause:** Validation blocking (requires valid email)  
**Fix:** Check for red error borders. Fix validation errors.

---

## 📊 Before/After Comparison

| Element | Before | After |
|---------|--------|-------|
| Header | Static, no logo | Sticky, logo, responsive menu |
| Footer | Minimal | Full contact details, 4-column grid |
| Images | Broken .jpg links | SVG placeholders |
| Navigation | Limited | Sticky header + mobile menu |
| Forms | No validation | Real-time validation + errors |
| Design | Basic CSS | Tailwind + brand colors |
| Favicon | None | SVG icon |
| SEO | Missing sitemap dates | Complete with lastmod |

---

## ✅ Final Approval Checklist

- [ ] All pages load without errors
- [ ] Header sticky on scroll
- [ ] Mobile menu works
- [ ] All images display
- [ ] Forms validate correctly
- [ ] Contact page submits successfully
- [ ] Footer shows contact info
- [ ] No console errors (F12)
- [ ] Mobile responsive (375px)
- [ ] Desktop responsive (1200px+)
- [ ] Links all work
- [ ] Favicon appears in tab
- [ ] WhatsApp button works
- [ ] SEO files complete (robots.txt, sitemap.xml)

---

**Once all checks pass, the site is ready for production!**

For issues, check the IMPLEMENTATION_SUMMARY.md file for detailed change documentation.
