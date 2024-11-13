<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer un ingrédients
        </h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('ingredients.store') }}" method="POST">
            @csrf
            <input type="hidden" name="redirect_url" value="{{ $redirect_url }}">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Nom</label>
                <input type="text" name="name" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Description</label>
                <input type="text" name="description" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ old('description') }}">
                @error('description')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            {{-- add isAllergen radio button --}}
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Allergène</label>
                <div class="flex gap-2">
                    <label class="flex items
                    -center">
                        <input type="radio" name="isAllergen" value="1" class="mr-2">
                        <span>Oui</span>
                    </label>
                    <label class="flex items
                    -center">
                        <input type="radio" name="isAllergen" value="0" class="mr-2">
                        <span>Non</span>
                    </label>
                </div>
                @error('isAllergen')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Créer</button>
            {{-- cancel button --}}
            <button type="button" class="bg-red-500 text-white px-4 py-2">
                <a href="{{ url()->previous() }}">Annuler</a>
            </button>
        </form>
    </div>
</x-app-layout>
