@props([
    'disabled' => false,
    'error' => false,
    'label' => null,
    'helpText' => null,
])

@php
    $classes = 'w-full rounded-lg border bg-white px-4 py-3 text-gray-900 shadow-sm transition duration-200 focus-visible:outline-none dark:bg-gray-800 dark:text-gray-100';
    $classes .= $error
        ? ' border-red-600 focus-visible:border-red-600 focus-visible:ring-4 focus-visible:ring-red-600/15 dark:border-red-500'
        : ' border-gray-300 hover:border-brand-light focus-visible:border-brand-light focus-visible:ring-4 focus-visible:ring-brand-light/15 dark:border-gray-600 dark:hover:border-brand-light';
    $classes .= $disabled ? ' cursor-not-allowed opacity-60' : ' cursor-pointer';
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }}>
    @if ($label)
        <label for="{{ $attributes->get('id') }}" class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-100">
            {{ $label }}
        </label>
    @endif

    <input type="date" {{ $disabled ? 'disabled' : '' }} {!! $attributes->except('class')->merge(['class' => $classes]) !!}>

    @if ($helpText)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @if ($error)
        <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ is_string($error) ? $error : 'Tanggal wajib diisi.' }}</p>
    @endif
</div>
