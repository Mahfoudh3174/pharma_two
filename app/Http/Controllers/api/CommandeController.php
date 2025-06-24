<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Card;
use App\Models\Commande;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;

class CommandeController extends Controller
{

public function store(Request $request)
{
    Log::info($request->all());

    $validatedData = $request->validate([
        'totalPrice' => 'required|numeric|min:1',
        'pharmacy_id' => 'required|exists:pharmacies,id',
        'cardItems' => 'required|array',
        'longitude' => 'nullable|numeric',
        'latitude' => 'nullable|numeric',
        'cardItems.*.medication.id' => 'required|exists:medications,id',
        'cardItems.*.quantity' => 'required|integer|min:1',
        'cardItems.*.medication.price' => 'required|numeric|min:1',
        "deliveryType"=>"required|in:SURE PLACE,LIVRAISON",
        'shipping_price' => 'required|numeric|min:1',
    ]);

    DB::beginTransaction();

    try {
        if($validatedData['deliveryType']=="SURE PLACE"){
            $validatedData['shipping_price']=0;
        }
        $reference = Commande::generateReference();
        // Create commande
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'reference' => $reference,
            'longitude' => $validatedData['longitude'] ?? null,
            'latitude' => $validatedData['latitude'] ?? null,
            'pharmacy_id' => $validatedData['pharmacy_id'],
            'total_amount' => $validatedData['totalPrice'],
            'delivery_type' => $validatedData['deliveryType'],
            'shipping_price' => $validatedData['shipping_price']
        ]);

        foreach ($validatedData['cardItems'] as $item) {
    $medicationId = $item['medication']['id'];
    $quantity = (int) $item['quantity'];
    $unitPrice = (int) $item['medication']['price'];

    

    $totalPrice = $quantity * $unitPrice ; 

    // Attach to pivot table
    $commande->medications()->attach($medicationId, [
        'quantity' => $quantity,
        'total_price' => $totalPrice,
    ]);

    // Decrement pharmacy stock
    $medicationModel = $commande->pharmacy->medications()->find($medicationId);
    if ($medicationModel && $medicationModel->quantity >= $quantity) {
        $medicationModel->decrement('quantity', $quantity);
    } else {
        DB::rollBack();
        return response()->json(['error' => $medicationModel->name]);
    }
}


        // Delete from cards table for this user and pharmacy
        Card::where('user_id', auth()->id())
            ->where('pharmacy_id', $validatedData['pharmacy_id'])
            ->delete();

        DB::commit();
        return response()->json([
            'message' => 'Commande created successfully',
            'commande' => $commande
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'An error occurred while processing the commande'], 500);
    }
}

    public function index(Request $request)
    {

        $user= Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $commandes=$user->commandes()
            ->with(['pharmacy', 'medications'])
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(3)->withQueryString();
           // dd(OrderResource::collection($commandes));



        return response()->json([
            'orders' => OrderResource::collection($commandes),
            'meta' => [
                'current_page' => $commandes->currentPage(),
                'last_page' => $commandes->lastPage(),
            ]
        ], 200);
    }

    public function delete($id)
    {
        $commande = Commande::find($id);
        if (!$commande) {
            return response()->json(['message' => 'Commande not found'], 404);
        }
        $commande->delete();
        return response()->json(['message' => 'Commande deleted successfully'], 200);
    }
}
