@props([
    'color' => 'blue',     // Pilihan: 'blue' atau 'red'
    'variant' => 'solid',  // Pilihan: 'solid' atau 'outline'
    'icon' => null,        // Class Remix Icon (contoh: 'ri-send-plane-fill')
    'href' => null,        // Jika diisi, akan otomatis menjadi tag <a>
    'type' => 'button'     // Tipe button (button, submit, reset)
])

@php
    // Class dasar yang selalu dipakai
    $baseClasses = "inline-flex items-center justify-center gap-3 px-4 py-2 text-sm font-normal font-['Poppins'] leading-7 rounded-full transition-colors duration-200";

    // Logika pemilihan warna dan varian
    if ($color === 'red') {
        if ($variant === 'solid') {
            $colorClasses = "bg-red hover:bg-redhover active:bg-redactive text-light shadow-md";
        } else {
            $colorClasses = "border border-red text-red hover:bg-red/10 active:bg-red/20 shadow-sm";
        }
    } else { // Default biru
        if ($variant === 'solid') {
            $colorClasses = "bg-blue hover:bg-bluehover active:bg-blueactive text-light shadow-md";
        } else {
            $colorClasses = "border border-blue text-blue hover:bg-blue/10 active:bg-blue/20 shadow-sm";
        }
    }

    // Gabungkan class
    $classes = $baseClasses . ' ' . $colorClasses;
@endphp

<!-- Render Tag <a> jika ada href -->
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }} text-xl"></i>
        @endif
        <span>{{ $slot }}</span>
    </a>
<!-- Render Tag <button> jika tidak ada href -->
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }} text-xl"></i>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif