<x-layouts.app title="Edit Medication">
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 rounded-full bg-green-100 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Medication: {{ $medication->name }}</h1>
        </div>
        
        <form action="{{ route('medications.update', $medication->id) }}" method="POST" class="space-y-4 z-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Medication Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $medication->name) }}" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
         
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select id="category" name="category" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('category') border-red-500 @enderror">
                            @foreach(['Antibiotics', 'Analgesics', 'Antidepressants', 'Antihistamines', 'Antacids', 'Other'] as $category)
                                <option value="{{ $category }}" {{ old('category', $medication->category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Medication Details -->
                <div class="space-y-4">
                    <div>
                        <label for="dosage_form" class="block text-sm font-medium text-gray-700 mb-1">Dosage Form *</label>
                        <select id="dosage_form" name="dosage_form" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('dosage_form') border-red-500 @enderror">
                            @foreach(['Tablet', 'Capsule', 'Liquid', 'Injection', 'Cream', 'Other'] as $form)
                                <option value="{{ $form }}" {{ old('dosage_form', $medication->dosage_form) == $form ? 'selected' : '' }}>
                                    {{ $form }}
                                </option>
                            @endforeach
                        </select>
                        @error('dosage_form')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="strength" class="block text-sm font-medium text-gray-700 mb-1">Strength *</label>
                        <input type="text" id="strength" name="strength" value="{{ old('strength', $medication->strength) }}" required placeholder="e.g., 500mg"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('strength') border-red-500 @enderror">
                        @error('strength')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                
                </div>
            </div>
            
            <!-- Pharmacy Assignment -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Pharmacy Inventory</h3>
                
                <div class="space-y-4">
                    @foreach($pharmacies as $pharmacy)
                        @php
                            $pivotData = $medication->pharmacies->find($pharmacy->id)->pivot ?? null;
                        @endphp
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-800 mb-2">{{ $pharmacy->name }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="pharmacies[{{ $pharmacy->id }}][stock]" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                    <input type="number" 
                                           name="pharmacies[{{ $pharmacy->id }}][stock]" 
                                           id="pharmacy_{{ $pharmacy->id }}_stock"
                                           value="{{ old("pharmacies.$pharmacy->id.stock", $pivotData->stock ?? 0) }}" 
                                           min="0"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                                
                                <div>
                                    <label for="pharmacies[{{ $pharmacy->id }}][price]" class="block text-sm font-medium text-gray-700 mb-1">Price (UM)</label>
                                    <input type="number" step="0.01"
                                           name="pharmacies[{{ $pharmacy->id }}][price]" 
                                           id="pharmacy_{{ $pharmacy->id }}_price"
                                           value="{{ old("pharmacies.$pharmacy->id.price", $pivotData->price ?? 0) }}" 
                                           min="0"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Update Medication
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>