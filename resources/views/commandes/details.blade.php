<x-app-layout title="Détails de la Commande">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header with back button -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">{{$commande->uuid}}</h1>
                <p class="text-gray-600 mt-1">
                    Client: <span class="font-medium">{{$commande->user->name}}</span>
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                ← Retour
            </a>
        </div>

        <!-- Ordered items -->
        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden mb-6">
            <div class="divide-y divide-gray-200">
                @php
                    $total = 0
                @endphp
                @foreach ($details as $detail)
                @php
                    $total += $detail->price * $detail->quantity
                @endphp
                <div class="p-4">
                    <div class="flex justify-between">
                        <div>
                            <p class="font-medium">{{$detail->name}}</p>
                            <p class="text-sm text-gray-600">{{$detail->price}} x {{$detail->quantity}}</p>
                        </div>
                        <p class="font-medium">{{$detail->price * $detail->quantity}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order total -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
            <div class="flex justify-between font-medium text-lg">
                <span>Total</span>
                <span>{{$total}} UM</span>
            </div>
        </div>

        <!-- Reject Order Modal -->
        <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Rejeter la Commande</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 mb-4">Raison du rejet :</p>
                        <textarea id="rejectReason" rows="3" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" placeholder="Saisissez la raison..."></textarea>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="confirmReject" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700">
                            Confirmer
                        </button>
                        <button onclick="document.getElementById('rejectModal').classList.add('hidden')" class="ml-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function validateOrder(orderId) {
                if (confirm("Valider cette commande ?")) {
                    // AJAX call to validate order
                    console.log(`Commande ${orderId} validée`);
                    alert(`Commande ${orderId} validée`);
                    // Optionally redirect or refresh
                }
            }
            
            function showRejectModal(orderId) {
                document.getElementById('rejectModal').classList.remove('hidden');
            }
            
            document.getElementById('confirmReject').addEventListener('click', function() {
                const reason = document.getElementById('rejectReason').value.trim();
                if (reason === "") {
                    alert("Veuillez saisir une raison");
                    return;
                }
                
                // AJAX call to reject order
                console.log(`Commande rejetée. Raison: ${reason}`);
                alert("Commande rejetée");
                document.getElementById('rejectModal').classList.add('hidden');
            });
        </script>
    </div>
</x-app-layout>