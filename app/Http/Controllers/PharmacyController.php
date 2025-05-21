<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pharmacy\PharmacyRequest;
use App\Models\Pharmacy;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PharmacyController extends Controller
{
    /**
     * Show the form for creating a new pharmacy.
     */
    public function create()
    {
        // Prevent creating multiple pharmacies
        if (Auth::user()->pharmacy) {
            return redirect()->route('pharmacist.dashboard')
                ->with('error', 'You already have a pharmacy');
        }

        return view('pharmacy.create');
    }

    /**
     * Store a newly created pharmacy.
     */
    public function store(PharmacyRequest $request)
    {
        
        // Validate pharmacist doesn't already have a pharmacy
        if (Auth::user()->pharmacy) {
            abort(403, 'You already have a pharmacy');
        }
        

         
        $pharmacy = DB::transaction(function () use ($request) {
            $pharmacy =Pharmacy::create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'user_id' => Auth::id(),
        ]);
        return $pharmacy;


    });
        return to_route('dashboard')
            ->with('success', 'Pharmacy created successfully!');
    }

    /**
     * Show the form for editing the pharmacy.
     */
    public function edit(Pharmacy $pharmacy)
    {
        return view('pharmacy.edit', compact('pharmacy'));
    }

    /**
     * Update the specified pharmacy.
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 
                      Rule::unique('pharmacies')->ignore($pharmacy->id)],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $pharmacy->update($validated);

        return redirect()->route('pharmacist.dashboard')
            ->with('success', 'Pharmacy updated successfully!');
    }

    /**
     * Manage pharmacy medications.
     */
    public function medications(Pharmacy $pharmacy)
    {
        $medications = $pharmacy->medications()
            ->withPivot('stock', 'price')
            ->when(request('search'), function($query) {
                $query->where('name', 'like', '%'.request('search').'%');
            })
            ->when(request('category'), function($query) {
                $query->where('category', request('category'));
            })
            ->paginate(15);

        return view('pharmacy.medications', [
            'pharmacy' => $pharmacy,
            'medications' => $medications
        ]);
    }

    /**
     * Show form to edit medication stock/price.
     */
    public function editMedication(Pharmacy $pharmacy, Medication $medication)
    {
        if (!$pharmacy->medications->contains($medication->id)) {
            abort(404, 'Medication not found in your pharmacy');
        }

        return view('pharmacy.medication-edit', compact('pharmacy', 'medication'));
    }

    /**
     * Update medication stock/price.
     */
    public function updateMedication(Request $request, Pharmacy $pharmacy, Medication $medication)
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $pharmacy->medications()->updateExistingPivot($medication->id, $validated);

        return redirect()->route('pharmacy.medications', $pharmacy)
            ->with('success', 'Medication updated successfully!');
    }

    /**
     * Remove medication from pharmacy.
     */
    public function removeMedication(Pharmacy $pharmacy, Medication $medication)
    {
        dd("here");
        $pharmacy->medications()->detach($medication->id);

        return back()->with('success', 'Medication removed from your pharmacy');
    }
}
