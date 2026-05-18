<!-- Navigasi Bar Interaktif dengan "Sliding Background" (Alpine.js) -->
<nav x-data="{ 
        mobileMenuOpen: false, 
        scrolled: false,
        // Menyuntikkan deteksi route dari Laravel langsung ke Alpine
        isTrackingPage: {{ request()->routeIs('tracking.show') ? 'true' : 'false' }},
        // Jika di halaman tracking, set default active ke 'tracking'
        activeSection: '{{ request()->routeIs('tracking.show') ? 'tracking' : 'beranda' }}',
        
        // Data untuk posisi kotak merah (Sliding Pill)
        pillLeft: 0,
        pillWidth: 0,
        pillHeight: 0,
        pillTop: 0,
        pillOpacity: 0,

        // Fungsi untuk menggeser kotak merah
        updatePill() {
            this.$nextTick(() => {
                const activeEl = this.$refs['link_' + this.activeSection];
                if (activeEl) {
                    this.pillLeft = activeEl.offsetLeft;
                    this.pillWidth = activeEl.offsetWidth;
                    this.pillHeight = activeEl.offsetHeight;
                    this.pillTop = activeEl.offsetTop;
                    this.pillOpacity = 1; // Munculkan kotak merah setelah posisinya didapat
                }
            });
        },

        // Fungsi pengecekan scroll
        checkScroll() {
            // Background navbar tetap mendeteksi scroll (transparan ke solid)
            this.scrolled = window.scrollY > 20;
            
            // JIKA DI HALAMAN TRACKING: Kunci menu aktif di 'tracking' & hentikan deteksi section
            if (this.isTrackingPage) {
                if (this.activeSection !== 'tracking') {
                    this.activeSection = 'tracking';
                    this.updatePill();
                }
                return; // Berhenti di sini
            }
            
            // JIKA DI LANDING PAGE: Lanjutkan deteksi section seperti biasa
            const sections = ['beranda', 'tentang', 'layanan', 'tracking', 'faq'];
            const scrollPosition = window.scrollY + 150; 
            let newActive = this.activeSection;

            for (let i = sections.length - 1; i >= 0; i--) {
                const el = document.getElementById(sections[i]);
                if (el && el.offsetTop <= scrollPosition) {
                    newActive = sections[i];
                    break;
                }
            }

            // Jika section berubah, geser kotaknya!
            if (this.activeSection !== newActive) {
                this.activeSection = newActive;
                this.updatePill();
            }
        }
    }" @scroll.window="checkScroll()" @resize.window="updatePill()" x-init="checkScroll(); updatePill()"
    :class="{ 'bg-white/90 shadow-md': scrolled, 'bg-white/50 shadow-sm': !scrolled }"
    class="fixed top-0 left-0 z-50 w-full transition-all duration-300 backdrop-blur-3xl">

    <!-- Wrapper Utama Navbar -->
    <div class="px-4 py-4 md:px-8 flex justify-between items-center mx-auto w-full">
        <!-- Logo Section -->
        <a href="{{ route('home') }}#beranda" class="flex-shrink-0 relative z-20">
            <img class="h-6 md:h-8 w-auto drop-shadow-sm" src="{{ asset('storage/images/logo mex.png') }}"
                alt="Logo MEX" />
        </a>

        <!-- Menu Tengah (Desktop Only) dengan relative agar kotak merah tidak keluar jalur -->
        <div
            class="relative hidden lg:flex px-2 py-2 bg-white/80 backdrop-blur-md rounded-full shadow-sm outline outline-2 outline-offset-[-2px] outline-slate-100 items-center gap-1 transition-all">

            <!-- INI ADALAH KOTAK MERAH YANG BERGESER -->
            <!-- Warna dikembalikan ke class custom Anda: bg-red -->
            <div class="absolute bg-red rounded-full shadow-md transition-all duration-300 ease-out z-0 pointer-events-none"
                :style="`left: ${pillLeft}px; top: ${pillTop}px; width: ${pillWidth}px; height: ${pillHeight}px; opacity: ${pillOpacity};`">
            </div>

            <!-- Teks Menu (Z-10 agar posisinya berada di ATAS kotak merah) -->
            <!-- SEMUA HREF DIUBAH MENJADI ABSOLUTE URL MENGGUNAKAN route('home') -->
            <!-- Warna hover dikembalikan ke class custom Anda: hover:text-red -->
            <a href="{{ route('home') }}#beranda" x-ref="link_beranda"
                @click="if(!isTrackingPage) { activeSection = 'beranda'; updatePill() }"
                :class="activeSection === 'beranda' ? 'text-white' : 'text-gray-800 hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-['Poppins'] transition-colors duration-300">
                Beranda
            </a>

            <a href="{{ route('home') }}#tentang" x-ref="link_tentang"
                @click="if(!isTrackingPage) { activeSection = 'tentang'; updatePill() }"
                :class="activeSection === 'tentang' ? 'text-white' : 'text-gray-800 hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-['Poppins'] transition-colors duration-300">
                Tentang
            </a>

            <a href="{{ route('home') }}#layanan" x-ref="link_layanan"
                @click="if(!isTrackingPage) { activeSection = 'layanan'; updatePill() }"
                :class="activeSection === 'layanan' ? 'text-white' : 'text-gray-800 hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-['Poppins'] transition-colors duration-300">
                Layanan
            </a>

            <a href="{{ request()->routeIs('tracking.show') ? '#' : route('home') . '#tracking' }}"
                x-ref="link_tracking" @click="if(!isTrackingPage) { activeSection = 'tracking'; updatePill() }"
                :class="activeSection === 'tracking' ? 'text-white' : 'text-gray-800 hover:text-red'"
                class="relative z-10 flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-normal font-['Poppins'] transition-colors duration-300">
                Tracking
            </a>

            <a href="{{ route('home') }}#faq" x-ref="link_faq"
                @click="if(!isTrackingPage) { activeSection = 'faq'; updatePill() }"
                :class="activeSection === 'faq' ? 'text-white' : 'text-gray-800 hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-['Poppins'] transition-colors duration-300">
                FAQ
            </a>
        </div>

        <!-- Tombol Kontak & Mobile Menu Toggle -->
        <div class="flex items-center gap-4 relative z-20">
            <div class="hidden lg:block">
                <x-button color="blue" icon="ri-customer-service-2-fill">
                    Kontak
                </x-button>
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="block lg:hidden p-2 bg-white rounded-full shadow-sm text-gray-800 hover:text-blue focus:outline-none transition-colors">
                <i :class="mobileMenuOpen ? 'ri-close-line' : 'ri-menu-3-line'"
                    class="text-2xl transition-transform duration-200"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" @click.away="mobileMenuOpen = false"
        class="absolute top-full left-0 w-full bg-white border-t border-gray-100 shadow-xl lg:hidden flex flex-col"
        style="display: none;">

        <div class="flex flex-col px-6 py-6 gap-4">
            <!-- Warna text active dikembalikan ke class custom Anda: text-red -->
            <a href="{{ route('home') }}#beranda" @click="mobileMenuOpen = false"
                :class="activeSection === 'beranda' ? 'text-red font-semibold' : 'text-gray-600 font-normal'"
                class="text-lg font-['Poppins'] transition-colors">Beranda</a>

            <a href="{{ route('home') }}#tentang" @click="mobileMenuOpen = false"
                :class="activeSection === 'tentang' ? 'text-red font-semibold' : 'text-gray-600 font-normal'"
                class="text-lg font-['Poppins'] transition-colors">Tentang</a>

            <a href="{{ route('home') }}#layanan" @click="mobileMenuOpen = false"
                :class="activeSection === 'layanan' ? 'text-red font-semibold' : 'text-gray-600 font-normal'"
                class="text-lg font-['Poppins'] transition-colors">Layanan</a>

            <a href="{{ request()->routeIs('tracking.show') ? '#' : route('home') . '#tracking' }}"
                @click="mobileMenuOpen = false"
                :class="activeSection === 'tracking' ? 'text-red font-semibold' : 'text-gray-600 font-normal'"
                class="text-lg font-['Poppins'] transition-colors">Tracking</a>

            <a href="{{ route('home') }}#faq" @click="mobileMenuOpen = false"
                :class="activeSection === 'faq' ? 'text-red font-semibold' : 'text-gray-600 font-normal'"
                class="text-lg font-['Poppins'] transition-colors">FAQ</a>

            <hr class="border-gray-100 my-2">

            <x-button class="w-full justify-center" color="blue" icon="ri-customer-service-2-fill">
                Kontak Kami
            </x-button>
        </div>
    </div>
</nav>