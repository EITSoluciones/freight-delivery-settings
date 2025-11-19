@props(['type' => 'success', 'message'])

@php
    $isVisible = $message && in_array($type, ['success', 'danger', 'warning']);

    $wrapperClasses = [
        'success' => 'text-fg-success bg-success-soft',
        'danger' => 'text-fg-danger bg-danger-soft',
        'warning' => 'text-fg-warning bg-warning-soft',
    ];

    $icon = [
        'success' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>',
        'danger' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>',
        'warning' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>',
    ];

    $toastId = 'toast-' . $type;
@endphp

@if ($isVisible)
    <div id="{{ $toastId }}"
        class="flex items-center w-full max-w-sm p-4 text-body bg-neutral-primary-soft rounded-base shadow-xs border border-default fixed top-5 right-5 z-50"
        role="alert">
        <div
            class="inline-flex items-center justify-center shrink-0 w-7 h-7 rounded {{ $wrapperClasses[$type] ?? '' }}">
            {!! $icon[$type] ?? '' !!}
            <span class="sr-only">{{ ucfirst($type) }} icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ $message }}</div>
        <button type="button"
            class="ms-auto flex items-center justify-center text-body hover:text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded text-sm h-8 w-8 focus:outline-none"
            data-dismiss-target="#{{ $toastId }}" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18 17.94 6M18 18 6.06 6" />
            </svg>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const toast = document.getElementById('{{ $toastId }}');
                if (toast) {
                    toast.style.display = 'none';
                }
            }, 5000); // 5 seconds
        });
    </script>
@endif
