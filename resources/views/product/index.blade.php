<x-app-layout>
    <x-slot name="header">
        <div class="flex gap-2 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Liste des Produits
            </h2>
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                <a href="{{ route('products.create') }}" class="text-blue-500 text-xl"><x-fas-plus class="w-5 h-5" /></a>
            @endif
            <button id="toggleViewButton" class="ml-auto bg-blue-500 text-white px-4 py-2" onclick="toggleView()">Switch to
                Table View</button>
        </div>
    </x-slot>

    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- <h1 class="text-2xl font-bold mb-6">Liste des Produits</h1> --}}

        <div class="flex gap-4 h-full">
            <div class="min-w-60 h-full bg-white shadow-md rounded-lg overflow-hidden p-6">
                menu
            </div>
            <div>
                <div id="tableView" class="hidden">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200"></th>
                                <th class="py-2 px-4 border-b border-gray-200">Nom</th>
                                <th class="py-2 px-4 border-b border-gray-200">Catégorie</th>
                                <th class="py-2 px-4 border-b border-gray-200">Description</th>
                                <th class="py-2 px-4 border-b border-gray-200">Ingrédients</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <th class="py-2 px-4 border-b border-gray-200">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="cursor-pointer hover:bg-gray-100"
                                    onclick="window.location='{{ route('products.show', $product->id) }}'">
                                    <td class="border-b border-gray-200">
                                        @if ($product->status == 'unavailable')
                                            <x-fas-circle-exclamation class="text-red-500 h-5 w-5 ml-2"
                                                title="Indisponible" />
                                        @endif

                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 font-semibold">
                                        {{ $product->name }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $product->category->name }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $product->description }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        @foreach ($product->ingredients as $ingredient)
                                            <span class="py-0.5 text-sm font-medium">{{ $ingredient->name }},</span>
                                        @endforeach
                                    </td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                        <td class="py-2 px-4 border-b border-gray-200 flex gap-1">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="text-orange-400">
                                                <x-fas-edit class="w-5 h-5" title="Editer le produit" />
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500">
                                                    <x-fas-trash-alt class="w-5 h-5" title="Supprimer le produit" />
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="cardView" class="block">
                    <div class="columns-4 gap-1">
                        @foreach ($products as $product)
                            <div class="bg-white shadow-md rounded-lg p-4 mr-0.5 cursor-pointer hover:bg-gray-100 h-40"
                                onclick="window.location='{{ route('products.show', $product->id) }}'">

                                <div class="flex mb-2 justify-between">
                                    <div class="flex items-center mb-2 gap-2">
                                        @if ($product->status == 'unavailable')
                                            <x-fas-circle-exclamation class="text-red-500 h-5 w-5"
                                                title="Indisponible" />
                                        @endif
                                        <h2 class="text-xl font-bold">{{ $product->name }}</h2>
                                    </div>

                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                        <div class="flex gap-1 ">
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
                                @foreach ($product->ingredients as $ingredient)
                                    <span class="py-0.5 text-sm font-medium">{{ $ingredient->name }},</span>
                                @endforeach

                            </div>
                        @endforeach
                    </div>
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
            } else {
                tableView.classList.remove('hidden');
                tableView.classList.add('block');
                cardView.classList.remove('block');
                cardView.classList.add('hidden');
                toggleButton.textContent = 'Switch to Card View';
            }
        }
    </script>
</x-app-layout>
