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
        $user = Auth::user();

        // Load pharmacy with counts and additional data
        $pharmacy =Pharmacy::where('user_id', $user->id)->withCount([
            'medications',
            'medications as low_stock_count' => fn($q) => $q->whereBetween('medications.quantity', [1, 9]),
            'medications as out_of_stock_count' => fn($q) => $q->where('medications.quantity', 0)
        ])->first();
       

        // Get all medications for quick add modal
        $allMedications = Medication::orderBy('name')->get();

        $commandes =$pharmacy ? Commande::with(['user','medications'])->where('pharmacy_id', $pharmacy->id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('reference', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')
            ->paginate(10)
            : null
            ;
    
        // Get medications if pharmacy exists with enhanced filtering
        $medications = $pharmacy ? $pharmacy->medications()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->orderBy($request->sort ?? 'name', $request->direction ?? 'asc')
            ->paginate(10)
            : null;
       

        //   $total=$pharmcy->medications()->sum('price * quantity');
        return view('dashboard', [
            'pharmacy' => $pharmacy,
            'totalValue'=>$pharmacy ? $pharmacy->medications()->selectRaw('sum(price * quantity) as total_value')->first()->total_value : 0,
            'medications' => $medications,
            'allMedications' => $allMedications,
            'commandes' => $commandes,
            'categories' => Category::select('id', 'name')->get(),
            'sortDirection' => $request->direction === 'desc' ? 'desc' : 'asc',
            'currentSort' => $request->sort
        ]);
    }
}