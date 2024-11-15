<x-app-layout>
    <div class="container mx-auto py-8 m-4">
        <h1 class="text-2xl font-bold mb-6">Créer un nouveau produit</h1>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <x-input-label name="name" value="Nom" />
                <x-text-input name="name" :value="old('name')" />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div class="mb-4">
                <x-input-label name="description" value="Description" />
                <x-text-input name="description" :value="old('description')" />
                <x-input-error :messages="$errors->get('description')" />
            </div>
            <div class="mb-4">
                <div class="flex gap-2 items-center mb-2">
                    <x-input-label name="catid" value="Catégorie" />
                    <a href="{{ route('categories.create', ['redirect_url' => route('products.create')]) }}"
                        class="text-blue-500 ">+</a>
                </div>
                <x-input-select-dynamic name="catid" :options="$categories" />
                <x-input-error :messages="$errors->get('catid')" />
            </div>
            <div class="mb-4">
                <div class="flex gap-2 items-center mb-2">
                    <x-input-label name="status" value="Statut" />
                    <a href="{{ route('ingredients.create', ['redirect_url' => route('products.create')]) }}"
                        class="text-blue-500 ">+</a>
                </div>
                <div class="flex gap-2 items-center mb-2">
                    <x-input-select-dynamic id="ingredientSelect" name="status" :options="$ingredients" />
                    <button type="button" class="bg-blue-500 text-white px-4 py-2" onclick="addIngredient()">+</button>
                </div>
                <div id="ingredientList" class="flex flex-wrap gap-2">
                    @if (old('ingredientsList'))
                        @foreach (old('ingredientsList') as $ingredientId)
                            @foreach ($ingredients as $ingredient)
                                @if ($ingredient->id == $ingredientId)
                                    <div class="bg-blue-600 rounded text-gray-100 px-2 py-1 flex items-center">
                                        <span>{{ $ingredient->name }}</span>
                                        <button type="button" class="text-gray-100 ml-2 hover:text-red-500"
                                            onclick="removeIngredient({{ $ingredient->id }})">X</button>
                                        <input type="hidden" name="ingredientsList[]" value="{{ $ingredient->id }}">
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </div>
                <x-input-error :messages="$errors->get('ingredientsList')" />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Créer</button>
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

            // Vérifier si l'ingrédient est déjà dans la liste
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
            // Trouver l'élément correspondant à l'ingrédient à supprimer
            const ingredientElement = document.querySelector(`input[name="ingredientsList[]"][value="${ingredientId}"]`);
            // Supprimer l'élément du DOM
            ingredientElement.parentNode.remove();
        }
    </script>
</x-app-layout>
