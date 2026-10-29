@props([
    'disabled' => false,
    'error' => false,
    'label' => null,
    'helpText' => null,
    'placeholder' => 'Pilih opsi',
    'searchable' => false,
])

@php
    $inputClasses =
        'flex w-full items-center justify-between gap-3 rounded-lg border bg-white px-4 py-3 text-left text-gray-900 shadow-sm transition duration-200 focus-visible:outline-none dark:bg-gray-800 dark:text-gray-100';

    $inputClasses .= $error
        ? ' border-red-600 focus-visible:border-red-600 focus-visible:ring-4 focus-visible:ring-red-600/15 dark:border-red-500'
        : ' border-gray-300 hover:border-brand-light focus-visible:border-brand-light focus-visible:ring-4 focus-visible:ring-brand-light/15 dark:border-gray-600 dark:hover:border-brand-light';

    $inputClasses .= $disabled ? ' cursor-not-allowed opacity-60' : ' cursor-pointer';
@endphp

<div
    x-data="{
        open: false,
        search: '',
        selectedValue: '',
        selectedLabel: @js($placeholder),
        options: [],
        highlightedIndex: 0,
        init() {
            const select = this.$refs.nativeSelect;

            this.options = Array.from(select.options).map((option) => ({
                value: option.value,
                label: option.text,
                disabled: option.disabled,
            }));

            this.syncFromNativeSelect();
            select.addEventListener('change', () => this.syncFromNativeSelect());

            this.$watch('open', (isOpen) => {
                if (isOpen) {
                    this.search = '';
                    this.highlightedIndex = Math.max(this.selectableOptions.findIndex((option) => option.value === this.selectedValue), 0);
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                }
            });
        },
        get visibleOptions() {
            const keyword = this.search.trim().toLocaleLowerCase();

            return this.options.filter((option) => !keyword || option.label.toLocaleLowerCase().includes(keyword));
        },
        get selectableOptions() {
            return this.visibleOptions.filter((option) => !option.disabled);
        },
        syncFromNativeSelect() {
            const selectedOption = this.$refs.nativeSelect.options[this.$refs.nativeSelect.selectedIndex];
            this.selectedValue = selectedOption?.value ?? '';
            this.selectedLabel = selectedOption?.value ? selectedOption.text : @js($placeholder);
        },
        selectOption(option) {
            if (!option || option.disabled) {
                return;
            }

            const select = this.$refs.nativeSelect;
            select.value = option.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
            this.open = false;
            this.$refs.trigger.focus();
        },
        moveHighlight(direction) {
            const options = this.selectableOptions;

            if (!options.length) {
                return;
            }

            this.highlightedIndex = (this.highlightedIndex + direction + options.length) % options.length;
        },
        selectHighlightedOption() {
            const options = this.selectableOptions;
            this.selectOption(options[this.highlightedIndex]);
        },
        close() {
            this.open = false;
            this.search = '';
        },
    }"
    @click.outside="close()"
    @keydown.escape.window="close()"
    class="w-full"
>
    @if ($label)
        <label for="{{ $attributes->get('id') }}" class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-100">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select x-ref="nativeSelect" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'sr-only']) !!}>
            {{ $slot }}
        </select>

        <button
            x-ref="trigger"
            type="button"
            class="{{ $inputClasses }}"
            :aria-expanded="open"
            aria-haspopup="listbox"
            @click="!{{ $disabled ? 'true' : 'false' }} && (open = !open)"
            @keydown.arrow-down.prevent="open ? moveHighlight(1) : (open = true)"
            @keydown.arrow-up.prevent="open ? moveHighlight(-1) : (open = true)"
            @keydown.enter.prevent="open ? selectHighlightedOption() : (open = true)"
        >
            <span class="truncate" :class="selectedValue ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500'" x-text="selectedLabel"></span>
            <svg class="h-5 w-5 shrink-0 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180 text-brand-dark dark:text-brand-light': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
            </svg>
        </button>

        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="-translate-y-1 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-1 opacity-0"
            class="absolute z-50 mt-2 w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl shadow-gray-900/10 dark:border-gray-700 dark:bg-gray-800"
        >
            @if ($searchable)
                <div class="border-b border-gray-100 p-3 dark:border-gray-700">
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="6" />
                            <path stroke-linecap="round" d="m16 16 4 4" />
                        </svg>
                        <input x-ref="searchInput" x-model="search" type="search" placeholder="Cari opsi..." class="w-full rounded-lg border border-gray-200 bg-gray-50 py-2 pl-9 pr-3 text-sm text-gray-900 outline-none transition focus:border-brand-light focus:ring-4 focus:ring-brand-light/15 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" @keydown.arrow-down.prevent="moveHighlight(1)" @keydown.arrow-up.prevent="moveHighlight(-1)" @keydown.enter.prevent="selectHighlightedOption()">
                    </div>
                </div>
            @endif

            <ul class="max-h-64 overflow-y-auto p-1.5" role="listbox">
                <template x-for="option in visibleOptions" :key="option.value">
                    <li>
                        <button
                            type="button"
                            role="option"
                            :aria-selected="selectedValue === option.value"
                            :disabled="option.disabled"
                            @click="selectOption(option)"
                            @mouseenter="!option.disabled && (highlightedIndex = selectableOptions.indexOf(option))"
                            class="flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition"
                            :class="{
                                'bg-brand-surface text-brand-dark dark:bg-brand-dark/30 dark:text-brand-light': selectedValue === option.value,
                                'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-gray-100': highlightedIndex === selectableOptions.indexOf(option) && selectedValue !== option.value,
                                'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700': highlightedIndex !== selectableOptions.indexOf(option) && selectedValue !== option.value,
                                'cursor-not-allowed opacity-50': option.disabled,
                            }"
                        >
                            <span class="truncate" x-text="option.label"></span>
                            <svg x-show="selectedValue === option.value" class="h-4 w-4 shrink-0 text-brand-dark dark:text-brand-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        </button>
                    </li>
                </template>

                <li x-show="!visibleOptions.length" class="px-3 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    Opsi tidak ditemukan.
                </li>
            </ul>
        </div>
    </div>

    @if ($helpText)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @if ($error)
        <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ is_string($error) ? $error : 'Pilihan ini wajib diisi.' }}</p>
    @endif
</div>
