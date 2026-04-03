<?php

namespace App\Http\Controllers\Patron;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReferralController extends Controller
{
    public function index(Request $request): View
    {
        $referrals = Referral::where('referrer_id', $request->user()->id)
            ->with('referred', 'vendor')
            ->latest()
            ->paginate(20);

        // Generate referral links for each vendor the patron has a wallet with
        $walletVendors = $request->user()->wallets()->with('vendor')->get()
            ->pluck('vendor');

        $referralLinks = [];
        foreach ($walletVendors as $vendor) {
            $existing = Referral::where('referrer_id', $request->user()->id)
                ->where('vendor_id', $vendor->id)
                ->first();

            $code = $existing?->referral_code ?? strtoupper(Str::random(8));
            $referralLinks[$vendor->id] = [
                'vendor' => $vendor,
                'code' => $code,
                'url' => url("/store/{$vendor->slug}?ref={$code}"),
            ];
        }

        $badges = $request->user()->belongsToMany(\App\Models\Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->get();

        return view('patron.referrals', compact('referrals', 'referralLinks', 'badges'));
    }
}
