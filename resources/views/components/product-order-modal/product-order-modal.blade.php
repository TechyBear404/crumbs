@props(['name', 'show' => false, 'maxWidth' => '2xl', 'product' => []])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div x-data="{
    show: @js($show),
    focusables() {
        // All focusable element types...
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
        return [...$el.querySelectorAll(selector)]
            // All non-disabled elements...
            .filter(el => !el.hasAttribute('disabled'))
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
    prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
    nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
    prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
}" x-init="$watch('show', value => {
    if (value) {
        document.body.classList.add('overflow-y-hidden');
        {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
    } else {
        document.body.classList.remove('overflow-y-hidden');
    }
})"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null" x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false" x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()" x-show="show"
    class="fixed inset-0 z-50 px-4 py-6 overflow-y-auto sm:px-0" style="display: {{ $show ? 'block' : 'none' }};">
    <div x-show="show" class="fixed inset-0 transition-all transform" x-on:click="show = false"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-show="show"
        class="mb-6 p-4 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        {{-- a component to be used as a modal for product order form need to select the size and quantity and orderDate via date picker --}}
        <div class="">
            {{-- add close button --}}
            <div class="flex justify-between">
                <h3 class="text-lg font-medium text-gray-900">Commande </h3>
                <button x-on:click="show = false">
                    <x-fas-xmark class="w-5 h-5" />
                </button>
            </div>
        </div>
        <form action="{{ route('orders.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="productId" value="{{ $product->id }}">

            <h2 class="mb-4 text-lg font-semibold">Commander {{ $product->name }}</h2>

            <!-- Size Selection -->
            <div class="mb-4">
                <x-input-label name="variantId" value="Taille" class="mb-1" />
                @if (count($product->variations) > 1)
                    {{-- <x-input-select-dynamic name="variantId" :options="$product->variations" /> --}}
                    <select name="variantId"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        @foreach ($product->variations as $variation)
                            <option value="{{ $variation->id }}">{{ $variation->name }} -
                                {{ $variation->prices->where('endDate', null)->first()->price }}€</option>
                        @endforeach
                    </select>
                @else
                    <p>
                        {{ $product->variations->first()->name }} -
                        {{ $product->variations->first()->prices->where('endDate', null)->first()->price }}€
                    </p>
                @endif
            </div>

            <!-- Quantity Selection -->
            <div class="mb-4">
                <x-input-label name="qty" value="Quantité" class="mb-1" />
                <div class="flex items-center">
                    <button type="button" onclick="decrementQuantity()" class="px-3 py-1 border rounded-l">-</button>
                    <input type="number" name="qty" value="1" min="1"
                        class="w-20 text-center border-t border-b">
                    <button type="button" onclick="incrementQuantity()" class="px-3 py-1 border rounded-r">+</button>
                </div>
            </div>

            <!-- Order Date -->
            <div class="mb-4">
                <x-input-label name="orderDate" value="Date de commande" class="mb-1" />
                <input type="date" name="orderDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>

            {{-- Comment --}}
            <div class="mb-4">
                <x-input-label name="comment" value="Commentaire" class="mb-1" />
                <textarea name="comment"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end mt-6 space-x-3">
                <button type="button" onclick="closeModal('{{ $name }}')"
                    class="px-4 py-2 text-gray-800 bg-gray-200 rounded-md hover:bg-gray-300">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                    Commander
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function incrementQuantity() {
        const input = document.querySelector('input[name="qty"]');
        input.value = parseInt(input.value) + 1;
    }

    function decrementQuantity() {
        const input = document.querySelector('input[name="qty"]');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
