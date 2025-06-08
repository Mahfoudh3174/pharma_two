<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Http\Resources\MedicationResource;
use App\Models\Card;
use App\Models\Medication;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;

class CardController extends Controller
{


public function index(Request $request) {
    $userId = Auth::id();
    $pharmacyId = $request->pharmacy_id;


    // اجلب كل الكروت للمستخدم (مع الأدوية المرتبطة والفئات والصيدليات)
    $cards = Card::with(['medication.pharmacy', 'medication.category'])
        ->where('user_id', $userId)
        ->when($pharmacyId, function ($query) use ($pharmacyId) {
            $query->whereHas('medication', function ($q) use ($pharmacyId) {
                $q->where('pharmacy_id', $pharmacyId);
            });
        })
        ->get();


    $grouped = $cards->groupBy('medication_id')->map(function ($items) {
        $medication = $items->first()->medication;
        $quantity = $items->count();
        $totalPrice = $medication->price * $quantity;

        return [
            'id' => $items->first()->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'medication' => new MedicationResource($medication),
        ];
    })->values();


    $totalPrice = $grouped->sum('total_price');
    $totalItems = $grouped->count();

    return response()->json([
        'cartItems' => $grouped,
        'totalCard' => $totalPrice,
        'totalItems' => $totalItems,
        'pharmacy_id' => $pharmacyId
    ]);
}


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'medication_id' => 'required|exists:medications,id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
        ]);
        $user=Auth::user();
        $card=Card::create([
            'user_id'=>$user->id,
            'medication_id'=>$validatedData['medication_id'],
            'pharmacy_id'=>$validatedData['pharmacy_id']
        ]);

        return response()->json([
            'message'=>'success',
            // "count"=>$user->cards()->where('medication_id', $validatedData['medication_id'])->count()
        ]);


    }

    public function show($id){
        $count=Auth::user()->cards()->where('medication_id', $id)->count();
        return response()->json([
            'count'=>$count
        ]);
    }

    public function delete($id){
        $user=Auth::user();
        $card=$user->cards()->where('medication_id', $id)->first();
        if(!$card){
            return response()->json([
                'message'=>'error',
                "count"=>$user->cards()->where('medication_id', $id)->count()
            ]);
        }
        $card->delete();
        Log::info('User created', ['user_id' => $user->cards()->where('medication_id', $id)->count()]);
        return response()->json([
            'message'=>'success',
            "count"=>$user->cards()->where('medication_id', $id)->count()
        ]);

    }
}
