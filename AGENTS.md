# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

NovaVault.io is a ledger-first loyalty operating system (CBLS — Customer-Based Loyalty System). The platform is designed as Web2 now, Web3-ready later — starting with traditional database-backed loyalty and an optional future Cardano token layer. The current codebase is the **marketing/pitch site**, not the application itself.

## Architecture

### Frontend (Static HTML + Vanilla JS + CSS)

Single-page marketing site with flat `.html` files at the project root. One shared `styles.css` and one `script.js`. No build step, no bundler, no framework.

**Key pages:**
- `index.html` — Full marketing landing page (hero, features, how-it-works, who-it's-for, roadmap, pricing, security, contact form)
- `founder_statement.html` — Founder's Statement of Purpose (Juan José Piedra / John Joseph Stone)
- `novavault_business_plan_01-2026.html` — Complete investor-ready business plan (85+ pages, self-contained HTML with embedded styles)
- `novavault_complete_business_plan.html` — Shorter version of business plan
- `novavault_pitch_deck_01-2026.pdf` — PDF pitch deck
- `resume-ubaid-rather.html` — Team member CV (Ubaid Parvaiz Rather)

**Key JS (`script.js`):**
- Sticky header with scroll-based shrink
- Mobile hamburger menu toggle
- Tab component (Customers / Vendors / Investors panels)
- Scroll-reveal animations (IntersectionObserver)
- Toast notification system (demo form button)
- Auto-set copyright year

**CSS (`styles.css`):**
- Dark theme (navy base `#070B14`, gold accents, glassmorphism cards)
- CSS custom properties for colours
- Responsive grid layouts (features, pricing, security, steps)
- Google Fonts: Inter (400–700)

### Assets
- `assets/images/` — Hero image (`01_hero-1200x600.jpg`), logo (`novavault_logo.png`), favicon, founder photo

### Backend
No backend currently. The contact form is a static demo (front-end only, not wired to any endpoint). The `.htaccess` handles HTTPS canonicalization, `.html` extension stripping, security headers, caching, and gzip.

## Tech Stack
- HTML5, vanilla CSS3, vanilla ES6+ JS
- Apache shared hosting (BlueHost/cPanel)
- No dependencies, no npm, no build tools

## Business Context
- **Product concept:** SaaS loyalty platform with secure rewards ledger, vendor stores, POS, checkout, configurable reward rules, fraud controls, dashboards
- **Tech stack (planned app):** Haskell backend (Yesod/Scotty/Snap), PostgreSQL, REST/JSON APIs
- **Pricing model:** Tiered merchant subscriptions ($99–$15K/yr) + optional Phase 2 tokenization services
- **Seed funding ask:** $490,350
- **Phase 1 target:** 5–10 pilot merchants, $120K–$180K ARR
- **Founder:** Juan José Piedra (also goes by John Joseph Stone)
- **Project Consultant:** Ubaid Parvaiz Rather

## Conventions
- All JS is vanilla ES6+, no modules, no bundler
- Dark theme with navy/gold colour palette
- Nav/header/footer markup is duplicated across HTML files (no includes)
- Scroll-reveal via IntersectionObserver with `.reveal` / `.is-visible` classes
- Tab UI uses `data-tab` / `data-panel` attributes
- Print-friendly styles included in business plan pages (`@media print`)

## Important Notes
- The contact form is **not functional** — it's a front-end demo only
- Business plan pages are self-contained with embedded `<style>` blocks (not using `styles.css`)
- The `.htaccess` contains security headers and caching rules — review before modifying
- The pitch deck is a binary PDF — do not attempt to edit it as text
