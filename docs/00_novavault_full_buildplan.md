# NovaVault.io — Full PHP Platform Build Plan

Based on: `01_novavault_desc_buildplan.docx`

## Current State

The repo at `J:\01_Warp_Projects\02_novavault.io` contains only the **static marketing/pitch site** (HTML + CSS + JS). No backend, no database, no application code. The contact form is non-functional. Hosted on Apache/BlueHost/cPanel.

## Goal

Build the full NovaVault.io loyalty operating system as a PHP application across 3 phases. Phase 1 is the Web2 foundation — a working loyalty platform with vendor stores, POS, checkout, ledger-backed token balances, dashboards, and redemption. Phases 2 and 3 expand into growth tooling and Web3 tokenization.

## Proposed Tech Stack

- **Language:** PHP 8.2+
- **Framework:** Laravel 11 (routing, Eloquent ORM, Blade templates, queues, auth scaffolding, API resources)
- **Database:** MySQL 8 (cPanel/BlueHost compatible; ledger tables use `DECIMAL` precision)
- **Frontend:** Blade templates + Tailwind CSS + Alpine.js (lightweight, no SPA complexity)
- **Auth:** Laravel Breeze (email/password, email verification, password reset, CSRF) extended with role middleware
- **Payments:** Stripe SDK (checkout, webhooks, refunds)
- **Email:** Laravel Mail (SMTP via transactional service like Mailgun or SendGrid)
- **File Storage:** Laravel Filesystem (local disk on cPanel, S3-compatible later)
- **Queue:** `database` driver (no Redis needed on shared hosting; swap later)
- **Deployment:** Git push → cPanel Git Deployment or SSH-based deploy script
- **Testing:** PHPUnit + Laravel's test helpers

## Project Structure (Laravel)

```
novavault-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin console controllers
│   │   ├── Vendor/         # Vendor dashboard controllers
│   │   ├── Patron/         # Patron dashboard controllers
│   │   ├── POS/            # POS interface controllers
│   │   ├── Checkout/       # Online checkout controllers
│   │   └── Public/         # Marketing pages controller
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic (TokenEngine, LedgerService, RedemptionService)
│   ├── Policies/           # Authorization policies
│   └── Middleware/         # RoleMiddleware, VendorApproved, etc.
├── database/
│   └── migrations/         # Versioned schema
├── resources/views/
│   ├── layouts/            # master.blade.php, vendor.blade.php, patron.blade.php, admin.blade.php
│   ├── public/             # marketing pages (port existing HTML)
│   ├── vendor/             # vendor dashboard views
│   ├── patron/             # patron dashboard views
│   ├── admin/              # admin console views
│   ├── pos/                # POS interface views
│   └── components/         # shared Blade components
├── routes/
│   ├── web.php             # public + auth routes
│   └── api.php             # future API routes (Phase 2)
└── tests/
```

---

## Phase 1 — Web2 Foundation, Core Platform, and Initial Launch

### 1.1 Project Scaffolding

- Initialize Laravel 11 project inside the repo (alongside or replacing the existing static site)
- Configure `.env` for MySQL, mail, app key, Stripe keys
- Set up `.htaccess` compatibility with existing Apache rules
- Configure `public/` as document root (cPanel subdomain or symlink)
- Add Tailwind CSS + Alpine.js via Vite
- Port existing marketing site HTML into Blade templates under `resources/views/public/`
- Preserve existing dark navy/gold theme (`styles.css` → Tailwind config + component CSS)

### 1.2 Database & Ledger Model

Core migrations (the ledger architecture is the backbone — must be clean and abstracted for Phase 3 token mapping):

- `users` — id, name, email, password, role (enum: admin/vendor/patron), email_verified_at, 2fa_secret
- `vendors` — id, user_id (FK), business_name, slug, description, category, contact_email, contact_phone, logo_path, theme_json, status (pending/approved/suspended), pricing_tier, approved_at
- `vendor_profiles` — id, vendor_id (FK), address, website, social_links_json, about_text
- `products` — id, vendor_id (FK), title, description, sku, price (DECIMAL 10,2), backstock_qty, status (active/inactive), image_path, category_id, low_stock_threshold
- `categories` — id, vendor_id (FK, nullable for global), name, slug
- `orders` — id, vendor_id, patron_id (nullable for guest), status (pending/paid/refunded/cancelled), total (DECIMAL 10,2), payment_intent_id, source (pos/online), created_at
- `order_items` — id, order_id, product_id, qty, unit_price, line_total
- `wallets` — id, user_id, vendor_id, balance (DECIMAL 18,8), created_at
- `token_ledger` — id, wallet_id, type (earn/redeem/reverse/adjust), amount (DECIMAL 18,8), reference_type, reference_id, memo, created_at (append-only, immutable)
- `redemptions` — id, wallet_id, patron_id, vendor_id, amount, reward_type, reward_detail_json, status, created_at
- `reward_rules` — id, vendor_id, earn_rate (DECIMAL), min_purchase, multiplier, active, valid_from, valid_until
- `promotions` — id, vendor_id, name, type, config_json, active, start_at, end_at
- `payment_events` — id, order_id, stripe_event_id, type, payload_json, created_at
- `bans` — id, type (ip/email/username), value, reason, admin_id, created_at
- `notification_logs` — id, user_id, channel (email/sms), subject, status, sent_at
- `audit_logs` — id, user_id, action, target_type, target_id, ip, user_agent, created_at
- `settings` — id, group, key, value

