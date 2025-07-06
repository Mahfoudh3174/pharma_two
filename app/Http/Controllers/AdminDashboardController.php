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
        $userCount = User::where('status', 'active')->count();
        $pharmacyCount = Pharmacy::where('status', 'active')->count();
        $totalSales = Commande::where('status', 'LIVRÉ')->sum('total_amount');
        $adminId = auth()->id();

        // Active users
        $activeUsersWithPharmacies = User::where('id', '!=', $adminId)
            ->where('status', 'active')
            ->whereHas('pharmacy')->with('pharmacy')->get();
        $activeRegularUsers = User::where('id', '!=', $adminId)
            ->where('status', 'active')
            ->whereDoesntHave('pharmacy')->get();

        // Inactive users
        $inactiveUsersWithPharmacies = User::where('id', '!=', $adminId)
            ->where('status', 'inactive')
            ->whereHas('pharmacy')->with('pharmacy')->get();
        $inactiveRegularUsers = User::where('id', '!=', $adminId)
            ->where('status', 'inactive')
            ->whereDoesntHave('pharmacy')->get();

        // Active and inactive pharmacies
        $activePharmacies = Pharmacy::with('user')->where('status', 'active')->get();
        $inactivePharmacies = Pharmacy::with('user')->where('status', 'inactive')->get();

        return view('admin.dashboard', [
            'userCount' => $userCount,
            'pharmacyCount' => $pharmacyCount,
            'totalSales' => $totalSales,
            'activeUsersWithPharmacies' => $activeUsersWithPharmacies,
            'activeRegularUsers' => $activeRegularUsers,
            'inactiveUsersWithPharmacies' => $inactiveUsersWithPharmacies,
            'inactiveRegularUsers' => $inactiveRegularUsers,
            'activePharmacies' => $activePharmacies,
            'inactivePharmacies' => $inactivePharmacies,
        ]);
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot change status of admin user.');
        }
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        return back()->with('success', 'User status updated successfully.');
    }

    public function togglePharmacyStatus(Pharmacy $pharmacy)
    {
        $pharmacy->status = $pharmacy->status === 'active' ? 'inactive' : 'active';
        $pharmacy->save();
        return back()->with('success', 'Pharmacy status updated successfully.');
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

    public function editPharmacy(Pharmacy $pharmacy)
    {
        return view('admin.pharmacies.edit', compact('pharmacy'));
    }

    public function updatePharmacy(Request $request, Pharmacy $pharmacy)
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $pharmacy->update($validated);

        return redirect()->route('admin.pharmacies.details', $pharmacy)->with('success', 'Pharmacy updated successfully.');
    }
} 