<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Commande;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $pharmacyCount = Pharmacy::count();
        $totalSales = Commande::where('status', 'LIVRÉ')->sum('total_amount');
        $adminId = auth()->id();
        // Users with pharmacies (owners)
        $usersWithPharmacies = User::where('id', '!=', $adminId)
            ->whereHas('pharmacy')->with('pharmacy')->get();
        // Regular users (no pharmacy)
        $regularUsers = User::where('id', '!=', $adminId)
            ->whereDoesntHave('pharmacy')->get();
        $pharmacies = Pharmacy::with('user')->get();

        return view('admin.dashboard', [
            'userCount' => $userCount,
            'pharmacyCount' => $pharmacyCount,
            'totalSales' => $totalSales,
            'usersWithPharmacies' => $usersWithPharmacies,
            'regularUsers' => $regularUsers,
            'pharmacies' => $pharmacies,
        ]);
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin user.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function destroyPharmacy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        return back()->with('success', 'Pharmacy deleted successfully.');
    }

    public function pharmacyDetails(\App\Models\Pharmacy $pharmacy)
    {
        $orders = $pharmacy->commandes()->with('user')->orderByDesc('created_at')->get();
        $totalSales = $pharmacy->commandes()->where('status', 'LIVRÉ')->sum('total_amount');
        return view('admin.pharmacies.details', [
            'pharmacy' => $pharmacy,
            'orders' => $orders,
            'totalSales' => $totalSales,
        ]);
    }
} 