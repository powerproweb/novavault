# NovaVault.io — Phase 3 Build Plan

## Web3 Transition, Tokenization, and Ecosystem Expansion

**Goal:** Transform NovaVault from a Web2 loyalty platform into a Web3-capable rewards infrastructure where vendor reward balances can be represented as branded blockchain tokens on Cardano, while preserving the easy merchant and patron flows established in earlier phases.

**Prerequisites:** Phase 1 + Phase 2 complete — stable platform with active vendors, proven token engine, working ledger, analytics, tiered loyalty, API, billing.

---

### 3.1 Blockchain Architecture Design

**Ledger-to-Chain Mapping**

- Define how internal `token_ledger` events (earn/redeem/reverse/adjust) map to on-chain actions (mint/burn/transfer)
- Not every internal event needs an on-chain counterpart — define which events trigger chain writes vs. batch settlement
- Design the reconciliation strategy: periodic sync job compares DB wallet balances against on-chain token holdings, flags discrepancies

**Token Policy Design**

- Each vendor gets a Cardano native token with a unique policy ID
- Define minting policy: who can mint (platform-controlled policy script), supply rules (capped vs. uncapped), burning rules
- Define vendor token metadata: name, ticker, description, logo (CIP-25 / CIP-68 metadata standard)

**Custody Model**

- Platform-managed custody (Phase 3 default): platform holds keys, patrons see on-chain balances but don't manage wallets directly
- User-managed custody (Phase 3 advanced): patrons link external Cardano wallets, can withdraw tokens
- Define withdrawal model: patron requests withdrawal → platform verifies balance → submits on-chain transfer → updates internal ledger

**New tables/columns:**

- `blockchain_wallets` — id, user_id, vendor_id, wallet_address, type (platform/external), verified, created_at
- `chain_transactions` — id, wallet_id, tx_hash, type (mint/burn/transfer), amount, status (pending/confirmed/failed), block_height, created_at
- `vendor_tokens` — id, vendor_id, policy_id, asset_name, ticker, total_supply, minted_supply, metadata_json, status (draft/active/paused), created_at
- Add `token_ledger.chain_tx_id` (FK, nullable) — links internal ledger entries to on-chain transactions

**Deliverables:** Complete architecture document, database migrations, reconciliation service skeleton.

---

### 3.2 Vendor Token Creation Workflow

**Token Setup Wizard (Vendor Dashboard)**

- Step 1: Token branding — name, ticker symbol (e.g., "NOVA-CAFE"), description
- Step 2: Brand assets — logo upload (for on-chain metadata), color scheme
- Step 3: Supply configuration — initial supply, max supply (or unlimited), minting schedule
- Step 4: Fee and allocation — platform fee percentage on mints, vendor reserve allocation
- Step 5: Review and submit for approval

**Admin Compliance Review**

- Admin reviews token request: business legitimacy, naming conflicts, regulatory flags
- Approve → triggers minting policy creation on Cardano
- Reject → notification with reason, vendor can resubmit

**Minting Pipeline**

- Use Blockfrost API (or `cardano-cli` via server) for on-chain operations
- Create minting policy script per vendor
- Mint initial token supply to platform-managed wallet
- Register token metadata on-chain (CIP-25/CIP-68)
- Update `vendor_tokens` record with policy_id, asset_name, tx_hash

**Deliverables:** Vendor can request, configure, and launch a branded Cardano native token through the platform.

---

### 3.3 External Wallet Integration

**Patron Wallet Connection**

- CIP-30 wallet connector (JavaScript): support Nami, Eternl, Flint, Lace, Typhon
- Patron links external wallet from dashboard → signs verification message → platform records wallet address
- Display external wallet balance alongside internal balance
- Multiple wallet support (one primary for withdrawals)

**Vendor Payout Wallet**

- Vendor links Cardano wallet for receiving token-related payouts or fee distributions
- Wallet verification via signed message
- Admin can require wallet linking before activating token features

**Platform Wallet Management**

- Platform-managed HD wallet infrastructure for custodial operations
- Key management: encrypted key storage, key rotation policy
- Per-vendor sub-wallets for token custody segregation

**New UI components:**

- Wallet connection modal (Alpine.js + CIP-30 JS bridge)
- Wallet address display with copy/explorer link
- Transaction signing confirmation dialogs

**Deliverables:** Patrons and vendors can connect Cardano wallets; platform can manage custodial wallets.

---

### 3.4 On-Chain Token Movements

**Internal-to-Chain Sync**

- When patron earns tokens (Phase 1 engine): internal ledger entry created immediately; on-chain mint queued (batch or real-time based on vendor config)
- Batch minting job: aggregates pending earn events → single mint transaction → distributes to patron platform wallets
- Real-time mode (premium): individual mint per earn event

**Token Transfers**

- Patron-to-patron transfer (if vendor allows): debit sender wallet, credit receiver wallet, record on-chain
- Patron withdrawal to external wallet: verify balance, submit on-chain transfer, deduct internal balance on confirmation
- Platform-to-vendor distributions: fee payouts, revenue share

**Transaction Recording**

- Every on-chain transaction recorded in `chain_transactions` with tx_hash, block_height, confirmation status
- Internal `token_ledger` entries linked via `chain_tx_id`
- Confirmation watcher: background job polls Blockfrost for transaction confirmations, updates status

