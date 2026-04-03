<?php

namespace App\Console\Commands;

use App\Models\AnalyticsSnapshot;
use App\Models\Vendor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SnapshotAnalytics extends Command
{
    protected $signature = 'analytics:snapshot {--date= : Date to snapshot (default: yesterday)}';
    protected $description = 'Generate daily analytics snapshots for all vendors';

    public function handle(): int
    {
        $date = $this->option('date')
            ? \Carbon\Carbon::parse($this->option('date'))
            : now()->subDay();

        $dateStr = $date->toDateString();

        $vendors = Vendor::approved()->get();

        foreach ($vendors as $vendor) {
            $orders = $vendor->orders()
                ->where('status', 'paid')
                ->whereDate('created_at', $dateStr);

            $tokenData = DB::table('wallets')
                ->join('token_ledger', 'wallets.id', '=', 'token_ledger.wallet_id')
                ->where('wallets.vendor_id', $vendor->id)
                ->whereDate('token_ledger.created_at', $dateStr);

            // Count patrons who ordered today
            $patronIds = $vendor->orders()
                ->where('status', 'paid')
                ->whereDate('created_at', $dateStr)
                ->whereNotNull('patron_id')
                ->pluck('patron_id')
                ->unique();

            // Repeat = patrons with >1 order ever
            $repeatCount = DB::table('orders')
                ->where('vendor_id', $vendor->id)
                ->where('status', 'paid')
                ->whereIn('patron_id', $patronIds)
                ->groupBy('patron_id')
                ->havingRaw('COUNT(*) > 1')
                ->count();

            AnalyticsSnapshot::updateOrCreate(
                ['vendor_id' => $vendor->id, 'date' => $dateStr],
                [
                    'transactions_count' => $orders->count(),
                    'revenue' => $orders->sum('total'),
                    'tokens_issued' => (clone $tokenData)->where('token_ledger.type', 'earn')->sum('token_ledger.amount'),
                    'tokens_redeemed' => (clone $tokenData)->where('token_ledger.type', 'redeem')->sum('token_ledger.amount'),
                    'active_patrons' => $patronIds->count(),
                    'new_patrons' => $patronIds->count() - $repeatCount,
                    'repeat_patrons' => $repeatCount,
                ]
            );
        }

        $this->info("Snapshots generated for {$vendors->count()} vendors on {$dateStr}.");

        return self::SUCCESS;
    }
}
