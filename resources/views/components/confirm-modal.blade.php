{{--
    Confirm Delete Modal
    Usage:
    <x-confirm-modal
        form-id="delete-form-{id}"
        action="url"
        title="Hapus Data?"
        message="Yakin ingin menghapus data ini?"
    />
--}}
@props([
    'formId',
    'action',
    'title' => 'Konfirmasi Hapus',
    'message' => 'Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
])

<span x-data="{ open: false }" @keydown.escape.window="open = false" class="inline-flex">
    {{-- Trigger Button --}}
    <button
        type="button"
        @click="open = true"
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 border border-red-700 text-red-700 hover:bg-red-100 focus:ring-red-500']) }}
    >
        {{ $slot->isEmpty() ? 'Hapus' : $slot }}
    </button>

    {{-- Hidden Form --}}
    <form id="{{ $formId }}" method="POST" action="{{ $action }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- Modal Overlay --}}
    <div
        x-show="open"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center px-4"
        style="display: none;"
    >
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-navy-900/50" @click="open = false"></div>

        {{-- Modal Box --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 z-10"
        >
            {{-- Icon --}}
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto mb-4">
                <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>

            {{-- Title & Message --}}
            <h3 class="text-base font-semibold text-navy-900 text-center mb-1">{{ $title }}</h3>
            <p class="text-sm text-navy-700 text-center mb-6">{{ $message }}</p>

            {{-- Actions --}}
            <div class="flex gap-3">
                <button
                    type="button"
                    @click="open = false"
                    class="flex-1 px-4 py-2 text-sm font-medium rounded-lg border border-navy-700 text-navy-700 hover:bg-navy-100 transition-colors"
                >
                    Batal
                </button>
                <button
                    type="button"
                    @click="open = false; document.getElementById('{{ $formId }}').submit()"
                    class="flex-1 px-4 py-2 text-sm font-medium rounded-lg bg-red-700 text-white hover:bg-red-800 transition-colors"
                >
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</span>
