<x-app-layout>
    <x-slot name="header">
        <div class="flex gap-2 items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('products.create') }}" class="text-blue-500 text-xl">+</a>
        </div>
    </x-slot>

    <table class="w-full">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Category</th>
                <th>Description</th>
                <th>Ingredients</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->description }}</td>
                    {{-- <td>{{ $product->ingredients() }}</td> --}}
                    <td>
                        @foreach ($product->ingredients as $ingredient)
                            <span
                                class="bg-blue-600 rounded-full text-gray-100 px-2 py-0.5 text-sm">{{ $ingredient->name }}</span>
                        @endforeach
                    </td>
                    {{-- add edit and delete buttons --}}
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                        <td class="flex gap-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500">Edit</a>
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
</x-app-layout>
