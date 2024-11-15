<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="flex gap-2 items-center mb-6">
            <h1 class="text-2xl font-bold mb">Liste des Utilisateurs</h1>
            <a href="{{ route('users.create') }}" class="text-blue-500 text-xl">+</a>
        </div>

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
                            <a href="{{ route('users.show', $user->id) }}" class="text-blue-500">Voir</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 ml-2">Modifier</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Supprimer</button>
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