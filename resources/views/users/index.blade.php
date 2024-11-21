<x-app-layout>
    <div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Liste des Utilisateurs
                </h2>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                    <a href="{{ route('users.create') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700">
                        <x-fas-user-plus class="w-4 h-4 mr-2" />
                        Ajouter un utilisateur
                    </a>
                @endif
            </div>
        </x-slot>

        <div class="mt-8 overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Nom</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Email</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Rôle</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Statut</th>
                            <th
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr class="transition-colors hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->status === 'actif' ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                        {{ $user->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('users.show', $user->id) }}"
                                            class="p-1.5 text-blue-600 transition-colors duration-200 rounded-lg hover:bg-blue-100">
                                            <x-fas-user class="w-4 h-4" title="Afficher l'utilisateur" />
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="text-orange-500 transition-colors duration-200 p-1.5 rounded-lg hover:bg-orange-100">
                                            <x-fas-edit class="w-4 h-4" title="Editer l'utilisateur" />
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 transition-colors p-1.5 duration-200 rounded-lg hover:bg-red-100">
                                                <x-fas-trash-alt class="w-4 h-4" title="Supprimer l'utilisateur" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
