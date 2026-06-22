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

        <!-- Menu Tengah (Desktop Only) -->
        <div
            class="relative hidden lg:flex px-2 py-2 bg-white/80 backdrop-blur-md rounded-full shadow-sm outline outline-2 outline-offset-[-2px] outline-surface-border items-center gap-1 transition-all">

            <!-- Kotak Merah Sliding -->
            <div class="absolute bg-red rounded-full shadow-md transition-all duration-300 ease-out z-0 pointer-events-none"
                :style="`left: ${pillLeft}px; top: ${pillTop}px; width: ${pillWidth}px; height: ${pillHeight}px; opacity: ${pillOpacity};`">
            </div>

            <!-- Teks Menu -->
            <a href="{{ route('home') }}#beranda" x-ref="link_beranda"
                @click="if(!isTrackingPage) { activeSection = 'beranda'; updatePill() }"
                :class="activeSection === 'beranda' ? 'text-white' : 'text-surface-text hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-primary transition-colors duration-300">
                Beranda
            </a>

            <a href="{{ route('home') }}#tentang" x-ref="link_tentang"
                @click="if(!isTrackingPage) { activeSection = 'tentang'; updatePill() }"
                :class="activeSection === 'tentang' ? 'text-white' : 'text-surface-text hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-primary transition-colors duration-300">
                Tentang
            </a>

            <a href="{{ route('home') }}#layanan" x-ref="link_layanan"
                @click="if(!isTrackingPage) { activeSection = 'layanan'; updatePill() }"
                :class="activeSection === 'layanan' ? 'text-white' : 'text-surface-text hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-primary transition-colors duration-300">
                Layanan
            </a>

            <a href="{{ request()->routeIs('tracking.show') ? '#' : route('home') . '#tracking' }}"
                x-ref="link_tracking" @click="if(!isTrackingPage) { activeSection = 'tracking'; updatePill() }"
                :class="activeSection === 'tracking' ? 'text-white' : 'text-surface-text hover:text-red'"
                class="relative z-10 flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-normal font-primary transition-colors duration-300">
                Tracking
            </a>

            <a href="{{ route('home') }}#faq" x-ref="link_faq"
                @click="if(!isTrackingPage) { activeSection = 'faq'; updatePill() }"
                :class="activeSection === 'faq' ? 'text-white' : 'text-surface-text hover:text-red'"
                class="relative z-10 px-6 py-2.5 rounded-full text-sm font-normal font-primary transition-colors duration-300">
                FAQ
            </a>
        </div>

        <!-- Tombol Kontak & Mobile Menu Toggle -->
        <div class="flex items-center gap-4 relative z-20">

            <!-- Tombol Desktop -->
            <div class="hidden lg:block">
                <div class="hidden lg:block">
                    <x-button
                        href="https://wa.me/6283149159269?text=Halo%20Admin%20PT%20MEX%20Berlian%20Dirgantara.%20Saya%20ingin%20mengajukan%20komplain%2Fpertanyaan%20dengan%20detail%20form%20sebagai%20berikut%3A%0A%0A*Nama%20Pelapor%3A*%20%0A*No.%20HP%20Pelapor%3A*%20%0A*Email%20Pelapor%20%28Opsional%29%3A*%20%0A*Nomor%20Resi%3A*%20%0A*Kategori%20Komplain%20%28Keterlambatan%20%2F%20Rusak%20%2F%20Hilang%20%2F%20Layanan%29%3A*%20%0A*Tingkat%20Keparahan%20%28Rendah%20%2F%20Sedang%20%2F%20Tinggi%20%2F%20Kritis%29%3A*%20%0A*Estimasi%20Nilai%20Klaim%20%28Opsional%29%3A*%20%0A*Deskripsi%20Lengkap%3A*%20%0A%0AMohon%20bantuannya.%20Terima%20kasih."
                        target="_blank" color="blue" icon="ri-whatsapp-line">
                        Kontak Kami
                    </x-button>
                </div>
            </div>

            <!-- Hamburger Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="block lg:hidden p-2 bg-white rounded-full shadow-sm text-surface-text hover:text-blue focus:outline-none transition-colors">
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
        class="absolute top-full left-0 w-full bg-white border-t border-surface-border shadow-xl lg:hidden flex flex-col"
        style="display: none;">

        <div class="flex flex-col px-6 py-6 gap-4">
            <a href="{{ route('home') }}#beranda" @click="mobileMenuOpen = false"
                :class="activeSection === 'beranda' ? 'text-red font-semibold' : 'text-surface-muted font-normal'"
                class="text-lg font-primary transition-colors">Beranda</a>

            <a href="{{ route('home') }}#tentang" @click="mobileMenuOpen = false"
                :class="activeSection === 'tentang' ? 'text-red font-semibold' : 'text-surface-muted font-normal'"
                class="text-lg font-primary transition-colors">Tentang</a>

            <a href="{{ route('home') }}#layanan" @click="mobileMenuOpen = false"
                :class="activeSection === 'layanan' ? 'text-red font-semibold' : 'text-surface-muted font-normal'"
                class="text-lg font-primary transition-colors">Layanan</a>

            <a href="{{ request()->routeIs('tracking.show') ? '#' : route('home') . '#tracking' }}"
                @click="mobileMenuOpen = false"
                :class="activeSection === 'tracking' ? 'text-red font-semibold' : 'text-surface-muted font-normal'"
                class="text-lg font-primary transition-colors">Tracking</a>

            <a href="{{ route('home') }}#faq" @click="mobileMenuOpen = false"
                :class="activeSection === 'faq' ? 'text-red font-semibold' : 'text-surface-muted font-normal'"
                class="text-lg font-primary transition-colors">FAQ</a>

            <hr class="border-surface-border my-2">

            <!-- Tombol Mobile -->
            <!-- Tombol Mobile -->
            <x-button
                href="https://wa.me/6283149159269?text=Halo%20Admin%20PT%20MEX%20Berlian%20Dirgantara.%20Saya%20ingin%20mengajukan%20komplain%2Fpertanyaan%20dengan%20detail%20form%20sebagai%20berikut%3A%0A%0A*Nama%20Pelapor%3A*%20%0A*No.%20HP%20Pelapor%3A*%20%0A*Email%20Pelapor%20%28Opsional%29%3A*%20%0A*Nomor%20Resi%3A*%20%0A*Kategori%20Komplain%20%28Keterlambatan%20%2F%20Rusak%20%2F%20Hilang%20%2F%20Layanan%29%3A*%20%0A*Tingkat%20Keparahan%20%28Rendah%20%2F%20Sedang%20%2F%20Tinggi%20%2F%20Kritis%29%3A*%20%0A*Estimasi%20Nilai%20Klaim%20%28Opsional%29%3A*%20%0A*Deskripsi%20Lengkap%3A*%20%0A%0AMohon%20bantuannya.%20Terima%20kasih."
                target="_blank" class="w-full justify-center" color="blue" icon="ri-whatsapp-line">
                Kontak Kami
            </x-button>
        </div>
    </div>
</nav>