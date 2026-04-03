<!doctype html>
<html lang="en">
<head>
<!-- ==== Begin Modern Meta Tag Block (2025) ==== -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#070B14" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="googlebot" content="index, follow">
<meta name="bingbot" content="index, follow">
<meta name="author" content="Juan Jose Piedra">
<meta name="copyright" content="© 2026 Juan Jose Piedra">

<!-- Primary SEO -->
<title>NovaVault.io | CBLS - Ledger‑First Loyalty OS</title>
<meta name="description" content="NovaVault.io, a ledger-first loyalty operating system: Web2 now, Web3-ready later." />
<meta name="keywords" content="NovaVault, loyalty, software, customer, platform, small business, merchant, vendor, consumer, POS, customer retention, retailers, omnichannel, web-based loyalty system, rewards">
<link rel="canonical" href="https://novavault.io/">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="NovaVault.io Ledger‑First Loyalty OS">
<meta name="twitter:description" content="NovaVault.io, a ledger-first loyalty operating system: Web2 now, Web3-ready later.">
<meta name="twitter:image" content="https://novavault.io/assets/images/01_hero-1200x600.jpg">
<meta name="twitter:site" content="@NovaVault">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:title" content="NovaVault.io | Ledger-First Loyalty OS">
<meta property="og:description" content="NovaVault.io, a ledger-first loyalty operating system: Web2 now, Web3-ready later.">
<meta property="og:image" content="https://novavault.io/assets/images/01_hero-1200x600.jpg">
<meta property="og:url" content="https://novavault.io/">

<!-- Favicon & App Icons -->
<link rel="icon" type="image/png" href="assets/images/favicon.png" />

