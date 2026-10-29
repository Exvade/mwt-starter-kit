@props([
    'lines' => 3,
    'avatar' => false,
])

<div {{ $attributes->merge(['class' => 'animate-pulse space-y-3']) }} role="status" aria-label="Memuat konten">
    @if ($avatar)
        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700"></div>
    @endif

    @for ($line = 0; $line < $lines; $line++)
        <div class="h-4 rounded bg-gray-200 dark:bg-gray-700 {{ $line === $lines - 1 ? 'w-2/3' : 'w-full' }}"></div>
    @endfor

    <span class="sr-only">Memuat konten</span>
</div>
