<x-app-layout>
    <div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-6 text-2xl font-bold">Modifier le produit</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST"
            class="p-4 overflow-hidden bg-white border border-gray-200 rounded">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-input-label name="name" value="Nom" class="mb-1" />
                <x-text-input name="name" :value="old('name', $product->name)" />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div class="mb-4">
                <x-input-label name="description" value="Description" class="mb-1" />
                <x-text-input name="description" :value="old('description', $product->description)" />
                <x-input-error :messages="$errors->get('description')" />
            </div>
            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <x-input-label name="categoryId" value="Catégorie" />
                    <a href="{{ route('categories.create', ['redirect_url' => route('products.create')]) }}"
                        class="text-blue-500 ">+</a>
                </div>
                <x-input-select-dynamic name="categoryId" :options="$categories" :selected="$product->categoryId" />
                <x-input-error :messages="$errors->get('categoryId')" />
            </div>
            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <x-input-label name="status" value="Ingrédients" />
                    <a href="{{ route('ingredients.create', ['redirect_url' => route('products.edit', ['product' => $product->id])]) }}"
                        class="text-blue-500 ">+</a>
                </div>
                <div class="flex items-center gap-2 mb-2">
                    <x-input-select-dynamic id="ingredientSelect" name="status" :options="$ingredients" />
                    <button type="button" class="px-4 py-2 text-white bg-blue-500 rounded"
                        onclick="addIngredient()">+</button>
                </div>
                <div id="ingredientList" class="flex flex-wrap gap-2">
                    @foreach ($product->ingredients as $ingredient)
                        <div class="flex items-center px-2 py-1 text-gray-100 bg-blue-600 rounded">
                            <span>{{ $ingredient->name }}</span>
                            <button type="button" class="ml-2 text-gray-100 hover:text-red-500"
                                onclick="removeIngredient({{ $ingredient->id }})">X</button>
                            <input type="hidden" name="ingredientsList[]" value="{{ $ingredient->id }}">
                        </div>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('ingredientsList')" />
            </div>
            <div class="mb-6">
                <x-input-label name="status" value="Status" class="mb-1" />
                <x-input-select name="status" :options="['available' => 'Disponible', 'unavailable' => 'Indisponible']" :selected="$product->status" />
                <x-input-error :messages="$errors->get('status')" />
            </div>
            <div class="flex flex-col mb-4">
                <div class="flex items-center gap-2 mb-2">
                    <x-input-label name="prices" value="Prix" class="" />
                    <button type="button" class="text-xl text-blue-500" onclick="addPrice()">
                        +
                    </button>
                </div>
                <div id="pricesList" class="flex flex-col gap-2">
                    @foreach ($product->variations as $index => $variation)
                        <div class="flex gap-2 price-entry">
                            <div>
                                <x-input-label name="size" value="Taille" class="mb-1" />
                                <x-input-select name="variations[{{ $index }}][size]" :options="['normal' => 'Normal', 'large' => 'Grand']"
                                    :selected="$variation->name" />
                            </div>
                            <div>
                                <x-input-label name="price" value="Prix" class="mb-1" />
                                <x-text-input type="number" name="variations[{{ $index }}][price]"
                                    :value="$variation->price" />
                                <x-input-error :messages="$errors->get('variations.' . $index . '.price')" />
                            </div>
                            <button type="button" class="text-red-500 mt-7" onclick="removePrice(this)">
                                <x-fas-trash-alt class="w-5 h-5" title="Supprimer la variation de prix" />
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-2 pt-4">
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Mettre à jour</button>
                <button type="button" class="px-4 py-2 text-white bg-red-500 rounded">
                    <a href="{{ url()->previous() }}">Annuler</a>
                </button>
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
