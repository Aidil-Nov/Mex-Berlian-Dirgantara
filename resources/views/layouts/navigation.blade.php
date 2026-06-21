<header
    class="flex items-center justify-between px-6 md:px-8 py-4 bg-white border-b border-slate-200 shadow-sm shrink-0 w-full">

    <div class="flex items-center gap-4">

        <div
            class="flex items-center justify-center w-10 h-10 rounded-full shrink-0 
            {{ Auth::user()->role === 'manajer_cabang' ? 'bg-emerald-100 text-emerald-600' : 'bg-sky-100 text-sky-600' }}">
            <i class="ri-user-line text-xl"></i>
        </div>

        <div class="flex flex-col">
            <span class="text-sm font-semibold text-slate-900">{{ Auth::user()->nama }}</span>

            @if(Auth::user()->role === 'manajer_cabang')
                <span class="text-xs text-slate-500 hidden sm:block">Manajer Cabang - Kantor Pusat Merdeka Barat</span>
                <span class="text-xs text-slate-500 sm:hidden">Manajer Cabang</span>
            @elseif(Auth::user()->role === 'admin_operasional')
                <span class="text-xs text-slate-500 hidden sm:block">Admin Operasional Unit Kargo</span>
                <span class="text-xs text-slate-500 sm:hidden">Admin Ops</span>
            @endif
        </div>

    </div>

    <div class="flex items-center gap-4 md:gap-6">

        <div class="hidden lg:flex flex-col items-end">
            <span id="live-time" class="text-sm font-semibold text-slate-900 tracking-wide">--.--.--</span>
            <span id="live-date" class="text-xs text-slate-500">Memuat...</span>
        </div>

        <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors focus:outline-none">
                <i class="ri-logout-circle-r-line text-lg"></i>
                <span class="hidden md:inline">Keluar</span>
            </button>
        </form>

    </div>

</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateClock() {
            const now = new Date();

            // Format Jam (Contoh: 14.24.17)
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            let timeString = now.toLocaleTimeString('id-ID', timeOptions).replace(/:/g, '.');

            // Format Tanggal (Contoh: Senin, 25 Mei 2026)
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            let dateString = now.toLocaleDateString('id-ID', dateOptions);

            document.getElementById('live-time').textContent = timeString;
            document.getElementById('live-date').textContent = dateString;
        }

        // Jalankan sekali saat dimuat, lalu update setiap 1 detik
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>