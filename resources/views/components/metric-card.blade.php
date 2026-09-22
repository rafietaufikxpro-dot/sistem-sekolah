@props([
    'label',
    'value',
    'sub' => null,
])

<x-card class="flex flex-col justify-between h-full min-h-[160px]">
    <div class="flex justify-between items-start mb-4">
        @if (isset($icon))
            <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600 flex-shrink-0">
                {{ $icon }}
            </div>
        @endif
    </div>
    
    <div>
        <p class="text-3xl font-semibold text-zinc-900 tracking-tight">{{ $value }}</p>
        <p class="mt-1 text-sm font-medium text-navy-700">{{ $label }}</p>
        @if ($sub)
            <p class="mt-1 text-xs text-navy-600">{{ $sub }}</p>
        @endif
    </div>
</x-card>
