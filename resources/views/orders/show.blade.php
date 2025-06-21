<x-app-layout>
<div class="py-6 px-4 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Détails de la Commande #{{ $commande->reference }}</h1>
        <span class="px-3 py-1 rounded-full text-sm font-medium 
            @if($commande->status == 'VALIDEE') bg-green-100 text-green-800
            @elseif($commande->status == 'rejetee') bg-red-100 text-red-800
            @else bg-yellow-100 text-yellow-800 @endif">
            {{ $commande->status }}
        </span>
    </div>

    @if($commande->reject_reason)
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-semibold">Raison du rejet</p>
                <p class="text-sm text-red-600 mt-1">{{ $commande->reject_reason }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-900">Informations de la commande</h2>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-500">Date de la commande</p>
                    <p class="text-sm font-medium text-gray-900">{{ $commande->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pharmacie</p>
                    <p class="text-sm font-medium text-gray-900">{{ $commande->pharmacy->name ?? 'Non spécifiée' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Client</p>
                    <p class="text-sm font-medium text-gray-900">{{ $commande->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Type de livraison</p>
                    <p class="text-sm font-medium text-gray-900">{{ $commande->type ?? 'Non spécifié' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-900">Articles commandés</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médicament</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($commande->medications as $medication)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $medication->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $medication->pivot->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($medication->price, 2, ',', ' ') }} UM
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($medication->pivot->total_price, 2, ',', ' ') }} UM
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-900">Récapitulatif</h2>
        </div>
        <div class="px-6 py-4">
            <div class="flex justify-between py-2">
                <span class="text-sm text-gray-600">Sous-total</span>
                <span class="text-sm font-medium text-gray-900">{{ number_format($commande->medications->sum('pivot.total_price'), 2, ',', ' ') }} UM</span>
            </div>
            <div class="flex justify-between py-2">
                <span class="text-sm text-gray-600">Frais de livraison</span>
                <span class="text-sm font-medium text-gray-900">{{ number_format($commande->shipping_price, 2, ',', ' ') }} UM</span>
            </div>
            <div class="flex justify-between py-2 border-t border-gray-200 mt-2 pt-2">
                <span class="text-base font-medium text-gray-900">Total</span>
                <span class="text-base font-bold text-gray-900">{{ number_format($commande->medications->sum('pivot.total_price') + $commande->shipping_price, 2, ',', ' ') }} UM</span>
            </div>
        </div>
    </div>

    @if($commande->status != 'VALIDEE' && $commande->status != 'rejetee')
    <div class="mt-6 flex justify-end space-x-3">
        <form action="{{ route('commandes.validate', $commande->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Valider la commande
            </button>
        </form>
        <button onclick="showRejectModal({{ $commande->id }})" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
            Rejeter la commande
        </button>
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Rejeter la commande</h3>
                <div class="mt-2">
                    <form id="rejectForm" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reject_reason" class="block text-sm font-medium text-gray-700">Raison du rejet</label>
                            <textarea id="reject_reason" name="reject_reason" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                    Annuler
                </button>
                <button type="button" onclick="submitRejectForm()" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Confirmer le rejet
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showRejectModal(orderId) {
        const form = document.getElementById('rejectForm');
        form.action = `/commandes/${orderId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function submitRejectForm() {
        document.getElementById('rejectForm').submit();
    }
</script>
</x-app-layout>