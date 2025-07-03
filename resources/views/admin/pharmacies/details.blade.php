@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Pharmacy: {{ $pharmacy->name }}</h1>
        <div class="text-gray-600 mb-2">Owner: <span class="font-semibold">{{ $pharmacy->user->name ?? '-' }}</span></div>
        <div class="text-gray-600 mb-2">Address: <span class="font-semibold">{{ $pharmacy->address }}</span></div>
        <div class="text-gray-600 mb-2">Location: <span class="font-semibold">Lat: {{ $pharmacy->latitude }}, Lng: {{ $pharmacy->longitude }}</span></div>
        <div class="text-gray-600 mb-2">City: <span class="font-semibold">{{ $pharmacy->city }}</span> | State: <span class="font-semibold">{{ $pharmacy->state }}</span></div>
        <div class="mt-4 bg-green-100 text-green-800 px-4 py-2 rounded inline-block font-semibold">Total Sales: {{ $totalSales }} MRU</div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2" /></svg>
            Orders Sold by This Pharmacy
        </h2>
        <div class="overflow-x-auto rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-3 font-mono">{{ $order->reference ?? $order->id }}</td>
                        <td class="px-6 py-3">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                @if($order->status === 'VALIDEE') bg-green-100 text-green-800
                                @elseif($order->status === 'REJETEE') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3">{{ $order->total_amount }} MRU</td>
                        <td class="px-6 py-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-4 text-center text-gray-400">No orders found for this pharmacy.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 