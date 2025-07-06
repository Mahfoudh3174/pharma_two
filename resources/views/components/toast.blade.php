<div x-data="{ show: false, message: '', type: '' }"
    x-init="
        @if (session()->has('success'))
            show = true;
            message = '{{ session('success') }}';
            type = 'success';
            setTimeout(() => show = false, 3000);
        @endif
        @if (session()->has('error'))
            show = true;
            message = '{{ session('error') }}';
            type = 'error';
            setTimeout(() => show = false, 3000);
        @endif
        $watch('show', value => {
            if (value) {
                setTimeout(() => show = false, 3000);
            }
        });
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="fixed bottom-4 right-4 z-50 w-full max-w-xs rounded-lg shadow-lg p-4 text-white"
    :class="{
        'bg-green-500': type === 'success',
        'bg-red-500': type === 'error'
    }">
    <div class="flex items-center">
        <template x-if="type === 'success'">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </template>
        <template x-if="type === 'error'">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </template>
        <span x-text="message"></span>
    </div>
</div>
