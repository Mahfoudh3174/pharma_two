<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pharmacy;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Storage;

class MedicationController extends Controller
{
    public function create()
    {
        $categories = Category::active()->get();
        return view('medications.create', compact('categories'));
    }

public function store(Request $request)
{
    $pharmacy = Pharmacy::where('user_id', Auth::id())->first();
    
    if (!$pharmacy) {
        return redirect()->back()->with('error', 'You must have a pharmacy to add medications');
    }
    
    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('medications')->where(function ($query) use ($pharmacy) {
                return $query->where('pharmacy_id', $pharmacy->id);
            })
        ],
        'generic_name' => 'required|string|max:255',
        'category' => 'required|exists:categories,id',
        'dosage_form' => 'required|string|max:255',
        'strength' => 'required|string|max:50',
        'barcode' => 'nullable|string|max:255', // Changed to nullable
        'price' => 'required|numeric|min:0', 
        'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Updated to include common formats
        'quantity' => 'required|integer|min:0' 
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        try {
            // Store the image in the 'public/medications' directory
            $imagePath = $request->file('image')->store('medications', 'public');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to upload image. Please try again.');
        }
    }

    try {
        $medication = Medication::create([
            'name' => $validated['name'],
            'generic_name' => $validated['generic_name'],
            'strength' => $validated['strength'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'barcode' => $validated['barcode'],
            'dosage_form' => $validated['dosage_form'],
            'pharmacy_id' => $pharmacy->id,
            'category_id' => $validated['category'],
            'image' => $imagePath, // Add the image path to the database
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Medication added successfully!');
            
    } catch (\Exception $e) {
        // If medication creation fails and we uploaded an image, delete it
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to add medication. Please try again.');
    }
}

    public function show(Medication $medication)
    {
        
        $medication->load('pharmacy');
        return view('medications.show', compact('medication'));
    }

    public function edit(Medication $medication)
    {
        $categories = Category::active()->get();
        return view('medications.edit', compact('medication', 'categories'));
    }

    public function update(Request $request, Medication $medication)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('medications')->ignore($medication->id)->where(function ($query) use ($medication) {
                    return $query->where('pharmacy_id', $medication->pharmacy_id);
                })
            ],
            'generic_name' => 'nullable|string|max:255',
            'category' => 'required|exists:categories,id',
            'dosage_form' => 'required|string|max:255',
            'strength' => 'required|string|max:50',
            'barcode' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0'
        ]);

        $medication->update([
            'name' => $validated['name'],
            'generic_name' => $validated['generic_name'],
            'strength' => $validated['strength'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'barcode' => $validated['barcode'] ?? null,
            'dosage_form' => $validated['dosage_form'],
            'category_id' => $validated['category'],
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Medication updated successfully!');
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();
        return redirect()->route('dashboard')
            ->with('success', 'Medication deleted successfully!');
    }
}