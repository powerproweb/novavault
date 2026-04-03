<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendorOnboardingTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendor_can_submit_onboarding_profile(): void
    {
        $user = User::factory()->create(['role' => 'vendor']);
        $vendor = Vendor::create([
            'user_id' => $user->id,
            'business_name' => 'My Shop',
            'slug' => 'my-shop',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post('/vendor/onboarding', [
            'business_name' => 'Updated Shop Name',
            'category' => 'Retail',
            'contact_email' => 'shop@example.com',
            'description' => 'A great shop.',
        ]);

        $response->assertRedirect(route('vendor.pending'));
        $this->assertDatabaseHas('vendors', ['business_name' => 'Updated Shop Name', 'category' => 'Retail']);
    }

    public function test_pending_vendor_cannot_access_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'vendor']);
        Vendor::create([
            'user_id' => $user->id,
            'business_name' => 'Pending Shop',
            'slug' => 'pending-shop',
            'status' => 'pending',
        ]);

        $this->actingAs($user)->get('/vendor/dashboard')->assertRedirect(route('vendor.pending'));
    }

    public function test_admin_can_approve_vendor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $vendorUser = User::factory()->create(['role' => 'vendor']);
        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'business_name' => 'Shop',
            'slug' => 'shop',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/admin/vendors/{$vendor->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('vendors', ['id' => $vendor->id, 'status' => 'approved']);
        $this->assertDatabaseHas('audit_logs', ['action' => 'vendor.approved', 'target_id' => $vendor->id]);
    }

    public function test_approved_vendor_can_access_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'vendor']);
        Vendor::create([
            'user_id' => $user->id,
            'business_name' => 'Approved Shop',
            'slug' => 'approved-shop',
            'status' => 'approved',
        ]);

        $this->actingAs($user)->get('/vendor/dashboard')->assertOk();
    }
}
