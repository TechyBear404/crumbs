<x-app-layout>
    <div class="container mx-auto py-8 m-4">
        <h1 class="text-2xl font-bold mb-6">Modifier le produit</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Nom</label>
                <input type="text" name="name" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Description</label>
                <input type="text" name="description" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ old('description', $product->description) }}">
                @error('description')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <div class="flex gap-2 items-center mb-2">
                    <label class="block text-sm font-bold">Catégorie</label>
                    <a href="{{ route('categories.create', ['redirect_url' => route('products.create')]) }}"
                        class="text-blue-500 ">+</a>
                </div>
                <select name="catid" class="w-full border border-gray-300 px-3 py-2">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->catid == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('catid')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <div class="flex gap-2 items-center mb-2">
                    <label class="block text-sm font-bold">Ingrédients</label>
                    <a href="{{ route('ingredients.create', ['redirect_url' => route('products.edit', ['product' => $product->id])]) }}"
                        class="text-blue-500 ">+</a>
                </div>
                <div class="flex gap-2 items-center mb-2">
                    <select id="ingredientSelect" class="flex-1">
                        @foreach ($ingredients as $ingredient)
                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="bg-blue-500 text-white px-4 py-2" onclick="addIngredient()">+</button>
                </div>
                <div id="ingredientList" class="flex flex-wrap gap-2">
                    @foreach ($product->ingredients as $ingredient)
                        <div class="bg-blue-600 rounded text-gray-100 px-2 py-1 flex items-center">
                            <span>{{ $ingredient->name }}</span>
                            <button type="button" class="text-gray-100 ml-2 hover:text-red-500"
                                onclick="removeIngredient({{ $ingredient->id }})">X</button>
                            <input type="hidden" name="ingredientsList[]" value="{{ $ingredient->id }}">
                        </div>
                    @endforeach
                </div>
                @error('ingredients')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Mettre à jour</button>
            <button type="button" class="bg-red-500 text-white px-4 py-2">
                <a href="{{ url()->previous() }}">Annuler</a>
            </button>
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
                <button type="button" class="text-gray-100 ml-2 hover:text-red-500" onclick="removeIngredient(${selectedIngredientId})">X</button>
                <input type="hidden" name="ingredientsList[]" value="${selectedIngredientId}">
            `;
            ingredientListDiv.appendChild(newIngredientDiv);
        }

        function removeIngredient(ingredientId) {
            const ingredientElement = document.querySelector(`input[name="ingredientsList[]"][value="${ingredientId}"]`);
            ingredientElement.parentNode.remove();
        }
    </script>
</x-app-layout>
