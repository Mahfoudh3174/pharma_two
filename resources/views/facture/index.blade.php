@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Invoice Header -->
        <div class="bg-blue-600 text-white px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Pharmacy Invoice</h1>
                    <p class="text-blue-100">Order #{{ $commande->id }}</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-100">Date: {{ $commande->created_at->format('d/m/Y') }}</p>
                    <p class="text-blue-100">Status: 
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            @if($commande->status == 'validee') bg-green-100 text-green-800
                            @elseif($commande->status == 'rejetee') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($commande->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Pharmacy and Customer Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 border-b">
            <div>
                <h2 class="text-lg font-semibold mb-2">Pharmacy Information</h2>
                <p class="text-gray-700">{{ $commande->pharmacy->name }}</p>
                <p class="text-gray-700">{{ $commande->pharmacy->address }}</p>
                <p class="text-gray-700">{{ $commande->pharmacy->phone }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Customer Information</h2>
                <p class="text-gray-700">{{ $commande->user->name }}</p>
                <p class="text-gray-700">{{ $commande->user->email }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Order Details</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($commande->medications as $medication)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $medication->name }}</div>
                                <div class="text-sm text-gray-500">{{ $medication->generic_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $medication->strength }} {{ $medication->dosage_form }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $medication->pivot->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($medication->price, 2) }} MRU
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($medication->pivot->total_price, 2) }} MRU
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="p-6 bg-gray-50 border-t">
            <div class="flex justify-end">
                <div class="w-full md:w-1/3">


                    <div class="flex justify-between py-2 border-t border-gray-200">
                        <span class="font-semibold">Total:</span>
                        <span class="font-bold">{{ number_format($commande->medications->sum('pivot.total_price') , 2) }} MRU</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejection Reason (if applicable) -->
        @if($commande->status == 'rejetee' && $commande->reject_reason)
        <div class="p-6 bg-red-50 border-t">
            <h2 class="text-lg font-semibold mb-2 text-red-800">Rejection Reason</h2>
            <p class="text-red-700">{{ $commande->reject_reason }}</p>
        </div>
        @endif

        <!-- Invoice Footer -->
        <div class="bg-gray-100 px-6 py-4 text-center text-sm text-gray-600">
            <p>Thank you for your order! For any questions, please contact our pharmacy.</p>
            <p class="mt-1">© {{ date('Y') }} {{ $commande->pharmacy->name }}. All rights reserved.</p>
        </div>
    </div>
</div>
@endsection