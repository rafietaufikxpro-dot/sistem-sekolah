@props([
    'variant' => 'primary',
    'type' => 'button',
])

@php
$baseClasses = 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
    'primary' => 'bg-navy-700 hover:bg-navy-900 text-white focus:ring-navy-600',
    'ghost' => 'bg-transparent text-navy-700 border border-navy-700 hover:bg-navy-100 hover:text-navy-900 focus:ring-navy-600',
    'danger' => 'border border-red-700 text-red-700 hover:bg-red-100 focus:ring-red-500',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
