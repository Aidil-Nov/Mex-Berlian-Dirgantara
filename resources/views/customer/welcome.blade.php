@extends('layouts.frontend')

@section('content')

    <section class="w-full mx-auto px-4 py-8 md:px-8 flex flex-col items-center" id="beranda">
        <h1 data-aos="fade-down" data-aos-duration="1000"
            class="text-center text-black text-4xl md:text-6xl lg:text-[96px] font-medium font-['Poppins'] leading-tight lg:leading-[1.1] mb-8 md:mb-12 ">
            Solusi Terintegrasi Pengiriman
        </h1>

        <div data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
            class="relative w-full min-h-[500px] lg:min-h-[600px] rounded-[32px] shadow-lg flex flex-col justify-end p-4 md:p-6 lg:p-8 overflow-hidden bg-slate-200 bg-cover bg-center"
            style="background-image: url({{ asset('storage/images/pesawat.jpeg') }});">

            <div class="absolute inset-0 bg-black/10"></div>

            <div class="flex flex-col lg:flex-row w-full gap-4 md:gap-6 relative z-10 mt-auto">
                <div data-aos="fade-up" data-aos-delay="600"
                    class="flex-1 bg-white/50 rounded-[24px] lg:rounded-[32px] backdrop-blur-md p-6 flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex flex-col h-full justify-between items-start gap-6 w-full sm:w-auto">
                        <p class="text-black text-sm lg:text-xl font-medium font-['Poppins'] leading-relaxed max-w-sm">
                            Kami menawarkan pengiriman cargo anda, dari Sabang hingga ke Merauke
                        </p>
                        <a href="#"
                            class="inline-flex items-center gap-2 text-blue hover:text-bluehover text-sm font-normal font-['Poppins'] transition-colors">
                            Pelajari <i class="ri-arrow-right-line text-sm"></i>
                        </a>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="800"
                    class="flex-1 bg-white/50 rounded-[24px] lg:rounded-[32px] backdrop-blur-md p-6 flex flex-col justify-between gap-2 lg:gap-0">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <x-button color="blue" href="#">Pelajari</x-button>
                        <p
                            class="text-black text-base lg:text-lg font-normal font-['Poppins'] leading-relaxed sm:text-right flex-1">
                            Kami juga memiliki partner bisnis di penerbangan nasional
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-between items-center gap-2 mt-auto pt-6">
                        <div class="text-black text-xl lg:text-2xl font-semibold font-['Poppins']">46+ Kota</div>
                        <div class="text-black text-xl lg:text-2xl font-semibold font-['Poppins']">134 Hingga 184 Titik
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="w-full mx-auto px-4 py-12 md:py-16 flex flex-col items-center gap-10 lg:gap-14">

        <div data-aos="fade-up">
            <x-section-header icon="ri-seo-line" label="Tentang Kami" title="Siapa MEX Berlian Dirgantara?"
                description="PT MEX Berlian Dirgantara adalah perusahaan jasa logistik dan kargo udara yang menghadirkan layanan pengiriman cepat, aman, dan terpercaya dengan dukungan sistem operasional terintegrasi. Berkomitmen pada inovasi dan pelayanan profesional, perusahaan terus meningkatkan efisiensi distribusi serta transparansi pengiriman untuk memberikan kepuasan terbaik bagi pelanggan." />
        </div>

        <div
            class="flex overflow-x-auto snap-x snap-mandatory gap-4 lg:gap-6 w-full pb-6 lg:pb-0 lg:grid lg:grid-cols-2 lg:grid-rows-2 lg:overflow-visible [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

            <div data-aos="fade-up" data-aos-delay="100"
                class="w-[85vw] sm:w-[60vw] lg:w-auto shrink-0 snap-center snap-always lg:col-start-1 lg:row-start-1 p-6 md:p-8 bg-white rounded-[32px] shadow-lg flex flex-col justify-center border border-gray-50 hover:shadow-xl transition-shadow duration-300">
                <div class="border-b-2 border-slate-100 pb-4 mb-4">
                    <h4 class="text-black text-lg md:text-xl font-normal font-['Poppins']">Pengiriman Cepat</h4>
                </div>
                <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed">
                    Kami menawarkan pengiriman cargo anda, dari Sabang hingga ke Merauke.
                </p>
            </div>

            <div data-aos="fade-up" data-aos-delay="200"
                class="w-[85vw] sm:w-[60vw] lg:w-auto shrink-0 snap-center snap-always lg:col-start-1 lg:row-start-2 p-6 md:p-8 bg-white rounded-[32px] shadow-lg flex flex-col justify-center border border-gray-50 hover:shadow-xl transition-shadow duration-300">
                <div class="border-b-2 border-slate-100 pb-4 mb-4">
                    <h4 class="text-black text-lg md:text-xl font-normal font-['Poppins']">Monitoring Real-Time</h4>
                </div>
                <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed">
                    Memudahkan pelanggan melacak status pengiriman secara transparan melalui sistem tracking dan pembaruan
                    status secara langsung.
                </p>
            </div>

            <div data-aos="fade-left" data-aos-delay="300"
                class="w-[85vw] sm:w-[60vw] lg:w-auto shrink-0 snap-center snap-always lg:col-start-2 lg:row-start-1 lg:row-span-2 p-6 md:p-8 bg-white rounded-[32px] shadow-lg flex flex-col gap-6 border border-gray-50 hover:shadow-xl transition-shadow duration-300">
                <div
                    class="w-full h-48 sm:h-56 lg:h-[280px] relative rounded-[20px] overflow-hidden shrink-0 lg:flex hidden bg-slate-100">
                    <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted playsinline>
                        <source src="{{ asset('storage/video/video.mp4') }}" type="video/mp4">
                    </video>
                </div>
                <div class="flex flex-col justify-start">
                    <div class="border-b-2 border-slate-100 pb-4 mb-4">
                        <h4 class="text-black text-lg md:text-3xl font-normal font-['Poppins']">Keamanan & Profesionalitas
                        </h4>
                    </div>
                    <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed">
                        Memudahkan pelanggan melacak status pengiriman secara transparan melalui sistem tracking dan
                        pembaruan status secara langsung.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full mx-auto px-4 py-8 md:py-12">
        <div data-aos="fade-up"
            class="w-full bg-gradient-to-r from-blue to-slate-900 rounded-[32px] p-8 md:p-12 flex flex-col lg:flex-row justify-between items-center gap-10 lg:gap-16 shadow-xl">

            <div data-aos="fade-right" data-aos-delay="200" class="flex-1 flex flex-col items-start gap-4 lg:gap-6">
                <div class="inline-flex items-center gap-3 bg-white/10 px-4 py-2 rounded-full border border-white/20">
                    <i class="ri-bar-chart-box-fill text-slate-200 text-xl"></i>
                    <span class="text-slate-200 text-lg md:text-xl font-normal font-['Poppins']">Statistik</span>
                </div>
                <h2 class="text-slate-100 text-xl md:text-2xl lg:text-4xl font-semibold font-['Poppins'] leading-tight">
                    Trusted Logistics Partner
                </h2>
                <p class="text-slate-300 text-sm lg:text-base font-normal font-['Poppins'] leading-relaxed max-w-2xl">
                    PT MEX Berlian Dirgantara terus meningkatkan kualitas layanan pengiriman melalui operasional yang
                    efisien, transparan, dan berorientasi pada kepuasan pelanggan.
                </p>
            </div>

            <div class="w-full lg:w-auto flex-1 grid grid-cols-2 gap-8 md:gap-10">
                <div data-aos="fade-up" data-aos-delay="300" class="flex flex-col justify-start items-start gap-1">
                    <div class="text-white text-3xl md:text-4xl font-bold font-['Poppins']">15+ Tahun</div>
                    <div class="text-slate-300 text-sm md:text-base lg:text-lg font-normal font-['Poppins']">Pengalaman
                        Logistik</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="400" class="flex flex-col justify-start items-start gap-1">
                    <div class="text-white text-3xl md:text-4xl font-bold font-['Poppins']">300+</div>
                    <div class="text-slate-300 text-sm md:text-base lg:text-lg font-normal font-['Poppins']">Mitra &
                        Pelanggan Aktif</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="500" class="flex flex-col justify-start items-start gap-1">
                    <div class="text-white text-3xl md:text-4xl font-bold font-['Poppins']">99%</div>
                    <div class="text-slate-300 text-sm md:text-base lg:text-lg font-normal font-['Poppins']">Kepuasan
                        Pelanggan</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="600" class="flex flex-col justify-start items-start gap-1">
                    <div class="text-white text-3xl md:text-4xl font-bold font-['Poppins']">99%</div>
                    <div class="text-slate-300 text-sm md:text-base lg:text-lg font-normal font-['Poppins']">Ketepatan
                        Pengiriman</div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-full mx-auto py-12 md:py-16 flex flex-col items-center gap-12" id="layanan">

        <div data-aos="fade-up">
            <x-section-header icon="ri-service-line" label="Layanan" title="Kami Menawarkan"
                description="Kami menyediakan layanan logistik dan kargo udara yang mencakup pengiriman barang domestik, handling kargo bandara Supadio Pontianak, monitoring pengiriman secara realtime, serta dukungan operasional yang cepat, aman, dan terpercaya untuk memenuhi kebutuhan distribusi bisnis maupun personal pelanggan." />
        </div>

        <div x-data="{
            intervalId: null,
            activeSlide: 0,
            slides: [0, 1], // Total 6 layanan

            startAutoScroll() {
                this.intervalId = setInterval(() => {
                    let slider = this.$refs.slider;
                    // Jika sudah mentok di kanan, kembali ke awal
                    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                        this.goToSlide(0);
                    } else {
                        // Geser ke slide berikutnya
                        this.goToSlide(this.activeSlide + 1);
                    }
                }, 3000); 
            },

            stopAutoScroll() {
                clearInterval(this.intervalId);
            },

            // Fungsi membaca posisi scroll untuk mengaktifkan titik yang sesuai
            updateSlide() {
                let slider = this.$refs.slider;
                let cardWidth = slider.firstElementChild.offsetWidth;
                // Cek gap responsif: di layar md ke atas gap-6 (24px), di bawahnya gap-4 (16px)
                let gap = window.innerWidth >= 768 ? 24 : 16;
                this.activeSlide = Math.round(slider.scrollLeft / (cardWidth + gap));

                // Jaga-jaga agar tidak out of bounds
                if (this.activeSlide > 5) this.activeSlide = 5;
            },

            // Fungsi melompat ke kartu tertentu saat titik diklik
            goToSlide(index) {
                let slider = this.$refs.slider;
                let cardWidth = slider.firstElementChild.offsetWidth;
                let gap = window.innerWidth >= 768 ? 24 : 16;
                slider.scrollTo({ left: index * (cardWidth + gap), behavior: 'smooth' });
                this.activeSlide = index;
            }
        }" x-init="startAutoScroll()" @mouseenter="stopAutoScroll()" @mouseleave="startAutoScroll()"
            class="w-full flex flex-col gap-6 md:gap-8">

            <div x-ref="slider" @scroll="updateSlide()" @touchstart="stopAutoScroll()" @touchend="startAutoScroll()"
                class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:gap-6 w-full pb-4 px-4 md:px-8 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

                <div data-aos="fade-up" data-aos-delay="100"
                    class="w-[85vw] md:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-3rem)/3)] shrink-0 snap-center snap-always bg-white rounded-[24px] p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-50 flex flex-col justify-between gap-6 h-full">
                    <div class="flex justify-between items-start gap-4">
                        <h4 class="text-black text-xl md:text-2xl font-semibold font-['Poppins'] leading-snug">Layanan Kargo
                            Udara</h4>
                        <div
                            class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-red/10 text-red flex items-center justify-center shrink-0">
                            <i class="ri-plane-fill text-2xl md:text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed">
                        Pengiriman barang dan dokumen melalui jalur udara dengan proses cepat, aman, dan tepat waktu.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-delay="400"
                    class="w-[85vw] md:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-3rem)/3)] shrink-0 snap-center snap-always bg-white rounded-[24px] p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-50 flex flex-col justify-between gap-6 h-full">
                    <div class="flex justify-between items-start gap-4">
                        <h4 class="text-black text-xl md:text-2xl font-semibold font-['Poppins'] leading-snug">Layanan
                            Packing
                            Barang</h4>
                        <div
                            class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-red/10 text-red flex items-center justify-center shrink-0">
                            <i class="ri-box-3-fill text-2xl md:text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed">
                        Menyediakan pengepakan barang menggunakan material yang aman untuk menjaga kualitas selama proses
                        pengiriman.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-delay="500"
                    class="w-[85vw] md:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-3rem)/3)] shrink-0 snap-center snap-always bg-white rounded-[24px] p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-50 flex flex-col justify-between gap-6 h-full">
                    <div class="flex justify-between items-start gap-4">
                        <h4 class="text-black text-xl md:text-2xl font-semibold font-['Poppins'] leading-snug">Tracking
                            Pengiriman</h4>
                        <div
                            class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-red/10 text-red flex items-center justify-center shrink-0">
                            <i class="ri-map-pin-fill text-2xl md:text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed">
                        Memudahkan pelanggan memantau status dan posisi barang secara realtime melalui sistem pelacakan
                        resi.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-delay="600"
                    class="w-[85vw] md:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-3rem)/3)] shrink-0 snap-center snap-always bg-white rounded-[24px] p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-50 flex flex-col justify-between gap-6 h-full">
                    <div class="flex justify-between items-start gap-4">
                        <h4 class="text-black text-xl md:text-2xl font-semibold font-['Poppins'] leading-snug">
                            Layanan<br>Port
                            to Port</h4>
                        <div
                            class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-red/10 text-red flex items-center justify-center shrink-0">
                            <i class="ri-ship-fill text-2xl md:text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed">
                        Pengiriman kargo antar bandara atau antar kota dengan jaringan distribusi yang luas dan terpercaya.
                    </p>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="700" class="flex justify-center items-center gap-2 mt-2">
                <template x-for="slide in slides" :key="slide">
                    <button @click="goToSlide(slide); stopAutoScroll(); startAutoScroll();"
                        class="h-2 md:h-2.5 rounded-full transition-all duration-300 ease-out focus:outline-none"
                        :class="activeSlide === slide ? 'w-8 md:w-10 bg-red' : 'w-2 md:w-2.5 bg-slate-200 hover:bg-slate-300'">
                    </button>
                </template>
            </div>

        </div>
    </section>

    <section class="relative w-full py-24 md:py-32 flex flex-col justify-center items-center overflow-hidden" id="tracking"
        {{-- Inisialisasi State Modal Alpine.js --}}
        x-data="{ isVerifyModalOpen: false, inputResi: '' }">
        
        <img src="{{ asset('storage/images/map.jpeg') }}" alt="Background Tracking"
            class="absolute inset-0 w-full h-full object-cover z-0" />
        <div class="absolute inset-0 bg-black/60 z-10"></div>

        <div class="relative z-20 w-full max-w-4xl mx-auto px-4 flex flex-col items-center gap-6 text-center">

            <div data-aos="fade-down" class="inline-flex items-center gap-3">
                <i class="ri-map-pin-user-fill text-red text-2xl md:text-3xl"></i>
                <span class="text-white text-lg md:text-xl font-normal font-['Poppins']">Tracking</span>
            </div>

            <h2 data-aos="fade-up" data-aos-delay="100"
                class="text-white text-xl md:text-2xl lg:text-4xl font-medium font-['Poppins'] leading-tight">
                Lacak Kargo Anda
            </h2>

            {{-- Flash Message jika Verifikasi HP atau Resi Salah --}}
            @if(session('error'))
            <div data-aos="fade-up" class="w-full max-w-xl p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-2 font-['Poppins'] text-sm shadow-lg text-left">
                <i class="ri-error-warning-fill text-lg shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            {{-- Form Pertama: Hanya Input Nomor Resi --}}
            <form data-aos="zoom-in" data-aos-delay="200" 
                @submit.prevent="if(inputResi.trim() !== '') isVerifyModalOpen = true"
                class="w-full max-w-xl mt-4 p-2 bg-white rounded-full flex items-center shadow-2xl outline outline-1 outline-slate-200">
                <div class="pl-4 pr-2 text-slate-400">
                    <i class="ri-barcode-box-line text-2xl"></i>
                </div>
                <input type="text" x-model="inputResi" placeholder="Masukkan ID Resi (Contoh: MEX-XXXXXX)..."
                    class="flex-1 bg-transparent text-black text-base md:text-lg font-normal font-['Poppins'] placeholder-slate-400 focus:outline-none focus:ring-0 border-none px-2 py-2 uppercase"
                    required />
                <button type="submit"
                    class="w-12 h-12 bg-red hover:bg-redhover text-white rounded-full flex justify-center items-center shrink-0 transition-colors duration-200 shadow-md">
                    <i class="ri-arrow-right-line text-2xl"></i>
                </button>
            </form>
        </div>

        {{-- ========================================================= --}}
        {{-- POP-UP MODAL VERIFIKASI KEAMANAN (4 DIGIT NO TELEPON)     --}}
        {{-- ========================================================= --}}
        <div x-show="isVerifyModalOpen" x-cloak style="display: none;" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 animate-fade-in">
            
            <div @click.outside="isVerifyModalOpen = false" 
                class="w-full max-w-md bg-white rounded-3xl p-6 shadow-2xl border border-slate-100 flex flex-col gap-4 text-left font-['Poppins']">
                
                <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                    <div class="w-10 h-10 bg-red/10 text-red rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-shield-keyhole-line text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-900 text-base font-semibold">Verifikasi Keamanan</h3>
                        <p class="text-slate-500 text-xs">Konfirmasi kepemilikan paket kargo</p>
                    </div>
                </div>

                {{-- Form Kedua: Mengirim Resi + Digit Verifikasi ke Backend --}}
                <form action="{{ route('tracking.show') }}" method="GET" class="flex flex-col gap-4">
                    {{-- Input Hidden untuk melempar nilai resi dari form pertama --}}
                    <input type="hidden" name="no_resi" :value="inputResi">

                    <div class="flex flex-col gap-1.5">
                        <label for="digit" class="text-slate-800 text-sm font-medium">4 Angka Terakhir No. HP</label>
                        <input type="text" id="digit" name="digit" maxlength="4" required pattern="[0-9]{4}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            placeholder="Contoh: 7890"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-base text-center font-mono font-bold tracking-widest text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-colors">
                        <p class="text-slate-500 text-[11px] leading-relaxed">
                            *Masukkan 4 angka terakhir dari nomor handphone **Pengirim** atau **Penerima** yang terdaftar pada kargo <span class="font-bold text-slate-800 uppercase" x-text="inputResi"></span>.
                        </p>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                        <button type="button" @click="isVerifyModalOpen = false"
                            class="px-5 py-2 rounded-xl text-sm font-medium border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 rounded-xl text-sm font-medium bg-red hover:bg-redhover text-white transition-colors shadow-sm">
                            Verifikasi & Lacak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- CSS Inline Pengaman transisi mata berkedip (X-CLOAK) --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <section
        class="w-full mx-auto px-4 py-12 md:py-16 flex flex-col lg:flex-row justify-between items-start gap-12 lg:gap-16"
        id="faq">

        <div data-aos="fade-right" class="w-full lg:w-[400px] flex flex-col justify-start items-start gap-6 shrink-0">
            <div class="flex flex-col gap-4">
                <div class="inline-flex items-center gap-3">
                    <div class="w-5 h-5 bg-red rounded-sm"></div>
                    <h3 class="text-black text-base md:text-xl font-normal font-['Poppins']">FAQ</h3>
                </div>
                <h2
                    class="text-black text-xl md:text-2xl lg:text-3xl font-medium font-['Poppins'] leading-tight lg:leading-[1.2]">
                    Frequently Asked Questions
                </h2>
                <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed max-w-4xl mt-2">
                    Pertanyaan yang sering di ajukan oleh pelanggan kami, anda bisa mengajukan pertanyaan
                    spesifik dengan menekan tombol berikut.
                </p>
            </div>
            <x-button class="justify-center" color="red" icon="ri-customer-service-2-fill" type="button" variant="outline">
                Kontak Kami
            </x-button>
        </div>

        <div class="w-full lg:flex-1 flex flex-col justify-start items-start gap-4">
            @php
                $faqs = [
                    ['pertanyaan' => 'Bagaimana cara melacak status pengiriman barang?', 'jawaban' => 'Anda dapat melacak status pengiriman barang secara real-time dengan memasukkan ID Resi pada kolom pencarian di halaman Tracking kami.'],
                    ['pertanyaan' => 'Jenis barang apa saja yang dapat dikirim?', 'jawaban' => 'Kami menerima pengiriman berbagai jenis barang mulai dari dokumen, paket e-commerce, hingga kargo industri berukuran besar, selama tidak melanggar aturan penerbangan.'],
                    ['pertanyaan' => 'Apakah tersedia layanan penjemputan barang?', 'jawaban' => 'Ya, kami menyediakan layanan penjemputan (Door to Door) langsung ke alamat Anda. Silakan hubungi tim operasional kami untuk menjadwalkan penjemputan.'],
                    ['pertanyaan' => 'Apakah barang akan melalui pemeriksaan keamanan?', 'jawaban' => 'Tentu. Demi keamanan dan kepatuhan terhadap regulasi bandara, semua barang akan melalui proses X-Ray dan pemeriksaan standar sebelum diberangkatkan.']
                ];
            @endphp

            @foreach($faqs as $index => $item)
                <div data-aos="fade-left" data-aos-delay="{{ $index * 100 }}" x-data="{ open: false }"
                    class="w-full bg-white rounded-3xl border-2 border-slate-200 flex flex-col cursor-pointer hover:border-blue/30 hover:shadow-md transition-all duration-300 overflow-hidden group">

                    <div @click="open = !open" class="w-full p-4 md:p-5 flex justify-between items-center gap-4">
                        <h4 class="text-blue md:text-sm lg:text-base font-normal font-['Poppins'] leading-snug">
                            {{ $item['pertanyaan'] }}
                        </h4>
                        <div class="w-8 h-8 flex justify-center items-center shrink-0 text-blue transition-transform duration-300"
                            :class="open ? 'rotate-90' : 'group-hover:translate-x-1'">
                            <i class="ri-arrow-right-s-line text-3xl"></i>
                        </div>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                        style="display: none;">
                        <div
                            class="px-4 md:px-5 pb-4 md:pb-5 text-gray-600 text-sm md:text-sm font-normal font-['Poppins'] leading-relaxed">
                            <div class="pt-3 border-t border-slate-100">
                                {{ $item['jawaban'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection