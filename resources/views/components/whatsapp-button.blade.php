@props(['phone', 'message' => '', 'class' => 'btn-sm'])

@php
    $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);
    if (str_starts_with($normalizedPhone, '0')) {
        $normalizedPhone = '62' . substr($normalizedPhone, 1);
    } elseif (!str_starts_with($normalizedPhone, '62')) {
        $normalizedPhone = '62' . $normalizedPhone;
    }
    $url = "https://wa.me/{$normalizedPhone}";
    if ($message) {
        $url .= "?text=" . urlencode($message);
    }
@endphp

<a href="{{ $url }}"
   target="_blank"
   class="btn {{ $class }}"
   style="background-color: #25D366; border-color: #25D366; color: #fff;"
   title="Chat via WhatsApp">
    <i class="bi bi-whatsapp"></i>
    {{ $slot->isEmpty() ? '' : $slot }}
</a>
