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
    quantity: 1,
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
        class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-transition:enter="translate-x-0" x-transition:enter-start="translate-x-full"
        x-transition:leave-end="translate-x-full">

        {{-- Header --}}
        <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 bg-white border-b">
            <h3 class="text-lg font-bold text-gray-900">Ajouter au panier</h3>
            <button @click="show = false" class="p-2 transition-colors rounded-full hover:bg-gray-100">
                <x-fas-xmark class="w-5 h-5" />
            </button>
        </div>

        <form action="{{ route('orders.store') }}" method="POST" class="flex flex-col h-full">
            @csrf
            <input type="hidden" name="productId" value="{{ $product->id }}">

            {{-- Scrollable Content --}}
            <div class="flex-1 p-6 space-y-8 overflow-y-auto">
                {{-- Product Preview --}}
                <div class="flex gap-6">
                    @if ($product->image)
                        <div class="relative flex-shrink-0 w-40 h-40">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="object-cover w-full h-full rounded-2xl">
                        </div>
                    @endif
                    <div class="space-y-2">
                        @if ($product->category)
                            <span
                                class="inline-flex px-2.5 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        <h2 class="text-xl font-bold text-gray-900">{{ $product->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $product->description }}</p>
                    </div>
                </div>

                {{-- Size Selection --}}
                <div class="space-y-3">
                    <label class="text-sm font-medium text-gray-900">Taille</label>
                    <div class="grid grid-cols-3 gap-3" x-data="{ selectedVariant: '{{ $product->variations->first()->id }}' }">
                        @foreach ($product->variations as $variation)
                            <label class="relative">
                                <input type="radio" name="variantId" value="{{ $variation->id }}"
                                    x-model="selectedVariant" class="sr-only peer">
                                <div
                                    class="p-4 text-center transition-all border-2 cursor-pointer rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-200">
                                    <span class="block text-sm font-medium">{{ $variation->name }}</span>
                                    <span class="block mt-1 text-sm text-gray-500">
                                        {{ $variation->prices->where('endDate', null)->first()->price }}€
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="space-y-3">
                    <label class="text-sm font-medium text-gray-900">Quantité</label>
                    <div class="inline-flex items-center border rounded-lg">
                        <button type="button" @click.prevent="quantity = Math.max(1, quantity - 1)"
                            class="flex items-center justify-center w-12 h-12 text-gray-600 transition-colors hover:bg-gray-50">
                            <span class="text-xl">−</span>
                        </button>
                        <input type="number" name="qty" x-model="quantity" min="1"
                            class="w-20 h-12 text-center border-x focus:ring-0 focus:outline-none">
                        <button type="button" @click.prevent="quantity = quantity + 1"
                            class="flex items-center justify-center w-12 h-12 text-gray-600 transition-colors hover:bg-gray-50">
                            <span class="text-xl">+</span>
                        </button>
                    </div>
                </div>

                {{-- Date & Comment --}}
                <div class="space-y-6">
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-900">Date de retrait</label>
                        <input type="date" name="orderDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                            class="w-full h-12 px-4 border-gray-200 rounded-lg focus:border-blue-500">
                    </div>

                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-900">Instructions spéciales</label>
                        <textarea name="comment" rows="3" class="w-full px-4 py-3 border-gray-200 rounded-lg focus:border-blue-500"
                            placeholder="Ajouter des instructions particulières..."></textarea>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer --}}
            <div class="sticky bottom-0 p-6 space-y-4 bg-white border-t">

                <div class="grid grid-cols-2 gap-4">
                    <button type="button" @click="show = false"
                        class="w-full py-3.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                        class="w-full py-3.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        Ajouter au panier
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
