@props(['status'])

@php
    $statusValue = $status->value ?? $status;
    $badgeStyle = match($statusValue) {
        'New' => 'background-color: #6c757d; color: #fff;',
        'Cold' => 'background-color: #0dcaf0; color: #000;',
        'Warm' => 'background-color: #ffc107; color: #000;',
        'Hot' => 'background-color: #dc3545; color: #fff;',
        'Deal' => 'background-color: #198754; color: #fff;',
        default => 'background-color: #6c757d; color: #fff;',
    };
@endphp

<span class="badge" style="{{ $badgeStyle }}">{{ $statusValue }}</span>
