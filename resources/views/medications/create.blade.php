<x-app-layout title="Ajouter un Médicament">
    <!-- Conteneur du formulaire -->
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg -mt-6 relative z-20 ">
        <form action="{{ route('medications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de base -->
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom du médicament *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="generic_name" class="block text-sm font-medium text-gray-700 mb-1">Nom générique</label>
                        <input type="text" id="generic_name" name="generic_name" value="{{ old('generic_name') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('generic_name') border-red-500 @enderror">
                        @error('generic_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label>
                        <select id="category" name="category" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('category') border-red-500 @enderror">
                            <option value="">Sélectionner une catégorie</option>
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
                
                <!-- Détails du médicament -->
                <div class="space-y-4">
                    <div>
                        <label for="dosage_form" class="block text-sm font-medium text-gray-700 mb-1">Forme de dosage *</label>
                        <select id="dosage_form" name="dosage_form" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('dosage_form') border-red-500 @enderror">
                            <option value="">Sélectionner une forme</option>
                            <option value="Tablet" {{ old('dosage_form') == 'Tablet' ? 'selected' : '' }}>Comprimé</option>
                            <option value="Capsule" {{ old('dosage_form') == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                            <option value="Liquid" {{ old('dosage_form') == 'Liquid' ? 'selected' : '' }}>Liquide</option>
                            <option value="Injection" {{ old('dosage_form') == 'Injection' ? 'selected' : '' }}>Injection</option>
                            <option value="Cream" {{ old('dosage_form') == 'Cream' ? 'selected' : '' }}>Crème</option>
                            <option value="Other" {{ old('dosage_form') == 'Other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('dosage_form')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="strength" class="block text-sm font-medium text-gray-700 mb-1">Dosage *</label>
                        <input type="text" id="strength" name="strength" value="{{ old('strength') }}" required placeholder="ex : 500mg"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('strength') border-red-500 @enderror">
                        @error('strength')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Code-barres</label>
                        <input type="text" id="barcode" name="barcode" value="{{ old('barcode') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('barcode') border-red-500 @enderror">
                        @error('barcode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Image du médicament -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Image du médicament</h3>
                
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Photo du médicament</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-400 transition-colors @error('image') border-red-300 @enderror">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <span>Télécharger une image</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="sr-only" onchange="previewImage(this)">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG jusqu'à 2MB</p>
                        </div>
                    </div>
                    
                    <!-- Prévisualisation de l'image -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImg" src="" alt="Prévisualisation" class="max-w-xs max-h-48 rounded-lg shadow-md mx-auto">
                        <div class="text-center mt-2">
                            <button type="button" onclick="removeImage()" class="text-red-600 hover:text-red-800 text-sm">
                                Supprimer l'image
                            </button>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Affectation à la pharmacie -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Ajouter à l'inventaire de la pharmacie</h3>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantité initiale *</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" 
                                   min="0" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('quantity') border-red-500 @enderror">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prix (UM) *</label>
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
            
            <!-- Actions du formulaire -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Enregistrer le médicament
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('previewImg').src = '';
        }
    </script>
</x-app-layout>