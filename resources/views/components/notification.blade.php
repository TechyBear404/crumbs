@if (session()->has('success'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-300"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed z-50 px-4 py-2 text-white bg-green-500 rounded-lg shadow-lg bottom-4 right-4">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error') || $errors->any())
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-300"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="translate-x-full opacity-0"
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed z-50 px-4 py-2 text-white bg-red-500 rounded-lg shadow-lg bottom-4 right-4">
        {{ session('error') ?? $errors->first() }}
    </div>
@endif