**Key design rule:** `wallets` holds the current balance; `token_ledger` holds the immutable history. Balance is always derivable from the ledger. This makes Phase 3 on-chain reconciliation possible without rewriting.

### 1.3 Authentication & Role-Based Access

- Install Laravel Breeze (Blade + Tailwind stack)
- Add `role` column to users (enum: `admin`, `vendor`, `patron`)
- Create `RoleMiddleware` → `role:admin`, `role:vendor`, `role:patron`
- Separate route groups: `/admin/*`, `/vendor/*`, `/patron/*`
- Email verification flow (required for vendors)
- Password reset
- Optional TOTP 2FA (use `pragmarx/google2fa-laravel`)
- CSRF on all forms (built-in)

### 1.4 Vendor Onboarding

- Public vendor signup form → creates user with `role=vendor` + vendor record (status=pending)
- Vendor profile wizard: business name, category, contact info, logo upload, store description
- Admin approval queue: list pending vendors, approve/reject with notes
- On approval → welcome email + guided first-time setup checklist
- Pricing tier assignment (admin sets tier during approval)

### 1.5 Product & Inventory Management

- CRUD for products (title, description, SKU, price, backstock, status, image)
- Category management per vendor
- Spreadsheet import: CSV/Excel upload → validation → preview → commit (use `maatwebsite/excel`)
- Bulk status toggle (active/inactive)
- Low-stock alerts (configurable threshold per product, email notification when qty drops below)
- Image upload with thumbnail generation

### 1.6 Vendor Storefronts

- Public route: `/store/{vendor-slug}` → vendor homepage
- Product listing page with grid/list toggle, category filter, search
- Product detail page (images, description, price, "Add to Cart", reward callout)
- Shopping cart (session-based, persisted to DB on login)
- Vendor branding: logo, custom accent color, layout variant (stored in `vendors.theme_json`)
- Mobile responsive

### 1.7 POS & Online Checkout

**Browser-Based POS (`/vendor/pos`)**

- Product quick-add grid
- Cart management (add, remove, adjust qty)
- Customer lookup by email/phone
- Guest checkout with prompt to create account
- Stripe Terminal or Stripe Payment Intents for card-present
- Receipt generation (printable HTML)

**Online Checkout (`/store/{vendor-slug}/checkout`)**

- Stripe Checkout Session or embedded Payment Element
- Webhook handler: `payment_intent.succeeded`, `charge.refunded`, `charge.dispute.created`
- Idempotent order creation (use Stripe payment_intent_id as idempotency key)
- Order confirmation page + email
- Refund flow: vendor initiates → Stripe refund API → order status update → token reversal

### 1.8 Internal Token Earning Engine

- `TokenEngine` service class:
  - On successful payment → lookup `reward_rules` for vendor → calculate earn amount → create `token_ledger` entry (type=earn) → update `wallets.balance`
  - All balance mutations go through the ledger (no direct balance writes)
  - On refund → create `token_ledger` entry (type=reverse) → deduct from balance
- Configurable earn rate per vendor (default + vendor override via `reward_rules`)
- Future-ready: service interface allows swapping in blockchain minting in Phase 3

### 1.9 Patron Dashboard

- `/patron/dashboard` — overview: total balances across vendors, recent activity
- `/patron/wallets` — per-vendor balance breakdown
- `/patron/transactions` — full history (purchases, earnings, redemptions)
- `/patron/redeem` — available offers per vendor
- `/patron/profile` — name, email, password, notification preferences
- Vendor discovery: browse participating vendors

### 1.10 Redemption System

- Vendor defines redemption offers: discount (% or flat), free product, service reward, promo offer
- `RedemptionService`:
  - Validate patron balance ≥ redemption cost
  - Deduct via ledger (type=redeem)
  - Generate redemption code/confirmation
  - Anti-abuse: rate limit, min-balance rules, cooldown periods
- Redemption history for patrons and vendors

### 1.11 Admin Console

- `/admin/vendors` — list, approve, suspend, edit tier
- `/admin/patrons` — list, view, suspend
- `/admin/transactions` — global transaction viewer with filters
- `/admin/redemptions` — review and audit
- `/admin/bans` — IP/email/username ban management
- `/admin/settings` — platform config (default earn rates, feature flags)
- `/admin/logs` — audit log viewer
- `/admin/analytics` — basic dashboard: active vendors, active patrons, transaction volume, token issuance/redemption totals

