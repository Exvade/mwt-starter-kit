@props([
    'name',
    'show' => false,
    'position' => 'right',
    'title' => null,
])

@php
    $positionClasses = $position === 'left' ? 'left-0' : 'right-0';
    $hiddenTransform = $position === 'left' ? '-translate-x-full' : 'translate-x-full';
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-cloak
    @open-drawer.window="if ($event.detail === '{{ $name }}') show = true"
    @close-drawer.window="if ($event.detail === '{{ $name }}') show = false"
    @keydown.escape.window="show = false"
    class="relative z-50"
    aria-labelledby="drawer-{{ $name }}-title"
    role="dialog"
    aria-modal="true"
>
    <div x-show="show" x-transition.opacity class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm" @click="show = false"></div>

    <section
        x-show="show"
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="{{ $hiddenTransform }}"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="{{ $hiddenTransform }}"
        class="fixed inset-y-0 {{ $positionClasses }} flex w-full max-w-md flex-col bg-white shadow-2xl dark:bg-gray-900"
    >
        <header class="flex items-center justify-between gap-4 border-b border-gray-200 px-5 py-4 dark:border-gray-700 sm:px-6">
            <div>
                @if ($title)
                    <h2 id="drawer-{{ $name }}-title" class="font-heading text-lg font-bold text-gray-900 dark:text-white">{{ $title }}</h2>
                @endif
                @isset($header)
                    {{ $header }}
                @endisset
            </div>
            <button type="button" @click="show = false" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-brand-light/20 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white" aria-label="Tutup panel">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 18 12-12M6 6l12 12" /></svg>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-5 sm:p-6">{{ $slot }}</div>

        @isset($footer)
            <footer class="border-t border-gray-200 p-5 dark:border-gray-700 sm:p-6">{{ $footer }}</footer>
        @endisset
    </section>
</div>
