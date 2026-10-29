@props(['paginator'])

@if ($paginator->hasPages())
    <nav {{ $attributes->merge(['class' => 'flex flex-col gap-3 border-t border-gray-200 pt-4 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between']) }} aria-label="Navigasi halaman">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </p>

        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-400 dark:border-gray-700" aria-disabled="true">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-brand-light hover:text-brand-dark dark:border-gray-700 dark:text-gray-300 dark:hover:text-brand-light" rel="prev" aria-label="Halaman sebelumnya">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
                </a>
            @endif

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 1), min($paginator->lastPage(), $paginator->currentPage() + 1)) as $page => $url)
                @if ($page === $paginator->currentPage())
                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-brand-dark px-2 text-sm font-semibold text-white" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg px-2 text-sm font-medium text-gray-600 transition hover:bg-brand-surface hover:text-brand-dark dark:text-gray-300 dark:hover:bg-brand-dark/30 dark:hover:text-brand-light">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-brand-light hover:text-brand-dark dark:border-gray-700 dark:text-gray-300 dark:hover:text-brand-light" rel="next" aria-label="Halaman berikutnya">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" /></svg>
                </a>
            @else
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-400 dark:border-gray-700" aria-disabled="true">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" /></svg>
                </span>
            @endif
        </div>
    </nav>
@endif
