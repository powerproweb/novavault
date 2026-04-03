<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['sometimes', 'in:patron,vendor'],
        ]);

        $role = $request->input('role', 'patron');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        // Auto-create vendor record if registering as vendor
        if ($role === 'vendor') {
            $user->vendor()->create([
                'business_name' => $request->name,
                'slug' => \Illuminate\Support\Str::slug($request->name),
                'status' => 'pending',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return match ($role) {
            'vendor' => redirect(route('vendor.onboarding', absolute: false)),
            default => redirect(route('patron.dashboard', absolute: false)),
        };
    }
}
