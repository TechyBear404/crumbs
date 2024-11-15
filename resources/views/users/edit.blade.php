<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Modifier l'Utilisateur</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-input-label name="name" value="Nom" />
                <x-text-input name="name" :value="old('name', $user->name)" />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div class="mb-4">
                <x-input-label name="email" value="Email" />
                <x-text-input type="email" name="email" :value="old('email', $user->email)" />
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="mb-4">
                <x-input-label name="password" value="Mot de passe" />
                <x-text-input type="password" name="password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>
            <div class="mb-4">
                <x-input-label name="passwordConfirmation" value="Confirmer le mot de passe" />
                <x-text-input type="password" name="passwordConfirmation" />
                <x-input-error :messages="$errors->get('passwordConfirmation')" />
            </div>
            <div class="mb-4">
                <x-input-label name="role" value="Rôle" />
                <x-input-select name="role" :options="['user' => 'Utilisateur', 'admin' => 'Administrateur', 'manager' => 'Manager']" :selected="$user->role" />
                <x-input-error :messages="$errors->get('role')" />
            </div>
            <div class="mb-4">
                <x-input-label name="status" value="Statut" />
                <x-input-select name="status" :options="['active' => 'Actif', 'inactive' => 'Inactif']" :selected="$user->status" />
                <x-input-error :messages="$errors->get('status')" />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Mettre à jour</button>
            <button type="button" class="bg-red-500 text-white px-4 py-2">
                <a href="{{ url()->previous() }}">Annuler</a>
            </button>
        </form>
    </div>
</x-app-layout>
