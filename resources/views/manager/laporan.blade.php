<x-app-layout>
<div class="w-full flex flex-col gap-6 font-poppins">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-slate-900 text-2xl font-semibold leading-8">Validasi & Log Laporan</h1>
        <p class="text-slate-500 text-base font-normal">Review dan validasi laporan dari admin lapangan</p>
    </div>

    {{-- STATISTIC CARDS (Sekarang hanya 2 kolom, kartu nominal pending dihapus) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- Pending Validasi --}}
        <div class="bg-amber-50 rounded-2xl p-6 shadow-sm border border-amber-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center shrink-0">
                <i class="ri-alert-line text-2xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-amber-800 text-sm font-medium">Pending Validasi</span>
                <h2 class="text-slate-900 text-2xl font-bold">2 Laporan</h2>
            </div>
        </div>

        {{-- Tervalidasi --}}
        <div class="bg-emerald-50 rounded-2xl p-6 shadow-sm border border-emerald-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center shrink-0">
                <i class="ri-checkbox-circle-line text-2xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-emerald-800 text-sm font-medium">Tervalidasi</span>
                <h2 class="text-slate-900 text-2xl font-bold">3 Laporan</h2>
            </div>
        </div>

    </div>

    {{-- TABEL 1: LAPORAN PENDING VALIDASI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-amber-100 flex flex-col gap-4">
        <div class="flex flex-col gap-1">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-folder-warning-line text-amber-600"></i> Laporan Pending Validasi
            </h3>
            <p class="text-slate-500 text-sm">Daftar laporan yang memerlukan review dan validasi dari manajer</p>
        </div>
        
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="px-4 py-3 text-left">ID Laporan</th>
                        <th class="px-4 py-3 text-left">Jenis Laporan</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Admin Pembuat</th>
                        <th class="px-4 py-3 text-left">Jumlah Kargo</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap font-medium text-slate-900">LAP-002</td>
                        <td class="px-4 py-3 whitespace-nowrap">Laporan Operasional</td>
                        <td class="px-4 py-3 whitespace-nowrap">25 Mei 2026</td>
                        <td class="px-4 py-3 whitespace-nowrap">Ahmad Fauzi</td>
                        <td class="px-4 py-3 whitespace-nowrap">18 unit</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending Validasi</span>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <button class="border border-slate-200 hover:bg-slate-50 text-slate-700 px-3 py-1 rounded-lg text-xs font-medium transition-colors shadow-sm">Review</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap font-medium text-slate-900">LAP-001</td>
                        <td class="px-4 py-3 whitespace-nowrap">Laporan Keuangan Harian</td>
                        <td class="px-4 py-3 whitespace-nowrap">25 Mei 2026</td>
                        <td class="px-4 py-3 whitespace-nowrap">Ahmad Fauzi</td>
                        <td class="px-4 py-3 whitespace-nowrap">24 unit</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending Validasi</span>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <button class="border border-slate-200 hover:bg-slate-50 text-slate-700 px-3 py-1 rounded-lg text-xs font-medium transition-colors shadow-sm">Review</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABEL 2: RIWAYAT LAPORAN TERVALIDASI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100 flex flex-col gap-4">
        <div class="flex flex-col gap-1">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-emerald-600"></i> Riwayat Laporan Tervalidasi
            </h3>
            <p class="text-slate-500 text-sm">Laporan yang telah divalidasi dan terkunci di database cloud</p>
        </div>
        
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="px-4 py-3 text-left">ID Laporan</th>
                        <th class="px-4 py-3 text-left">Jenis Laporan</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Tanggal Validasi</th>
                        <th class="px-4 py-3 text-left">Validator</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap font-medium text-slate-900">LAP-003</td>
                        <td class="px-4 py-3 whitespace-nowrap">Laporan Keuangan Harian</td>
                        <td class="px-4 py-3 whitespace-nowrap">24 Mei 2026</td>
                        <td class="px-4 py-3 whitespace-nowrap">2026-05-24 16:30</td>
                        <td class="px-4 py-3 whitespace-nowrap">Budi Santoso</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Tervalidasi</span>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <button class="border border-slate-200 hover:bg-slate-50 text-slate-700 px-3 py-1 rounded-lg text-xs font-medium transition-colors shadow-sm">Download PDF</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-app-layout>