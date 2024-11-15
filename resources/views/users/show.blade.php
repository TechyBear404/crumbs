<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Détails de l'Utilisateur</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <div class="flex flex-row mb-4">
                <h2 class="text-lg font-semibold basis-1/4">Nom</h2>
                <p class="">{{ $user->name }}</p>
            </div>
            <div class="flex mb-4">
                <h2 class="text-lg font-semibold basis-1/4">Email</h2>
                <p class="">{{ $user->email }}</p>
            </div>
            <div class="flex mb-4">
                <h2 class="text-lg font-semibold basis-1/4">Rôle</h2>
                <p class="">{{ $user->role }}</p>
            </div>
            <div class="flex mb-4">
                <h2 class="text-lg font-semibold basis-1/4">Statut</h2>
                <p class="">{{ $user->status }}</p>
            </div>
            <div class="flex mb-4">
                <h2 class="text-lg font-semibold basis-1/4">Créé le</h2>
                <p class="">{{ $user->created_at }}</p>
            </div>
            @if ($user->created_at != $user->updated_at)
                <div class="flex mb-4">
                    <h2 class="text-lg font-semibold basis-1/4">Mis à jour le</h2>
                    <p class="">{{ $user->updated_at }}</p>
                </div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('users.index') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600">Retour à la liste</a>
        </div>
    </div>
</x-app-layout>
