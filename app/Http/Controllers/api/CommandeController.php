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
    Log::info('$request: ', $request->all());

    $validatedData = $request->validate([
        'totalPrice' => 'required|numeric|min:1',
        'pharmacy_id' => 'required|exists:pharmacies,id',
        'cardItems' => 'required|array',
        'longitude' => 'nullable|numeric',
        'latitude' => 'nullable|numeric',
        'cardItems.*.medication.id' => 'required|exists:medications,id',
        'cardItems.*.quantity' => 'required|integer|min:1',
        'cardItems.*.medication.price' => 'required|numeric|min:1',
        "deliveryType"=>"required|in:SURE PLACE,LIVRAISON"
    ]);

    DB::beginTransaction();

    try {
        // Create commande
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'longitude' => $validatedData['longitude'] ?? null,
            'latitude' => $validatedData['latitude'] ?? null,
            'pharmacy_id' => $validatedData['pharmacy_id'],
            'total_amount' => $validatedData['totalPrice'],
        ]);

        foreach ($validatedData['cardItems'] as $item) {
            $medicationId = $item['medication']['id'];
            $quantity = $item['quantity'];
            $price = $item['medication']['price'];

            $commande->medications()->attach($medicationId, [
                'quantity' => $quantity,
                'total_price' => $quantity * $price,
            ]);

            // Decrement from pharmacy stock
            $medicationModel = $commande->pharmacy->medications()->find($medicationId);
            if ($medicationModel && $medicationModel->quantity >= $quantity) {
                $medicationModel->decrement('quantity', $quantity);
                Log::info("Medication decremented: {$medicationModel->name} - Quantity: {$quantity}, Left: {$medicationModel->quantity}");
            } else {
                DB::rollBack();
                return response()->json(['message' => "{$medicationModel->name} is out of stock"], 404);
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
        Log::error('Commande creation failed: ' . $e->getMessage());
        return response()->json(['message' => 'An error occurred while processing the commande'], 500);
    }
}

    public function index(Request $request)
    {

  Log::info('$request: ', $request->all());
        $user= Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $commandes=$user->commandes()
            ->with(['pharmacy.categories', 'medications'])
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();
           // dd(OrderResource::collection($commandes));

        Log::info('Commandes fetched: ' . $commandes->count());


        return response()->json(['orders' => OrderResource::collection($commandes)], 200);
    }
}
