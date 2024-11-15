<x-app-layout>
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-400">← Back</a>
        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 mt-4">
            <h2 class="text-lg font-semibold mb-2">{{ $product->name }}</h2>
            <p class="text-gray-700 mb-2"><strong>Statut:</strong> {{ $product->status }}</p>
            <p class="text-gray-700 mb-2"><strong>Catégorie:</strong> {{ $product->category->name }}</p>
            <p class="text-gray-700 mb-2"><strong>Description:</strong> {{ $product->description }}</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($product->ingredients as $ingredient)
                    <span
                        class="bg-blue-600 rounded-full text-gray-100 px-2 py-0.5 text-sm">{{ $ingredient->name }}</span>
                @endforeach
            </div>
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



    </div>
</x-app-layout>
