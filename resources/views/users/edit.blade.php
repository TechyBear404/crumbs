{{-- edit for to change user values --}}
<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Modifier l'Utilisateur</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Nom</label>
                <input type="text" name="name" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ $user->name }}">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ $user->email }}">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Rôle</label>
                <select name="role" class="w-full border border-gray-300 px-3 py-2">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                </select>
                @error('role')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Mettre à jour</button>
            <button type="button" class="bg-red-500 text-white px-4 py-2">
                <a href="{{ url()->previous() }}">Annuler</a>
            </button>
        </form>
    </div>
</x-app-layout>
{{-- <x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Créer un Nouvel Utilisateur</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Nom</label>
                <input type="text" name="name" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 px-3 py-2"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Mot de passe</label>
                <input type="password" name="password" class="w-full border border-gray-300 px-3 py-2">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Rôle</label>
                <select name="role" class="w-full border border-gray-300 px-3 py-2">
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                    <option value="manager">Manager</option>
                </select>
                @error('role')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Créer</button>
        </form>
    </div>
</x-app-layout> --}}
