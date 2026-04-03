<?php

namespace App\Http\Controllers\Patron;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $wallets = $user->wallets()
            ->with('vendor')
            ->where('balance', '>', 0)
            ->get();

        $totalBalance = $wallets->sum('balance');

        $recentTransactions = $user->wallets()
            ->join('token_ledger', 'wallets.id', '=', 'token_ledger.wallet_id')
            ->select('token_ledger.*', 'wallets.vendor_id')
            ->latest('token_ledger.created_at')
            ->take(15)
            ->get();

        return view('patron.dashboard', compact('wallets', 'totalBalance', 'recentTransactions'));
    }

    public function wallets(Request $request): View
    {
        $wallets = $request->user()->wallets()
            ->with('vendor')
            ->get();

        return view('patron.wallets', compact('wallets'));
    }

    public function transactions(Request $request): View
    {
        $entries = $request->user()->wallets()
            ->join('token_ledger', 'wallets.id', '=', 'token_ledger.wallet_id')
            ->join('vendors', 'wallets.vendor_id', '=', 'vendors.id')
            ->select('token_ledger.*', 'vendors.business_name as vendor_name')
            ->latest('token_ledger.created_at')
            ->paginate(30);

        return view('patron.transactions', compact('entries'));
    }

    public function discover(): View
    {
        $vendors = Vendor::approved()
            ->withCount('products')
            ->paginate(20);

        return view('patron.discover', compact('vendors'));
    }
}
