<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pharmacy;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MedicationController extends Controller
{
    public function create()
    {
        
        
        $categories = Category::all(); 

        return view('medications.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->pharmacy) {
            return redirect()->back()->with('error', 'You must have a pharmacy to add medications');
        }
    
        $validated = $request->validate([
             'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('medications')->where(function ($query) use ($user) {
                    return $query->where('pharmacy_id', $user->pharmacy->id);
                })
            ],
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'dosage_form' => 'required|string|max:255',
            'strength' => 'required|string|max:50',
            'price' => 'required|numeric|min:0', 
            'stock' => 'required|integer|min:0' 
        ]);
    
        // Create or find the medication
        $medication = Medication::firstOrCreate([
            'name' => $validated['name'],
            'generic_name' => $validated['generic_name'],
            'strength' => $validated['strength']
        ], $validated);
    
        // Attach to current pharmacy with pivot data
        $user->pharmacy->medications()->syncWithoutDetaching([
            $medication->id => [
                'price' => $validated['price'],
                'stock' => $validated['stock']
            ]
        ]);
    
        return redirect()->route('dashboard')
            ->with('success', 'Medication added successfully!');
    }

    public function show(Medication $medication)
    {
        $medication->load('pharmacies'); // Load pharmacy relationships
        return view('medications.show', compact('medication'));
    }

    public function edit(Medication $medication)
    {
       
        
        $pharmacies = Pharmacy::all();
        $medication->load('pharmacies');

        return view('medications.edit', compact('medication', 'categories', 'pharmacies'));
    }

    public function update(Request $request, Medication $medication)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'dosage_form' => 'required|string|max:255',
            'strength' => 'required|string|max:50',
            'pharmacies' => 'sometimes|array',
            'pharmacies.*.price' => 'required_with:pharmacies|numeric|min:0',
            'pharmacies.*.stock' => 'required_with:pharmacies|integer|min:0'
        ]);

        $medication->update($validated);

        if ($request->has('pharmacies')) {
            $syncData = [];
            foreach ($request->pharmacies as $pharmacyId => $data) {
                $syncData[$pharmacyId] = [
                    'price' => $data['price'],
                    'stock' => $data['stock']
                ];
            }
            $medication->pharmacies()->sync($syncData);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Medication updated successfully!');
    }

    public function destroy(Medication $medication)
    {
        $medication->pharmacies()->detach();
        $medication->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Medication deleted successfully!');
    }
}