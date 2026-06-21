<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-sans">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Dashboard</h1>
            <p class="text-slate-600 text-base font-normal">Pantauan kilat operasional harian</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-accent flex flex-col justify-center gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <span class="text-slate-700 text-sm font-medium">Total Kargo Masuk</span>
                    <div class="w-9 h-9 bg-accent text-blue rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-inbox-archive-line text-lg"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-slate-900 text-3xl font-bold">{{ $kargoHariIni }}</span>
                    <span class="text-slate-500 text-xs font-normal">Entry hari ini</span>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-purple-200 flex flex-col justify-center gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <span class="text-slate-700 text-sm font-medium">Kargo Loading</span>
                    <div
                        class="w-9 h-9 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-loader-4-line text-lg"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-slate-900 text-3xl font-bold">{{ $kargoLoading }}</span>
                    <span class="text-slate-500 text-xs font-normal">Persiapan armada penerbangan</span>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-red/20 flex flex-col justify-center gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <span class="text-slate-700 text-sm font-medium">Kargo Offload</span>
                    <div class="w-9 h-9 bg-red/10 text-red rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-error-warning-line text-lg"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-slate-900 text-3xl font-bold">{{ $kargoOffload }}</span>
                    <span class="text-slate-500 text-xs font-normal">Memerlukan perhatian</span>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-200 flex flex-col justify-center gap-6 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-center">
                    <span class="text-slate-700 text-sm font-medium">Total Kargo Tiba</span>
                    <div
                        class="w-9 h-9 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                        <i class="ri-checkbox-circle-line text-lg"></i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-slate-900 text-3xl font-bold">{{ $kargoTiba }}</span>
                    <span class="text-slate-500 text-xs font-normal">Diterima hari ini</span>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">

            <div
                class="bg-white p-6 flex flex-col sm:flex-row justify-between sm:items-center gap-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <i class="ri-list-check-2 text-slate-600 text-xl"></i>
                    <h3 class="text-slate-900 text-base font-semibold">Ringkasan Cepat - 5 Kargo Terakhir Diupdate</h3>
                </div>
                <div class="bg-slate-100 border border-slate-200 rounded-lg px-2 py-0.5 w-max">
                    <span
                        class="text-slate-900 text-xs font-medium flex items-center gap-1.5 before:content-[''] before:w-1.5 before:h-1.5 before:bg-green-500 before:rounded-full before:animate-pulse">Live</span>
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-white">
                            <th class="px-6 py-4 font-medium">Nomor Resi</th>
                            <th class="px-6 py-4 font-medium">Asal &rarr; Tujuan</th>
                            <th class="px-6 py-4 font-medium">Status Baru</th>
                            <th class="px-6 py-4 font-medium">Waktu Update</th>
                            <th class="px-6 py-4 font-medium">Admin</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">

                        @forelse ($recentUpdates as $update)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-slate-900 uppercase">{{ $update->no_resi }}</td>
                                <td class="px-6 py-3 text-slate-900">
                                    {{ $update->kargo->kotaAsal->nama_kota ?? '-' }}
                                    <span class="text-slate-400 mx-1">&rarr;</span>
                                    {{ $update->kargo->kotaTujuan->nama_kota ?? '-' }}
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        // Badge status diadaptasi dengan custom theme Anda
                                        $statusColor = match (strtolower($update->status)) {
                                            'entry' => 'bg-slate-100 text-slate-800',
                                            'x-ray' => 'bg-accent text-blue',
                                            'loading' => 'bg-yellow-100 text-yellow-800',
                                            'offload', 'tertunda' => 'bg-red/10 text-red',
                                            'di terima', 'selesai', 'tiba' => 'bg-emerald-100 text-emerald-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="{{ $statusColor }} text-xs font-medium px-2.5 py-1 rounded-md">
                                        {{ ucfirst($update->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ \Carbon\Carbon::parse($update->waktu_update)->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ $update->user->nama ?? 'Sistem' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    <i class="ri-history-line text-2xl mb-2 block"></i>
                                    Belum ada aktivitas pembaruan pengiriman kargo.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-accent/40 rounded-2xl p-6 shadow-sm border border-accent flex items-start gap-4">
            <div
                class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-light text-blue shadow-sm border border-blue/10 shrink-0">
                <i class="ri-lightbulb-flash-fill text-lg"></i>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="text-blue text-base font-semibold">Selamat Datang, {{ Auth::user()->nama ?? 'Admin' }}!
                </h3>
                <p class="text-slate-700 text-sm leading-relaxed max-w-4xl">
                    Gunakan menu navigasi di sebelah kiri untuk mengakses fitur kelola data kargo, update status
                    pengiriman, tracking, dan generate laporan.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>