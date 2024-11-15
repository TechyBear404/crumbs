<x-app-layout>
    <x-slot name="header">
        <div class="flex gap-2 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                <a href="{{ route('products.create') }}" class="text-blue-500 text-xl">+</a>
            @endif
            <button id="toggleViewButton" class="ml-auto bg-blue-500 text-white px-4 py-2" onclick="toggleView()">Switch to
                Table View</button>
        </div>
    </x-slot>

    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold mb-6">Liste des Produits</h1>

        <div class="flex gap-4 h-full">
            <div class="min-w-60 h-full bg-white shadow-md rounded-lg overflow-hidden p-6">
                menu
            </div>
            <div id="tableView" class="hidden">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200">Nom</th>
                            <th class="py-2 px-4 border-b border-gray-200">Statut</th>
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
                                <td class="py-2 px-4 border-b border-gray-200">{{ $product->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $product->status }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $product->category->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $product->description }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @foreach ($product->ingredients as $ingredient)
                                        <span
                                            class="bg-blue-600 rounded-full text-gray-100 px-2 py-0.5 text-sm">{{ $ingredient->name }}</span>
                                    @endforeach
                                </td>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <td class="py-2 px-4 border-b border-gray-200 flex gap-4">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="text-blue-500">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="cardView" class="block">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($products as $product)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 cursor-pointer hover:bg-gray-100"
                            onclick="window.location='{{ route('products.show', $product->id) }}'">
                            <h2 class="text-lg font-semibold mb-2">{{ $product->name }}</h2>
                            <p class="text-gray-700 mb-2"><strong>Statut:</strong> {{ $product->status }}</p>
                            {{-- <p class="text-gray-700 mb-2"><strong>Catégorie:</strong> {{ $product->category->name }}</p>
                            <p class="text-gray-700 mb-2"><strong>Description:</strong> {{ $product->description }}</p>
                            <div class="flex flex-wrap gap-2"> --}}
                            @foreach ($product->ingredients as $ingredient)
                                <span
                                    class="bg-blue-600 rounded-full text-gray-100 px-2 py-0.5 text-sm">{{ $ingredient->name }}</span>
                            @endforeach
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                <div class="flex gap-4 mt-4">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                </div>
                @endforeach
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
