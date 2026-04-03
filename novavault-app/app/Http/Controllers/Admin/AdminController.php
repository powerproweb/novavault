<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Ban;
use App\Models\Order;
use App\Models\Redemption;
use App\Models\Setting;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    // ----- Dashboard / Analytics -----

    public function dashboard(): View
    {
        $stats = [
            'vendors_total' => Vendor::count(),
            'vendors_pending' => Vendor::pending()->count(),
            'vendors_approved' => Vendor::approved()->count(),
            'patrons_total' => User::where('role', 'patron')->count(),
            'orders_total' => Order::where('status', 'paid')->count(),
            'revenue_total' => Order::where('status', 'paid')->sum('total'),
            'tokens_issued' => \DB::table('token_ledger')->where('type', 'earn')->sum('amount'),
            'tokens_redeemed' => \DB::table('token_ledger')->where('type', 'redeem')->sum('amount'),
        ];

        $recentOrders = Order::with('vendor', 'patron')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    // ----- Vendors -----

    public function vendors(Request $request): View
    {
        $query = Vendor::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vendors = $query->latest()->paginate(20);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function approveVendor(Vendor $vendor): RedirectResponse
    {
        $vendor->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'vendor.approved',
            'target_type' => 'vendor',
            'target_id' => $vendor->id,
            'ip' => request()->ip(),
        ]);

        return back()->with('status', "{$vendor->business_name} approved.");
    }

    public function suspendVendor(Vendor $vendor): RedirectResponse
    {
        $vendor->update(['status' => 'suspended']);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'vendor.suspended',
            'target_type' => 'vendor',
            'target_id' => $vendor->id,
            'ip' => request()->ip(),
        ]);

        return back()->with('status', "{$vendor->business_name} suspended.");
    }

    public function editVendor(Vendor $vendor): View
    {
        $vendor->load('user', 'profile');

        return view('admin.vendors.edit', compact('vendor'));
    }

    public function updateVendor(Request $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validate([
            'pricing_tier' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:pending,approved,suspended'],
        ]);

        $vendor->update($validated);

        if ($validated['status'] === 'approved' && ! $vendor->approved_at) {
            $vendor->update(['approved_at' => now()]);
        }

        return redirect()->route('admin.vendors')
            ->with('status', "{$vendor->business_name} updated.");
    }

    // ----- Patrons -----

    public function patrons(): View
    {
        $patrons = User::where('role', 'patron')
            ->withCount('wallets')
            ->latest()
            ->paginate(20);

        return view('admin.patrons.index', compact('patrons'));
    }

    public function showPatron(User $user): View
    {
        $user->load('wallets.vendor');

        return view('admin.patrons.show', compact('user'));
    }

    public function suspendPatron(User $user): RedirectResponse
    {
        // Simple soft-disable: we don't delete but could add a 'suspended' flag later
        Ban::create([
            'type' => 'email',
            'value' => $user->email,
            'reason' => 'Admin suspended account.',
            'admin_id' => auth()->id(),
        ]);

        return back()->with('status', "{$user->name} suspended.");
    }

    // ----- Transactions -----

    public function transactions(Request $request): View
    {
        $query = Order::with('vendor', 'patron');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $orders = $query->latest()->paginate(30);

        return view('admin.transactions', compact('orders'));
    }

    // ----- Redemptions -----

    public function redemptions(): View
    {
        $redemptions = Redemption::with('vendor', 'patron')
            ->latest()
            ->paginate(30);

        return view('admin.redemptions', compact('redemptions'));
    }

    // ----- Bans -----

    public function bans(): View
    {
        $bans = Ban::with('admin')->latest('created_at')->paginate(20);

        return view('admin.bans.index', compact('bans'));
    }

    public function storeBan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:ip,email,username'],
            'value' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        Ban::create([...$validated, 'admin_id' => auth()->id()]);

        return back()->with('status', 'Ban created.');
    }

    public function destroyBan(Ban $ban): RedirectResponse
    {
        $ban->delete();

        return back()->with('status', 'Ban removed.');
    }

    // ----- Settings -----

    public function settings(): View
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'settings' => ['required', 'array'],
            'settings.*.group' => ['required', 'string'],
            'settings.*.key' => ['required', 'string'],
            'settings.*.value' => ['nullable', 'string'],
        ]);

        foreach ($request->settings as $item) {
            Setting::setValue($item['group'], $item['key'], $item['value']);
        }

        return back()->with('status', 'Settings saved.');
    }

    // ----- Audit Logs -----

    public function logs(): View
    {
        $logs = AuditLog::with('user')->latest('created_at')->paginate(50);

        return view('admin.logs', compact('logs'));
    }
}
