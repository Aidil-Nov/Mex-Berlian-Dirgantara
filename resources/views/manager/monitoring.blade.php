<x-app-layout>
    {{-- Inisialisasi Alpine.js untuk fitur pencarian tabel secara Real-Time --}}
    <div class="w-full flex flex-col gap-6 font-primary" x-data="{ searchKritis: '' }">

        <div class="flex flex-col gap-1">
            <h1 class="text-surface-text text-2xl font-semibold leading-8">Monitor Operasional Supadio</h1>
            <p class="text-surface-muted text-base font-normal">Pengawasan real-time kinerja admin lapangan dan kargo
                kritis
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div
                class="bg-red-50 rounded-2xl p-6 border-2 border-red-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-alert-fill text-2xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-red-600 text-sm font-medium">Kargo Offload</span>
                        <span class="text-red-900 text-2xl font-bold">{{ $kargoOffloadCount }} Unit</span>
                    </div>
                </div>
            </div>

            <div
                class="bg-blue-50 rounded-2xl p-6 border-2 border-blue-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-user-settings-fill text-2xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-blue-600 text-sm font-medium">Keluhan Menunggu Validasi</span>
                        <span class="text-blue-900 text-2xl font-bold">{{ $keluhanMasukCount }} Laporan</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border-2 border-red-100 overflow-hidden flex flex-col">

            <div
                class="bg-red-50/50 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-red-100">
                <div class="flex flex-col gap-1">
                    <h3 class="text-surface-text text-base font-semibold flex items-center gap-2">
                        <i class="ri-error-warning-line text-red-600 text-lg"></i> Daftar Kargo Kritis - Peringatan Dini
                    </h3>
                    <p class="text-surface-muted text-sm">Kargo dengan status Offload atau anomali yang memerlukan
                        tindakan segera</p>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto">
                    <div
                        class="bg-zinc-100 rounded-lg px-3 py-2 flex items-center w-full md:w-64 border border-transparent focus-within:border-surface-border transition-colors">
                        {{-- Input terhubung ke state Alpine x-model="searchKritis" --}}
                        <input type="text" x-model="searchKritis" placeholder="Cari resi atau nama pengirim..."
                            class="bg-transparent border-none focus:ring-0 text-sm w-full p-0 text-surface-text outline-none placeholder-surface-muted">
                    </div>
                    <button
                        class="bg-white border border-surface-border rounded-lg p-2 text-surface-muted hover:bg-slate-50 transition-colors">
                        <i class="ri-search-line"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                    <thead>
                        <tr class="border-b border-surface-border text-surface-text text-sm font-semibold bg-white">
                            <th class="px-6 py-4">Nomor Resi</th>
                            <th class="px-6 py-4">Pengirim</th>
                            <th class="px-6 py-4">Rute</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Waktu Update</th>
                            <th class="px-6 py-4">Keterangan Masalah</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">

                        {{-- Perulangan dari Controller (Data Real Database) --}}
                        @forelse($kargoKritis as $item)
                            {{-- Logika Alpine.js: Tampilkan baris jika search kosong atau teks cocok --}}
                            <tr x-show="searchKritis === '' || $el.innerText.toLowerCase().includes(searchKritis.toLowerCase())"
                                class="border-b border-slate-100 bg-red-50/30 hover:bg-red-50/70 transition-colors">

                                <td class="px-6 py-3 font-medium text-surface-text">{{ $item->no_resi }}</td>
                                <td class="px-6 py-3 text-surface-muted">{{ $item->pengirim->nama ?? '-' }}</td>
                                <td class="px-6 py-3 text-surface-muted">
                                    {{ $item->kotaAsal->nama_kota ?? '-' }} &rarr; {{ $item->kotaTujuan->nama_kota ?? '-' }}
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-md uppercase">
                                        {{ $item->status_terakhir }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-surface-muted">
                                    {{ $item->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-3 text-red-700 max-w-xs truncate">
                                    {{ $item->history->first()->keterangan ?? 'Menunggu keterangan lanjutan lapangan' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-surface-muted">
                                    <i class="ri-checkbox-circle-line text-2xl mb-2 block text-emerald-500"></i>
                                    Tidak ada kargo kritis/offload saat ini. Operasional berjalan lancar.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-surface-border p-6 flex flex-col gap-6">

            <div class="flex flex-col gap-1">
                <h3 class="text-surface-text text-base font-semibold flex items-center gap-2">
                    <i class="ri-history-line text-surface-muted text-lg"></i> Log Aktivitas Admin - Audit Trail
                </h3>
                <p class="text-surface-muted text-sm">Riwayat otomatis sistem di Bandara Supadio (Menampilkan 10 log
                    terbaru)</p>
            </div>

            <div class="flex flex-col gap-3">

                @forelse($auditTrail as $log)
                    {{-- Beri warna kuning/warning jika statusnya Offload --}}
                    @php
                        $isWarning = strtolower($log->status) === 'offload';
                        $bgColor = $isWarning ? 'bg-yellow-50 border-yellow-200 hover:border-yellow-300' : 'bg-slate-50 border-slate-200 hover:border-slate-300';
                    @endphp

                    <div class="rounded-xl p-4 border {{ $bgColor }} flex justify-between items-start transition-colors">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="text-surface-muted text-xs font-semibold">
                                    {{ $log->created_at ? $log->created_at->format('d M Y, H:i') : 'Tanggal tidak tersedia' }}
                                </span>
                                <span
                                    class="bg-white border border-surface-border text-surface-text text-xs font-medium px-2 py-1 rounded-md shadow-sm">
                                    <i class="ri-user-line mr-1"></i> {{ $log->user->nama ?? 'Sistem / Guest' }}
                                </span>
                            </div>
                            <p class="text-surface-text text-sm font-medium">
                                Update status resi <span class="font-bold">{{ $log->no_resi }}</span> menjadi <span
                                    class="uppercase font-bold">{{ $log->status }}</span>
                            </p>
                            @if($log->keterangan)
                                <p class="text-surface-muted text-xs italic">Catatan: "{{ $log->keterangan }}"</p>
                            @endif
                        </div>

                        @if($isWarning)
                            <i class="ri-error-warning-fill text-yellow-500 text-xl mt-1"></i>
                        @else
                            <i class="ri-check-double-line text-emerald-500 text-xl mt-1"></i>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-surface-muted py-6">
                        Belum ada aktivitas yang direkam sistem.
                    </div>
                @endforelse

            </div>
        </div>

    </div>
</x-app-layout>