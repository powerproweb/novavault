<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorApproved
{
    /**
     * Ensure the authenticated vendor has been approved by an admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isVendor()) {
            abort(403);
        }

        $vendor = $user->vendor;

        if (! $vendor || $vendor->status !== 'approved') {
            return redirect()->route('vendor.pending');
        }

        return $next($request);
    }
}
