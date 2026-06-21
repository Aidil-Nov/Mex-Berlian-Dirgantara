<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-sans">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-slate-900 text-2xl font-semibold leading-8">Validasi & Log Laporan</h1>
        <p class="text-slate-600 text-base font-normal">Review dan validasi laporan keuangan dari admin lapangan</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-yellow-50 rounded-2xl p-6 border-2 border-yellow-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-file-warning-fill text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-yellow-600 text-sm font-medium">Pending Validasi</span>
                    <span class="text-yellow-900 text-2xl font-bold">2 Laporan</span>
                </div>
            </div>
        </div>

        <div class="bg-emerald-50 rounded-2xl p-6 border-2 border-emerald-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-checkbox-circle-fill text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-emerald-600 text-sm font-medium">Tervalidasi</span>
                    <span class="text-emerald-900 text-2xl font-bold">3 Laporan</span>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 rounded-2xl p-6 border-2 border-blue-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-wallet-3-fill text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-blue-600 text-sm font-medium">Total Nominal Pending</span>
                    <span class="text-blue-900 text-2xl font-bold">Rp 20.8 Jt</span>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 overflow-hidden flex flex-col">
        
        <div class="bg-yellow-50/50 p-6 flex flex-col border-b border-yellow-100">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-folder-warning-line text-yellow-600 text-lg"></i> Laporan Pending Validasi
            </h3>
            <p class="text-slate-500 text-sm mt-1">Daftar laporan yang memerlukan review dan validasi keuangan dari manajer</p>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-white">
                        <th class="px-6 py-4">ID Laporan</th>
                        <th class="px-6 py-4">Jenis Laporan</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4">Admin Pembuat</th>
                        <th class="px-6 py-4">Total Nominal</th>
                        <th class="px-6 py-4">Jumlah Kargo</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    
                    <tr class="border-b border-slate-100 bg-yellow-50/30 hover:bg-yellow-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">LAP-002</td>
                        <td class="px-6 py-4 text-slate-600">Laporan Operasional</td>
                        <td class="px-6 py-4 text-slate-600">25 Mei 2026</td>
                        <td class="px-6 py-4 text-slate-600">Ahmad Fauzi</td>
                        <td class="px-6 py-4 text-slate-900 font-semibold">Rp 8.300.000</td>
                        <td class="px-6 py-4 text-slate-600">18 unit</td>
                        <td class="px-6 py-4">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-1 rounded-md flex items-center w-max gap-1.5">
                                <i class="ri-time-line"></i> Pending Validasi
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1.5 mx-auto transition-colors shadow-sm">
                                <i class="ri-search-eye-line"></i> Review
                            </button>
                        </td>
                    </tr>

                    <tr class="border-b border-slate-100 bg-yellow-50/30 hover:bg-yellow-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">LAP-001</td>
                        <td class="px-6 py-4 text-slate-600">Laporan Keuangan Harian</td>
                        <td class="px-6 py-4 text-slate-600">25 Mei 2026</td>
                        <td class="px-6 py-4 text-slate-600">Ahmad Fauzi</td>
                        <td class="px-6 py-4 text-slate-900 font-semibold">Rp 12.500.000</td>
                        <td class="px-6 py-4 text-slate-600">24 unit</td>
                        <td class="px-6 py-4">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-1 rounded-md flex items-center w-max gap-1.5">
                                <i class="ri-time-line"></i> Pending Validasi
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1.5 mx-auto transition-colors shadow-sm">
                                <i class="ri-search-eye-line"></i> Review
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden flex flex-col">
        
        <div class="bg-emerald-50/30 p-6 flex flex-col border-b border-emerald-100">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-checkbox-multiple-line text-emerald-600 text-lg"></i> Riwayat Laporan Tervalidasi
            </h3>
            <p class="text-slate-500 text-sm mt-1">Laporan yang telah divalidasi dan terkunci di database cloud</p>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1000px]">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-white">
                        <th class="px-6 py-4">ID Laporan</th>
                        <th class="px-6 py-4">Jenis Laporan</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4">Total Nominal</th>
                        <th class="px-6 py-4">Tanggal Validasi</th>
                        <th class="px-6 py-4">Validator</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    
                    <tr class="border-b border-slate-100 bg-white hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">LAP-003</td>
                        <td class="px-6 py-4 text-slate-600">Laporan Keuangan Harian</td>
                        <td class="px-6 py-4 text-slate-600">24 Mei 2026</td>
                        <td class="px-6 py-4 text-slate-900 font-semibold">Rp 15.200.000</td>
                        <td class="px-6 py-4 text-slate-600">2026-05-24 16:30</td>
                        <td class="px-6 py-4 text-slate-600">Budi Santoso</td>
                        <td class="px-6 py-4">
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-1 rounded-md flex items-center w-max gap-1.5">
                                <i class="ri-check-line"></i> Tervalidasi
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1.5 mx-auto transition-colors shadow-sm">
                                <i class="ri-download-2-line"></i> Download PDF
                            </button>
                        </td>
                    </tr>

                    <tr class="border-b border-slate-100 bg-white hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">LAP-004</td>
                        <td class="px-6 py-4 text-slate-600">Laporan Operasional</td>
                        <td class="px-6 py-4 text-slate-600">24 Mei 2026</td>
                        <td class="px-6 py-4 text-slate-900 font-semibold">Rp 9.800.000</td>
                        <td class="px-6 py-4 text-slate-600">2026-05-24 16:45</td>
                        <td class="px-6 py-4 text-slate-600">Budi Santoso</td>
                        <td class="px-6 py-4">
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-1 rounded-md flex items-center w-max gap-1.5">
                                <i class="ri-check-line"></i> Tervalidasi
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1.5 mx-auto transition-colors shadow-sm">
                                <i class="ri-download-2-line"></i> Download PDF
                            </button>
                        </td>
                    </tr>

                    <tr class="bg-white hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">LAP-005</td>
                        <td class="px-6 py-4 text-slate-600">Laporan Keuangan Harian</td>
                        <td class="px-6 py-4 text-slate-600">23 Mei 2026</td>
                        <td class="px-6 py-4 text-slate-900 font-semibold">Rp 11.700.000</td>
                        <td class="px-6 py-4 text-slate-600">2026-05-23 17:00</td>
                        <td class="px-6 py-4 text-slate-600">Budi Santoso</td>
                        <td class="px-6 py-4">
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-1 rounded-md flex items-center w-max gap-1.5">
                                <i class="ri-check-line"></i> Tervalidasi
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1.5 mx-auto transition-colors shadow-sm">
                                <i class="ri-download-2-line"></i> Download PDF
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-slate-50 rounded-2xl p-6 shadow-sm border border-slate-200 flex items-start gap-4">
        <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 text-slate-700 shrink-0">
            <i class="ri-information-line text-lg"></i>
        </div>
        <div class="flex flex-col gap-1">
            <h3 class="text-slate-900 text-base font-semibold">Informasi Validasi Laporan</h3>
            <p class="text-slate-600 text-sm leading-relaxed">
                Sebagai Manajer Cabang, Anda memiliki wewenang untuk melakukan validasi keuangan terhadap laporan yang di-generate oleh Admin Lapangan Supadio. Proses validasi ini memastikan bahwa semua data keuangan telah diperiksa dan disetujui sebelum masuk ke rekapitulasi jangka panjang perusahaan. Laporan yang telah tervalidasi akan terkunci di database cloud dan bebas dari manipulasi data.
            </p>
        </div>
    </div>

</div>
</x-app-layout>