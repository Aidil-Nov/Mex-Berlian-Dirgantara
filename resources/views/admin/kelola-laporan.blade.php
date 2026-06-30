<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-sans">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Kelola Laporan</h1>
            <p class="text-slate-600 text-base font-normal">Generate, pantau status validasi, dan unduh laporan operasional</p>
        </div>

        {{-- Flash Messages --}}
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 text-sm px-5 py-3 rounded-xl flex items-center gap-2">
            <i class="ri-error-warning-fill text-red-500 text-base"></i> {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-5 py-3 rounded-xl flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-emerald-500 text-base"></i> {{ session('success') }}
        </div>
        @endif

        {{-- Form Generate (Tetap Sama) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-medium">Generate Laporan Baru</h3>
                <p class="text-slate-500 text-sm">Laporan akan masuk ke antrean "Pending Validasi" sebelum dapat diunduh</p>
            </div>
            <form action="{{ route('admin.kelola-laporan.generate') }}" method="POST" class="p-6 flex flex-col gap-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <input type="hidden" name="jenis_laporan" value="operasional">
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 text-sm font-medium">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 text-sm font-medium">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 text-sm font-medium">Status Kargo</label>
                        <select name="status_filter" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                            <option value="semua">Semua Status</option>
                            <option value="diproses">Sedang Diproses</option>
                            <option value="offload">Tertunda</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 text-sm font-medium">Format</label>
                        <div class="flex items-center gap-4 h-full">
                            <label class="flex items-center gap-2"><input type="radio" name="format" value="pdf" checked> PDF</label>
                            <label class="flex items-center gap-2"><input type="radio" name="format" value="excel"> Excel</label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                        Generate Laporan
                    </button>
                </div>
            </form>
        </div>

        {{-- TABEL 1: LAPORAN PENDING --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-amber-100 flex flex-col gap-4">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-time-line text-amber-600"></i> Laporan Menunggu Validasi ({{ $pending->count() }})
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-left">ID Laporan</th>
                            <th class="px-4 py-3 text-left">Periode</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pending as $lap)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $lap->id_laporan }}</td>
                            <td class="px-4 py-3">{{ $lap->periode_label }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-md">Pending</span>
                            </td>
                            <td class="px-4 py-3 text-center text-slate-400 italic text-xs">Menunggu Manajer</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-slate-400">Tidak ada laporan pending.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TABEL 2: RIWAYAT TERVALIDASI --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100 flex flex-col gap-4">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-emerald-600"></i> Riwayat Laporan Tervalidasi ({{ $validated->count() }})
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-left">ID Laporan</th>
                            <th class="px-4 py-3 text-left">Periode</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($validated as $lap)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $lap->id_laporan }}</td>
                            <td class="px-4 py-3">{{ $lap->periode_label }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-md">Tervalidasi</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.kelola-laporan.download', $lap->id) }}" class="text-sky-600 hover:text-sky-800 font-medium underline">
                                    <i class="ri-download-2-line"></i> Unduh
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-slate-400">Belum ada laporan tervalidasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>