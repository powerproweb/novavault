# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

NovaVault.io is a ledger-first loyalty operating system (CBLS — Customer-Based Loyalty System). The platform is designed as Web2 now, Web3-ready later — starting with traditional database-backed loyalty and an optional future Cardano token layer. The repo contains both the **static marketing/pitch site** (root) and the **full Laravel application** (`novavault-app/`).

## Architecture

### Marketing Site (Static HTML + Vanilla JS + CSS)

Single-page marketing site with flat `.html` files at the project root. CSS at `assets/css/styles.css`, JS at `assets/js/script.js`. No build step, no bundler, no framework.

**Key pages:**
- `index.html` — Full marketing landing page (hero, features, how-it-works, who-it's-for, roadmap, pricing, security, contact form)
- `founder_statement.html` — Founder's Statement of Purpose (Juan José Piedra / John Joseph Stone)
- `novavault_business_plan_01-2026.html` — Complete investor-ready business plan (85+ pages, self-contained HTML with embedded styles)
- `novavault_complete_business_plan.html` — Shorter version of business plan
- `novavault_pitch_deck_01-2026.pdf` — PDF pitch deck
- `resume-ubaid-rather.html` — Team member CV (Ubaid Parvaiz Rather)

**Key JS (`assets/js/script.js`):**
- Sticky header with scroll-based shrink
- Mobile hamburger menu toggle
- Tab component (Customers / Vendors / Investors panels)
- Scroll-reveal animations (IntersectionObserver)
- Toast notification system (demo form button)
- Auto-set copyright year

**CSS (`assets/css/styles.css`):**
- Dark theme (navy base `#070B14`, gold accents, glassmorphism cards)
- CSS custom properties for colours
- Responsive grid layouts (features, pricing, security, steps)
- Google Fonts: Inter (400–700)

### Assets
- `assets/images/` — Hero image (`01_hero-1200x600.jpg`), logo (`novavault_logo.png`), favicon, founder photo
- `assets/css/` — `styles.css` (marketing site)
- `assets/js/` — `script.js` (marketing site)

### Docs
- `docs/` — Build plans (Phase 1/2/3), full build plan, changelog

### Laravel Application (`novavault-app/`)
- **Framework:** Laravel 13 (PHP 8.2+)
- **Frontend:** Blade + Tailwind CSS + Alpine.js (Vite build)
- **Database:** MySQL 8 (14 migrations, 17+ tables, ledger-first architecture)
- **Auth:** Laravel Breeze with 3 roles (admin/vendor/patron)
- **Key services:** `TokenEngine` (ledger), `RedemptionService` (anti-abuse)
- **88 routes:** Admin console, vendor dashboard/POS/orders/products, patron dashboard/wallets/redemptions, public storefronts, checkout
- **Dark/light theme switcher** across all pages
- **Tests:** 43 tests, 111 assertions (PHPUnit)
- See `novavault-app/DEPLOY.md` for production deployment guide

## Tech Stack
- **Marketing site:** HTML5, vanilla CSS3, vanilla ES6+ JS
- **Application:** PHP 8.2+ / Laravel 13 / MySQL 8 / Tailwind CSS / Alpine.js
- Apache shared hosting (BlueHost/cPanel)

## Business Context
- **Product concept:** SaaS loyalty platform with secure rewards ledger, vendor stores, POS, checkout, configurable reward rules, fraud controls, dashboards
- **Tech stack (app):** PHP 8.2+ / Laravel 13 / MySQL 8 / Blade + Tailwind + Alpine.js
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
