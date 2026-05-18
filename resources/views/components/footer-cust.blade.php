<footer class="w-full bg-white pt-12 pb-8 border-t border-slate-100">
    <div class="mx-auto px-4 md:px-8 flex flex-col gap-8 md:gap-10">

        <!-- Baris Atas: Logo & Navigasi -->
        <!-- Mobile: Stack ke bawah & tengah | Tablet/Desktop: Kiri-Kanan -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-0">
            <!-- Logo -->
            <a href="#" class="flex-shrink-0">
                <img class="h-8 md:h-10 w-auto drop-shadow-sm" src="{{ asset('storage/images/logo mex.png') }}"
                    alt="MEX Berlian Dirgantara" />
            </a>

            <!-- Menu Navigasi -->
            <!-- Ditambahkan gap-y-3 agar jika layar sangat kecil dan menu turun baris, jarak atas-bawahnya tetap rapi -->
            <nav
                class="flex flex-wrap justify-center md:justify-end gap-x-6 gap-y-3 text-black text-sm md:text-base font-normal font-['Poppins']">
                <a href="#beranda" class="hover:text-red transition-colors duration-200">Beranda</a>
                <a href="#tentang" class="hover:text-red transition-colors duration-200">Tentang</a>
                <a href="#layanan" class="hover:text-red transition-colors duration-200">Layanan</a>
                <a href="#tracking" class="hover:text-red transition-colors duration-200">Tracking</a>
                <a href="#faq" class="hover:text-red transition-colors duration-200">FAQ</a>
            </nav>
        </div>

        <!-- Baris Tengah: Info Kontak & Sosial Media -->
        <div
            class="flex flex-col lg:flex-row justify-between items-center lg:items-start gap-8 py-8 border-y border-slate-200">

            <!-- Info Kontak (Menggunakan Grid) -->
            <!-- Mobile: 1 Kolom terpusat | Tablet: 2 Kolom rapi | Desktop: Flex Baris -->
            <div
                class="w-full lg:w-auto grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-row gap-6 lg:gap-8 justify-items-center sm:justify-items-start">

                <!-- Alamat 1 -->
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <div
                        class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-black shrink-0">
                        <i class="ri-map-pin-2-fill text-xl"></i>
                    </div>
                    <span
                        class="text-black text-sm md:text-base font-normal font-['Poppins'] text-center sm:text-left">Jalan
                        Merdeka</span>
                </div>

                <!-- Alamat 2 (Bandara) -->
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <div
                        class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-black shrink-0">
                        <i class="ri-building-4-fill text-xl"></i>
                    </div>
                    <span
                        class="text-black text-sm md:text-base font-normal font-['Poppins'] text-center sm:text-left">Operasional
                        Bandara Supadio</span>
                </div>

                <!-- Email -->
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <div
                        class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-black shrink-0">
                        <i class="ri-mail-fill text-xl"></i>
                    </div>
                    <span
                        class="text-black text-sm md:text-base font-normal font-['Poppins'] text-center sm:text-left">MEXCargo@gmail.com</span>
                </div>

                <!-- Telepon -->
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <div
                        class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-black shrink-0">
                        <i class="ri-phone-fill text-xl"></i>
                    </div>
                    <span
                        class="text-black text-sm md:text-base font-normal font-['Poppins'] text-center sm:text-left">+62
                        8120-1200-1201</span>
                </div>
            </div>

            <!-- Sosial Media Icons -->
            <!-- Diberikan garis batas atas (border-t) khusus di tampilan mobile agar terpisah dari info kontak -->
            <div
                class="flex items-center justify-center gap-4 shrink-0 mt-2 lg:mt-0 w-full lg:w-auto border-t sm:border-t-0 border-slate-100 pt-6 sm:pt-0">
                <a href="#"
                    class="w-10 h-10 rounded-full bg-slate-100 hover:bg-blue hover:text-white flex items-center justify-center text-slate-600 transition-all duration-200">
                    <i class="ri-instagram-line text-xl"></i>
                </a>
                <a href="#"
                    class="w-10 h-10 rounded-full bg-slate-100 hover:bg-blue hover:text-white flex items-center justify-center text-slate-600 transition-all duration-200">
                    <i class="ri-facebook-circle-fill text-xl"></i>
                </a>
            </div>
        </div>

        <!-- Baris Bawah: Copyright & Legal Links -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">

            <!-- Copyright (Di mobile, urutan ini dipindah ke bawah menggunakan order-2) -->
            <div
                class="order-2 md:order-1 flex items-center justify-center md:justify-start gap-2 text-slate-500 text-sm md:text-base font-normal font-['Poppins'] w-full md:w-auto mt-2 md:mt-0">
                <i class="ri-copyright-line text-lg"></i>
                <span>2025 MEX Berlian Dirgantara. All rights reserved.</span>
            </div>

            <!-- Legal Links (Di mobile, urutan ini naik ke atas menggunakan order-1) -->
            <div
                class="order-1 md:order-2 flex flex-wrap justify-center md:justify-end items-center gap-4 md:gap-6 text-slate-500 text-sm md:text-base font-normal font-['Poppins'] w-full md:w-auto">
                <a href="#" class="hover:text-black transition-colors duration-200">Privacy Statement</a>
                <a href="#" class="hover:text-black transition-colors duration-200">Terms of Services</a>
                <a href="#" class="hover:text-black transition-colors duration-200">Accessibility</a>
            </div>
        </div>

    </div>
</footer>