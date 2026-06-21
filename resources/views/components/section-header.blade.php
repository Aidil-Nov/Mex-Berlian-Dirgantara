@props([
    'icon' => null,      // Dibuat opsional dengan default null
    'label',             // Teks label kecil di atas (contoh: 'Tentang Kami')
    'title',             // Judul utama yang besar
    'description' => ''  // Deskripsi di bawah judul (opsional)
])

<div class="flex flex-col items-start lg:items-center text-left lg:text-center gap-4">
    
    <div class="inline-flex items-center gap-3">
        
        @if($icon)
            <i class="{{ $icon }} text-red text-xl md:text-2xl"></i>
        @else
            <div class="w-5 h-5 bg-red rounded-sm shadow-sm shrink-0"></div>
        @endif
        
        <h2 class="text-black text-base md:text-xl font-normal font-['Poppins']">
            {{ $label }}
        </h2>
        
    </div>

    <h3 class="text-black text-xl md:text-2xl lg:text-3xl font-medium font-['Poppins'] leading-tight lg:leading-[1.2]">
        {{ $title }}
    </h3>

    @if($description)
        <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed max-w-4xl mt-2 text-justify lg:text-center">
            {{ $description }}
        </p>
    @endif
    
</div>