<x-app-layout>
    <div x-data="{}"> {{-- Ajout de x-data ici --}}
        <x-cart :orders="$orders" />
        <div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Liste des Produits
                    </h2>
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                        <a href="{{ route('products.create') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700">
                            <x-fas-plus class="w-4 h-4 mr-2" />
                            Ajouter un produit
                        </a>
                    @endif
                </div>
            </x-slot>

            <!-- Formulaire de filtrage -->
            <form id="filterForm" action="{{ route('products.index') }}" method="GET" class="mb-6">
                <div class="grid gap-6 md:grid-cols-[300px_1fr]">
                    <!-- Filtres -->
                    <x-product.filter :categories="$categories" :ingredients="$ingredients" />

                    <!-- Contenu principal -->
                    <div class="space-y-6">
                        <!-- Toggle vue -->
                        <div class="flex justify-end">
                            <button id="viewToggle" type="button"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <x-fas-table id="tableIcon" class="w-4 h-4 transition-opacity duration-200" />
                                <x-fas-grip id="gridIcon" class="hidden w-4 h-4 transition-opacity duration-200" />
                                <span class="ml-2" id="viewText">Vue Tableau</span>
                            </button>
                        </div>

                        <!-- Vues des produits -->
                        <div id="tableView" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Produit</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Catégorie</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Statut</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Ingrédients
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $product->category->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    {{ $product->status === 'available' ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                                    {{ $product->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">
                                                    @foreach ($product->ingredients as $ingredient)
                                                        <span
                                                            class="flex justify-center items-center px-2 py-1 mr-1 text-xs font-semibold rounded-full
                                                            {{ $ingredient->isAllergen ? 'text-amber-800 bg-amber-100' : 'text-gray-700 bg-gray-100' }}">
                                                            {{ $ingredient->name }}
                                                            @if ($ingredient->isAllergen)
                                                                <x-fas-exclamation-triangle class="w-3 h-3 ml-1" />
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-3">
                                                    <button type="button"
                                                        @if ($product->status === 'available') x-on:click="$dispatch('open-modal', 'modal-product-{{ $product->id }}')" @endif
                                                        class="p-1.5 rounded-lg {{ $product->status === 'available' ? 'text-blue-600 hover:bg-blue-50' : 'text-gray-400 cursor-not-allowed' }}">
                                                        <x-fas-cart-plus class="w-4 h-4" />
                                                    </button>
                                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                            class="p-1.5 text-orange-500 hover:bg-orange-50 rounded-lg">
                                                            <x-fas-edit class="w-4 h-4" />
                                                        </a>
                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg">
                                                                <x-fas-trash-alt class="w-4 h-4" />
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="gridView">
                            <div id="gridView"
                                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                                @foreach ($products as $product)
                                    <div class="overflow-hidden bg-white rounded-lg shadow">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    {{ $product->status === 'available' ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                                    {{ $product->status }}
                                                </span>
                                            </div>
                                            <p class="mb-4 text-sm text-gray-500">{{ $product->category->name }}</p>
                                            <!-- Ajout des ingrédients -->
                                            <div class="mb-4 space-y-2">
                                                <p class="text-sm font-medium text-gray-700">Ingrédients:</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($product->ingredients as $ingredient)
                                                        <span
                                                            class="flex justify-center items-center px-2 py-1 text-xs font-semibold rounded-full
                                                            {{ $ingredient->isAllergen ? 'text-amber-800 bg-amber-100' : 'text-blue-700 bg-blue-100' }}">
                                                            {{ $ingredient->name }}
                                                            @if ($ingredient->isAllergen)
                                                                <x-fas-exclamation-triangle class="w-3 h-3 ml-1" />
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between mt-4">
                                                <button type="button"
                                                    @if ($product->status === 'available') x-on:click="$dispatch('open-modal', 'modal-product-{{ $product->id }}')" @endif
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md
                                                        {{ $product->status === 'available'
                                                            ? 'text-white bg-blue-600 hover:bg-blue-700'
                                                            : 'text-gray-400 bg-gray-100 cursor-not-allowed' }}">
                                                    <x-fas-cart-plus class="w-4 h-4 mr-2" />
                                                    Ajouter
                                                </button>
                                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                                    <div class="flex items-center ">
                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                            class="p-1 text-orange-500 rounded-lg hover:bg-orange-50">
                                                            <x-fas-edit class="w-4 h-4" />
                                                        </a>
                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="p-1 text-red-600 rounded-lg hover:bg-red-50">
                                                                <x-fas-trash-alt class="w-4 h-4" />
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modals des produits -->
        @foreach ($products as $product)
            <x-product-order-modal :name="'modal-product-' . $product->id" :product="$product" />
        @endforeach
    </div>

    <script>
        const viewToggle = document.getElementById('viewToggle');
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');
        const tableIcon = document.getElementById('tableIcon');
        const gridIcon = document.getElementById('gridIcon');
        const viewText = document.getElementById('viewText');

        // Charger la préférence utilisateur
        let currentView = localStorage.getItem('productView') || 'grid';
        updateView(currentView);

        viewToggle.addEventListener('click', () => {
            currentView = currentView === 'grid' ? 'table' : 'grid';
            localStorage.setItem('productView', currentView);
            updateView(currentView);
        });

        function updateView(view) {
            if (view === 'grid') {
                gridView.classList.remove('hidden');
                tableView.classList.add('hidden');
                tableIcon.classList.remove('hidden');
                gridIcon.classList.add('hidden');
                viewText.textContent = 'Vue Tableau';
            } else {
                gridView.classList.add('hidden');
                tableView.classList.remove('hidden');
                tableIcon.classList.add('hidden');
                gridIcon.classList.remove('hidden');
                viewText.textContent = 'Vue Grille';
            }
        }
    </script>
</x-app-layout>
