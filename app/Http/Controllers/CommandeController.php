<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeDetails;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function details($id)
    {
        $commande = Commande::with(["medications","user","pharmacy"])
            ->where("id", $id)

            ->first();
   
        return view("facture.index",compact("commande"));
    }
    
    public function validate( Commande $commande)
    {
        $commande->update(["status" => "VALIDÉE", "ar_status" => "تم قبوله"]);

        return back()->with("success","commande validated.");
    }
    public function show(Commande $commande)
    {
        $commade= Commande::with(["medications","user","pharmacy"])
            ->where("id", $commande->id)
            ->first();
        return view("order.show",compact("commande"));
    }

    public function reject(Request $request)
    {
        $commande = Commande::findOrFail($request->order_id);


        $commande->update(["status" => "REJETEE","ar_status"=>"تم الرفض", "reject_reason" => $request->reject_reason]);

        return back()->with("success","commande rejected.");
    }
    public function delivered(Commande $commande)
    {
        $commande->update(["status" => "LIVRÉ", "ar_status" => "تم التسليم"]);

        return back()->with("success","commande delivered.");
    }
}
