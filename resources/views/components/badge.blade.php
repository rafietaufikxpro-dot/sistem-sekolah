@props([
    'status' => 'menunggu',
])

@php
$classes = match(strtolower($status)) {
    'menunggu' => 'bg-amber-100 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400 border border-amber-600/20',
    'disetujui' => 'bg-green-100 text-green-700 dark:bg-green-950/60 dark:text-green-400 border border-green-700/20',
    'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-950/60 dark:text-red-400 border border-red-700/20',
    default => 'bg-ink-100 text-ink-700 dark:bg-ink-900 dark:text-ink-300',
};
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize ' . $classes]) }}>
    {{ $status }}
</span>
