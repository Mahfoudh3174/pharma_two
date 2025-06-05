<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicationResource;
use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Log;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all pharmacies
        $pharmacies = Pharmacy::with(['categories', 'medications.category'])->get();

        return response()->json(['pharmacies'=>PharmacyResource::collection($pharmacies)], 200);
    }
  public function show(Request $request,$id)
{
    $pharmacy = Pharmacy::findOrFail($id);
    
    $medications = $pharmacy->medications()
    ->with(['category'])
    ->where('quantity', '>', 0) // Ensure only medications with quantity > 0 are returned
    ->when($request->search, function ($query) use ($request) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('generic_name', 'like', '%' . $request->search . '%');
    })
        ->orderBy('id', 'desc')
    ->cursorPaginate(PAGINATE, ['*'], 'cursor', $request->cursor ? $request->cursor : null); 
    
    return response()->json([
        'medications' => MedicationResource::collection($medications),
        'meta' => [
            'next_cursor' => $medications->nextCursor()?->encode(),
            'per_page' => $medications->perPage(),
            'has_more' => $medications->hasMorePages()
        ]
    ]);
}
}
