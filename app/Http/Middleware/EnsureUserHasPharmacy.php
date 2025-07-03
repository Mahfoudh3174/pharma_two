<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasPharmacy
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && !$user->isAdmin() && !$user->isPharmacy() && !$user->pharmacy) {
            // Allow access to pharmacy creation routes
            if (!($request->routeIs('pharmacy.create') || $request->routeIs('pharmacy.store'))) {
                return redirect()->route('pharmacy.create');
            }
        }
        return $next($request);
    }
} 