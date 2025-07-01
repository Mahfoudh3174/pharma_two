<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
 public function generatePdf($id)
    {
                $commande = Commande::with(["medications","user","pharmacy"])
            ->where("id", $id)
            ->first();
        
        $pdf = Pdf::loadView('facture.pdf', compact('commande'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);
        return $pdf->download('invoice-' . $commande->reference . '.pdf');
    }
}
