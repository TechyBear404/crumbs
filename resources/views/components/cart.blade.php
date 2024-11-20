@props(['orders'])

<div x-data="{
    open: false,
    toggleCart() {
        console.log('Toggle cart, current state:', this.open);
        this.open = !this.open;
    }
}" class="fixed top-0 right-0 z-40 h-full pointer-events-none w-80">

    {{-- Cart Panel --}}
    <div x-show="open" x-cloak x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full" class="absolute inset-0 bg-white shadow-xl pointer-events-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between p-4 border-b bg-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Panier</h2>
            <button @click="open = false" class="p-1 rounded-full hover:bg-gray-200">
                <x-fas-times class="w-5 h-5" />
            </button>
        </div>

        {{-- Cart Items --}}
        <div class="p-4 h-[calc(100vh-180px)] overflow-y-auto">
            @if ($orders->count() === 0)
                <div class="flex flex-col items-center justify-center h-full space-y-4">
                    <x-fas-shopping-cart class="w-16 h-16 text-gray-300" />
                    <p class="text-lg text-gray-500">Votre panier est vide</p>
                </div>
            @endif

            @if ($orders->count() > 0)
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="mb-3 text-sm font-medium text-gray-600">
                                Commande du {{ \Carbon\Carbon::parse($order->orderDate)->format('d/m/Y') }}
                            </p>
                            @foreach ($order->details as $product)
                                <div class="flex items-center justify-between py-2 border-b last:border-0">
                                    <div class="flex items-center space-x-3">
                                        <span class="px-2 py-1 text-sm text-blue-800 transition-colors bg-blue-100 rounded-full cursor-pointer hover:bg-blue-200">
                                            {{ $product->qty }}x
                                        </span>
                                        <div>
                                            <p class="font-medium">{{ $product->productVariation->product->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $product->productVariation->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <p class="font-medium">@currency_euro($product->qty * $product->unitPrice)</p>
                                        <button class="p-1 text-red-500 transition-colors rounded hover:bg-red-100 hover:text-red-600 active:bg-red-200">
                                            <x-fas-trash-alt class="w-4 h-4" />
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="absolute bottom-0 left-0 right-0 p-4 bg-white border-t">
            <div class="flex justify-between mb-4">
                <span class="text-lg font-bold">Total</span>
                <span class="text-lg font-bold">
                    @currency_euro(
                        $orders->sum(function ($order) {
                            return $order->details->sum(function ($detail) {
                                return $detail->qty * $detail->unitPrice;
                            });
                        })
                    )
                </span>
            </div>
            @if ($orders->count() > 0)
                <button class="w-full px-4 py-3 text-white transition-colors bg-blue-500 rounded-lg hover:bg-blue-600">
                    Commander
                </button>
            @endif
        </div>
    </div>

    {{-- Cart Toggle Button - Repositioned outside panel with transitions --}}
    <div class="absolute z-50 transition-all duration-300 pointer-events-auto bottom-4 right-4"
        :class="open ? 'hidden' : ''">
        <button @click="toggleCart()"
            class="p-3 text-white transition-colors bg-blue-500 rounded-full shadow-lg hover:bg-blue-600">
            <x-fas-shopping-cart class="w-6 h-6" />
        </button>
        @if ($orders->count() > 0)
            <span class="absolute flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full -top-2 -right-2">
                {{ $orders->count() }}
            </span>
        @endif
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
