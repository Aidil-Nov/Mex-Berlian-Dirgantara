<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-sans">
    
    <!-- 1. Header Section -->
    <div class="flex flex-col gap-1">
        <h1 class="text-slate-900 text-2xl font-semibold leading-8">Monitor Operasional Supadio</h1>
        <p class="text-slate-600 text-base font-normal">Pengawasan real-time kinerja admin lapangan dan kargo kritis</p>
    </div>

    <!-- 2. Top Metric Cards (Grid Responsive) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card 1: Kargo Offload -->
        <div class="bg-red-50 rounded-2xl p-6 border-2 border-red-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-alert-fill text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-red-600 text-sm font-medium">Kargo Offload</span>
                    <span class="text-red-900 text-2xl font-bold">3 Unit</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Pending Karantina -->
        <div class="bg-orange-50 rounded-2xl p-6 border-2 border-orange-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-shield-keyhole-fill text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-orange-600 text-sm font-medium">Pending Karantina</span>
                    <span class="text-orange-900 text-2xl font-bold">2 Unit</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Aktivitas Admin -->
        <div class="bg-blue-50 rounded-2xl p-6 border-2 border-blue-200 flex flex-col justify-center gap-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-user-settings-fill text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-blue-600 text-sm font-medium">Aktivitas Admin</span>
                    <span class="text-blue-900 text-2xl font-bold">6 Aksi</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. Daftar Kargo Kritis (Data Table) -->
    <div class="bg-white rounded-2xl shadow-sm border-2 border-red-100 overflow-hidden flex flex-col">
        
        <!-- Table Header & Search -->
        <div class="bg-red-50/50 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-red-100">
            <div class="flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                    <i class="ri-error-warning-line text-red-600 text-lg"></i> Daftar Kargo Kritis - Peringatan Dini
                </h3>
                <p class="text-slate-500 text-sm">Kargo dengan status Offload atau Pending Karantina yang memerlukan tindakan segera</p>
            </div>
            
            <div class="flex items-center gap-2 w-full md:w-auto">
                <div class="bg-zinc-100 rounded-lg px-3 py-2 flex items-center w-full md:w-64 border border-transparent focus-within:border-slate-300 transition-colors">
                    <input type="text" placeholder="Cari nomor resi..." class="bg-transparent border-none focus:ring-0 text-sm w-full p-0 text-slate-700 outline-none">
                </div>
                <button class="bg-white border border-slate-200 rounded-lg p-2 text-slate-600 hover:bg-slate-50 transition-colors">
                    <i class="ri-search-line"></i>
                </button>
            </div>
        </div>

        <!-- Table Container (Scrollable on small screens) -->
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-white">
                        <th class="px-6 py-4">Prioritas</th>
                        <th class="px-6 py-4">Nomor Resi</th>
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Rute</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Waktu Update</th>
                        <th class="px-6 py-4">Keterangan Masalah</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    
                    <!-- Row 1: Tinggi (Offload) -->
                    <tr class="border-b border-slate-100 bg-red-50 hover:bg-red-100/50 transition-colors">
                        <td class="px-6 py-3">
                            <span class="bg-red-600 text-white text-xs font-medium px-2.5 py-1 rounded-md">Tinggi</span>
                        </td>
                        <td class="px-6 py-3 font-medium text-slate-900">KRG-001230</td>
                        <td class="px-6 py-3 text-slate-600">Rina Wijaya</td>
                        <td class="px-6 py-3 text-slate-600">Pontianak &rarr; Makassar</td>
                        <td class="px-6 py-3">
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-md">Offload</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">2026-05-25 07:45</td>
                        <td class="px-6 py-3 text-red-700">Dokumen tidak lengkap - Surat Jalan hilang</td>
                        <td class="px-6 py-3">
                            <button class="bg-white border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1 mx-auto transition-colors shadow-sm">
                                <i class="ri-eye-line"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2: Tinggi (Offload) -->
                    <tr class="border-b border-slate-100 bg-red-50 hover:bg-red-100/50 transition-colors">
                        <td class="px-6 py-3">
                            <span class="bg-red-600 text-white text-xs font-medium px-2.5 py-1 rounded-md">Tinggi</span>
                        </td>
                        <td class="px-6 py-3 font-medium text-slate-900">KRG-001231</td>
                        <td class="px-6 py-3 text-slate-600">Andi Pratama</td>
                        <td class="px-6 py-3 text-slate-600">Pontianak &rarr; Batam</td>
                        <td class="px-6 py-3">
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-md">Offload</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">2026-05-25 08:10</td>
                        <td class="px-6 py-3 text-red-700">Berat melebihi kapasitas pesawat - Butuh koordinasi</td>
                        <td class="px-6 py-3">
                            <button class="bg-white border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1 mx-auto transition-colors shadow-sm">
                                <i class="ri-eye-line"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3: Sedang (Pending Karantina) -->
                    <tr class="border-b border-slate-100 bg-orange-50/50 hover:bg-orange-50 transition-colors">
                        <td class="px-6 py-3">
                            <span class="bg-orange-500 text-white text-xs font-medium px-2.5 py-1 rounded-md">Sedang</span>
                        </td>
                        <td class="px-6 py-3 font-medium text-slate-900">KRG-001228</td>
                        <td class="px-6 py-3 text-slate-600">Sari Indah</td>
                        <td class="px-6 py-3 text-slate-600">Pontianak &rarr; Jakarta</td>
                        <td class="px-6 py-3">
                            <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-1 rounded-md">Pending Karantina</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">2026-05-25 06:20</td>
                        <td class="px-6 py-3 text-red-700">Pending inspeksi karantina - Produk makanan organik</td>
                        <td class="px-6 py-3">
                            <button class="bg-white border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1 mx-auto transition-colors shadow-sm">
                                <i class="ri-eye-line"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Row 4: Sedang (Pending Karantina) -->
                    <tr class="border-b border-slate-100 bg-orange-50/50 hover:bg-orange-50 transition-colors">
                        <td class="px-6 py-3">
                            <span class="bg-orange-500 text-white text-xs font-medium px-2.5 py-1 rounded-md">Sedang</span>
                        </td>
                        <td class="px-6 py-3 font-medium text-slate-900">KRG-001229</td>
                        <td class="px-6 py-3 text-slate-600">Budi Hartono</td>
                        <td class="px-6 py-3 text-slate-600">Pontianak &rarr; Surabaya</td>
                        <td class="px-6 py-3">
                            <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-1 rounded-md">Pending Karantina</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">2026-05-25 07:00</td>
                        <td class="px-6 py-3 text-red-700">Pending sertifikat kesehatan hewan - Kirim ikan hias</td>
                        <td class="px-6 py-3">
                            <button class="bg-white border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1 mx-auto transition-colors shadow-sm">
                                <i class="ri-eye-line"></i> Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Row 5: Rendah (Offload - Reschedule) -->
                    <tr class="bg-white hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3">
                            <span class="bg-slate-400 text-white text-xs font-medium px-2.5 py-1 rounded-md">Rendah</span>
                        </td>
                        <td class="px-6 py-3 font-medium text-slate-900">KRG-001226</td>
                        <td class="px-6 py-3 text-slate-600">Hendra Wijaya</td>
                        <td class="px-6 py-3 text-slate-600">Pontianak &rarr; Medan</td>
                        <td class="px-6 py-3">
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-md">Offload</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">2026-05-24 18:30</td>
                        <td class="px-6 py-3 text-red-700">Space constraints - Pesawat penuh, reschedule besok</td>
                        <td class="px-6 py-3">
                            <button class="bg-white border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 flex items-center gap-1 mx-auto transition-colors shadow-sm">
                                <i class="ri-eye-line"></i> Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Log Aktivitas Admin (Audit Trail) -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col gap-6">
        
        <div class="flex flex-col gap-1">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-history-line text-slate-600 text-lg"></i> Log Aktivitas Admin - Audit Trail
            </h3>
            <p class="text-slate-500 text-sm">Riwayat pengerjaan sistem oleh admin operasional di Bandara Supadio</p>
        </div>
        
        <div class="flex flex-col gap-3">
            
            <!-- Log Item 1 -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 flex flex-col gap-2 hover:border-slate-300 transition-colors">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-slate-500 text-xs font-semibold">2026-05-25 14:35</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Ahmad Fauzi</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Durasi: 2 menit</span>
                </div>
                <p class="text-slate-900 text-sm font-medium">Update status KRG-001240 menjadi Diterima</p>
            </div>

            <!-- Log Item 2 (Highlighted/Warning) -->
            <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200 flex justify-between items-start hover:border-yellow-300 transition-colors">
                <div class="flex flex-col gap-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-slate-500 text-xs font-semibold">2026-05-25 14:22</span>
                        <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Ahmad Fauzi</span>
                        <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Durasi: 5 menit</span>
                    </div>
                    <p class="text-slate-900 text-sm font-medium">Update status KRG-001239 menjadi Offload</p>
                </div>
                <i class="ri-error-warning-fill text-yellow-500 text-xl mt-1"></i>
            </div>

            <!-- Log Item 3 -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 flex flex-col gap-2 hover:border-slate-300 transition-colors">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-slate-500 text-xs font-semibold">2026-05-25 14:05</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Ahmad Fauzi</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Durasi: 1 menit</span>
                </div>
                <p class="text-slate-900 text-sm font-medium">Update status KRG-001237 menjadi On Flight</p>
            </div>

            <!-- Log Item 4 -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 flex flex-col gap-2 hover:border-slate-300 transition-colors">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-slate-500 text-xs font-semibold">2026-05-25 13:50</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Ahmad Fauzi</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Durasi: 8 menit</span>
                </div>
                <p class="text-slate-900 text-sm font-medium">Input data kargo baru KRG-001241</p>
            </div>

            <!-- Log Item 5 -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 flex flex-col gap-2 hover:border-slate-300 transition-colors">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-slate-500 text-xs font-semibold">2026-05-25 13:20</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Ahmad Fauzi</span>
                    <span class="bg-white border border-slate-200 text-slate-800 text-xs font-medium px-2 py-1 rounded-md shadow-sm">Durasi: 4 menit</span>
                </div>
                <p class="text-slate-900 text-sm font-medium">Update status KRG-001235 menjadi X-Ray</p>
            </div>

        </div>
    </div>

</div>
</x-app-layout>