<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeDetails;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function details(Commande $commande)
    {
        $details = CommandeDetails::where("commande_id",$commande->id)->get();
   
        return view("commandes.details",compact("details","commande"));
    }
    
    public function validate(Commande $commande)
    {
        $commande->update(["status" => "validated"]);

        return back()->with("success","commande validated.");
    }

    public function reject(Request $request)
    {
        $commande = Commande::findOrFail($request->order_id);


        $commande->update(["status" => "rejected", "reject_reason" => $request->reject_reason]);

        return back()->with("success","commande rejected.");
    }
}
