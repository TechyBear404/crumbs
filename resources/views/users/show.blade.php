<x-app-layout>
    <div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Profil de {{ $user->name }}
                    </h2>
                    <span
                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->status === 'actif' ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                        {{ $user->status }}
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('users.edit', $user->id) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-orange-500 rounded-md hover:bg-orange-600">
                        <x-fas-edit class="w-4 h-4 mr-2" />
                        Modifier
                    </a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-md hover:bg-red-700">
                            <x-fas-trash-alt class="w-4 h-4 mr-2" />
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </x-slot>

        <div class="grid gap-6 mt-8 md:grid-cols-3">
            <!-- Informations principales -->
            <div class="md:col-span-2">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Informations de l'utilisateur</h3>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nom complet</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Rôle</p>
                                <span
                                    class="inline-flex px-2 py-1 mt-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                    {{ $user->role }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date d'inscription</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="md:col-span-1">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Statistiques</h3>
                        <div class="space-y-4">
                            <div class="p-4 rounded-lg bg-gray-50">
                                <p class="text-sm font-medium text-gray-500">Dernière connexion</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->last_login ?? 'Jamais' }}</p>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <p class="text-sm font-medium text-gray-500">Nombre de connexions</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->login_count ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('users.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                <x-fas-arrow-left class="w-4 h-4 mr-2" />
                Retour à la liste
            </a>
        </div>
    </div>
</x-app-layout>
