@props([
    'label',             // Teks label kecil di atas (contoh: 'Tentang Kami')
    'title',             // Judul utama yang besar
    'description' => '', // Deskripsi di bawah judul (dibuat opsional dengan default kosong)
])

<div class="flex flex-col items-start lg:items-center text-left lg:text-center gap-4">
    <!-- Label -->
    <div class="inline-flex items-center gap-3">
        <div class="w-5 h-5 bg-red rounded-full shadow-sm"></div>
        <h2 class="text-black text-base md:text-xl font-normal font-['Poppins']">
            {{ $label }}
        </h2>
    </div>

    <!-- Judul Utama -->
    <h3 class="text-black text-xl md:text-2xl lg:text-3xl font-medium font-['Poppins'] leading-tight lg:leading-[1.2]">
        {{ $title }}
    </h3>

    <!-- Deskripsi (Hanya dirender jika parameter deskripsi diisi) -->
    @if($description)
        <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed max-w-4xl mt-2 text-justify lg:text-center">
            {{ $description }}
        </p>
    @endif
</div>