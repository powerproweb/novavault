<?php

namespace App\Http\Controllers\Patron;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\Vendor;
use App\Models\Wallet;
use App\Services\TokenEngine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RedemptionController extends Controller
{
    public function index(Request $request): View
    {
        $redemptions = Redemption::where('patron_id', $request->user()->id)
            ->with('vendor')
            ->latest()
            ->paginate(20);

        return view('patron.redemptions.index', compact('redemptions'));
    }

    /**
     * Show available offers for a specific vendor.
     */
    public function offers(Request $request, Vendor $vendor): View
    {
        $wallet = Wallet::where('user_id', $request->user()->id)
            ->where('vendor_id', $vendor->id)
            ->first();

        $balance = $wallet?->balance ?? 0;

        // For now promotions serve as the "offers" — will expand later
        $offers = $vendor->promotions()->where('active', true)->get();

        return view('patron.redemptions.offers', compact('vendor', 'wallet', 'balance', 'offers'));
    }

    /**
     * Execute a redemption.
     */
    public function redeem(Request $request, TokenEngine $engine): RedirectResponse
    {
        $validated = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'amount' => ['required', 'numeric', 'min:0.00000001'],
            'reward_type' => ['required', 'in:discount_pct,discount_flat,free_product,service,promo'],
            'reward_detail' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $entry = $engine->debit(
                userId: $request->user()->id,
                vendorId: $validated['vendor_id'],
                amount: (string) $validated['amount'],
                type: 'redeem',
                referenceType: 'redemption',
                memo: "Redeemed: {$validated['reward_type']}"
            );

            $redemption = Redemption::create([
                'wallet_id' => $entry->wallet_id,
                'patron_id' => $request->user()->id,
                'vendor_id' => $validated['vendor_id'],
                'amount' => $validated['amount'],
                'reward_type' => $validated['reward_type'],
                'reward_detail_json' => $validated['reward_detail'] ? ['note' => $validated['reward_detail']] : null,
                'status' => 'completed',
                'confirmation_code' => strtoupper(Str::random(8)),
            ]);

            // Link the ledger entry to this redemption
            $entry->update([
                'reference_type' => 'redemption',
                'reference_id' => $redemption->id,
            ]);

            return back()->with('status', "Redeemed! Confirmation: {$redemption->confirmation_code}");
        } catch (\DomainException $e) {
            return back()->withErrors(['amount' => $e->getMessage()]);
        }
    }
}
