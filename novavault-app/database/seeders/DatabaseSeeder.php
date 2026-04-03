<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\RewardRule;
use App\Models\Setting;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ----- Admin -----
        User::create([
            'name' => 'Juan Jose Piedra',
            'email' => 'admin@novavault.io',
            'password' => Hash::make('changeme123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // ----- Demo Vendor -----
        $vendorUser = User::create([
            'name' => 'Demo Coffee Co.',
            'email' => 'vendor@novavault.io',
            'password' => Hash::make('changeme123'),
            'role' => 'vendor',
            'email_verified_at' => now(),
        ]);

        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'business_name' => 'Demo Coffee Co.',
            'slug' => 'demo-coffee',
            'description' => 'A sample coffee shop to demonstrate the NovaVault loyalty platform.',
            'category' => 'Restaurant',
            'contact_email' => 'vendor@novavault.io',
            'status' => 'approved',
            'pricing_tier' => 'starter',
            'approved_at' => now(),
        ]);

        VendorProfile::create([
            'vendor_id' => $vendor->id,
            'address' => '123 Main St, Anytown, USA',
            'website' => 'https://democoffee.example.com',
        ]);

        // Categories
        $drinks = Category::create(['vendor_id' => $vendor->id, 'name' => 'Drinks', 'slug' => 'drinks']);
        $food = Category::create(['vendor_id' => $vendor->id, 'name' => 'Food', 'slug' => 'food']);
        $merch = Category::create(['vendor_id' => $vendor->id, 'name' => 'Merch', 'slug' => 'merch']);

        // Products
        $products = [
            ['title' => 'Espresso', 'price' => 3.50, 'backstock_qty' => 100, 'category_id' => $drinks->id],
            ['title' => 'Latte', 'price' => 5.00, 'backstock_qty' => 100, 'category_id' => $drinks->id],
            ['title' => 'Cold Brew', 'price' => 4.75, 'backstock_qty' => 80, 'category_id' => $drinks->id],
            ['title' => 'Cappuccino', 'price' => 5.25, 'backstock_qty' => 90, 'category_id' => $drinks->id],
            ['title' => 'Avocado Toast', 'price' => 9.50, 'backstock_qty' => 40, 'category_id' => $food->id],
            ['title' => 'Blueberry Muffin', 'price' => 3.75, 'backstock_qty' => 50, 'category_id' => $food->id],
            ['title' => 'Croissant', 'price' => 4.00, 'backstock_qty' => 60, 'category_id' => $food->id],
            ['title' => 'Logo Mug', 'price' => 14.99, 'backstock_qty' => 25, 'category_id' => $merch->id],
            ['title' => 'Tote Bag', 'price' => 19.99, 'backstock_qty' => 15, 'category_id' => $merch->id],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, [
                'vendor_id' => $vendor->id,
                'status' => 'active',
                'low_stock_threshold' => 5,
            ]));
        }

        // Reward rule: 1 token per $1 spent
        RewardRule::create([
            'vendor_id' => $vendor->id,
            'earn_rate' => 1.0000,
            'min_purchase' => 0,
            'multiplier' => 1.00,
            'active' => true,
        ]);

        // ----- Demo Patron -----
        User::create([
            'name' => 'Jane Patron',
            'email' => 'patron@novavault.io',
            'password' => Hash::make('changeme123'),
            'role' => 'patron',
            'email_verified_at' => now(),
        ]);

        // ----- Platform Settings -----
        Setting::setValue('platform', 'default_earn_rate', '1.0');
        Setting::setValue('platform', 'min_redemption', '1.0');
        Setting::setValue('features', 'web3_enabled', 'false');
        Setting::setValue('features', 'sms_notifications', 'false');
    }
}
