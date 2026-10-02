@if (session('success'))
    <div class="fixed top-5 right-5 z-50 pointer-events-none">
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 3000)"
             class="pointer-events-auto bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg text-center" 
             role="alert">
            {{ session('success') }}
        </div>
    </div>
@endif