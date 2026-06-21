<x-app-layout>
<div class="w-full flex flex-col gap-6 font-poppins">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-slate-900 text-2xl font-semibold leading-8">Dashboard Monitoring Utama</h1>
        <p class="text-slate-500 text-base font-normal">Ringkasan eksekutif operasional kargo Bandara Supadio</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border-2 border-blue-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex flex-col gap-1">
                    <h3 class="text-slate-700 text-sm font-medium">Volume Kargo Harian</h3>
                    <p class="text-slate-500 text-xs">Total berat kargo hari ini</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-scales-3-line text-xl"></i>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-baseline gap-2">
                    <h2 class="text-slate-900 text-3xl font-bold">2,847</h2>
                    <span class="text-slate-500 text-sm">Kg</span>
                </div>
                <p class="text-emerald-600 text-xs font-medium"><i class="ri-arrow-up-line"></i> +12% dari kemarin</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border-2 border-red-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex flex-col gap-1">
                    <h3 class="text-slate-700 text-sm font-medium">Kargo Tertahan (Offload)</h3>
                    <p class="text-slate-500 text-xs">Memerlukan perhatian</p>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-error-warning-line text-xl"></i>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-baseline gap-2">
                    <h2 class="text-slate-900 text-3xl font-bold">7</h2>
                    <span class="text-slate-500 text-sm">Unit</span>
                </div>
                <p class="text-slate-500 text-xs font-medium">-2 dari kemarin</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border-2 border-orange-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex flex-col gap-1">
                    <h3 class="text-slate-700 text-sm font-medium">Pending Karantina</h3>
                    <p class="text-slate-500 text-xs">Tertahan di otoritas</p>
                </div>
                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center shrink-0">
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

        <div class="bg-white rounded-2xl p-6 shadow-sm border-2 border-emerald-100 flex flex-col gap-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex flex-col gap-1">
                    <h3 class="text-slate-700 text-sm font-medium">Validasi Keuangan</h3>
                    <p class="text-slate-500 text-xs">Siap divalidasi hari ini</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="ri-secure-payment-line text-xl"></i>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-baseline gap-2">
                    <h2 class="text-slate-900 text-3xl font-bold">Rp 24.5</h2>
                    <span class="text-slate-500 text-sm">Juta</span>
                </div>
                <p class="text-slate-500 text-xs font-medium">8 laporan pending</p>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                    <i class="ri-bar-chart-2-line text-slate-500"></i> Tren Volume Kargo Mingguan
                </h3>
                <p class="text-slate-500 text-sm">Fluktuasi volume kargo (Kg) dalam 7 hari terakhir</p>
            </div>
            
            <div class="relative h-64 flex items-end gap-2 sm:gap-4 mt-4">
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                    <div class="border-t border-slate-100 w-full h-0"></div>
                    <div class="border-t border-slate-100 w-full h-0"></div>
                    <div class="border-t border-slate-100 w-full h-0"></div>
                    <div class="border-t border-slate-100 w-full h-0"></div>
                    <div class="border-t border-slate-300 w-full h-0"></div> </div>
                
                <div class="absolute left-0 top-0 h-full flex flex-col justify-between text-xs text-slate-400 pb-6 -ml-2 -translate-x-full text-right">
                    <span>3000</span>
                    <span>2250</span>
                    <span>1500</span>
                    <span>750</span>
                    <span>0</span>
                </div>

                <div class="relative flex-1 flex flex-col justify-end items-center h-[70%] group">
                    <div class="w-full max-w-[40px] bg-blue-500 rounded-t-sm h-full group-hover:bg-blue-600 transition-colors"></div>
                    <span class="absolute -bottom-6 text-xs text-slate-500">Sen</span>
                </div>
                <div class="relative flex-1 flex flex-col justify-end items-center h-[50%] group">
                    <div class="w-full max-w-[40px] bg-blue-500 rounded-t-sm h-full group-hover:bg-blue-600 transition-colors"></div>
                    <span class="absolute -bottom-6 text-xs text-slate-500">Sel</span>
                </div>
                <div class="relative flex-1 flex flex-col justify-end items-center h-[35%] group">
                    <div class="w-full max-w-[40px] bg-blue-500 rounded-t-sm h-full group-hover:bg-blue-600 transition-colors"></div>
                    <span class="absolute -bottom-6 text-xs text-slate-500">Rab</span>
                </div>
                <div class="relative flex-1 flex flex-col justify-end items-center h-[45%] group">
                    <div class="w-full max-w-[40px] bg-blue-500 rounded-t-sm h-full group-hover:bg-blue-600 transition-colors"></div>
                    <span class="absolute -bottom-6 text-xs text-slate-500">Kam</span>
                </div>
                <div class="relative flex-1 flex flex-col justify-end items-center h-[15%] group">
                    <div class="w-full max-w-[40px] bg-blue-500 rounded-t-sm h-full group-hover:bg-blue-600 transition-colors"></div>
                    <span class="absolute -bottom-6 text-xs text-slate-500">Jum</span>
                </div>
                <div class="relative flex-1 flex flex-col justify-end items-center h-[85%] group">
                    <div class="w-full max-w-[40px] bg-blue-500 rounded-t-sm h-full group-hover:bg-blue-600 transition-colors"></div>
                    <span class="absolute -bottom-6 text-xs text-slate-500">Sab</span>
                </div>
                <div class="relative flex-1 flex flex-col justify-end items-center h-[100%] group">
                    <div class="w-full max-w-[40px] bg-blue-500 rounded-t-sm h-full group-hover:bg-blue-600 transition-colors"></div>
                    <span class="absolute -bottom-6 text-xs text-slate-500">Min</span>
                </div>
            </div>
            <div class="h-4 w-full"></div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold">Distribusi Status Kargo</h3>
                <p class="text-slate-500 text-sm">Persentase berdasarkan status terakhir</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 mt-2 h-full">
                <div class="w-48 h-48 rounded-full shrink-0 shadow-inner" 
                     style="background: conic-gradient(#10b981 0% 70%, #8b5cf6 70% 90%, #ef4444 90% 97%, #f59e0b 97% 100%);">
                     </div>
                
                <div class="flex flex-col gap-4 w-full">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                            <span class="text-sm text-slate-700">Tiba di Tujuan</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-900">70%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-violet-500 rounded-full"></div>
                            <span class="text-sm text-slate-700">On Flight</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-900">20%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-slate-700">Offload</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-900">7%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                            <span class="text-sm text-slate-700">Pending Karantina</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-900">3%</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-blue-50 rounded-2xl p-6 shadow-sm border border-blue-200 flex items-start gap-4">
        <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 shrink-0">
            <i class="ri-information-fill text-lg"></i>
        </div>
        <div class="flex flex-col gap-1">
            <h3 class="text-blue-900 text-base font-semibold">Insight Eksekutif</h3>
            <p class="text-blue-800 text-sm leading-relaxed">
                Volume kargo minggu ini menunjukkan tren positif dengan peningkatan 12% dibanding minggu lalu. Namun, perhatian khusus diperlukan untuk 7 kargo offload yang memerlukan koordinasi dengan maskapai mitra. Sistem deteksi otomatis telah mengirim notifikasi ke admin lapangan untuk penanganan segera.
            </p>
        </div>
    </div>

</div>
</x-app-layout>