### 1.12 Notifications

- Laravel notification classes for each event:
  - Welcome email, email verification
  - Payment confirmation
  - Tokens earned
  - Redemption confirmation
  - Password reset
  - Vendor approval/rejection
  - Low-stock alert (vendor)
  - Admin alerts
- `database` + `mail` channels (add `sms` in Phase 2)

### 1.13 QA, Security & Launch Prep

- Feature tests for: auth flows, vendor onboarding, product CRUD, checkout, token calculation, ledger consistency, redemption, refunds, admin permissions
- Security: rate limiting on auth routes, input validation, XSS via Blade escaping, SQL injection via Eloquent, CSRF tokens, Stripe webhook signature verification
- `.htaccess` hardening: existing rules + Laravel-specific rewrites
- Staging environment on cPanel subdomain
- Backup strategy: daily DB dump + file backup via cPanel
- Uptime monitoring setup

---

## Phase 2 — Feature Expansion & Revenue Optimization

### 2.1 Advanced Analytics

- Vendor dashboard modules: transaction trends (Chart.js), repeat customer rate, token issuance vs redemption, top products, retention cohorts
- Admin analytics: platform-wide KPIs, churn tracking, revenue impact

### 2.2 Tiered Loyalty

- New migration: `loyalty_tiers` — vendor_id, name (bronze/silver/gold), threshold, multiplier
- Automatic tier assignment based on cumulative spend
- Tier-specific earn rate multipliers in `TokenEngine`
- Milestone rewards, VIP segmentation

### 2.3 Referral & Gamification

- `referrals` table — referrer_id, referred_id, status, bonus_amount
- Invite link generation, referral bonus on first purchase
- Badges, achievements, leaderboards, progress visualization

### 2.4 SMS Notifications

- Add Twilio/Vonage driver to notification channels
- Segmented campaigns, milestone emails, promotion blasts

### 2.5 REST API

- API routes with Laravel Sanctum token auth
- Endpoints: merchant data, product sync, order sync, reward lookup, redemption validation, reporting export
- API documentation (Scribe or Swagger)

### 2.6 Data Import/Export

- Enhanced CSV/Excel import with validation reports, duplicate detection, field mapping UI
- Bulk export for products, orders, customers, ledger

### 2.7 Merchant Growth Tools

- Marketing kit portal: downloadable posters, QR code generator (endpoint + image), social media copy packs
- Campaign builder: vendor creates time-bound promotions with tracking

### 2.8 Public Site Content Expansion

- Case studies, testimonials, comparison pages, ROI calculator, industry solution pages
- Blog/CMS (simple Laravel-based or headless)

### 2.9 Support & Billing

- Support ticket system (simple internal or integrate Crisp/Intercom)
- Merchant subscription billing via Stripe Billing (Laravel Cashier)
- Invoice generation, plan management

---

## Phase 3 — Web3 Transition & Tokenization

### 3.1 Blockchain Architecture

- Design ledger-to-chain mapping: internal `token_ledger` events → Cardano token mint/burn/transfer
- Custody approach: platform-managed wallets vs. user-managed
- Reconciliation service between DB balances and on-chain state

### 3.2 Vendor Token Creation

- Token setup wizard: name, symbol, supply, brand image, fee config
- Admin compliance review + minting approval
- Cardano native token minting (via `cardano-cli` or blockfrost API)

### 3.3 External Wallet Integration

- Cardano wallet connection (Nami, Eternl, etc.) via CIP-30
- Patron wallet linking + verification
- Vendor payout wallet setup

### 3.4 On-Chain Token Movements

- Map internal balance → on-chain balance
- Transfer vendor tokens to patron wallets
- Record transaction hashes in `token_ledger`
- Dashboard reflects both internal and on-chain state

### 3.5 Web3 Redemption & Utility

- On-chain redemption, cross-vendor token use, burn-back campaigns
- Partner token collaborations

### 3.6 Tokenomics Dashboard

- Circulating supply, distribution, issuance/burn rates, holder activity, transfer volume

### 3.7 Cross-Vendor Network

- Shared campaigns, coalition rewards, token interoperability, ecosystem discovery pages

### 3.8 Public Site Web3 Messaging

- Tokenization explainer pages, compliance/trust pages, ecosystem map, updated roadmap

---

## Implementation Priority

**Start with Phase 1 in this order:**

1. Project scaffolding + Blade marketing site port (1.1)
2. Database migrations + seeders (1.2)
3. Auth + roles (1.3)
4. Vendor onboarding + admin approval (1.4)
5. Product/inventory management (1.5)
6. Vendor storefronts (1.6)
7. POS + checkout + Stripe (1.7)
8. Token earning engine + ledger (1.8)
9. Patron dashboard + wallets (1.9)
10. Redemption system (1.10)
11. Admin console (1.11)
12. Notifications (1.12)
13. QA + security + launch (1.13)
