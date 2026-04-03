# NovaVault.io — Phase 2 Build Plan

## Feature Expansion, Merchant Growth, and Revenue Optimization

**Goal:** Expand the Web2 platform into a more advanced commercial product with better analytics, stronger loyalty mechanics, scalable onboarding, and growth systems that support real traction. This is where NovaVault stops being "a working platform" and starts becoming "a business with teeth."

**Prerequisites:** Phase 1 complete — working auth, vendor stores, POS, checkout, token engine, patron dashboards, redemption, admin console.

---

### 2.1 Advanced Analytics

**Vendor Dashboard Modules**

- Transaction trends over time (Chart.js line/bar charts)
- Repeat customer rate
- Token issuance vs. redemption ratio
- Top-selling products
- Customer retention cohorts (weekly/monthly)
- Revenue impact of rewards program
- Campaign performance metrics
- Wallet activity metrics (active vs. dormant)

**Admin Analytics**

- Platform-wide KPIs: total vendors, total patrons, transaction volume, GMV
- Churn tracking: vendor and patron churn rates
- Revenue impact analysis across all vendors
- Executive reporting dashboard

**New tables/columns:**

- `analytics_snapshots` — daily rollup table for fast dashboard loading (vendor_id, date, transactions_count, revenue, tokens_issued, tokens_redeemed, active_patrons)

**Deliverables:** Interactive dashboards for vendors and admins with actionable metrics.

---

### 2.2 Tiered Loyalty Programs

- New migration: `loyalty_tiers` — id, vendor_id, name (bronze/silver/gold/custom), spend_threshold (DECIMAL), earn_multiplier (DECIMAL), perks_json, sort_order
- New column: `wallets.tier_id` (FK, nullable)
- Automatic tier assignment: scheduled job evaluates patron cumulative spend per vendor → assigns/upgrades tier
- Tier-specific earn rate multipliers integrated into `TokenEngine`
- Milestone rewards: bonus token grants at tier upgrade
- VIP segmentation: vendor can filter/target patrons by tier in promotions
- Tier status visible on patron dashboard

**Deliverables:** Vendors can configure multi-tier loyalty programs; patrons see tier progress and benefits.

---

### 2.3 Referral & Gamification

**Referral System**

- New migration: `referrals` — id, referrer_id (user), referred_id (user), vendor_id, status (pending/completed/expired), bonus_amount, completed_at
- Unique referral link generation per patron per vendor
- Referral bonus awarded to both parties on first qualifying purchase
- Referral tracking dashboard for patrons

**Gamification**

- New migrations: `badges` — id, name, description, icon_path, criteria_json; `user_badges` — id, user_id, badge_id, earned_at
- Achievement milestones (e.g., "10th purchase", "first referral", "100 tokens earned")
- Leaderboards: top earners per vendor (opt-in)
- Account progress visualization (progress bars, level indicators)
- Bonus token campaigns: time-limited multiplier events

**Deliverables:** Viral growth mechanics + engagement gamification for patrons.

---

### 2.4 SMS Notifications

- Add Twilio or Vonage SMS driver to Laravel notification channels
- Patron opt-in for SMS during registration or in profile settings
- New notification types via SMS:
  - Tokens earned confirmation
  - Redemption code delivery
  - Promotion alerts
  - Milestone/tier-up congratulations
- Segmented campaign system: vendor selects audience (by tier, activity, spend) → sends targeted promotion blast
- Delivery status tracking in `notification_logs`

**Deliverables:** SMS channel operational for transactional and marketing messages.

---

### 2.5 REST API

- API routes under `/api/v1/*` with Laravel Sanctum token authentication
- **Merchant endpoints:** vendor profile, store settings, reward rules CRUD
- **Product endpoints:** list, create, update, delete, bulk operations
- **Order endpoints:** list orders, order detail, initiate refund
- **Reward endpoints:** patron balance lookup, redemption validation, redemption execution
- **Reporting endpoints:** transaction summary, token activity, export (CSV/JSON)
- Rate limiting per API token
- API documentation generated via Scribe or L5-Swagger
- Webhook system: vendors can register webhook URLs for order and token events

**Deliverables:** Full REST API for external integrations, POS systems, and ecommerce plugins.

---

### 2.6 Data Import/Export

**Enhanced Import**

- CSV and Excel upload with column mapping UI (drag-and-drop field matching)
- Validation report: preview errors/warnings before commit
- Duplicate detection (by SKU, email, or custom key)
- Import templates downloadable from vendor dashboard
- Import history log

**Bulk Export**

- Products, orders, customers, ledger entries, redemptions
- CSV and Excel format options
- Date range and filter selection
- Scheduled export option (weekly email with report)

**Deliverables:** Frictionless data movement in and out of the platform.

---

### 2.7 Merchant Growth Tools

**Marketing Kit Portal**

- Downloadable branded materials: posters, flyers, table tents (PDF generation with vendor logo/colors)
- QR code generator: produces scannable codes linking to vendor store, signup page, or specific promotion
- Social media copy packs: pre-written captions and image templates for Instagram, Facebook, X
- Email content templates for vendor-to-customer outreach

**Campaign Builder**

- Vendor creates time-bound promotions: bonus earn events, flash redemption deals, new-customer bonuses
- Campaign tracking: impressions, signups, conversions, tokens issued
- Campaign scheduling: set start/end dates, auto-activate/deactivate
- Campaign analytics integrated into vendor dashboard (2.1)

**Deliverables:** Vendors have tools to drive their own customer acquisition and retention.

---

### 2.8 Public Site Content Expansion

- Case study pages (template-driven, admin-managed)
- Merchant testimonials section
- Competitor comparison pages (NovaVault vs. generic points programs)
- ROI calculator: interactive tool showing projected retention/revenue lift
- Industry-specific solution pages (restaurants, retail, services, etc.)
- Thought leadership blog posts
- Webinar/event pages
- Customer success stories

**Implementation:**

- Simple Laravel-based CMS: `posts` table — id, title, slug, body (markdown), category, featured_image, status (draft/published), author_id, published_at
- Admin content editor with markdown preview
- SEO-friendly URLs, meta tags, Open Graph tags

**Deliverables:** Content-rich public site supporting sales, trust, and organic search.

---

### 2.9 Support & Billing

**Support System**

- Internal ticket system: `support_tickets` — id, user_id, subject, status (open/in-progress/resolved/closed), priority, created_at
- `ticket_messages` — id, ticket_id, user_id, body, created_at
- Vendor and patron can submit tickets from their dashboards
- Admin ticket management: assign, prioritize, respond, close
- (Alternative: integrate Crisp or Intercom widget via JS snippet)

**Merchant Subscription Billing**

- Laravel Cashier (Stripe Billing) integration
- Subscription plans matching pricing tiers ($99/yr Starter → $15K/yr Enterprise)
- Trial period support
- Plan upgrade/downgrade with proration
- Invoice generation and history
- Payment failure handling with grace period and dunning emails
- Admin can override plans, grant credits, or comp accounts

**Deliverables:** Self-serve billing for merchants + support infrastructure for all users.

---

### Phase 2 Build Order

1. Advanced analytics — vendor + admin dashboards (2.1)
2. Tiered loyalty programs (2.2)
3. Referral & gamification (2.3)
4. SMS notifications (2.4)
5. REST API + documentation (2.5)
6. Data import/export enhancements (2.6)
7. Merchant growth tools + campaign builder (2.7)
8. Public site content expansion + CMS (2.8)
9. Support ticketing + subscription billing (2.9)
