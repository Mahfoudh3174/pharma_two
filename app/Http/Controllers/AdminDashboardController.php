<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Commande;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $userCount = User::where('status', 'active')->count();
        $pharmacyCount = Pharmacy::where('status', 'active')->count();
        $totalSales = Commande::where('status', 'LIVRÉ')->sum('total_amount');
        $adminId = auth()->id();

        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        $perPage = $request->query('per_page', 10);

        // Active users with pharmacies
        $activeUsersWithPharmaciesQuery = User::where('id', '!=', $adminId)
            ->where('status', 'active')
            ->whereHas('pharmacy')->with('pharmacy');

        if ($search) {
            $activeUsersWithPharmaciesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $activeUsersWithPharmacies = $activeUsersWithPharmaciesQuery->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'active_users_with_pharmacies_page');

        // Active regular users
        $activeRegularUsersQuery = User::where('id', '!=', $adminId)
            ->where('status', 'active')
            ->whereDoesntHave('pharmacy');
        if ($search) {
            $activeRegularUsersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $activeRegularUsers = $activeRegularUsersQuery->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'active_regular_users_page');

        // Inactive users with pharmacies
        $inactiveUsersWithPharmaciesQuery = User::where('id', '!=', $adminId)
            ->where('status', 'inactive')
            ->whereHas('pharmacy')->with('pharmacy');
        if ($search) {
            $inactiveUsersWithPharmaciesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $inactiveUsersWithPharmacies = $inactiveUsersWithPharmaciesQuery->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'inactive_users_with_pharmacies_page');

        // Inactive regular users
        $inactiveRegularUsersQuery = User::where('id', '!=', $adminId)
            ->where('status', 'inactive')
            ->whereDoesntHave('pharmacy');
        if ($search) {
            $inactiveRegularUsersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $inactiveRegularUsers = $inactiveRegularUsersQuery->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'inactive_regular_users_page');

        // Active pharmacies
        $activePharmaciesQuery = Pharmacy::with('user')->where('status', 'active');
        if ($search) {
            $activePharmaciesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('address', 'like', '%' . $search . '%');
            });
        }
        $activePharmacies = $activePharmaciesQuery->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'active_pharmacies_page');

        // Inactive pharmacies
        $inactivePharmaciesQuery = Pharmacy::with('user')->where('status', 'inactive');
        if ($search) {
            $inactivePharmaciesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('address', 'like', '%' . $search . '%');
            });
        }
        $inactivePharmacies = $inactivePharmaciesQuery->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'inactive_pharmacies_page');

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
            'search' => $search,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'perPage' => $perPage,
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

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
 
                            'phone' => ['nullable', 'string', 'max:15', \Illuminate\Validation\Rule::unique('users')->ignore($user->id), 'regex:/^[2-4][0-9]{7}$/'],

        ],[
            'phone.regex' => 'Le numéro de téléphone doit commencer par 2, 3 ou 4 et être suivi de 7 chiffres.',
            'phone.unique' => 'Le numéro de téléphone a déjà été pris.',
            'email.unique' => 'L\'email a déjà été pris.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 15 caractères.',
            'phone.regex' => 'Le numéro de téléphone doit commencer par 2, 3',
            
        ]);

        $user->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    public function pharmacyDetails(\App\Models\Pharmacy $pharmacy, Request $request)
    {
        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        $perPage = $request->query('per_page', 10);
        $filterStatus = $request->query('status');

        $ordersQuery = $pharmacy->commandes()->with('user');

        if ($search) {
            $ordersQuery->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                      ->orWhere('status', 'like', '%' . $search . '%')
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            });
        }

        if ($filterStatus) {
            $ordersQuery->where('status', $filterStatus);
        }

        $orders = $ordersQuery->orderBy($sortBy, $sortOrder)->paginate($perPage)->appends($request->query());

        $totalSales = $pharmacy->commandes()->where('status', 'LIVRÉ')->sum('total_amount');
        $totalOrdersCount = $pharmacy->commandes()->count();
        $validatedOrdersCount = $pharmacy->commandes()->where('status', 'VALIDEE')->count();
        $rejectedOrdersCount = $pharmacy->commandes()->where('status', 'REJETEE')->count();
        $deliveredOrdersCount = $pharmacy->commandes()->where('status', 'LIVRÉ')->count();
        $pendingOrdersCount = $pharmacy->commandes()->where('status', 'PENDING')->count();

        return view('admin.pharmacies.details', [
            'pharmacy' => $pharmacy,
            'orders' => $orders,
            'totalSales' => $totalSales,
            'totalOrdersCount' => $totalOrdersCount,
            'validatedOrdersCount' => $validatedOrdersCount,
            'rejectedOrdersCount' => $rejectedOrdersCount,
            'deliveredOrdersCount' => $deliveredOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'perPage' => $perPage,
            'filterStatus' => $filterStatus,
        ]);
    }

    public function editPharmacy(Pharmacy $pharmacy)
    {
        return view('admin.pharmacies.edit', compact('pharmacy'));
    }

    public function updatePharmacy(Request $request, Pharmacy $pharmacy)
    {
        $validated = $request->validate([
            "name" => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $pharmacy->update($validated);

        return redirect()->route('admin.pharmacies.details', $pharmacy)->with('success', 'Pharmacy updated successfully.');
    }
} 