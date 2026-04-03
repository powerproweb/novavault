# NovaVault.io — Deployment Guide (BlueHost / cPanel)

## Prerequisites
- PHP 8.2+ with extensions: openssl, pdo_mysql, mbstring, fileinfo, curl, zip, gd, intl, sodium
- MySQL 8
- Composer (install via SSH if not available: `curl -sS https://getcomposer.org/installer | php`)
- Node.js is **NOT** needed on the server (assets are pre-built)

## Local: Build Assets Before Deploy
```bash
npm run build --prefix novavault-app
```
This generates `public/build/` — commit and push these files.

## Server Setup (one-time)

### 1. Upload / Clone
Upload the `novavault-app/` folder to the server, or use cPanel Git Deployment.

### 2. Point Document Root
In cPanel → Domains, set the document root for `novavault.io` to:
```
/home/youraccount/novavault-app/public
```
Or create a symlink: `ln -s /home/youraccount/novavault-app/public /home/youraccount/public_html`

### 3. Install PHP Dependencies
```bash
cd ~/novavault-app
composer install --no-dev --optimize-autoloader
```

### 4. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```
Then edit `.env`:
```
APP_NAME=NovaVault
APP_ENV=production
APP_DEBUG=false
APP_URL=https://novavault.io

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your_mailgun_user
MAIL_PASSWORD=your_mailgun_password
MAIL_FROM_ADDRESS=noreply@novavault.io
```

### 5. Create MySQL Database
cPanel → MySQL Databases → Create database + user → Assign user to database with all privileges.

### 6. Run Migrations
```bash
php artisan migrate --force
```

### 7. Seed Data
```bash
php artisan db:seed
```
This creates:
- Admin: `admin@novavault.io` / `changeme123`
- Demo Vendor: `vendor@novavault.io` / `changeme123` (approved, with 9 products)
- Demo Patron: `patron@novavault.io` / `changeme123`
- Platform settings

**IMPORTANT: Change all passwords immediately after first login.**

### 8. Storage Link
```bash
php artisan storage:link
```

### 9. Cache Config (production)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 10. Set Permissions
```bash
chmod -R 775 storage bootstrap/cache
```

## Demo Accounts
| Role    | Email                | Password      |
|---------|---------------------|---------------|
| Admin   | admin@novavault.io  | changeme123   |
| Vendor  | vendor@novavault.io | changeme123   |
| Patron  | patron@novavault.io | changeme123   |

## Stripe (when ready)
1. Create a Stripe account at stripe.com
2. Get API keys from Dashboard → Developers → API keys
3. Add to `.env`:
```
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...
```
4. The checkout controller is pre-wired for Stripe — just uncomment the Stripe calls.

## Ongoing
- Logs: `storage/logs/laravel.log`
- Clear cache: `php artisan cache:clear && php artisan config:clear`
- Run migrations after updates: `php artisan migrate --force`
