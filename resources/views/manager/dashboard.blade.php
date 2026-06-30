<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-primary">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Dashboard Monitoring Manajer</h1>
            <p class="text-slate-500 text-base font-normal">Ringkasan eksekutif operasional kargo Bandara Supadio (Hak
                Akses: Manajer Cabang)</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- 1. Volume Kargo Harian (Dinamis dari Controller) --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border-2 border-blue-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-slate-700 text-sm font-medium">Volume Kargo Harian</h3>
                        <p class="text-slate-500 text-xs">Total berat kargo hari ini</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-scales-3-line text-xl"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-baseline gap-2">
                        <h2 class="text-slate-900 text-3xl font-bold">{{ number_format($volumeHariIni, 0, ',', '.') }}
                        </h2>
                        <span class="text-slate-500 text-sm">Kg</span>
                    </div>
                    {{-- Logika Warna Persentase (Naik = Hijau, Turun = Merah) --}}
                    @if($trendVolume >= 0)
                        <p class="text-emerald-600 text-xs font-medium">
                            <i class="ri-arrow-up-line"></i> +{{ number_format($trendVolume, 1, ',', '.') }}% dari kemarin
                        </p>
                    @else
                        <p class="text-red-600 text-xs font-medium">
                            <i class="ri-arrow-down-line"></i> {{ number_format($trendVolume, 1, ',', '.') }}% dari kemarin
                        </p>
                    @endif
                </div>
            </div>

            {{-- 2. Kargo Tertahan (Variabel Dinamis: $totalOffload) --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border-2 border-red-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-slate-700 text-sm font-medium">Kargo Tertahan (Offload)</h3>
                        <p class="text-slate-500 text-xs">Memerlukan atensi pesawat</p>
                    </div>
                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-error-warning-line text-xl"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-baseline gap-2">
                        <h2 class="text-slate-900 text-3xl font-bold">{{ $totalOffload }}</h2>
                        <span class="text-slate-500 text-sm">Unit</span>
                    </div>
                    <p class="text-slate-500 text-xs font-medium">Status anomali aktif</p>
                </div>
            </div>

            {{-- 3. Pending Karantina (Statik Sementara) --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border-2 border-orange-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-slate-700 text-sm font-medium">Pending Karantina</h3>
                        <p class="text-slate-500 text-xs">Tertahan di otoritas</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-shield-keyhole-line text-xl"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-baseline gap-2">
                        <h2 class="text-slate-900 text-3xl font-bold">3</h2>
                        <span class="text-slate-500 text-sm">Unit</span>
                    </div>
                    <p class="text-slate-500 text-xs font-medium">Kondisi Stabil</p>
                </div>
            </div>

            {{-- 4. Komplain Menunggu (Variabel Dinamis: $totalKomplainMenunggu) --}}
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border-2 border-amber-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-slate-700 text-sm font-medium">Komplain Menunggu</h3>
                        <p class="text-slate-500 text-xs">Butuh persetujuan solusi</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-ticket-2-line text-xl"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-baseline gap-2">
                        <h2 class="text-slate-900 text-3xl font-bold">{{ $totalKomplainMenunggu }}</h2>
                        <span class="text-slate-500 text-sm">Tiket</span>
                    </div>
                    <p class="text-amber-600 text-xs font-medium">Mempengaruhi SLA Pengiriman</p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ==============================================================
            TREN VOLUME KARGO (DINAMIS DENGAN FILTER & ALPINE.JS)
            ============================================================== --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col gap-6"
                x-data="{ chartData: {{ json_encode($grafikVolume) }}, maxVol: {{ $maxVolume }}, currentFilter: '{{ $filter }}' }">

                {{-- Header Grafik & Dropdown Filter --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex flex-col gap-1">
                        <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                            <i class="ri-bar-chart-2-line text-slate-500"></i> Tren Volume Kargo
                        </h3>
                        <p class="text-slate-500 text-sm">Fluktuasi volume kargo (Kg) berdasarkan waktu</p>
                    </div>

                    {{-- Komponen Select Filter --}}
                    <div class="relative shrink-0 w-full sm:w-auto">
                        <select x-model="currentFilter" @change="window.location.href = '?filter=' + currentFilter"
                            class="w-full sm:w-auto pl-4 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 font-medium focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none cursor-pointer shadow-sm transition-colors">
                            <option value="harian">7 Hari Terakhir</option>
                            <option value="bulanan">6 Bulan Terakhir</option>
                            <option value="tahunan">5 Tahun Terakhir</option>
                        </select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                            <i class="ri-arrow-down-s-line text-lg"></i>
                        </div>
                    </div>
                </div>

                {{-- Area Grafik --}}
                <div class="relative h-64 flex items-end gap-2 sm:gap-4 mt-2">

                    {{-- Garis Latar Belakang (Grid) --}}
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-6">
                        <div class="border-t border-slate-100 w-full h-0"></div>
                        <div class="border-t border-slate-100 w-full h-0"></div>
                        <div class="border-t border-slate-100 w-full h-0"></div>
                        <div class="border-t border-slate-100 w-full h-0"></div>
                        <div class="border-t border-slate-300 w-full h-0"></div>
                    </div>

                    {{-- Label Y-Axis (Dihitung Reaktif dari maxVol) --}}
                    <div
                        class="absolute left-0 top-0 h-full flex flex-col justify-between text-[10px] sm:text-xs text-slate-400 pb-6 -ml-2 -translate-x-full text-right pointer-events-none">
                        <span x-text="Math.round(maxVol)"></span>
                        <span x-text="Math.round(maxVol * 0.75)"></span>
                        <span x-text="Math.round(maxVol * 0.5)"></span>
                        <span x-text="Math.round(maxVol * 0.25)"></span>
                        <span>0</span>
                    </div>

                    {{-- Render Bar Chart Alpine.js --}}
                    <template x-for="(item, index) in chartData" :key="index">
                        <div class="relative flex-1 flex flex-col justify-end items-center h-full pb-6 group">

                            {{-- Batang Grafik & Tooltip --}}
                            <div class="w-full flex items-end justify-center h-full relative z-10">

                                {{-- Tooltip Hover --}}
                                <div
                                    class="absolute -top-10 bg-slate-800 text-white text-xs py-1.5 px-2.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-20 shadow-lg">
                                    <span x-text="item.label"></span>: <span class="font-bold text-blue-300"
                                        x-text="item.volume + ' Kg'"></span>
                                    {{-- Segitiga panah tooltip bawah --}}
                                    <div
                                        class="absolute w-2 h-2 bg-slate-800 rotate-45 -bottom-1 left-1/2 -translate-x-1/2">
                                    </div>
                                </div>

                                {{-- CSS Bar (Tinggi di-kalkulasi dinamis) --}}
                                <div class="w-full max-w-[40px] bg-blue-500 rounded-t-md transition-all duration-700 ease-out group-hover:bg-blue-600 shadow-sm"
                                    :style="`height: ${(item.volume / maxVol) * 100}%; min-height: ${item.volume > 0 ? '4px' : '0'};`">
                                </div>
                            </div>

                            {{-- Label Hari/Bulan/Tahun (X-Axis) --}}
                            <span class="absolute bottom-0 text-[10px] sm:text-xs text-slate-500 font-medium"
                                x-text="item.hari"></span>
                        </div>
                    </template>

                </div>
                <div class="h-4 w-full"></div>
            </div>

            {{-- Log Aktivitas Pergerakan Kargo Terbaru (Variabel Dinamis Loop: $logTerbaru) --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col gap-4">
                <div class="flex flex-col gap-1">
                    <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                        <i class="ri-history-line text-slate-500"></i> Log Aktivitas Pergerakan Kargo Terbaru
                    </h3>
                    <p class="text-slate-500 text-sm">5 Rekam jejak status operasional time-series terakhir</p>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50 text-slate-600 font-medium">
                            <tr>
                                <th class="px-4 py-3 text-left">Waktu</th>
                                <th class="px-4 py-3 text-left">No. Resi</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($logTerbaru as $log)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">
                                        {{ $log->created_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-blue-600">
                                        {{ $log->kargo->no_resi ?? $log->no_resi }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                                {{ strtolower($log->status) === 'offload' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $log->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500 max-w-xs truncate">
                                        {{ $log->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                                        Belum ada log pergerakan kargo hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="bg-blue-50 rounded-2xl p-6 shadow-sm border border-blue-200 flex items-start gap-4">
            <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 shrink-0">
                <i class="ri-information-fill text-lg"></i>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="text-blue-900 text-base font-semibold">Insight Eksekutif Manajer</h3>
                <p class="text-blue-800 text-sm leading-relaxed">
                    Akses pengawasan aktif. Pantau jumlah kargo berstatus <span
                        class="font-semibold text-amber-900">Offload</span> dan segera lakukan tindakan verifikasi
                    solusi komplain pada menu monitoring jika terdapat berkas komplain <span
                        class="font-semibold text-red-900">Menunggu</span> guna menjaga stabilitas SLA distribusi
                    logistik.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>