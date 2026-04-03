<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_patron_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Patron',
            'email' => 'patron@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'patron',
        ]);

        $response->assertRedirect('/patron/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'patron@test.com', 'role' => 'patron']);
    }

    public function test_vendor_registration_creates_vendor_record(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Vendor',
            'email' => 'vendor@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'vendor',
        ]);

        $response->assertRedirect('/vendor/onboarding');
        $this->assertDatabaseHas('users', ['email' => 'vendor@test.com', 'role' => 'vendor']);
        $this->assertDatabaseHas('vendors', ['business_name' => 'Test Vendor', 'status' => 'pending']);
    }

    public function test_role_middleware_blocks_unauthorized_access(): void
    {
        $patron = User::factory()->create(['role' => 'patron']);

        $this->actingAs($patron)->get('/vendor/dashboard')->assertForbidden();
        $this->actingAs($patron)->get('/admin/dashboard')->assertForbidden();
    }

    public function test_admin_cannot_register_via_form(): void
    {
        $response = $this->post('/register', [
            'name' => 'Hacker',
            'email' => 'hacker@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin', // not allowed
        ]);

        // Should fail validation since admin is not in the allowed roles
        $response->assertSessionHasErrors('role');
    }
}
