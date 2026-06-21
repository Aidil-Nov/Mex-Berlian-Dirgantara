<x-app-layout>
    <div x-data="{ resiInput: '{{ request('resi') }}', isTracking: {{ request('resi') ? 'true' : 'false' }} }"
        class="w-full flex flex-col gap-6 font-sans p-6 md:p-8">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Tracking Pengiriman</h1>
            <p class="text-slate-600 text-base font-normal">Lacak status pengiriman kargo secara real-time</p>
        </div>

        @if(request('resi') && !$kargo)
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
                <i class="ri-error-warning-fill text-xl"></i>
                <span class="text-sm font-medium">Nomor Resi <strong>{{ request('resi') }}</strong> tidak ditemukan di dalam
                    sistem.</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col gap-4">
            <div class="flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold">Cari Nomor Resi</h3>
                <p class="text-slate-500 text-sm">Masukkan nomor resi untuk melacak pengiriman</p>
            </div>

            <form x-ref="formTracking" action="{{ route('admin.tracking-pengiriman') }}" method="GET"
                class="flex flex-col sm:flex-row items-end sm:items-center gap-4 mt-2 max-w-2xl">
                <div class="flex flex-col gap-2 w-full">
                    <label for="resi" class="text-slate-900 text-sm font-medium">Nomor Resi</label>
                    <input type="text" name="resi" id="resi" x-model="resiInput" placeholder="Contoh: MEX-001234"
                        required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors uppercase">
                </div>

                <button type="submit"
                    class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white px-8 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 flex items-center justify-center gap-2">
                    <i class="ri-search-line text-lg"></i> Lacak
                </button>
            </form>
        </div>

        @if(!$kargo)
            <div x-show="!isTracking" x-transition.opacity.duration.500ms
                class="bg-sky-50 rounded-2xl border border-sky-200 p-8 flex flex-col items-center justify-center min-h-[300px] text-center gap-6">
                <div class="relative">
                    <i class="ri-dropbox-line text-8xl text-sky-300"></i>
                    <i
                        class="ri-search-eye-line text-4xl text-sky-600 absolute -bottom-2 -right-2 bg-sky-50 rounded-full p-1 border-2 border-sky-200"></i>
                </div>
                <div class="flex flex-col gap-4 items-center">
                    <p class="text-sky-900 text-base font-medium">Contoh resi yang bisa dicari:</p>
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <button @click="resiInput = 'MEX-26061001'; $refs.formTracking.submit()" type="button"
                            class="bg-sky-200/50 hover:bg-sky-200 text-sky-800 text-sm font-medium px-4 py-1.5 rounded-lg transition-colors border border-sky-300/50">
                            MEX-26061001
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if($kargo)
            <div x-show="isTracking" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="flex flex-col gap-6" x-cloak>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 flex flex-col overflow-hidden">
                    <div
                        class="bg-slate-50/50 p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-slate-900 text-base font-semibold">Informasi Pengiriman</h3>
                            <p class="text-slate-500 text-sm">Nomor Resi: <span
                                    class="font-semibold text-slate-700 uppercase">{{ $kargo->no_resi }}</span></p>
                        </div>

                        @php
                            $badgeColor = match (strtolower($kargo->status_terakhir)) {
                                'entry' => 'bg-slate-100 text-slate-800 border-slate-200',
                                'x-ray' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'loading' => 'bg-sky-100 text-sky-800 border-sky-200',
                                'offload' => 'bg-red-100 text-red-800 border-red-200',
                                'selesai', 'di terima' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                default => 'bg-gray-100 text-gray-800 border-gray-200',
                            };
                            $badgeIcon = match (strtolower($kargo->status_terakhir)) {
                                'entry' => 'ri-inbox-archive-line',
                                'x-ray' => 'ri-search-eye-line',
                                'loading' => 'ri-loader-4-line',
                                'offload' => 'ri-error-warning-line',
                                'selesai', 'di terima' => 'ri-checkbox-circle-line',
                                default => 'ri-information-line',
                            };
                        @endphp
                        <span
                            class="{{ $badgeColor }} text-xs font-semibold px-3 py-1.5 rounded-lg border uppercase tracking-wide flex items-center gap-1.5">
                            <i class="{{ $badgeIcon }}"></i> {{ $kargo->status_terakhir }}
                        </span>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-slate-500 text-sm">Pengirim</span>
                                <span
                                    class="text-slate-900 text-base font-medium">{{ $kargo->pengirim->nama ?? '-' }}</span>
                                <span class="text-slate-500 text-xs">{{ $kargo->pengirim->no_hp ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-slate-500 text-sm">Asal Kota</span>
                                <span class="text-slate-900 text-base font-medium flex items-center gap-2">
                                    <i class="ri-map-pin-2-fill text-red-500"></i> {{ $kargo->kotaAsal->nama_kota ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-slate-500 text-sm">Penerima</span>
                                <span
                                    class="text-slate-900 text-base font-medium">{{ $kargo->penerima->nama ?? '-' }}</span>
                                <span class="text-slate-500 text-xs">{{ $kargo->penerima->no_hp ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-slate-500 text-sm">Tujuan Kota</span>
                                <span class="text-slate-900 text-base font-medium flex items-center gap-2">
                                    <i class="ri-map-pin-4-fill text-sky-500"></i>
                                    {{ $kargo->kotaTujuan->nama_kota ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($detailPesawat) && $detailPesawat)
                    <div
                        class="bg-sky-50/50 rounded-2xl shadow-sm border border-sky-100 flex flex-col overflow-hidden p-6 relative">
                        <i class="ri-radar-line absolute -right-6 -top-6 text-9xl text-sky-500/10 opacity-50"></i>

                        <div class="flex items-center gap-2 text-sky-900 font-semibold text-sm mb-4 relative z-10">
                            <i class="ri-radar-line text-sky-600 animate-pulse text-lg"></i>
                            <span>Live Radar & Spesifikasi Armada Pesawat</span>
                        </div>

                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-xs md:text-sm relative z-10">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-slate-500">Penerbangan & Maskapai</span>
                                <span class="text-slate-800 font-bold">{{ $kargo->no_penerbangan }} -
                                    {{ $detailPesawat->maskapai }}</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-slate-500">Tipe / Seri Pesawat</span>
                                <span class="text-slate-800 font-medium">{{ $detailPesawat->jenis_pesawat }}</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-slate-500">Status Radar</span>
                                <span class="text-slate-800 font-medium">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-white border border-slate-200 shadow-sm">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ strtolower($detailPesawat->status_penerbangan) == 'active' ? 'bg-green-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                        {{ $detailPesawat->status_penerbangan }}
                                    </span>
                                </span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-slate-500">Estimasi Tiba (ETA)</span>
                                <span class="text-sky-700 font-bold flex items-center gap-1">
                                    <i class="ri-flight-land-line"></i> {{ $detailPesawat->eta }}
                                </span>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-400 text-right italic mt-4 relative z-10">
                            Penyedia Data: {{ $detailPesawat->sumber }}
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 flex flex-col overflow-hidden">
                    <div class="bg-slate-50/50 p-6 border-b border-slate-100 flex flex-col gap-1">
                        <h3 class="text-slate-900 text-base font-semibold">Riwayat Pengiriman</h3>
                        <p class="text-slate-500 text-sm">Timeline status perjalanan kargo Anda</p>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="relative flex flex-col gap-8">
                            <div
                                class="absolute left-[15px] md:left-[19px] top-2 bottom-2 w-[2px] bg-slate-200 rounded-full z-0">
                            </div>

                            @php
                                $histories = $kargo->history;
                                $totalHistory = $histories->count();
                            @endphp

                            @foreach($histories as $index => $history)
                                @php
                                    $isLast = ($index === $totalHistory - 1);

                                    if ($isLast) {
                                        $ringColor = match (strtolower($history->status)) {
                                            'offload' => 'bg-red-600 shadow-[0_0_0_4px_rgba(220,38,38,0.2)]',
                                            'selesai', 'di terima' => 'bg-emerald-600 shadow-[0_0_0_4px_rgba(5,150,105,0.2)]',
                                            default => 'bg-sky-600 shadow-[0_0_0_4px_rgba(59,130,246,0.2)]'
                                        };
                                        $textColor = match (strtolower($history->status)) {
                                            'offload' => 'text-red-700',
                                            'selesai', 'di terima' => 'text-emerald-700',
                                            default => 'text-sky-700'
                                        };
                                        $dateColor = match (strtolower($history->status)) {
                                            'offload' => 'text-red-500',
                                            'selesai', 'di terima' => 'text-emerald-500',
                                            default => 'text-sky-500'
                                        };
                                        $icon = match (strtolower($history->status)) {
                                            'entry' => 'ri-inbox-archive-line',
                                            'x-ray' => 'ri-search-eye-line',
                                            'loading' => 'ri-loader-4-line',
                                            'offload' => 'ri-error-warning-line',
                                            'di terima', 'selesai' => 'ri-checkbox-circle-line',
                                            default => 'ri-map-pin-line'
                                        };
                                    } else {
                                        $ringColor = 'bg-slate-200 border-4 border-white shadow-sm';
                                        $textColor = 'text-slate-900';
                                        $dateColor = 'text-slate-500';
                                        $icon = 'ri-check-line';
                                    }
                                @endphp

                                <div class="relative z-10 flex gap-4 md:gap-6 items-start">
                                    <div
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-full {{ $isLast ? $ringColor . ' text-white border-4 border-white' : 'bg-slate-200 text-slate-500 border-4 border-white shadow-sm' }} flex justify-center items-center shrink-0">
                                        <i class="{{ $icon }} text-lg"></i>
                                    </div>
                                    <div class="flex flex-col gap-1 pt-1.5 md:pt-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                            <h4 class="{{ $textColor }} text-base font-semibold">{{ $history->status }}</h4>
                                            <span
                                                class="{{ $dateColor }} text-xs sm:text-sm {{ $isLast ? 'font-medium' : 'font-normal' }}">
                                                <i
                                                    class="ri-time-line mr-1"></i>{{ \Carbon\Carbon::parse($history->waktu_update)->translatedFormat('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        <p class="{{ $isLast ? 'text-slate-800 font-medium' : 'text-slate-600' }} text-sm">
                                            {{ $history->keterangan }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            @if(!in_array(strtolower($kargo->status_terakhir), ['selesai', 'di terima']))
                                <div class="relative z-10 flex gap-4 md:gap-6 items-start opacity-50">
                                    <div
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-white border-2 border-slate-300 flex justify-center items-center shrink-0 shadow-sm outline outline-4 outline-white">
                                    </div>
                                    <div class="flex flex-col gap-1 pt-1.5 md:pt-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                            <h4 class="text-slate-500 text-base font-semibold">Di Terima</h4>
                                            <span class="text-slate-400 text-xs sm:text-sm font-normal">Menunggu Update</span>
                                        </div>
                                        <p class="text-slate-500 text-sm">Paket belum tiba atau belum diambil di fasilitas
                                            {{ $kargo->kotaTujuan->nama_kota ?? 'tujuan' }}.
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-2">
                    <a href="{{ route('admin.tracking-pengiriman') }}"
                        class="text-slate-600 hover:text-slate-900 font-medium text-sm flex items-center gap-2 py-2 px-4 rounded-lg hover:bg-slate-100 transition-colors">
                        <i class="ri-arrow-left-line"></i> Lacak Resi Lainnya
                    </a>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>