<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Models\Medication;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;

class CardController extends Controller
{

    public function index(){
        Auth::loginUsingId(12);
          $userId = Auth::id();


    $cartItems = Card::select('product_id', DB::raw('count(*) as quantity'))
        ->with(['medication.pharmacy','medication.category'])
        ->where('user_id', $userId)
        ->groupBy('product_id')
        ->get();
        dd($cartItems);
        dd( CardResource::collection($cartItems));
        // Log::info('User card', ['user_items' =>]);

    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'medication_id' => 'required|exists:medications,id',
        ]);
        $user=Auth::user();
        $card=Card::create([
            'user_id'=>$user->id,
            'medication_id'=>$validatedData['medication_id'],

        ]);

        return response()->json([
            'message'=>'success',
            "count"=>$user->cards()->where('medication_id', $validatedData['medication_id'])->count()
        ]);


    }

    public function show($id){
        $count=Auth::user()->cards()->where('medication_id', $id)->count();
        Log::info('User created', ['user_items_count' => $count]);
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
