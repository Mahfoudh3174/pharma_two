<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicationResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;
use App\Models\Category;
use Illuminate\Http\Request;
use Log;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all pharmacies
        $pharmacies = Pharmacy::with(['medications.category'])
        ->where('status', 'active') 
        ->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })->

        get();

        return response()->json([
            'pharmacies'=>PharmacyResource::collection($pharmacies),
            "categories"=>CategoryResource::collection(Category::get())
        ], 200);
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
    ->when($request->category_id, function ($query) use ($request) {
        $query->whereHas('category', function ($categoryQuery) use ($request) {
            $categoryQuery->where('id', $request->category_id);
        });
    })
        ->orderBy('id', 'desc')
         ->paginate(9);
            // ->cursorPaginate(PAGINATE, ['*'], 'cursor', $request->cursor ? $request->cursor : null);

    return response()->json([
        'medications' => MedicationResource::collection($medications),
        'meta' => [
            'current_page' => $medications->currentPage(),
            'last_page' => $medications->lastPage(),
        ]
    ]);
}
}
