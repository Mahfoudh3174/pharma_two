<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class CardController extends Controller
{

    public function index(){

        $cartItems=auth()->user()->carts()->with(['medications.pharmacy'])->get();
        return response()->json([
            'cartItems'=>$cartItems
        ]);
    }


    public function store(Request $request)
    {

        Log::info('$request: ', $request->all());


    }


}
