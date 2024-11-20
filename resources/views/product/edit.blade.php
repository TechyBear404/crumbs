<x-app-layout>
    <div class="container max-w-4xl px-4 py-12 mx-auto sm:px-6 lg:px-8">
        <h1 class="mb-8 text-3xl font-bold text-gray-800">Modifier le produit</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST"
            class="p-6 bg-white border border-gray-100 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <x-input-label name="name" value="Nom" class="text-sm font-medium text-gray-700" />
                    <x-text-input name="name" :value="old('name', $product->name)" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label name="description" value="Description" class="text-sm font-medium text-gray-700" />
                    <x-text-input name="description" :value="old('description', $product->description)" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div>
                    <div class="flex items-center gap-2">
                        <x-input-label name="categoryId" value="Catégorie" class="text-sm font-medium text-gray-700" />
                        <a href="{{ route('categories.create', ['redirect_url' => route('products.create')]) }}"
                            class="inline-flex items-center justify-center w-6 h-6 text-sm font-medium text-blue-600 transition-colors bg-blue-100 rounded-full hover:bg-blue-200">+</a>
                    </div>
                    <x-input-select-dynamic name="categoryId" :options="$categories" :selected="$product->categoryId" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('categoryId')" />
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <x-input-label name="ingredients" value="Ingrédients" class="text-sm font-medium text-gray-700" />
                        <a href="{{ route('ingredients.create', ['redirect_url' => route('products.edit', ['product' => $product->id])]) }}"
                            class="inline-flex items-center justify-center w-6 h-6 text-sm font-medium text-blue-600 transition-colors bg-blue-100 rounded-full hover:bg-blue-200">+</a>
                    </div>
                    <div class="flex gap-2 mb-2">
                        <x-input-select-dynamic id="ingredientSelect" name="status" :options="$ingredients" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                        <button type="button"
                            class="px-3 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            onclick="addIngredient()">+</button>
                    </div>
                    <div id="ingredientList" class="flex flex-wrap gap-2">
                        @foreach ($product->ingredients as $ingredient)
                            <div class="flex items-center px-3 py-1.5 bg-blue-100 text-blue-800 rounded-full">
                                <span class="text-sm">{{ $ingredient->name }}</span>
                                <button type="button" class="ml-2 text-blue-600 transition-colors hover:text-red-500"
                                    onclick="removeIngredient({{ $ingredient->id }})">×</button>
                                <input type="hidden" name="ingredientsList[]" value="{{ $ingredient->id }}">
                            </div>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('ingredientsList')" />
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <x-input-label name="prices" value="Prix" class="text-sm font-medium text-gray-700" />
                        <button type="button" class="inline-flex items-center justify-center w-6 h-6 text-sm font-medium text-blue-600 transition-colors bg-blue-100 rounded-full hover:bg-blue-200" onclick="addPrice()">+</button>
                    </div>
                    <div id="pricesList" class="space-y-3">
                        @foreach ($product->variations as $index => $variation)
                            <div class="flex items-center gap-4 p-4 rounded-lg price-entry bg-gray-50">
                                <div class="flex-1">
                                    <x-input-label name="size" value="Taille" class="text-sm font-medium text-gray-700" />
                                    <x-input-select name="variations[{{ $index }}][size]" :options="['normal' => 'Normal', 'large' => 'Grand']"
                                        :selected="$variation->name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                </div>
                                <div class="flex-1">
                                    <x-input-label name="price" value="Prix" class="text-sm font-medium text-gray-700" />
                                    <x-text-input type="number" name="variations[{{ $index }}][price]"
                                        :value="$variation->price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    <x-input-error :messages="$errors->get('variations.' . $index . '.price')" />
                                </div>
                                <button type="button" class="self-end mb-2 text-gray-400 transition-colors hover:text-red-500" onclick="removePrice(this)">
                                    <x-fas-trash-alt class="w-5 h-5" title="Supprimer la variation de prix" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <x-input-label name="status" value="Status" class="text-sm font-medium text-gray-700" />
                    <x-input-select name="status" :options="['available' => 'Disponible', 'unavailable' => 'Indisponible']" :selected="$product->status"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('status')" />
                </div>
            </div>

            <div class="flex gap-3 pt-4 mt-6 border-t">
                <button type="submit"
                    class="px-4 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Mettre à jour
                </button>
                <a href="{{ url()->previous() }}"
                    class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Annuler
                </a>
            </div>
        </form>
    </div>
    <script>
        function addIngredient() {
            const ingredientSelect = document.getElementById('ingredientSelect');
            const selectedIngredientId = ingredientSelect.value;
            const selectedIngredient = ingredientSelect.options[ingredientSelect.selectedIndex];

            if (document.querySelector(`input[name="ingredientsList[]"][value="${selectedIngredientId}"]`)) {
                return;
            }

            const ingredientListDiv = document.getElementById('ingredientList');
            const newIngredientDiv = document.createElement('div');
            newIngredientDiv.className = 'bg-blue-600 rounded text-gray-100 px-2 py-1 flex items-center';
            newIngredientDiv.innerHTML = `
                <span>${selectedIngredient.text}</span>
                <button type="button" class="ml-2 text-gray-100 hover:text-red-500" onclick="removeIngredient(${selectedIngredientId})">X</button>
                <input type="hidden" name="ingredientsList[]" value="${selectedIngredientId}">
            `;
            ingredientListDiv.appendChild(newIngredientDiv);
        }

        function removeIngredient(ingredientId) {
            const ingredientElement = document.querySelector(`input[name="ingredientsList[]"][value="${ingredientId}"]`);
            ingredientElement.parentNode.remove();
        }

        function addPrice() {
            const pricesList = document.getElementById('pricesList');
            const priceEntry = document.querySelector('.price-entry').cloneNode(true);
            const index = pricesList.children.length;

            // Update names to maintain array structure
            priceEntry.querySelector('select[name^="variations"]').name = `variations[${index}][size]`;
            priceEntry.querySelector('input[name^="variations"]').name = `variations[${index}][price]`;

            // Reset values
            priceEntry.querySelector('select[name^="variations"]').value = 'normal';
            priceEntry.querySelector('input[name^="variations"]').value = '';

            pricesList.appendChild(priceEntry);
        }

        function removePrice(button) {
            const pricesList = document.getElementById('pricesList');
            if (pricesList.children.length > 1) {
                button.closest('.price-entry').remove();
                // Reindex remaining prices
                const entries = pricesList.querySelectorAll('.price-entry');
                entries.forEach((entry, index) => {
                    entry.querySelector('select[name^="variations"]').name = `variations[${index}][size]`;
                    entry.querySelector('input[name^="variations"]').name = `variations[${index}][price]`;
                });
            }
        }
    </script>
</x-app-layout>
