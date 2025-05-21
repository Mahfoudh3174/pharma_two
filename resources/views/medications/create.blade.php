<x-app-layout title="Add Medication">
    <!-- Form Container -->
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg -mt-6 relative z-20 ">
        <form action="{{ route('medications.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Medication Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="generic_name" class="block text-sm font-medium text-gray-700 mb-1">Generic Name</label>
                        <input type="text" id="generic_name" name="generic_name" value="{{ old('generic_name') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('generic_name') border-red-500 @enderror">
                        @error('generic_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select id="category" name="category" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('category') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
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
                            <option value="">Select Form</option>
                            <option value="Tablet" {{ old('dosage_form') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Capsule" {{ old('dosage_form') == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                            <option value="Liquid" {{ old('dosage_form') == 'Liquid' ? 'selected' : '' }}>Liquid</option>
                            <option value="Injection" {{ old('dosage_form') == 'Injection' ? 'selected' : '' }}>Injection</option>
                            <option value="Cream" {{ old('dosage_form') == 'Cream' ? 'selected' : '' }}>Cream</option>
                            <option value="Other" {{ old('dosage_form') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('dosage_form')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="strength" class="block text-sm font-medium text-gray-700 mb-1">Strength *</label>
                        <input type="text" id="strength" name="strength" value="{{ old('strength') }}" required placeholder="e.g., 500mg"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('strength') border-red-500 @enderror">
                        @error('strength')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Barcode</label>
                        <input type="text" id="barcode" name="barcode" value="{{ old('barcode') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('barcode') border-red-500 @enderror">
                        @error('barcode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Pharmacy Assignment -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Add to Pharmacy Inventory</h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Initial quantity *</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" 
                                   min="0" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('quantity') border-red-500 @enderror">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (UM) *</label>
                            <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" 
                                   min="0" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
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
                    Save Medication
                </button>
            </div>
        </form>
    </div>
</x-app-layout>