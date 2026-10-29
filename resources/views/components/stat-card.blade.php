@props([
    'label',
    'value',
    'description' => null,
    'trend' => null,
    'trendDirection' => 'up',
])

@php
    $trendClasses = $trendDirection === 'down'
        ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-300'
        : 'bg-brand-surface text-brand-dark dark:bg-brand-dark/30 dark:text-brand-light';
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6']) }}>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
            <p class="mt-2 truncate font-heading text-3xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
        </div>

        @if (isset($icon))
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-surface text-brand-dark dark:bg-brand-dark/30 dark:text-brand-light">
                {{ $icon }}
            </div>
        @endif
    </div>

    @if ($trend || $description)
        <div class="mt-5 flex flex-wrap items-center gap-2 text-sm">
            @if ($trend)
                <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $trendClasses }}">
                    <svg class="h-3.5 w-3.5 {{ $trendDirection === 'down' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 15 7-7 7 7" />
                    </svg>
                    {{ $trend }}
                </span>
            @endif
            @if ($description)
                <span class="text-gray-500 dark:text-gray-400">{{ $description }}</span>
            @endif
        </div>
    @endif
</div>
