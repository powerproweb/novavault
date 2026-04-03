<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Patron\DashboardController as PatronDashboard;
use App\Http\Controllers\Patron\RedemptionController;
use App\Http\Controllers\Patron\ReferralController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\BlogController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\StorefrontController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Vendor\AnalyticsController;
use App\Http\Controllers\Vendor\CategoryController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Vendor\ExportController;
use App\Http\Controllers\Vendor\OnboardingController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\POSController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\RewardRuleController;
use App\Http\Controllers\Vendor\TierController;
use Illuminate\Support\Facades\Route;

// ----- Public -----

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Post-login redirect based on role
Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'vendor' => redirect()->route('vendor.dashboard'),
        default => redirect()->route('patron.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// ----- Profile (all authenticated users) -----

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ----- Vendor -----

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('vendor.onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('vendor.onboarding.store');
    Route::get('/pending', [OnboardingController::class, 'pending'])->name('vendor.pending');

    // Approved vendors only
    Route::middleware('vendor.approved')->group(function () {
        Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('vendor.dashboard');

        Route::resource('products', ProductController::class)
            ->names('vendor.products')
            ->except('show');
        Route::post('/products/bulk-toggle', [ProductController::class, 'bulkToggle'])
            ->name('vendor.products.bulk-toggle');
        Route::post('/products/import', [ProductController::class, 'import'])
            ->name('vendor.products.import');

        Route::get('/reward-rules', [RewardRuleController::class, 'index'])->name('vendor.reward-rules.index');
        Route::post('/reward-rules', [RewardRuleController::class, 'store'])->name('vendor.reward-rules.store');
        Route::put('/reward-rules/{rule}', [RewardRuleController::class, 'update'])->name('vendor.reward-rules.update');
        Route::delete('/reward-rules/{rule}', [RewardRuleController::class, 'destroy'])->name('vendor.reward-rules.destroy');

        Route::get('/orders', [OrderController::class, 'index'])->name('vendor.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('vendor.orders.show');
        Route::post('/orders/{order}/refund', [OrderController::class, 'refund'])->name('vendor.orders.refund');

        Route::get('/pos', [POSController::class, 'index'])->name('vendor.pos');
        Route::post('/pos/sale', [POSController::class, 'sale'])->name('vendor.pos.sale');

        Route::get('/categories', [CategoryController::class, 'index'])->name('vendor.categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('vendor.categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('vendor.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('vendor.categories.destroy');

        // Phase 2: Analytics, Tiers, Export
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('vendor.analytics');

        Route::get('/tiers', [TierController::class, 'index'])->name('vendor.tiers.index');
        Route::post('/tiers', [TierController::class, 'store'])->name('vendor.tiers.store');
        Route::delete('/tiers/{tier}', [TierController::class, 'destroy'])->name('vendor.tiers.destroy');

        Route::get('/export', [ExportController::class, 'index'])->name('vendor.export');
        Route::post('/export', [ExportController::class, 'download'])->name('vendor.export.download');
    });
});

// ----- Patron -----

Route::middleware(['auth', 'role:patron'])->prefix('patron')->group(function () {
    Route::get('/dashboard', [PatronDashboard::class, 'index'])->name('patron.dashboard');
    Route::get('/wallets', [PatronDashboard::class, 'wallets'])->name('patron.wallets');
    Route::get('/transactions', [PatronDashboard::class, 'transactions'])->name('patron.transactions');
    Route::get('/discover', [PatronDashboard::class, 'discover'])->name('patron.discover');

    Route::get('/redemptions', [RedemptionController::class, 'index'])->name('patron.redemptions');
    Route::get('/redeem/{vendor}', [RedemptionController::class, 'offers'])->name('patron.redeem.offers');
    Route::post('/redeem', [RedemptionController::class, 'redeem'])->name('patron.redeem');

    // Phase 2: Referrals & Badges
    Route::get('/referrals', [ReferralController::class, 'index'])->name('patron.referrals');
});

// ----- Storefront (public) -----

Route::prefix('store/{vendor:slug}')->group(function () {
    Route::get('/', [StorefrontController::class, 'show'])->name('store.show');
    Route::get('/category/{categorySlug}', [StorefrontController::class, 'category'])->name('store.category');
    Route::get('/product/{product}', [StorefrontController::class, 'product'])->name('store.product');

    Route::get('/cart', [CheckoutController::class, 'cart'])->name('store.cart');
    Route::post('/cart/add/{product}', [CheckoutController::class, 'addToCart'])->name('store.cart.add');
    Route::delete('/cart/remove/{product}', [CheckoutController::class, 'removeFromCart'])->name('store.cart.remove');
    Route::post('/checkout', [CheckoutController::class, 'processOrder'])->name('store.checkout')->middleware('auth');
    Route::get('/order/{order}', [CheckoutController::class, 'confirmation'])->name('store.order-confirmation')->middleware('auth');
});

// ----- Admin -----

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/vendors', [AdminController::class, 'vendors'])->name('admin.vendors');
    Route::post('/vendors/{vendor}/approve', [AdminController::class, 'approveVendor'])->name('admin.vendors.approve');
    Route::post('/vendors/{vendor}/suspend', [AdminController::class, 'suspendVendor'])->name('admin.vendors.suspend');
    Route::get('/vendors/{vendor}/edit', [AdminController::class, 'editVendor'])->name('admin.vendors.edit');
    Route::put('/vendors/{vendor}', [AdminController::class, 'updateVendor'])->name('admin.vendors.update');

    Route::get('/patrons', [AdminController::class, 'patrons'])->name('admin.patrons');
    Route::get('/patrons/{user}', [AdminController::class, 'showPatron'])->name('admin.patrons.show');
    Route::post('/patrons/{user}/suspend', [AdminController::class, 'suspendPatron'])->name('admin.patrons.suspend');

    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/redemptions', [AdminController::class, 'redemptions'])->name('admin.redemptions');

    Route::get('/bans', [AdminController::class, 'bans'])->name('admin.bans');
    Route::post('/bans', [AdminController::class, 'storeBan'])->name('admin.bans.store');
    Route::delete('/bans/{ban}', [AdminController::class, 'destroyBan'])->name('admin.bans.destroy');

    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');

    // Phase 2: Blog CMS + Support Tickets
    Route::resource('posts', PostController::class)->names('admin.posts');

    Route::get('/tickets', function () {
        $tickets = \App\Models\SupportTicket::with('user', 'assignee')->latest()->paginate(20);
        return view('admin.tickets', compact('tickets'));
    })->name('admin.tickets');
});

// ----- Blog (public) -----
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// ----- Support (all authenticated users) -----
Route::middleware('auth')->prefix('support')->group(function () {
    Route::get('/', [SupportController::class, 'index'])->name('support.index');
    Route::get('/create', [SupportController::class, 'create'])->name('support.create');
    Route::post('/', [SupportController::class, 'store'])->name('support.store');
    Route::get('/{ticket}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/{ticket}/reply', [SupportController::class, 'reply'])->name('support.reply');
});

require __DIR__.'/auth.php';
