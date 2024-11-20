<x-app-layout>
    <x-cart :orders="$orders" />
    <div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button id="filterButton"
                        class="px-4 py-2 text-white transition-colors duration-200 bg-gray-500 rounded-lg md:hidden hover:bg-gray-600 focus:ring-2 focus:ring-gray-300"
                        x-data=""
                        x-on:click="$dispatch('toggle-filter')">
                        <x-fas-filter class="w-4 h-4" />
                    </button>
                    <h2 class="text-2xl font-bold leading-tight text-gray-800">
                        Liste des Produits
                    </h2>
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                        <a href="{{ route('products.create') }}"
                            class="text-blue-500 transition-colors duration-200 hover:text-blue-600">
                            <x-fas-plus class="w-6 h-6" />
                        </a>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <button id="toggleViewButton"
                        class="px-4 py-2 text-white transition-colors duration-200 bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-300"
                        onclick="toggleView()">
                        >
                        Switch to Table View
                    </button>
                </div>
            </div>
        </x-slot>

        <div class="flex gap-6 min-h-[calc(100vh-14rem)]">
            <x-product.filter :categories="$categories" />

            <!-- Content Area -->
            <div class="w-full">
                <!-- Table View -->
                <div id="tableView" class="hidden">
                    <div class="overflow-hidden bg-white/90 backdrop-blur-sm rounded-xl border border-gray-100/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th scope="col" class="w-12"></th>
                                    <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                                        Nom
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                                        Catégorie
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                                        Ingrédients
                                    </th>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                                            Actions
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white/50">
                                @if ($products->isEmpty())
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            Aucun produit trouvé
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($products as $product)
                                    <tr class="transition-colors group hover:bg-gray-50/50"
                                        onclick="window.location='{{ route('products.show', $product->id) }}'">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($product->status == 'unavailable')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <x-fas-circle-exclamation class="w-3 h-3 mr-1" />
                                                    Indisponible
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $product->category->name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 line-clamp-2">{{ $product->description }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($product->ingredients as $ingredient)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                        {{ $ingredient->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <button type="button"
                                                        x-on:click="$dispatch('open-modal', 'modal-product-{{ $product->id }}')"
                                                        class="inline-flex items-center p-1.5 text-green-600 rounded-lg bg-green-50 hover:bg-green-100 transition-colors duration-200">
                                                        <x-fas-cart-plus class="w-4 h-4" />
                                                    </button>
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="inline-flex items-center p-1.5 text-orange-500 rounded-lg bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                                                        <x-fas-edit class="w-4 h-4" />
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-flex">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center p-1.5 text-red-600 rounded-lg bg-red-50 hover:bg-red-100 transition-colors duration-200">
                                                            <x-fas-trash-alt class="w-4 h-4" />
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Card View -->
                <div id="cardView" class="hidden grow" x-data="{}">
                    @if ($products->isEmpty())
                        <div class="p-8 text-center shadow-md bg-white/90 backdrop-blur-sm rounded-xl">
                            <p class="text-lg text-gray-600">Aucun produit trouvé</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            @foreach ($products as $product)
                                <div class="group relative bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-sm border border-gray-100/50 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                    <!-- Status Badge -->
                                    @if ($product->status == 'unavailable')
                                        <div class="absolute px-3 py-1 rounded-full shadow-sm top-3 left-3 bg-red-500/90 backdrop-blur-sm">
                                            <span class="text-xs font-medium text-white">Indisponible</span>
                                        </div>
                                    @endif

                                    <!-- Admin Actions -->
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                        <div class="absolute flex flex-col justify-center transition-all duration-200 opacity-0 top-3 right-3 group-hover:opacity-100">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="p-1 text-orange-500 transition-colors duration-200 rounded shadow-sm bg-white/90 hover:bg-orange-50">
                                                <x-fas-edit class="w-4 h-4" />
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1 text-red-500 transition-colors duration-200 rounded shadow-sm bg-white/90 hover:bg-red-50">
                                                    <x-fas-trash-alt class="w-4 h-4" />
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    <div class="p-6 space-y-6">
                                        <!-- Product Name -->
                                        <div class="text-center">
                                            <h2 class="mb-2 text-2xl font-bold text-gray-800">{{ $product->name }}</h2>
                                            <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                        </div>

                                        <!-- Ingredients -->
                                        <div class="flex flex-wrap justify-center gap-2">
                                            @foreach ($product->ingredients as $ingredient)
                                                <span class="px-3 py-1 text-xs font-medium text-gray-600 border border-gray-100 rounded-full bg-gray-50">
                                                    {{ $ingredient->name }}
                                                </span>
                                            @endforeach
                                        </div>

                                        <!-- Add to Cart Button -->
                                        <button type="button"
                                            x-on:click="$dispatch('open-modal', 'modal-product-{{ $product->id }}')"
                                            class="flex items-center justify-center w-full gap-2 px-6 py-3 font-medium text-white transition-all duration-200 transform bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                                            <x-fas-cart-plus class="w-5 h-5" />
                                            <span>Ajouter au panier</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Product Order Modals -->
    @foreach ($products as $product)
        <x-product-order-modal :name="'modal-product-'.$product->id" :product="$product" />
    @endforeach

    <script>
        function toggleView() {
            const tableView = document.getElementById('tableView');
            const cardView = document.getElementById('cardView');
            const toggleButton = document.getElementById('toggleViewButton');


            if (tableView.classList.contains('block')) {
                tableView.classList.remove('block');
                tableView.classList.add('hidden');
                cardView.classList.remove('hidden');
                cardView.classList.add('block');
                toggleButton.textContent = 'Switch to Table View';
                localStorage.setItem('productsView', 'card');
            } else {
                tableView.classList.remove('hidden');
                tableView.classList.add('block');
                cardView.classList.remove('block');
                cardView.classList.add('hidden');
                toggleButton.textContent = 'Switch to Card View';
                localStorage.setItem('productsView', 'table');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let productsView = localStorage.getItem('productsView');
            const tableView = document.getElementById('tableView');
            const cardView = document.getElementById('cardView');
            const toggleButton = document.getElementById('toggleViewButton');

            if (productsView == null) {
                localStorage.setItem('productsView', 'card');
                productsView = 'card';
            }

            if (productsView === 'card') {
                cardView.classList.remove('hidden');
                cardView.classList.add('block');
                toggleButton.textContent = 'Switch to Table View';
                localStorage.setItem('productsView', 'card');

            } else {
                tableView.classList.remove('hidden');
                tableView.classList.add('block');
                toggleButton.textContent = 'Switch to Card View';
                localStorage.setItem('productsView', 'table');
            }

        });
    </script>
</x-app-layout>