<!-- Fonts (optional; system fallbacks included) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Light theme overrides for the marketing site -->
<style>
  /* Apply stored theme instantly to prevent flash */
  html.light body {
    color: #1a1a2e;
    background: linear-gradient(180deg, #f5f7fa, #ffffff 60%, #f0f2f6);
  }
  html.light .site-header {
    background: rgba(255,255,255,0.85);
    border-bottom-color: rgba(0,0,0,0.08);
  }
  html.light .brand-name,
  html.light .nav-link,
  html.light .section-title { color: #1a1a2e; }
  html.light .brand-tag,
  html.light .section-lede,
  html.light .nav-link { color: #4a5568; }
  html.light .nav-link:hover { color: #1a1a2e; background: rgba(0,0,0,0.05); }
  html.light .card,
  html.light .step.card,
  html.light .feature-card {
    background: rgba(255,255,255,0.92);
    border-color: rgba(0,0,0,0.08);
    color: #1a1a2e;
  }
  html.light .card p,
  html.light .checklist li,
  html.light .callout-text { color: #4a5568; }
  html.light .section-alt {
    background: linear-gradient(180deg, rgba(0,0,0,0.02), rgba(0,0,0,0.01));
    border-color: rgba(0,0,0,0.06);
  }
  html.light .gold { color: #b8860b; }
  html.light .strip-item { border-color: rgba(0,0,0,0.08); }
  html.light .strip-desc { color: #6b7280; }
  html.light .site-footer { background: #f0f2f6; color: #4a5568; }
  html.light .footer-links a { color: #4a5568; }
  html.light .btn-ghost { border-color: rgba(0,0,0,0.15); color: #1a1a2e; }
  html.light .hero-overlay { color: #1a1a2e; }
  html.light .hero-title { color: #1a1a2e; }
  html.light .hero-subtitle { color: #4a5568; }
  html.light .metric-top { color: #1a1a2e; }
  html.light .metric-bottom { color: #6b7280; }
  html.light .pill { background: rgba(0,0,0,0.06); color: #1a1a2e; }
  html.light .form input,
  html.light .form select,
  html.light .form textarea {
    background: #fff; border-color: #d1d5db; color: #1a1a2e;
  }
  html.light .form label span { color: #374151; }
  html.light .tech-pill { background: rgba(0,0,0,0.05); color: #374151; }
  html.light .header-glow { opacity: 0.3; }
  /* Theme toggle button */
  .nv-theme-btn {
    background: none; border: none; cursor: pointer; padding: 8px;
    font-size: 20px; line-height: 1; border-radius: 8px;
    transition: background 0.2s;
  }
  .nv-theme-btn:hover { background: rgba(128,128,128,0.15); }

  *, *::before, *::after {
    transition: background-color 0.25s ease, color 0.25s ease, border-color 0.25s ease;
  }
</style>

<!-- Prevent flash: apply theme before paint -->
<script>
  (function(){
    var t = localStorage.getItem('nv-theme');
    if (t === 'light') document.documentElement.classList.add('light');
  })();
</script>
</head>

<body>
  <div id="top" class="page-top-anchor" aria-hidden="true"></div>

  <a class="skip-link" href="#main">Skip to content</a>

  <!-- Sticky, always-on-top header -->
  <header class="site-header">
    <div class="header-inner">
      <a class="brand" href="#top" aria-label="NovaVault Home">
        <img class="brand-logo" src="assets/images/novavault_logo.png" alt="NovaVault logo" />
        <span class="brand-text">
          <span class="brand-name">NovaVault</span>
          <span class="brand-tag">Ledger‑First Loyalty OS</span>
        </span>
      </a>

      <button class="nav-toggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="primary-nav">
        <span></span><span></span><span></span>
      </button>

      <nav class="nav" id="primary-nav" aria-label="Primary navigation">
		<a class="nav-link" href="#features">Features</a>
        <a class="nav-link" href="#how-it-works">How</a>
        <a class="nav-link" href="#who-its-for">Who</a>
        <a class="nav-link" href="#roadmap">Roadmap</a>
        <a class="nav-link" href="#pricing">Pricing</a>
        <a class="nav-link" href="#security">Security</a>
        <a class="nav-link" href="#contact">Contact</a>
        <a class="nav-link" href="founder_statement.html">Founder Statement</a>
      </nav>

      <div class="header-cta" style="display:flex;gap:10px;align-items:center;">
        <button class="nv-theme-btn" id="themeToggle" type="button" title="Toggle theme">
          <span id="themeIcon">☀️</span>
        </button>
        @auth
          <a class="btn btn-primary" href="{{ route('dashboard') }}">Dashboard</a>
        @else
          <a class="nav-link" href="{{ route('login') }}" style="color:var(--muted);">Log in</a>
          <a class="btn btn-primary" href="{{ route('register') }}">Sign Up</a>
        @endauth
      </div>
    </div>

    <div class="header-glow" aria-hidden="true"></div>
  </header>

  <main id="main">
    <!-- 1200x600 static header image (sits directly under the sticky menu bar) -->
    <section class="hero" aria-label="NovaVault hero">
      <div class="container hero-container">
        <div class="hero-banner reveal">
          <img
            class="hero-img"
            src="assets/images/01_hero-1200x600.jpg"
            width="1200"
            height="600"
            alt="NovaVault abstract header background"
            loading="eager"
            decoding="async"
          />

          <div class="hero-overlay">
            <div class="hero-kicker">
              <span class="pill">Web2 now</span>
              <span class="pill pill-gold">Web3-ready later</span>
              <span class="pill pill-blue">Audit‑grade ledger</span>
            </div>

            <h1 class="hero-title">
              WE’RE BUILDING <span class="gold">THE LOYALTY SYSTEM</span> BUSINESSES WILL STILL BE USING <span class="gold">10 YEARS FROM NOW!</span>
            </h1>

            <p class="hero-subtitle">
              NovaVault is a <span class="gold"><strong>ledger‑first</strong></span> rewards platform with <span class="gold">Vendor
			  <br />
			  Stores, POS, Checkout, Configurable Reward Rules, Fraud
			  <br />
			  & Safety Controls, and dashboards,</span> engineered to <span class="gold"><strong>migrate 1:1</strong></span>
			  <br />
			  into a future Cardano token layer.
            </p>

            <div class="hero-actions">
              <a class="btn btn-primary" href="#contact">Book a Demo</a>
              <a class="btn btn-ghost" href="#features">Explore Features</a>
            </div>

            <div class="hero-metrics">
              <div class="metric">
                <div class="metric-top">Ledger‑first</div>
                <div class="metric-bottom">Every earn + redemption tracked</div>
              </div>
              <div class="metric">
                <div class="metric-top">Configurable</div>
                <div class="metric-bottom">% back • per‑visit • time‑bound promos</div>
              </div>
              <div class="metric">
                <div class="metric-top">Controlled</div>
                <div class="metric-bottom">Limits • audit trails • reversals</div>
              </div>
            </div>
          </div>
        </div>

		<div class="section-head reveal">
			<div class="font-header-white move_down_25">The Links Below are the documents created for this project</div>
		</div>

		<!-- Links for other docs -->
        <div class="hero-strip reveal" id="doc-links">
		<a href="novavault_business_plan_01-2026.html" target="_blank" rel="noopener noreferrer">
          <div class="strip-item">
            <span class="strip-title"><span class="gold">NovaVault Business Plan Jan-1-26 Complete</span></span>
            <span class="strip-desc">Downloadable / Printable</span>
          </div>
		</a>
		<a href="novavault_complete_business_plan.html" target="_blank" rel="noopener noreferrer">
          <div class="strip-item">
            <span class="strip-title"><span class="gold">NovaVault Business Plan Jan-1-26 Short</span></span>
            <span class="strip-desc">Downloadable / Printable</span>
          </div>
		</a>
		<a href="novavault_pitch_deck_01-2026.pdf" target="_blank" rel="noopener noreferrer">
          <div class="strip-item">
            <span class="strip-title"><span class="gold">NovaVault Pitch Deck Jan-1-26</span></span>
            <span class="strip-desc">Downloadable / Printable</span>
          </div>
		</a>
		<a href="founder_statement.html" target="_blank" rel="noopener noreferrer">
		  <div class="strip-item">
            <span class="strip-title"><span class="gold">Statement of Purpose | John Joseph Stone | Jan-1-26</span></span>
            <span class="strip-desc">Downloadable / Printable</span>
          </div>
		</a>
		<a href="resume-ubaid-rather.html" target="_blank" rel="noopener noreferrer">
          <div class="strip-item">
            <span class="strip-title"><span class="gold">CV | Ubaid Rather | Jan-1-26</span></span>
            <span class="strip-desc">Downloadable / Printable</span>
          </div>
		</a>
        </div>
		
		<!-- <div class="hero-strip reveal move_down_85">
          <div class="strip-item">
            <span class="strip-title">PURE cash‑value rewards</span>
            <span class="strip-desc">Balances customers can see, trust, and use.</span>
          </div>
          <div class="strip-item">
            <span class="strip-title">Launch fast</span>
            <span class="strip-desc">Web2 onboarding without wallet friction.</span>
          </div>
          <div class="strip-item">
            <span class="strip-title">Upgrade path</span>
            <span class="strip-desc">Optional Web3 tokenization when ready.</span>
          </div>
        </div> -->
		
      </div>
    </section>

    <!-- Features -->
    <section class="section move_up_115">
      <div class="container">
        <div class="section-head reveal">
          <h2 class="section-title" id="features">Everything you need to run loyalty like a real system</h2>
          <p class="section-lede">
            NovaVault replaces “points math” with a transparent, auditable ledger — then layers on commerce,
            campaigns, analytics, and operational controls that protect margin.
          </p>
        </div>

        <div class="feature-grid">
          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">⧉</div>
              <h3>Secure Rewards Ledger</h3>
            </div>
            <p>
              Tracks every earn, redemption, and adjustment. Supports idempotent event processing and full
              audit trails for predictable program economics.
            </p>
            <ul class="checklist">
              <li>Earn + redeem flows (e.g., 10 tokens per $ — configurable)</li>
              <li>Adjustment entries (refunds/chargebacks)</li>
              <li>Audit logs + admin inspection tools</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">🛒</div>
              <h3>Vendor Store + POS + Checkout</h3>
            </div>
            <p>
              Run browser-based POS and online checkout with integrated credit card processing.
              Vendor catalogs support spreadsheet uploads and in-app management.
            </p>
            <ul class="checklist">
              <li>Vendor-specific stores (products + services)</li>
              <li>Inventory/backstock + low-stock controls</li>
              <li>Payments integration (Stripe-ready)</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">🎨</div>
              <h3>Store Customization</h3>
            </div>
            <p>
              Make each merchant feel like a brand, not a template. Configure themes, logos, layouts, and responsive
              storefront experiences across desktop, tablet, and mobile.
            </p>
            <ul class="checklist">
              <li>Vendor themes + branding assets</li>
              <li>Layout options + CSS customization</li>
              <li>Future token metadata aligned to branding</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">✅</div>
              <h3>Merchant Onboarding (Self‑Serve)</h3>
            </div>
            <p>
              Rollout-ready onboarding flow for merchants, including verification steps and admin approval pathways —
              built to scale beyond pilots.
            </p>
            <ul class="checklist">
              <li>Self‑serve signup + verification</li>
              <li>Admin review + approval controls</li>
              <li>Role-based portals out of the box</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">👛</div>

              <h3>Customer Wallet + Dashboard</h3>
            </div>
            <p>
              Customers see clear balances and transaction history across participating vendors. Redemptions
              are immediate and logged to the ledger.
            </p>
            <ul class="checklist">
              <li>Internal wallets + balances per vendor</li>
              <li>Transaction history + reward visibility</li>
              <li>Redeem for discounts, products, or services</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">🎯</div>
              <h3>Campaign Templates + Referrals</h3>
            </div>
            <p>
              Drive repeat purchase behaviors with simple, controllable campaign rules — and grow via owned
              distribution (signup links + referral codes).
            </p>
            <ul class="checklist">
              <li>% back, fixed per visit, time-bound promos</li>
              <li>Basic segmentation (new vs returning)</li>
              <li>Referral codes + tracked links</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">📊</div>
              <h3>Dashboards + Reporting</h3>
            </div>
            <p>
              Practical analytics for merchants and admins: rewards issued, redemptions, active customers,
              anomalies, growth metrics — plus exports and scheduled reports.
            </p>
            <ul class="checklist">
              <li>Merchant dashboard + admin dashboard</li>
              <li>CSV exports + scheduled email reports</li>
              <li>Transactional email/notifications (optional)</li>
              <li>AI-ready reporting hooks (optional)</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">🧩</div>
              <h3>Modular by Design</h3>
            </div>
            <p>
              Built like “LEGO blocks”: wallet, promos, analytics, fraud/limits, admin controls.
              Clear API boundaries keep business logic stable as integrations evolve.
            </p>
            <ul class="checklist">
              <li>Role-based access control (admin/vendor/customer)</li>
              <li>REST/JSON API scaffolding + error standards</li>
              <li>Designed for Phase 2 mapping</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">🛡️</div>
              <h3>Control & Safety</h3>
            </div>
            <p>
              Prevent “loyalty leakage” with configurable limits, fraud/abuse protections, real-time cost visibility,
              and auditability.
            </p>
            <ul class="checklist">
              <li>Safety limits + rule guardrails</li>
              <li>Refund/chargeback reversals</li>
              <li>Ban controls + monitoring</li>
            </ul>
          </article>

          <article class="card feature-card reveal">
            <div class="card-top">
              <div class="icon">⚡</div>
              <h3>Web3 Upgrade Path (Optional)</h3>
            </div>
            <p>
              Start Web2-simple. When transaction volumes, regulatory clarity, and real demand justify it,
              migrate balances 1:1 into branded vendor tokens on Cardano.
            </p>
            <ul class="checklist">
              <li>Vendor-specific token mapping</li>
              <li>Customer wallet integrations (Phase 2)</li>
              <li>Portable, blockchain-secured rewards</li>
            </ul>
          </article>
        </div>
      </div>
    </section>

    <!-- How it works -->
    <section class="section section-alt" id="how-it-works">
      <div class="container">
        <div class="section-head reveal">
          <h2 class="section-title">How it works</h2>
          <p class="section-lede">
            A simple loyalty cycle — backed by an auditable ledger so rewards are predictable, measurable, and controlled.
          </p>
        </div>

        <div class="steps">
          <div class="step card reveal">
            <div class="step-num">01</div>
            <h3>Customer buys</h3>
            <p>In-store (POS) or online checkout, with credit card payments integrated into the workflow.</p>
          </div>

          <div class="step card reveal">
            <div class="step-num">02</div>
            <h3>Rewards are earned and logged</h3>
            <p>Reward rules issue tokens/credits. Every issuance is recorded with full ledger history.</p>
          </div>

          <div class="step card reveal">
            <div class="step-num">03</div>
            <h3>Balance updates instantly</h3>
            <p>Customers see clear balances and transaction history — no confusing points math.</p>
          </div>

          <div class="step card reveal">
            <div class="step-num">04</div>
            <h3>Rewards are redeemed later</h3>
            <p>Redemptions deduct balances and post ledger entries. Refunds/chargebacks post adjustments.</p>
          </div>
        </div>

        <div class="callout reveal">
          <div class="callout-inner">
            <div class="callout-title">Web2 onboarding without friction</div>
            <p class="callout-text">
              Start with internal wallets and database-backed balances. Avoid seed phrases and external wallet complexity
              until you’ve proven adoption and economics.
            </p>
          </div>
          <a class="btn btn-ghost" href="#roadmap">See the roadmap</a>
        </div>
      </div>
    </section>

    <!-- Who it's for -->
    <section class="section" id="who-its-for">
      <div class="container">
        <div class="section-head reveal">
          <h2 class="section-title">Built for everyone in the loyalty value chain</h2>
          <p class="section-lede">
            Customers want clarity. Vendors want control. Investors want a de-risked path to network effects.
          </p>
        </div>

        <div class="tabs reveal" role="tablist" aria-label="NovaVault audience tabs">
          <button class="tab is-active" role="tab" aria-selected="true" data-tab="customers">Customers</button>
          <button class="tab" role="tab" aria-selected="false" data-tab="vendors">Vendors</button>
          <button class="tab" role="tab" aria-selected="false" data-tab="investors">Investors</button>
        </div>

        <div class="tab-panels">
          <div class="panel is-active card reveal" data-panel="customers" role="tabpanel">
            <h3>Value for Customers</h3>
            <p>
              Earn automatically on purchases, view balances + history, and redeem for real rewards — without crypto
              friction. A single dashboard where rewards feel like real money.
            </p>
            <div class="panel-grid">
              <div class="mini">
                <div class="mini-title">Clear balances</div>
                <div class="mini-text">See value, not mystery points.</div>
              </div>
              <div class="mini">
                <div class="mini-title">Frictionless onboarding</div>
                <div class="mini-text">Web2 now — no seed phrases required.</div>
              </div>
              <div class="mini">
                <div class="mini-title">Future portability</div>
                <div class="mini-text">Optional on-chain migration later.</div>
              </div>
            </div>
          </div>

          <div class="panel card reveal" data-panel="vendors" role="tabpanel">
            <h3>Value for Vendors</h3>
            <p>
              Store + POS + checkout → auto rewards issuance → dashboards + campaigns → redemption → repeat purchases.
              Configurable rewards drive the behaviors you want while protecting margins.
            </p>
            <div class="panel-grid">
              <div class="mini">
                <div class="mini-title">Owned distribution</div>
                <div class="mini-text">Signup links, referral codes, customer lists.</div>
              </div>
              <div class="mini">
                <div class="mini-title">Integrity controls</div>
                <div class="mini-text">Refund/chargeback reversals protect economics.</div>
              </div>
              <div class="mini">
                <div class="mini-title">Launch in days</div>
                <div class="mini-text">Catalog uploads + configurable rules.</div>
              </div>
            </div>
          </div>

          <div class="panel card reveal" data-panel="investors" role="tabpanel">
            <h3>Value for Investors</h3>
            <p>
              Phase 1 ships as a Web2 revenue platform. Phase 2 adds tokenization as an expansion layer for moat + network effects.
              Economics are protected by ledger integrity and anti-leakage controls.
            </p>
            <div class="panel-grid">
              <div class="mini">
                <div class="mini-title">De-risked roadmap</div>
                <div class="mini-text">Revenue and adoption before tokenization.</div>
              </div>
              <div class="mini">
                <div class="mini-title">Two monetization layers</div>
                <div class="mini-text">Merchant fees now; token services later.</div>
              </div>
              <div class="mini">
                <div class="mini-title">Operational KPIs</div>
                <div class="mini-text">GMV, redemption rate, leakage, disputes.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Roadmap -->
    <section class="section section-alt" id="roadmap">
      <div class="container">
        <div class="section-head reveal">
          <h2 class="section-title">Roadmap: prove the model, then unlock Web3</h2>
          <p class="section-lede">
            NovaVault is intentionally staged: ship Web2, validate economics, then activate blockchain when the conditions are right.
          </p>
        </div>

        <div class="timeline">
          <div class="timeline-item card reveal">
            <div class="timeline-top">
              <div class="phase">Phase 1</div>
              <div class="time">0–45 days</div>
            </div>
            <h3>Web2 MVP — Live</h3>
            <ul class="checklist">
              <li>Core ledger engine: earn & redeem flows</li>
              <li>Admin dashboard (rules, limits, audit logs)</li>
              <li>Customer wallet (balance + redemption)</li>
              <li>Web2-only launch (no blockchain dependency)</li>
            </ul>
          </div>

          <div class="timeline-item card reveal">
            <div class="timeline-top">
              <div class="phase">Phase 2</div>
              <div class="time">45–90 days</div>
            </div>
            <h3>Early traction</h3>
            <ul class="checklist">
              <li>Onboard 5–10 pilot merchants</li>
              <li>Launch first live loyalty programs</li>
              <li>Track retention + reward cost metrics</li>
              <li>Harden fraud controls & limits</li>
            </ul>
          </div>

          <div class="timeline-item card reveal">
            <div class="timeline-top">
              <div class="phase">Phase 3</div>
              <div class="time">90–120 days</div>
            </div>
            <h3>Scale readiness</h3>
            <ul class="checklist">
              <li>Improve analytics & reporting</li>
              <li>Add integrations (POS / ecommerce)</li>
              <li>Define blockchain activation criteria</li>
              <li>Identify first Web3-ready merchant candidates</li>
            </ul>
          </div>
        </div>

        <details class="details reveal">
          <summary>
            <span class="details-title">Rollout-ready build plan (Plan B)</span>
            <span class="details-sub">14–16 weeks • milestone-based delivery • security + reliability gates</span>
          </summary>

          <div class="details-body">
            <div class="milestones">
              <div class="milestone">
                <div class="milestone-title">Milestone 0 — Discovery + Architecture + Design System</div>
                <div class="milestone-meta">Weeks 1–2</div>
                <p>Requirements, UX flows + clickable prototype, finalized ledger/campaign data model, threat model, DevOps plan.</p>
              </div>

              <div class="milestone">
                <div class="milestone-title">Milestone 1 — Core Platform Foundation</div>
                <div class="milestone-meta">Weeks 3–5</div>
                <p>Auth + roles, self-serve merchant onboarding with admin approval, base UI components, API scaffolding.</p>
              </div>

              <div class="milestone">
                <div class="milestone-title">Milestone 2 — Ledger v1 + Adjustments + Idempotency</div>
                <div class="milestone-meta">Weeks 6–7</div>
                <p>Earn/redemption/adjustments, idempotent processing, admin ledger inspection, unit tests for invariants.</p>
              </div>

              <div class="milestone">
                <div class="milestone-title">Milestone 3 — Payments + Reconciliation</div>
                <div class="milestone-meta">Weeks 8–10</div>
                <p>Stripe integration (Checkout or Payment Intents), webhooks + reconciliation report, refund handling entries.</p>
              </div>

              <div class="milestone">
                <div class="milestone-title">Milestone 4 — Campaigns + Dashboards</div>
                <div class="milestone-meta">Weeks 11–12</div>
                <p>Campaign templates, merchant/admin dashboards, export/reporting; campaigns can’t break accounting logic.</p>
              </div>

              <div class="milestone">
                <div class="milestone-title">Milestone 5 — QA Automation + Security + Hardening</div>
                <div class="milestone-meta">Weeks 13–14</div>
                <p>Smoke tests, professional pentest + remediation, monitoring/alerting upgrades + runbook.</p>
              </div>

              <div class="milestone">
                <div class="milestone-title">Milestone 6 — Pilot Rollout + Stabilization</div>
                <div class="milestone-meta">Weeks 15–16</div>
                <p>Onboard 3–10 merchants, training docs + support workflow, stabilization sprint, Phase Two readiness report.</p>
              </div>
            </div>
          </div>
        </details>
      </div>
    </section>

    <!-- Pricing -->
    <section class="section" id="pricing">
      <div class="container">
        <div class="section-head reveal">
          <h2 class="section-title">Pricing that fits real merchants</h2>
          <p class="section-lede">
            Start lean with Web2 stores and ledger economics. Add tokenization services in Phase 2 if/when your business is ready.
          </p>
        </div>

        <div class="pricing-grid">
          <div class="card price-card reveal">
            <div class="price-tier">Base</div>
            <div class="price-title">Starter Store</div>
            <div class="price-bullets">
              <div class="bullet">Up to 25 items</div>
              <div class="bullet">Vendor provides pre‑populated spreadsheet</div>
              <div class="bullet">Store + POS + rewards configuration</div>
            </div>
            <a class="btn btn-ghost" href="#contact">Get a quote</a>
          </div>

          <div class="card price-card featured reveal">
            <div class="price-tier">Standard</div>
            <div class="price-title">Growth Store</div>
            <div class="price-bullets">
              <div class="bullet">Up to 100 items</div>
              <div class="bullet">Dashboards + campaigns</div>
              <div class="bullet">Exports + scheduled reports</div>
            </div>
            <a class="btn btn-primary" href="#contact">Request demo</a>
          </div>

          <div class="card price-card reveal">
            <div class="price-tier">Scale</div>
            <div class="price-title">Expanded Catalog</div>
            <div class="price-bullets">
              <div class="bullet">Additional item costs (over base thresholds)</div>
              <div class="bullet">Optional product entry services</div>
              <div class="bullet">Enhanced monitoring + reliability</div>
            </div>
            <a class="btn btn-ghost" href="#contact">Talk to sales</a>
          </div>
        </div>

        <div class="note reveal">
          <div class="note-title">Phase 2 add‑on: tokenization services</div>
          <p class="note-text">
            When Web3 activation criteria are met, NovaVault can mint or integrate a branded vendor token on Cardano and migrate
            balances 1:1 from internal wallets to on-chain assets — as an upgrade, not a requirement.
          </p>
        </div>
      </div>
    </section>

    <!-- Security -->
    <section class="section section-alt" id="security">
      <div class="container">
        <div class="section-head reveal">
          <h2 class="section-title">Security + reliability by design</h2>
          <p class="section-lede">
            Loyalty is financial infrastructure. NovaVault treats it that way with hardened controls, audit trails, testing,
            and operational readiness.
          </p>
        </div>

        <div class="security-grid">
          <article class="card reveal">
            <h3>Access controls + auditability</h3>
            <ul class="checklist">
              <li>Role-based access (admin/vendor/customer)</li>
              <li>Audit logs and ledger inspection</li>
              <li>Ban tooling (IP/email/username)</li>
            </ul>
          </article>

          <article class="card reveal">
            <h3>Payments integrity</h3>
            <ul class="checklist">
              <li>Webhook reconciliation (“Stripe vs ledger”)</li>
              <li>Refund & chargeback adjustments</li>
              <li>Idempotent event processing</li>
            </ul>
          </article>

          <article class="card reveal">
            <h3>Operational hardening</h3>
            <ul class="checklist">
              <li>Monitoring + uptime alerts</li>
              <li>Log aggregation + dashboards</li>
              <li>Backups + restore tests</li>
              <li>Deployment pipeline + rollback (optional)</li>
              <li>Secrets management hygiene</li>
            </ul>
          </article>

          <article class="card reveal">
            <h3>Quality gates</h3>
            <ul class="checklist">
              <li>Unit tests for ledger invariants</li>
              <li>API contract tests + smoke tests</li>
              <li>Professional pentest + remediation cycle</li>
            </ul>
          </article>
        </div>

        <div class="tech-strip reveal" aria-label="Technical foundation">
          <div class="tech-pill">Haskell backend (Yesod / Scotty / Snap)</div>
          <div class="tech-pill">REST/JSON APIs</div>
          <div class="tech-pill">PostgreSQL / MySQL / SQLite</div>
          <div class="tech-pill">Dedicated hosting + observability</div>
        </div>
      </div>
    </section>

    <!-- Contact -->
    <section class="section" id="contact">
      <div class="container">
        <div class="section-head reveal">
          <h2 class="section-title">Ready to see NovaVault in action?</h2>
          <p class="section-lede">
            Tell us what kind of business you’re running and what you want loyalty to accomplish. We’ll respond with a tailored walkthrough.
          </p>
        </div>

        <div class="contact-grid">
          <div class="card reveal">
            <h3>Fast path</h3>
            <p>Use this landing page as your public pitch now — and connect it to your onboarding & demo flows later.</p>

            <div class="contact-actions">
              <a class="btn btn-primary" href="mailto:hello@novavault.io">Email hello@novavault.io</a>
              <a class="btn btn-ghost" href="#pricing">View pricing tiers</a>
            </div>

            <div class="mini-note">
              Tip: If you want, we can wire this page to a real form endpoint (HubSpot, Mailchimp, custom API) in minutes.
            </div>
          </div>

          <form class="card form reveal" aria-label="Contact form (static demo)">
            <h3>Request a demo</h3>

            <label>
              <span>Name</span>
              <input type="text" name="name" placeholder="Jane Doe" autocomplete="name" />
            </label>

            <label>
              <span>Email</span>
              <input type="email" name="email" placeholder="jane@company.com" autocomplete="email" />
            </label>

            <label>
              <span>Company</span>
              <input type="text" name="company" placeholder="Acme, Inc." autocomplete="organization" />
            </label>

            <label>
              <span>What are you trying to improve?</span>
              <select name="goal">
                <option value="" selected disabled>Choose one</option>
                <option>Repeat purchases / retention</option>
                <option>Average order value</option>
                <option>Referral growth</option>
                <option>Subscription retention</option>
                <option>Multi-vendor loyalty network</option>
              </select>
            </label>

            <label>
              <span>Notes</span>
              <textarea name="notes" rows="4" placeholder="Tell us your current loyalty setup (or lack of one)..."></textarea>
            </label>

            <button class="btn btn-primary" type="button" data-toast="This demo form is static. Hook it to your backend when ready.">
              Send request
            </button>

            <p class="form-disclaimer">
              This form is a front-end demo only. Connect it to a backend endpoint to receive submissions.
            </p>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <div class="footer-left">
        <img class="footer-logo" src="assets/images/novavault_logo.png" alt="NovaVault logo" />
        <div class="footer-links">
          <a href="#pricing">Pricing</a>
          <a href="#security">Security</a>
          <a href="#contact">Contact</a>
        </div>
      </div>

      <div class="footer-right">
        <a class="back-to-top" href="#top" aria-label="Back to top">Back to top ↑</a>
        <div class="footer-meta">
          <span>© <span id="year"></span> NovaVault.io</span>
          <span class="dot">•</span>
          <span>Web2 onboarding → Web3 upgrade path</span>
        </div>
      </div>
    </div>
  </footer>

  <div class="toast" id="toast" role="status" aria-live="polite" aria-atomic="true"></div>

  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script>
    // Theme toggle for the marketing page (no Alpine here)
    (function() {
      var btn = document.getElementById('themeToggle');
      var icon = document.getElementById('themeIcon');
      function isLight() { return document.documentElement.classList.contains('light'); }
      function updateIcon() { icon.textContent = isLight() ? '\uD83C\uDF19' : '\u2600\uFE0F'; }
      updateIcon();
      btn.addEventListener('click', function() {
        document.documentElement.classList.toggle('light');
        localStorage.setItem('nv-theme', isLight() ? 'light' : 'dark');
        updateIcon();
      });
    })();
  </script>
</body>
</html>
