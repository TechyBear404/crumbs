<x-app-layout>
    <div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-slot name="header">
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Liste des Utilisateurs
                </h2>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                    <a href="{{ route('users.create') }}" class="text-xl text-blue-500"><x-fas-user-plus
                            class="w-5 h-5" /></a>
                @endif
            </div>
        </x-slot>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Nom</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Rôle</th>
                    <th class="px-4 py-2 border-b">Statut</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->role }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->status }}</td>
                        <td class="flex justify-center gap-2 px-4 py-2 border-b">
                            <a href="{{ route('users.show', $user->id) }}" class="text-blue-500"><x-fas-user
                                    class="w-5 h-5" title="Afficher l'utilisateur" /></a>
                            <a href="{{ route('users.edit', $user->id) }}" class="ml-2 text-orange-400"><x-fas-edit
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
