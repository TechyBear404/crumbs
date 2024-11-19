<x-app-layout>

    <div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-slot name="header">
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Liste des Produits
                </h2>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                    <a href="{{ route('products.create') }}" class="text-xl text-blue-500"><x-fas-plus
                            class="w-5 h-5" /></a>
                @endif
                <button id="toggleViewButton" class="px-4 py-2 ml-auto text-white bg-blue-500"
                    onclick="toggleView()">Switch to
                    Table View</button>
            </div>
        </x-slot>
        {{-- <h1 class="mb-6 text-2xl font-bold">Liste des Produits</h1> --}}

        <div class="flex gap-4 min-h-[calc(100vh-14rem)]">
            <div class="sticky p-6 overflow-hidden bg-white rounded-lg shadow-md min-w-60 top-8">
                {{-- create filters for products --}}
                <form id="filterForm" action="{{ route('products.index') }}" method="GET">
                    <div class="mb-4">
                        <x-input-label name="name" value="Nom" class="mb-1" />
                        <x-text-input id="filterName" name="name" :value="old('name', request('name'))" />

                    </div>
                    <div class="mb-4">
                        @foreach ($categories as $categorie)
                            <div>
                                <input type="checkbox" name="categoryId[]" value="{{ $categorie->id }}"
                                    {{ in_array($categorie->id, request('categoryId', [])) ? 'checked' : '' }} />
                                <span>{{ $categorie->name }}</span>
                            </div>
                        @endforeach
                        {{-- <x-input-label name="categoryId" value="Catégorie" class="mb-1" />
                        <x-input-select-dynamic name="categoryId" :options="$categories" :selected="request('categoryId')" /> --}}
                    </div>

                    <div class="flex gap-2 pt-4">
                        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Filtrer</button>
                        <button type="button" class="px-4 py-2 text-white bg-red-500 rounded">
                            <a href="{{ route('products.index') }}">Réinitialiser</a>
                        </button>
                    </div>
                </form>
            </div>
            <div class="w-full">
                <div id="tableView" class="hidden">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200"></th>
                                <th class="px-4 py-2 border-b border-gray-200">Nom</th>
                                <th class="px-4 py-2 border-b border-gray-200">Catégorie</th>
                                <th class="px-4 py-2 border-b border-gray-200">Description</th>
                                <th class="px-4 py-2 border-b border-gray-200">Ingrédients</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <th class="px-4 py-2 border-b border-gray-200">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->isEmpty())
                                <tr>
                                    <td colspan="6" class="py-4 text-center">Aucun produit trouvé</td>
                                </tr>
                            @endif
                            @foreach ($products as $product)
                                <tr class="cursor-pointer hover:bg-gray-100"
                                    onclick="window.location='{{ route('products.show', $product->id) }}'">
                                    <td class="border-b border-gray-200">
                                        @if ($product->status == 'unavailable')
                                            <x-fas-circle-exclamation class="w-5 h-5 ml-2 text-red-500"
                                                title="Indisponible" />
                                        @endif

                                    </td>
                                    <td class="px-4 py-2 font-semibold border-b border-gray-200">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ $product->category->name }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ $product->description }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">
                                        @foreach ($product->ingredients as $ingredient)
                                            <span class="py-0.5 text-sm font-medium">{{ $ingredient->name }},</span>
                                        @endforeach
                                    </td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                        <td class="px-4 py-2 border-b border-gray-200 ">
                                            <div class="flex h-full gap-1">

                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="text-orange-400">
                                                    <x-fas-edit class="w-5 h-5" title="Editer le produit" />
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500">
                                                        <x-fas-trash-alt class="w-5 h-5" title="Supprimer le produit" />
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

                <div id="cardView" class="hidden grow">
                    @if ($products->isEmpty())
                        <div class="text-center bg-white shadow-md rounded-lg p-4 mr-0.5 w-full">
                            Aucun produit trouvé
                        </div>
                    @else
                        <div class="flex gap-1">
                            @foreach ($products as $product)
                                <div class="bg-white shadow-md rounded-lg p-4 mr-0.5 cursor-pointer hover:bg-gray-100 h-40 basis-1/4"
                                    {{-- onclick="window.location='{{ route('products.show', $product->id) }}'"> --}}>

                                    <div class="flex justify-between mb-2">
                                        <div class="flex items-center gap-2 mb-2">
                                            @if ($product->status == 'unavailable')
                                                <x-fas-circle-exclamation class="w-5 h-5 text-red-500"
                                                    title="Indisponible" />
                                            @endif
                                            <h2 class="text-xl font-bold">{{ $product->name }}</h2>
                                        </div>

                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                            <div class="flex gap-1">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="text-orange-400"><x-fas-edit class="w-5 h-5"
                                                        title="Editer le produit" /></a>
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500">
                                                        <x-fas-trash-alt class="w-5 h-5" title="Supprimer le produit" />
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="pb-2">
                                        @foreach ($product->ingredients as $ingredient)
                                            <span class="py-0.5 text-sm font-medium">{{ $ingredient->name }},</span>
                                        @endforeach
                                    </div>
                                    <button x-data x-on:click="$dispatch('open-modal', 'modal-name')">
                                        <x-fas-cart-plus class="w-5 h-5 text-green-500" />
                                    </button>

                                    {{-- @foreach ($product->variations as $variation)
                                        <div class="grid grid-cols-3">
                                            <div class="text-sm font-medium">
                                                {{ $variation->name }}
                                            </div>
                                            <div class="text-sm font-medium">
                                                {{ $variation->prices->where('endDate', null)->first()->price }}
                                                €
                                            </div>
                                        </div>
                                    @endforeach --}}
                                    {{-- Modal component --}}
                                    <x-product-order-modal name="modal-name" :show="false" maxWidth="md"
                                        :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
            const filterForm = document.getElementById('filterForm');
            const filterName = document.getElementById('filterName');
            const categoryCheckboxes = document.querySelectorAll('input[name="categoryId[]"]');

            // filterName.addEventListener('input', function() {
            //     filterForm.submit();
            // });

            categoryCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    filterForm.submit();
                });
            });
        });

        function resetName() {
            document.querySelector('#filterName').value = '';
        }
    </script>
</x-app-layout>
