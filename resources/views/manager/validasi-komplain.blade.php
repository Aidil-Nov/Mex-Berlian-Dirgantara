<x-app-layout>
<div class="w-full flex flex-col gap-6 font-poppins">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-slate-900 text-2xl font-semibold leading-8">Validasi & Solusi Keluhan</h1>
        <p class="text-slate-500 text-base font-normal">Otorisasi berkas tindakan keluhan dari pelanggan operasional bandara</p>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-5 py-3 rounded-xl flex items-center gap-2 shadow-sm">
        <i class="ri-checkbox-circle-fill text-emerald-500 text-base"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- TABEL 1: KOMPLAIN MENUNGGU VALIDASI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-amber-100 flex flex-col gap-4">
        <div class="flex flex-col gap-1">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-alert-line text-amber-600"></i> Komplain Menunggu Validasi Manajer
            </h3>
            <p class="text-slate-500 text-sm">Daftar tiket aktif yang membutuhkan keputusan instruksi solusi lapangan</p>
        </div>
        
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="px-4 py-3 text-left">No. Resi Kargo</th>
                        <th class="px-4 py-3 text-left">Tanggal Masuk</th>
                        <th class="px-4 py-3 text-left">Isi Keluhan Pelanggan</th>
                        <th class="px-4 py-3 text-center">Aksi Pengisian Solusi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($komplainPending as $k)
                        <tr class="hover:bg-slate-50 transition-colors">
                            {{-- PERBAIKAN AMAN: Mengambil data langsung dari object utama komplain --}}
                            <td class="px-4 py-3 whitespace-nowrap font-medium text-blue-600">
                                {{ $k->no_resi ?? $k->kargo_id ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $k->created_at ? $k->created_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600 max-w-xs truncate">
                                {{ $k->deskripsi_komplain ?? $k->keluhan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <form action="{{ route('manager.komplain.solusi', $k->id ?? $k->id_komplain ?? 0) }}" method="POST" class="inline-flex gap-2 items-center justify-center">
                                    @csrf
                                    <input type="text" name="tindakan_solusi" placeholder="Ketik instruksi solusi disini..." class="px-3 py-1 text-xs border border-slate-200 rounded-lg focus:outline-none focus:border-slate-400 w-64" required>
                                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-3 py-1 rounded-lg text-xs font-medium transition-colors shadow-sm flex items-center gap-1">
                                        <i class="ri-checkbox-circle-line"></i> Validasi Solusi
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                                <i class="ri-customer-service-line text-2xl block mb-1 opacity-50"></i>
                                Tidak ada data komplain berstatus menunggu tindakan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABEL 2: RIWAYAT KOMPLAIN SELESAI --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100 flex flex-col gap-4">
        <div class="flex flex-col gap-1">
            <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                <i class="ri-history-line text-emerald-600"></i> Log Riwayat Keluhan Selesai
            </h3>
            <p class="text-slate-500 text-sm">Rekam jejak keluhan yang telah diselesaikan tindakan solusinya</p>
        </div>
        
        <div class="overflow-x-auto w-full">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="px-4 py-3 text-left">No. Resi Kargo</th>
                        <th class="px-4 py-3 text-left">Keluhan</th>
                        <th class="px-4 py-3 text-left">Tanggal Selesai</th>
                        <th class="px-4 py-3 text-left">Tindakan Solusi Terpilih</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($komplainSelesai as $ks)
                        <tr class="hover:bg-slate-50 transition-colors">
                            {{-- PERBAIKAN AMAN: Mengambil data langsung dari object utama komplain --}}
                            <td class="px-4 py-3 whitespace-nowrap font-medium text-slate-900">
                                {{ $ks->no_resi ?? $ks->kargo_id ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500 max-w-xs truncate">
                                {{ $ks->deskripsi_komplain ?? $ks->keluhan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $ks->updated_at ? $ks->updated_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600 font-medium">
                                {{ $ks->tindakan_solusi ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    {{ ucfirst($ks->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                Belum ada log riwayat komplain yang berstatus selesai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-app-layout>