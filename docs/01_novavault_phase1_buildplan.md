# NovaVault.io — Phase 1 Build Plan

## Web2 Foundation, Core Platform, and Initial Launch

**Goal:** Build and launch a fully functional Web2 loyalty platform that allows vendors to onboard, manage stores, accept payments, issue internal reward balances, and give patrons a working customer rewards experience. This phase proves the core business model before any blockchain features are introduced.

**Tech Stack:** PHP 8.2+ / Laravel 11 / MySQL 8 / Blade + Tailwind CSS + Alpine.js / Stripe / Apache (cPanel/BlueHost)

---

### 1.1 Project Scaffolding

- Initialize Laravel 11 project inside the repo (alongside or replacing the existing static site)
- Configure `.env` for MySQL, mail, app key, Stripe keys
- Set up `.htaccess` compatibility with existing Apache rules
- Configure `public/` as document root (cPanel subdomain or symlink)
- Add Tailwind CSS + Alpine.js via Vite
- Port existing marketing site HTML into Blade templates under `resources/views/public/`
- Preserve existing dark navy/gold theme (`styles.css` → Tailwind config + component CSS)

**Deliverables:** Working Laravel app serving the existing marketing site through Blade templates.

---

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

**Deliverables:** All migrations, Eloquent models with relationships, factories, and seeders for dev data.

---

### 1.3 Authentication & Role-Based Access

- Install Laravel Breeze (Blade + Tailwind stack)
- Add `role` column to users (enum: `admin`, `vendor`, `patron`)
- Create `RoleMiddleware` → `role:admin`, `role:vendor`, `role:patron`
- Separate route groups: `/admin/*`, `/vendor/*`, `/patron/*`
- Email verification flow (required for vendors)
- Password reset
- Optional TOTP 2FA (use `pragmarx/google2fa-laravel`)
- CSRF on all forms (built-in)

**Deliverables:** Login/register pages for all 3 roles, role-guarded route groups, email verification working.

---

### 1.4 Vendor Onboarding

- Public vendor signup form → creates user with `role=vendor` + vendor record (status=pending)
- Vendor profile wizard: business name, category, contact info, logo upload, store description
- Admin approval queue: list pending vendors, approve/reject with notes
- On approval → welcome email + guided first-time setup checklist
- Pricing tier assignment (admin sets tier during approval)

**Deliverables:** End-to-end vendor signup → admin approval → vendor activated flow.

---

### 1.5 Product & Inventory Management

- CRUD for products (title, description, SKU, price, backstock, status, image)
- Category management per vendor
- Spreadsheet import: CSV/Excel upload → validation → preview → commit (use `maatwebsite/excel`)
- Bulk status toggle (active/inactive)
- Low-stock alerts (configurable threshold per product, email notification when qty drops below)
- Image upload with thumbnail generation

**Deliverables:** Vendor can manage full product catalog from their dashboard.

---

### 1.6 Vendor Storefronts

- Public route: `/store/{vendor-slug}` → vendor homepage
- Product listing page with grid/list toggle, category filter, search
- Product detail page (images, description, price, "Add to Cart", reward callout)
- Shopping cart (session-based, persisted to DB on login)
- Vendor branding: logo, custom accent color, layout variant (stored in `vendors.theme_json`)
- Mobile responsive

**Deliverables:** Customer-facing storefront per vendor, browsable and shoppable.

---

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

**Deliverables:** Working payment processing for both in-person (POS) and online orders.

---

### 1.8 Internal Token Earning Engine

- `TokenEngine` service class:
  - On successful payment → lookup `reward_rules` for vendor → calculate earn amount → create `token_ledger` entry (type=earn) → update `wallets.balance`
  - All balance mutations go through the ledger (no direct balance writes)
  - On refund → create `token_ledger` entry (type=reverse) → deduct from balance
- Configurable earn rate per vendor (default + vendor override via `reward_rules`)
- Future-ready: service interface allows swapping in blockchain minting in Phase 3

**Deliverables:** Automatic token earning on purchase, ledger integrity, configurable reward rules.

---

### 1.9 Patron Dashboard

- `/patron/dashboard` — overview: total balances across vendors, recent activity
- `/patron/wallets` — per-vendor balance breakdown
- `/patron/transactions` — full history (purchases, earnings, redemptions)
- `/patron/redeem` — available offers per vendor
- `/patron/profile` — name, email, password, notification preferences
- Vendor discovery: browse participating vendors

**Deliverables:** Patron can see balances, history, and available rewards in one place.

---

### 1.10 Redemption System

- Vendor defines redemption offers: discount (% or flat), free product, service reward, promo offer
- `RedemptionService`:
  - Validate patron balance ≥ redemption cost
  - Deduct via ledger (type=redeem)
  - Generate redemption code/confirmation
  - Anti-abuse: rate limit, min-balance rules, cooldown periods
- Redemption history for patrons and vendors

**Deliverables:** Patrons can redeem tokens for vendor-defined rewards.

---

### 1.11 Admin Console

- `/admin/vendors` — list, approve, suspend, edit tier
- `/admin/patrons` — list, view, suspend
- `/admin/transactions` — global transaction viewer with filters
- `/admin/redemptions` — review and audit
- `/admin/bans` — IP/email/username ban management
- `/admin/settings` — platform config (default earn rates, feature flags)
- `/admin/logs` — audit log viewer
- `/admin/analytics` — basic dashboard: active vendors, active patrons, transaction volume, token issuance/redemption totals

**Deliverables:** Full admin control panel for managing the entire ecosystem.

---

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

**Deliverables:** All transactional emails working, in-app notification center.

---

### 1.13 QA, Security & Launch Prep

- Feature tests for: auth flows, vendor onboarding, product CRUD, checkout, token calculation, ledger consistency, redemption, refunds, admin permissions
- Security: rate limiting on auth routes, input validation, XSS via Blade escaping, SQL injection via Eloquent, CSRF tokens, Stripe webhook signature verification
- `.htaccess` hardening: existing rules + Laravel-specific rewrites
- Staging environment on cPanel subdomain
- Backup strategy: daily DB dump + file backup via cPanel
- Uptime monitoring setup

**Deliverables:** Test suite passing, security hardened, staging live, ready for pilot merchants.

---

### Phase 1 Build Order

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
