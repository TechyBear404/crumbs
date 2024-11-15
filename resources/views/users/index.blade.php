<x-app-layout>
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <x-slot name="header">
            <div class="flex gap-2 items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Liste des Utilisateurs
                </h2>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                    <a href="{{ route('users.create') }}" class="text-blue-500 text-xl"><x-fas-user-plus
                            class="w-5 h-5" /></a>
                @endif
            </div>
        </x-slot>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nom</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Rôle</th>
                    <th class="py-2 px-4 border-b">Statut</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->role }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->status }}</td>
                        <td class="py-2 px-4 border-b flex gap-2 justify-center">
                            <a href="{{ route('users.show', $user->id) }}" class="text-blue-500"><x-fas-user
                                    class="w-5 h-5" title="Afficher l'utilisateur" /></a>
                            <a href="{{ route('users.edit', $user->id) }}" class="text-orange-400 ml-2"><x-fas-edit
                                    class="w-5 h-5" title="Editer l'utilisateur" /></a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500"><x-fas-trash-alt class="w-5 h-5"
                                        title="Supprimer l'utilisateur" /></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
