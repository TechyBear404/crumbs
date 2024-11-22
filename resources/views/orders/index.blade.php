<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Mes Commandes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($orders->isEmpty())
                        <p class="text-center text-gray-500">Aucune commande trouvée</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Date</th>
                                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')
                                            <th scope="col" class="px-6 py-3">Client</th>
                                        @endif
                                        <th scope="col" class="px-6 py-3">Statut</th>
                                        <th scope="col" class="px-6 py-3">Produits</th>
                                        <th scope="col" class="px-6 py-3">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                {{ \Carbon\Carbon::parse($order->orderDate)->format('d/m/Y H:i') }}</td>
                                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')
                                                <td class="px-6 py-4">{{ $order->user->name }}</td>
                                            @endif
                                            <td class="px-6 py-4">
                                                {{-- order can have multiple status --}}
                                                @foreach ($order->statusHistory as $status)
                                                    <span
                                                        class="px-3 py-1 text-sm rounded-full
                                                        @switch($status->name)
                                                            @case('pending') bg-yellow-100 text-yellow-800 @break
                                                            @case('completed') bg-green-100 text-green-800 @break
                                                            @case('cancelled') bg-red-100 text-red-800 @break
                                                            @default bg-gray-100 text-gray-800
                                                        @endswitch">
                                                        {{ $status->name }}
                                                    </span>
                                                @endforeach
                                                {{-- <span
                                                    class="px-3 py-1 text-sm rounded-full
                                                @switch($order->status)
                                                    @case('pending') bg-yellow-100 text-yellow-800 @break
                                                    @case('completed') bg-green-100 text-green-800 @break
                                                    @case('cancelled') bg-red-100 text-red-800 @break
                                                    @default bg-gray-100 text-gray-800
                                                @endswitch">
                                                    {{ $order->status()->name }}
                                                </span> --}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="space-y-2">
                                                    @foreach ($order->details as $detail)
                                                        <div class="flex items-center gap-3">
                                                            <span
                                                                class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                                                x{{ $detail->qty }}
                                                            </span>
                                                            <span class="text-sm font-medium text-gray-900">
                                                                {{ $detail->productVariation->product->name }}
                                                                {{ $detail->productVariation->name }}
                                                            </span>
                                                            <span class="text-sm font-medium text-gray-500">
                                                                @currency_euro($detail->unitPrice)
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 font-semibold">
                                                @currency_euro($order->details->sum(fn($detail) => $detail->qty * $detail->unitPrice))
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
