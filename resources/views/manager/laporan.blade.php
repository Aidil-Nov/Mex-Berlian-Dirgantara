<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-poppins">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Validasi & Log Laporan</h1>
            <p class="text-slate-500 text-base font-normal">Review dan validasi laporan dari admin lapangan</p>
        </div>

        {{-- STATISTIC CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-amber-50 rounded-2xl p-6 shadow-sm border border-amber-200 flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-alert-line text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-amber-800 text-sm font-medium">Pending Validasi</span>
                    <h2 class="text-slate-900 text-2xl font-bold">{{ $pending->count() }} Laporan</h2>
                </div>
            </div>

            <div class="bg-emerald-50 rounded-2xl p-6 shadow-sm border border-emerald-200 flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-checkbox-circle-line text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-emerald-800 text-sm font-medium">Tervalidasi</span>
                    <h2 class="text-slate-900 text-2xl font-bold">{{ $validated->count() }} Laporan</h2>
                </div>
            </div>
        </div>

        {{-- TABEL 1: PENDING VALIDASI (Untuk Manajer) --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-amber-100 flex flex-col gap-4">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-folder-warning-line text-amber-600"></i> Laporan Pending Validasi
            </h3>

            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600">
                            <th class="px-4 py-3 text-left">ID Laporan</th>
                            <th class="px-4 py-3 text-left">Admin Pembuat</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pending as $lap)
                            <tr>
                                <td class="px-4 py-3">{{ $lap->id_laporan }}</td>
                                <td class="px-4 py-3">{{ $lap->user->name ?? 'Admin' }}</td>
                                <td class="px-4 py-3 text-center">
                                    {{-- FORM VALIDASI --}}
                                    <form action="{{ route('manager.laporan.validate', $lap->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-1 rounded-lg text-xs font-medium">
                                            Validasi Laporan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-slate-400">Tidak ada laporan pending.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TABEL 2: RIWAYAT TERVALIDASI (Download Button Enabled) --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100 flex flex-col gap-4">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-emerald-600"></i> Riwayat Laporan Tervalidasi
            </h3>

            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600">
                            <th class="px-4 py-3 text-left">ID Laporan</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($validated as $lap)
                            <tr>
                                <td class="px-4 py-3">{{ $lap->id_laporan }}</td>
                                <td class="px-4 py-3 text-center">
                                    {{-- Tombol Download Aktif --}}
                                    <a href="{{ route('manager.laporan.download', $lap->id) }}"
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1 rounded-lg text-xs font-medium">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-slate-400">Belum ada laporan tervalidasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>