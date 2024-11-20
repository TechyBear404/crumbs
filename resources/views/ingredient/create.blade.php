<x-app-layout>
    <div class="container max-w-4xl px-4 py-12 mx-auto sm:px-6 lg:px-8">
        <h1 class="mb-8 text-3xl font-bold text-gray-800">Créer un nouvel ingrédient</h1>

        <form action="{{ route('ingredients.store') }}" method="POST" class="p-6 bg-white border border-gray-100 rounded-lg shadow-lg">
            @csrf
            <input type="hidden" name="redirect_url" value="{{ $redirect_url }}">

            <div class="space-y-4">
                <div>
                    <x-input-label name="name" value="Nom" class="text-sm font-medium text-gray-700" />
                    <x-text-input name="name" :value="old('name')" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label name="description" value="Description" class="text-sm font-medium text-gray-700" />
                    <x-text-input name="description" :value="old('description')" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div>
                    <x-input-label name="isAllergen" value="Allergène" class="text-sm font-medium text-gray-700" />
                    <div class="flex gap-4 mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="isAllergen" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Oui</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="isAllergen" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                            <span class="ml-2 text-sm text-gray-700">Non</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('isAllergen')" />
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="px-4 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Créer
                </button>
                <a href="{{ $redirect_url }}" class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
