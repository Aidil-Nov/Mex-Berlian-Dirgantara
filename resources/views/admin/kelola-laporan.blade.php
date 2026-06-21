<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-sans">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Kelola Laporan</h1>
            <p class="text-slate-600 text-base font-normal">Generate dan unduh laporan keuangan dan operasional</p>
        </div>

        {{-- Flash Message: Error --}}
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 text-sm px-5 py-3 rounded-xl flex items-center gap-2">
            <i class="ri-error-warning-fill text-red-500 text-base"></i>
            {{ session('error') }}
        </div>
        @endif

        {{-- Flash Message: Success --}}
        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-5 py-3 rounded-xl flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-emerald-500 text-base"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- Form Generate Laporan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">

            <div class="p-6 border-b border-slate-100 flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-medium">Generate Laporan Baru</h3>
                <p class="text-slate-500 text-sm">Buat laporan PDF/Excel berdasarkan jenis dan periode waktu</p>
            </div>

            <form action="{{ route('admin.kelola-laporan.generate') }}" method="POST" class="p-6 flex flex-col gap-6">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="jenis_laporan" class="text-slate-900 text-sm font-medium">Jenis Laporan</label>
                    <div class="relative">
                        <select id="jenis_laporan" name="jenis_laporan"
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('jenis_laporan') border-red-400 @else border-slate-200 @enderror rounded-lg text-sm text-slate-600 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition-colors appearance-none cursor-pointer">
                            {{-- Opsi Keuangan Dihapus, Operasional langsung terpilih secara default --}}
                            <option value="operasional" selected>Laporan Operasional Kargo</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <i class="ri-arrow-down-s-line text-lg"></i>
                        </div>
                    </div>
                    @error('jenis_laporan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label for="tgl_mulai" class="text-slate-900 text-sm font-medium">Tanggal Mulai</label>
                        <input type="date" id="tgl_mulai" name="tgl_mulai"
                            value="{{ old('tgl_mulai') }}"
                            class="w-full px-4 py-2 bg-slate-50 border @error('tgl_mulai') border-red-400 @else border-slate-200 @enderror rounded-lg text-sm text-slate-700 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition-colors">
                        @error('tgl_mulai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="tgl_selesai" class="text-slate-900 text-sm font-medium">Tanggal Selesai</label>
                        <input type="date" id="tgl_selesai" name="tgl_selesai"
                            value="{{ old('tgl_selesai') }}"
                            class="w-full px-4 py-2 bg-slate-50 border @error('tgl_selesai') border-red-400 @else border-slate-200 @enderror rounded-lg text-sm text-slate-700 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition-colors">
                        @error('tgl_selesai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label for="status_filter" class="text-slate-900 text-sm font-medium">Status Pengiriman</label>
                        <div class="relative">
                            <select id="status_filter" name="status_filter"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition-colors appearance-none cursor-pointer">
                                <option value="semua"     {{ old('status_filter', 'semua') === 'semua'     ? 'selected' : '' }}>Semua Status</option>
                                <option value="diproses"  {{ old('status_filter') === 'diproses'  ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="offload"   {{ old('status_filter') === 'offload'   ? 'selected' : '' }}>Tertunda / Offload</option>
                                <option value="selesai"   {{ old('status_filter') === 'selesai'   ? 'selected' : '' }}>Selesai / Tiba</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <i class="ri-arrow-down-s-line text-lg"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Pilihan Format Output --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-slate-900 text-sm font-medium">Format Output</label>
                        <div class="flex items-center gap-6 h-[46px]">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="format" value="pdf" checked class="text-slate-900 focus:ring-slate-900">
                                <span class="text-sm text-slate-700">PDF</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="format" value="excel" class="text-slate-900 focus:ring-slate-900">
                                <span class="text-sm text-slate-700">Excel (.xlsx)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 flex items-center gap-2 w-full sm:w-auto justify-center">
                        <i class="ri-file-download-line text-lg"></i> Generate Laporan
                    </button>
                </div>

            </form>
        </div>

        {{-- Tabel Riwayat Laporan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">

            <div class="p-6 border-b border-slate-100 flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-medium">Riwayat Laporan</h3>
                <p class="text-slate-500 text-sm">Daftar laporan yang telah digenerate</p>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-slate-50/50">
                            <th class="px-6 py-4 font-medium">ID Laporan</th>
                            <th class="px-6 py-4 font-medium">Jenis Laporan</th>
                            <th class="px-6 py-4 font-medium">Periode</th>
                            <th class="px-6 py-4 font-medium">Tanggal Cetak</th>
                            <th class="px-6 py-4 font-medium">Dicetak Oleh</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($riwayat as $lap)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $lap->id_laporan }}</td>
                            
                            {{-- PERBAIKAN: Gunakan jenis_laporan dan beri fungsi ucfirst agar huruf depannya besar --}}
                            <td class="px-6 py-4 text-slate-600">{{ ucfirst($lap->jenis_laporan) }}</td>
                            
                            <td class="px-6 py-4 text-slate-600">{{ $lap->periode_label }}</td>
                            
                            {{-- PERBAIKAN: Gunakan created_at karena kita tidak membuat kolom tgl_cetak di database --}}
                            <td class="px-6 py-4 text-slate-600">{{ $lap->created_at->format('d/m/Y H:i') }}</td>
                            
                            <td class="px-6 py-4 text-slate-600">{{ $lap->user->nama ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($lap->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($lap->file_path))
                                    <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-1 rounded-md">Tersedia</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1 rounded-md">File Hilang</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($lap->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($lap->file_path))
                                <a href="{{ route('admin.kelola-laporan.download', $lap->id) }}"
                                    class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 hover:text-sky-600 hover:border-sky-300 flex items-center justify-center gap-1.5 mx-auto transition-all shadow-sm w-fit">
                                    <i class="ri-download-2-line"></i> Unduh
                                </a>
                                @else
                                <span class="text-slate-400 text-xs mx-auto block text-center">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 text-sm">
                                <i class="ri-file-list-3-line text-3xl block mb-2 opacity-40"></i>
                                Belum ada laporan yang digenerate.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="bg-sky-50 rounded-2xl p-6 shadow-sm border border-sky-200 flex items-start gap-4">
            <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-sky-100 text-sky-600 shrink-0">
                <i class="ri-information-fill text-lg"></i>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="text-sky-900 text-base font-semibold">Informasi</h3>
                <p class="text-sky-800 text-sm leading-relaxed max-w-5xl">
                    Laporan akan digenerate dalam format PDF atau Excel dan tersimpan di database. Data diambil sesuai periode yang dipilih.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>