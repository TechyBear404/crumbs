{{-- @props(['categories']) --}}

<div x-data="{ showFilter: false }" class="relative">
    <!-- Backdrop -->
    <div class="fixed inset-0 z-40 transition-opacity bg-black bg-opacity-25 md:hidden"
        x-show="showFilter"
        @click="showFilter = false"
        x-cloak></div>

    <!-- Filter Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-full max-w-xs overflow-hidden transition transform bg-white rounded-lg shadow-lg md:block md:static md:inset-y-auto md:left-auto md:w-72 md:transform-none md:transition-none"
        :class="{'translate-x-0': showFilter, '-translate-x-full': !showFilter}"
        @toggle-filter.window="showFilter = !showFilter"
        @click.outside="showFilter = false">
        <div class="h-full p-4 overflow-hidden bg-white sm:p-6">
            <div class="flex items-center justify-between mb-4 lg:block">
                <h3 class="text-base font-semibold text-gray-700 sm:text-lg">Rechercher</h3>
                <button class="p-2 text-gray-500 rounded-lg md:hidden hover:bg-gray-100"
                    x-on:click="showFilter = false">
                    <x-fas-times class="w-4 h-4" />
                </button>
            </div>

            <form id="filterForm" action="{{ route('products.index') }}" method="GET">
                <div class="mt-4 mb-6">
                    <x-input-label name="name" value="Nom" class="mb-2 text-gray-600" />
                    <x-text-input id="filterName" name="name" :value="old('name', request('name'))"
                        class="w-full transition-shadow duration-200 hover:shadow-sm focus:shadow-md" />
                </div>
                @if ($categories->count() > 0)
                    <div class="mb-6">
                        <h4 class="mb-3 font-medium text-gray-600">Catégories</h4>
                        <div class="space-y-2">
                            @foreach ($categories as $categorie)
                                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-500">
                                    <input type="checkbox" name="categoryId[]" value="{{ $categorie->id }}"
                                        class="w-4 h-4 text-blue-500 rounded focus:ring-blue-400"
                                        {{ in_array($categorie->id, request('categoryId', [])) ? 'checked' : '' }} />
                                    <span class="text-sm">{{ $categorie->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterForm = document.getElementById('filterForm');
        const filterName = document.getElementById('filterName');
        const categoryCheckboxes = document.querySelectorAll('input[name="categoryId[]"]');

        let timeout;
        filterName.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });

        categoryCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                filterForm.submit();
            });
        });
    });

    // This function is no longer needed as we're using Alpine.js
    // function closeFilter() {
    //     const sidebar = document.getElementById('filterSidebar');
    //     const overlay = document.getElementById('filterOverlay');

    //     sidebar.classList.add('translate-x-full');
    //     overlay.classList.add('hidden');
    //     document.body.classList.remove('overflow-hidden');
    // }
</script>
