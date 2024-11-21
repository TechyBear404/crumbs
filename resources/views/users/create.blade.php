<x-app-layout>
    <div class="py-6">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                        Créer un Nouvel Utilisateur</h2>
                    <p class="mt-1 text-sm text-gray-500">Remplissez les informations pour créer un nouveau compte
                        utilisateur.</p>
                </div>
                <a href="{{ route('users.index') }}" class="flex items-center text-sm text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>

            <!-- Formulaire -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Informations de base -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Informations personnelles</h3>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label name="name" value="Nom complet" />
                                <x-text-input name="name" :value="old('name')" class="w-full mt-1" />
                                <x-input-error :messages="$errors->get('name')" />
                            </div>
                            <div>
                                <x-input-label name="email" value="Adresse email" />
                                <x-text-input type="email" name="email" :value="old('email')" class="w-full mt-1" />
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>
                    </div>

                    <!-- Sécurité -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Sécurité</h3>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label name="password" value="Mot de passe" />
                                <x-text-input type="password" name="password" class="w-full mt-1" />
                                <x-input-error :messages="$errors->get('password')" />
                            </div>
                            <div>
                                <x-input-label name="passwordConfirmation" value="Confirmation" />
                                <x-text-input type="password" name="passwordConfirmation" class="w-full mt-1" />
                                <x-input-error :messages="$errors->get('passwordConfirmation')" />
                            </div>
                        </div>
                    </div>

                    <!-- Paramètres du compte -->
                    <div class="p-4 rounded-lg bg-gray-50">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Paramètres du compte</h3>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label name="role" value="Rôle" />
                                <x-input-select name="role" :options="[
                                    'user' => 'Utilisateur',
                                    'admin' => 'Administrateur',
                                    'manager' => 'Manager',
                                ]" class="w-full mt-1" />
                                <x-input-error :messages="$errors->get('role')" />
                            </div>
                            <div>
                                <x-input-label name="status" value="Statut" />
                                <x-input-select name="status" :options="['active' => 'Actif', 'inactive' => 'Inactif']" class="w-full mt-1" />
                                <x-input-error :messages="$errors->get('status')" />
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ url()->previous() }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Créer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
