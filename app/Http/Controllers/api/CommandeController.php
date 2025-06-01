<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Commande;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;

class CommandeController extends Controller
{
    
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'medications' => 'required|array',
            'medications.*.id' => 'required|exists:medications,id',
            'medications.*.quantity' => 'required|integer|min:1',
            'medications.*.price' => 'required|numeric|min:1',
        ]);

        // Create a new commande
        DB::beginTransaction();
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'pharmacy_id' => $validatedData['pharmacy_id'],
        ]);

        // Attach medications to the commande
        foreach ($validatedData['medications'] as $medication) {
            $commande->medications()->attach($medication['id'], ['quantity' => $medication['quantity'],'total_price' => $medication['quantity'] * $medication['price']]);
        }
        // Commit the transaction
        DB::commit();

        return response()->json(['message' => 'Commande created successfully', 'commande' => $commande], 200);
    }
    public function index(Request $request)
    {
        //Auth::loginUsingId(12);
        
        $user= Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $commandes=$user->commandes()
            ->with(['pharmacy.categories', 'medications.commandes'])
            ->orderBy('created_at', 'desc')
            ->get();
           // dd(OrderResource::collection($commandes));

        Log::info('Commandes fetched: ' . $commandes->count());


        return response()->json(OrderResource::collection($commandes), 200);
    }
}
