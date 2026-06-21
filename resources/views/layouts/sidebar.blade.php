<aside
    class="inline-flex w-64 min-h-screen shrink-0 flex-col items-start justify-start border-r border-slate-200 bg-white font-sans shadow-sm fixed z-20">

    @if (Auth::user()->role === 'admin_operasional')
        <div class="flex h-24 w-full flex-col items-start justify-start gap-1 border-b border-slate-200 px-6 pt-6 pb-px">
            <h1 class="text-xl font-semibold leading-7 text-slate-900">Admin Operasional</h1>
            <p class="text-sm font-normal leading-5 text-slate-500">Sistem Manajemen Kargo</p>
        </div>

        <nav class="flex w-full flex-1 flex-col items-start justify-start gap-1 overflow-y-auto px-4 pt-4">
            <a href="{{ route('admin.dashboard') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('admin.dashboard') ? 'bg-sky-100 text-sky-800 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-dashboard-line text-xl leading-none"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.kelola-data-kargo') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('admin.kelola-data-kargo') ? 'bg-sky-100 text-sky-800 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-box-3-line text-xl leading-none"></i>
                Kelola Data Kargo
            </a>

            <a href="{{ route('admin.kelola-status-pengiriman') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('admin.kelola-status-pengiriman') ? 'bg-sky-100 text-sky-800 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-route-line text-xl leading-none"></i>
                Kelola Status Pengiriman
            </a>

            <a href="{{ route('admin.tracking-pengiriman') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('admin.tracking-pengiriman') ? 'bg-sky-100 text-sky-800 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-map-pin-line text-xl leading-none"></i>
                Tracking Pengiriman
            </a>

            <a href="{{ route('admin.kelola-laporan') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('admin.kelola-laporan') ? 'bg-sky-100 text-sky-800 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-file-text-line text-xl leading-none"></i>
                Kelola Laporan
            </a>

            <a href="{{ route('admin.komplain') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('admin.komplain') ? 'bg-sky-100 text-sky-800 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-question-mark text-xl leading-none"></i>
                Komplain
            </a>
        </nav>

        <div class="flex h-16 w-full flex-col items-start justify-start gap-1 border-t border-slate-200 px-4 pt-4">
            <p class="w-full text-xs font-normal leading-4 text-slate-500">© {{ date('Y') }} Sistem Kargo</p>
            <p class="w-full text-xs font-normal leading-4 text-slate-400">Bandara Supadio</p>
        </div>

    @elseif (Auth::user()->role === 'manajer_cabang')
        <div class="flex w-full flex-col items-start justify-start gap-1 border-b border-slate-200 px-6 pt-6 pb-px">
            <div class="mb-3 flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <i class="ri-user-settings-line text-lg"></i>
                </div>
                <span class="rounded-md bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Manajer</span>
            </div>
            <h1 class="text-xl font-semibold leading-7 text-slate-900">Portal Manajer</h1>
            <p class="text-sm font-normal leading-5 text-slate-500">Sistem Monitoring Kargo</p>
        </div>

        <nav class="flex w-full flex-1 flex-col items-start justify-start gap-1 overflow-y-auto px-4 pt-4">
            <a href="{{ route('manager.dashboard') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('manager.dashboard') ? 'bg-emerald-50 text-emerald-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-dashboard-line text-xl leading-none"></i>
                Dashboard Utama
            </a>

            <a href="{{ route('manager.monitoring') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('manager.monitoring') ? 'bg-emerald-50 text-emerald-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-radar-line text-xl leading-none"></i>
                Monitor Operasional
            </a>

            <a href="{{ route('manager.laporan') }}"
                class="flex h-10 w-full items-center gap-3 rounded-[10px] px-3 text-sm font-medium leading-5 transition-colors
                                    {{ request()->routeIs('manager.laporan') ? 'bg-emerald-50 text-emerald-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="ri-file-chart-line text-xl leading-none"></i>
                Validasi & Laporan
            </a>
        </nav>

        <div class="flex h-16 w-full flex-col items-start justify-start gap-1 border-t border-slate-200 px-4 pt-4">
            <p class="w-full text-xs font-normal leading-4 text-slate-500">© {{ date('Y') }} PT MEX</p>
            <p class="w-full text-xs font-normal leading-4 text-slate-400">Kantor Pusat Merdeka Barat</p>
        </div>
    @endif

</aside>