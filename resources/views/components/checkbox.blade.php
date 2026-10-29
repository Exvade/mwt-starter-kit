@props([
    'label' => null,
    'description' => null,
    'checked' => false,
    'disabled' => false,
])

<label class="flex items-start gap-3 {{ $disabled ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}">
    <input type="checkbox" @checked($checked) @disabled($disabled) {!! $attributes->merge(['class' => 'mt-0.5 h-5 w-5 rounded border-gray-300 text-brand-dark focus:ring-4 focus:ring-brand-light/20 dark:border-gray-600 dark:bg-gray-800']) !!}>
    <span>
        @if ($label)
            <span class="block text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $label }}</span>
        @endif
        @if ($description)
            <span class="mt-1 block text-sm text-gray-500 dark:text-gray-400">{{ $description }}</span>
        @endif
    </span>
</label>
