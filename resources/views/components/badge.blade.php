@props(['variant' => 'default'])

@php
    $classes = [
        'default' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
        'success' => 'bg-brand-surface text-brand-dark dark:bg-brand-dark/30 dark:text-brand-light',
        'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
        'danger' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
        'info' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
    ][$variant] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold $classes"]) }}>
    {{ $slot }}
</span>
