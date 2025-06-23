<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Commande;
use App\Models\Medication;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([
            'order_search' => 'nullable|string',
            'order_status' => 'nullable|string',
            'order_date' => 'nullable|date',
            'order_sort' => 'nullable|string',
            'order_direction' => 'nullable|string|in:asc,desc',
            'medication_search' => 'nullable|string',
            'medication_category' => 'nullable|string',
            'medication_sort' => 'nullable|string',
            'medication_direction' => 'nullable|string|in:asc,desc',
            'medication_stock' => 'nullable|string|in:low,out',
        ]);
        $user = Auth::user();

        // Load pharmacy with counts and additional data
        $pharmacy = Pharmacy::where('user_id', $user->id)->withCount([
            'medications',
            'medications as low_stock_count' => fn($q) => $q->whereBetween('medications.quantity', [1, 9]),
            'medications as out_of_stock_count' => fn($q) => $q->where('medications.quantity', 0)
        ])->first();

        // Get all medications for quick add modal
        $allMedications = Medication::orderBy('name')->get();

        // Handle commandes with separate parameters
        $commandes = $pharmacy ? Commande::with(['user', 'medications'])->where('pharmacy_id', $pharmacy->id)
            ->when($request->filled('order_search'), function ($query) use ($request) {
                $query->where('reference', 'like', '%' . $request->order_search . '%');
            })
            ->when($request->filled('order_status'), function ($query) use ($request) {
                $query->where('status', $request->order_status);
            })
            ->when($request->filled('order_date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->order_date);
            })
            ->orderBy($request->order_sort ?? 'created_at', $request->order_direction ?? 'desc')
            ->paginate(10, ['*'], 'order_page')
            : null;

        // Get medications if pharmacy exists with separate parameters
        $medications = $pharmacy ? $pharmacy->medications()
            ->with(['category'])
            ->when($request->filled('medication_stock'), function ($query) use ($request) {
                if ($request->medication_stock === 'low') {
                    $query->whereBetween('quantity', [1, 9]);
                } elseif ($request->medication_stock === 'out') {
                    $query->where('quantity', 0);
                }
            })
            ->when($request->filled('medication_search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->medication_search . '%');
            })
            ->when($request->filled('medication_category'), function ($query) use ($request) {
                $query->where('category_id', $request->medication_category);
            })
            ->orderBy($request->medication_sort ?? 'name', $request->medication_direction ?? 'asc')
            ->paginate(10, ['*'], 'medication_page')
            : null;

        return view('dashboard', [
            'pharmacy' => $pharmacy,
            'totalValue' => $pharmacy ? $pharmacy->medications()->selectRaw('sum(price * quantity) as total_value')->first()->total_value : 0,
            'medications' => $medications,
            'allMedications' => $allMedications,
            'commandes' => $commandes,
            'categories' => Category::active()->select('id', 'name', 'svg_logo')->get(),
            'medicationSortDirection' => $request->medication_direction === 'desc' ? 'desc' : 'asc',
            'medicationCurrentSort' => $request->medication_sort,
            'orderSortDirection' => $request->order_direction === 'desc' ? 'desc' : 'asc',
            'orderCurrentSort' => $request->order_sort
        ]);
    }
}