**Dashboard Integration**

- Patron dashboard shows: internal balance, on-chain balance, pending transactions
- Vendor dashboard shows: tokens minted, tokens in circulation, holder count
- Transaction history includes both internal and on-chain events with explorer links

**Deliverables:** Tokens flow between internal ledger and Cardano blockchain with full audit trail.

---

### 3.5 Web3 Redemption & Utility

**On-Chain Redemption**

- Patron burns tokens on-chain to redeem vendor rewards
- Burn transaction triggers redemption service → generates reward code/confirmation
- Alternative: patron transfers tokens back to vendor wallet (non-burn redemption)

**Cross-Vendor Token Use**

- Partner vendors can accept each other's tokens at defined exchange rates
- `token_exchange_rates` table — id, from_vendor_id, to_vendor_id, rate (DECIMAL), active
- Cross-vendor redemption flow: patron holds Token A → exchanges for Token B equivalent → redeems at Vendor B

**Advanced Token Campaigns**

- Burn-back campaigns: vendor offers bonus rewards for burning tokens (deflationary mechanics)
- Token-gated promotions: exclusive offers for patrons holding minimum token balance
- Staking-like mechanics: lock tokens for time period → earn bonus tokens (internal, not DeFi staking)

**Partner Collaborations**

- Vendor partnership portal: propose cross-promotion deals
- Shared reward pools between partner vendors
- Coalition token: optional shared token across vendor group

**Deliverables:** Token utility beyond simple earn/redeem — cross-vendor economy, burns, gated promotions.

---

### 3.6 Tokenomics Dashboard

**Vendor Tokenomics View**

- Circulating supply vs. total supply
- Token distribution: how tokens are spread across patron wallets
- Issuance rate: tokens minted per day/week/month
- Burn rate: tokens destroyed per period
- Holder activity: active holders, dormant holders, new holders
- Transfer volume: total tokens moved per period
- Top holders (anonymized or opt-in)

**Patron Token View**

- Portfolio overview: all vendor tokens held with current balances
- Historical balance chart per token
- On-chain activity feed
- Token value context (if vendor assigns fiat equivalence)

**Admin Ecosystem View**

- Aggregate tokenomics across all vendor tokens
- Network health metrics: total tokens across all vendors, total holders, velocity
- On-chain event history with filters
- Anomaly detection alerts (unusual minting, large transfers, rapid burns)

**Implementation:**

- `tokenomics_snapshots` — daily rollup per vendor token (supply, holders, volume, burns, mints)
- Chart.js or Apex Charts for visualization
- Export capability for all tokenomics data

**Deliverables:** Full visibility into the token economy for vendors, patrons, and platform admins.

---

### 3.7 Cross-Vendor Network Effects

**Vendor Partnerships**

- Partnership request system: Vendor A proposes partnership to Vendor B
- Partnership types: cross-redemption, shared campaigns, token exchange, joint promotions
- Partnership dashboard: manage active partnerships, view shared metrics

**Shared Campaigns**

- Multi-vendor campaigns: several vendors pool rewards for a themed promotion (e.g., "Downtown Rewards Week")
- Shared campaign budget allocation and tracking
- Cross-vendor leaderboards for campaign participants

**Token Interoperability**

- Token swap marketplace: patrons exchange one vendor token for another at market/set rates
- Universal reward discovery: patron sees all redeemable offers across all vendors they hold tokens for
- Ecosystem loyalty: bonus for patrons active across multiple vendors

**Ecosystem Discovery**

- Public ecosystem map: interactive page showing all participating vendors, their tokens, and partnership connections
- "Explore Vendors" patron tool: discover new vendors based on token holdings and preferences
- Merchant network expansion pages: attract new vendors by showing ecosystem size and activity

**Deliverables:** NovaVault functions as a network, not just isolated vendor programs.

---

### 3.8 Public Site Web3 Messaging Update

**New Public Pages**

- Web3 capabilities overview: what tokenization means for vendors and patrons
- Tokenization explainer: step-by-step how vendor tokens work (non-technical language)
- Merchant token benefits page: ROI of branded tokens vs. traditional points
- Customer token ownership explainer: what it means to "own" your rewards
- Compliance and trust pages: how NovaVault handles token regulations, custody, security
- Ecosystem map page (interactive, data-driven from 3.7)
- Updated technology roadmap
- Investor traction section: metrics, growth charts, partnership announcements

**Messaging Evolution**

- Phase 1 message: "A modern loyalty platform that works"
- Phase 2 message: "The loyalty engine that grows your business"
- Phase 3 message: "Your rewards, your tokens, your ecosystem"

**Deliverables:** Public site reflects Web3 capabilities while maintaining accessibility for non-crypto audiences.

---

### Phase 3 Build Order

1. Blockchain architecture design + database migrations (3.1)
2. Vendor token creation workflow (3.2)
3. External wallet integration — CIP-30 (3.3)
4. On-chain token movements + reconciliation (3.4)
5. Web3 redemption & cross-vendor utility (3.5)
6. Tokenomics dashboard (3.6)
7. Cross-vendor network features (3.7)
8. Public site Web3 messaging update (3.8)
