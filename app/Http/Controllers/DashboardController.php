<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Load pharmacy with counts and additional data
        $pharmacy = $user->pharmacy()->withCount([
            'medications',
            'medications as low_stock_count' => fn($q) => $q->whereBetween('medication_pharmacy.stock', [1, 9]),
            'medications as out_of_stock_count' => fn($q) => $q->where('medication_pharmacy.stock', 0)
        ])->first();

        // Get all medications for quick add modal
        $allMedications = Medication::orderBy('name')->get();
    
        // Get medications if pharmacy exists with enhanced filtering
        $medications = $pharmacy 
            ? $pharmacy->medications()
                ->withPivot('stock', 'price')
                ->when($request->search, function($q, $search) {
                    $q->where(function($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('generic_name', 'like', "%{$search}%");
                    });
                })
                ->when($request->category, fn($q, $cat) => $q->where('category', $cat))
                ->when($request->stock_status, function($q, $status) {
                    if ($status === 'low') {
                        $q->whereBetween('medication_pharmacy.stock', [1, 9]);
                    } elseif ($status === 'out') {
                        $q->where('medication_pharmacy.stock', 0);
                    } elseif ($status === 'normal') {
                        $q->where('medication_pharmacy.stock', '>=', 10);
                    }
                })
                ->when($request->sort, function($q, $sort) use ($request) {
                    $direction = $request->direction ?? 'asc';
                    if ($sort === 'stock' || $sort === 'price') {
                        $q->orderBy("medication_pharmacy.{$sort}", $direction);
                    } else {
                        $q->orderBy($sort, $direction);
                    }
                }, fn($q) => $q->orderBy('name'))
                ->paginate(15)
                ->withQueryString()
            : collect();
    
        return view('dashboard', [
            'pharmacy' => $pharmacy,
            'medications' => $medications,
            'allMedications' => $allMedications,
            'categories' => Medication::distinct()->pluck('category'),
            'sortDirection' => $request->direction === 'desc' ? 'desc' : 'asc',
            'currentSort' => $request->sort
        ]);
    }
}