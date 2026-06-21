<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-sans" x-data="{ 
            searchQuery: '', 
            isSearching: false, 
            resiData: null, 
            resiError: null,
            isDetailModalOpen: false,
            detailData: { id: '', resi: '', nama: '', hp: '', email: '', kategori: '', tingkat: '', deskripsi: '', klaim: '', status: '', solusi: '', channel: '', tanggal: '' },
            historySearch: '', 
            
            async checkResi() {
                if(!this.searchQuery) return;
                this.isSearching = true;
                this.resiError = null;
                this.resiData = null;
                try {
                    const response = await fetch(`{{ route('admin.komplain.cek-resi') }}?resi=${this.searchQuery}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const result = await response.json();
                    if(response.ok) {
                        this.resiData = result.data;
                    } else {
                        this.resiError = result.message;
                    }
                } catch (error) {
                    this.resiError = 'Terjadi kesalahan jaringan saat mengecek resi.';
                } finally {
                    this.isSearching = false;
                }
            },

            openDetailModal(data) {
                this.detailData = data;
                this.isDetailModalOpen = true;
            }
        }">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Komplain Customer</h1>
            <p class="text-slate-600 text-base font-normal">Catat dan kelola komplain customer terkait pengiriman kargo
            </p>
        </div>

        {{-- Pesan Sukses & Error Validasi --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <i class="ri-checkbox-circle-fill text-xl"></i><span
                    class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex flex-col gap-1">
                <div class="flex items-center gap-2"><i class="ri-error-warning-fill text-lg"></i> <span
                        class="font-semibold text-sm">Gagal Menyimpan:</span></div>
                <ul class="text-xs list-disc pl-8">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-orange-50 rounded-2xl p-6 shadow-sm border border-orange-200 flex items-start gap-4">
            <div
                class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 shrink-0">
                <i class="ri-alert-fill text-lg"></i>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="text-orange-900 text-base font-semibold">Perhatian</h3>
                <p class="text-orange-800 text-sm leading-relaxed max-w-5xl">
                    Komplain customer harus ditangani dengan cepat dan profesional. Pastikan semua informasi dicatat
                    dengan lengkap dan akurat. Segera lakukan koordinasi dengan maskapai mitra atau tim terkait untuk
                    penanganan lebih lanjut.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden flex flex-col">

            <div class="bg-red-50/50 p-6 border-b border-red-100 flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 text-red-600 rounded-lg flex items-center justify-center shrink-0">
                    <i class="ri-customer-service-2-fill text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h3 class="text-slate-900 text-base font-medium">Form Input Komplain Customer</h3>
                    <p class="text-slate-500 text-sm">Catat komplain yang disampaikan customer melalui telepon, email,
                        atau WhatsApp</p>
                </div>
            </div>

            <form action="{{ route('admin.komplain.store') }}" method="POST" class="p-6 flex flex-col gap-8">
                @csrf

                <input type="hidden" name="no_resi" :value="searchQuery">

                <div class="bg-sky-50 rounded-xl p-6 border border-sky-200 flex flex-col gap-4">
                    <h4 class="text-sky-900 text-sm font-semibold">Data Kargo yang Dikomplain</h4>
                    <div class="flex flex-col gap-2">
                        <label for="resi_komplain" class="text-slate-900 text-sm font-medium">Nomor Resi</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            <input type="text" id="resi_komplain" x-model="searchQuery" placeholder="MEX-XXXXXX"
                                @keyup.enter.prevent="checkResi"
                                class="w-full sm:max-w-md px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 uppercase transition-colors">

                            <button type="button" @click="checkResi"
                                class="w-full sm:w-auto bg-white border border-slate-300 text-slate-900 hover:bg-slate-50 px-6 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                                <i class="ri-search-line" :class="isSearching ? 'animate-spin' : ''"></i>
                                <span x-text="isSearching ? 'Mencari...' : 'Verifikasi Data'"></span>
                            </button>
                        </div>
                        <p x-show="!resiData && !resiError" class="text-sky-600 text-xs mt-1">Masukkan nomor resi dan
                            klik tombol Verifikasi sebelum mencatat komplain.</p>

                        <div x-show="resiError" x-cloak
                            class="mt-2 text-red-600 text-xs font-medium flex items-center gap-1">
                            <i class="ri-error-warning-fill"></i> <span x-text="resiError"></span>
                        </div>

                        <div x-show="resiData" x-cloak x-transition
                            class="mt-3 bg-white p-4 rounded-lg border border-sky-200 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="flex flex-col gap-0.5"><span class="text-slate-500 text-xs">Pengirim:</span>
                                <span class="font-semibold text-slate-900" x-text="resiData.pengirim"></span>
                            </div>
                            <div class="flex flex-col gap-0.5"><span class="text-slate-500 text-xs">Penerima:</span>
                                <span class="font-semibold text-slate-900" x-text="resiData.penerima"></span>
                            </div>
                            <div class="flex flex-col gap-0.5"><span class="text-slate-500 text-xs">Rute:</span> <span
                                    class="font-medium text-slate-900" x-text="resiData.rute"></span></div>
                            <div class="flex flex-col gap-0.5"><span class="text-slate-500 text-xs">Status Saat
                                    Ini:</span> <span class="font-medium text-sky-700 uppercase"
                                    x-text="resiData.status_kargo"></span></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8"
                    :class="!resiData ? 'opacity-50 pointer-events-none grayscale-[50%]' : ''">

                    <div class="flex flex-col gap-5">
                        <h4 class="text-slate-900 text-sm font-semibold border-b border-slate-100 pb-2">Data Customer
                            Pelapor</h4>

                        <div class="flex flex-col gap-2">
                            <label for="nama_pelapor" class="text-slate-900 text-sm font-medium">Nama Customer</label>
                            <input type="text" id="nama_pelapor" name="nama_pelapor"
                                placeholder="Masukkan nama customer pelapor" value="{{ old('nama_pelapor') }}" required
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="hp_pelapor" class="text-slate-900 text-sm font-medium">No. HP Customer</label>
                            <input type="text" id="hp_pelapor" name="hp_pelapor" placeholder="08xxxxxxxxxx"
                                value="{{ old('hp_pelapor') }}" required
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="email_pelapor" class="text-slate-900 text-sm font-medium">Email Customer
                                (Opsional)</label>
                            <input type="email" id="email_pelapor" name="email_pelapor" placeholder="customer@email.com"
                                value="{{ old('email_pelapor') }}"
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>

                    <div class="flex flex-col gap-5">
                        <h4 class="text-slate-900 text-sm font-semibold border-b border-slate-100 pb-2">Detail Komplain
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2">
                                <label for="kategori" class="text-slate-900 text-sm font-medium">Kategori
                                    Komplain</label>
                                <div class="relative">
                                    <select id="kategori" name="kategori" required
                                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 appearance-none cursor-pointer">
                                        <option value="" disabled selected>Pilih kategori</option>
                                        <option value="keterlambatan" {{ old('kategori') == 'keterlambatan' ? 'selected' : '' }}>Keterlambatan Pengiriman</option>
                                        <option value="rusak" {{ old('kategori') == 'rusak' ? 'selected' : '' }}>Barang
                                            Rusak</option>
                                        <option value="hilang" {{ old('kategori') == 'hilang' ? 'selected' : '' }}>Barang
                                            Hilang</option>
                                        <option value="layanan" {{ old('kategori') == 'layanan' ? 'selected' : '' }}>
                                            Pelayanan Staff</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="tingkat_keparahan" class="text-slate-900 text-sm font-medium">Tingkat
                                    Keparahan</label>
                                <div class="relative">
                                    <select id="tingkat_keparahan" name="tingkat_keparahan" required
                                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 appearance-none cursor-pointer">
                                        <option value="" disabled selected>Pilih tingkat</option>
                                        <option value="rendah" {{ old('tingkat_keparahan') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                        <option value="sedang" {{ old('tingkat_keparahan') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="tinggi" {{ old('tingkat_keparahan') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="kritis" {{ old('tingkat_keparahan') == 'kritis' ? 'selected' : '' }}>Kritis (Urgent)</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                        <i class="ri-arrow-down-s-line"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="deskripsi" class="text-slate-900 text-sm font-medium">Deskripsi Lengkap
                                Komplain</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" required
                                placeholder="Jelaskan detail komplain customer: Apa masalahnya? Kapan seharusnya tiba? Kondisi barang seperti apa?"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 resize-none">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="estimasi_klaim" class="text-slate-900 text-sm font-medium">Estimasi Nilai Klaim
                                (Opsional)</label>
                            <input type="text" id="estimasi_klaim" name="estimasi_klaim"
                                value="{{ old('estimasi_klaim') }}" placeholder="Contoh: Rp 5.000.000"
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500">
                            <p class="text-slate-500 text-[11px]">Isi jika customer menyebutkan nilai barang atau
                                kerugian yang dialami</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 bg-slate-50 p-4 border border-slate-200 rounded-xl"
                    :class="!resiData ? 'opacity-50 pointer-events-none' : ''">

                    <div class="flex flex-col gap-3 w-full md:w-auto">
                        <span class="text-slate-700 text-sm font-semibold border-b border-slate-200 pb-1">Komplain
                            Diterima Oleh:</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2">
                            <div class="text-sm"><span class="text-slate-500">Admin: </span><span
                                    class="font-medium text-slate-900">{{ Auth::user()->nama ?? 'Admin' }}</span></div>
                            <div class="text-sm"><span class="text-slate-500">Lokasi: </span><span
                                    class="font-medium text-slate-900">Unit Kargo MEX</span></div>
                            <div class="text-sm"><span class="text-slate-500">Waktu Diterima: </span><span
                                    class="font-medium text-slate-900"
                                    x-text="new Date().toLocaleString('id-ID')"></span></div>
                            <div class="text-sm flex items-center gap-2">
                                <span class="text-slate-500">Channel:</span>
                                <div class="relative w-32">
                                    <select name="channel" required
                                        class="w-full py-1 px-2 bg-white border border-slate-200 rounded text-xs text-slate-900 focus:outline-none appearance-none cursor-pointer">
                                        <option value="telepon">Telepon</option>
                                        <option value="whatsapp">WhatsApp</option>
                                        <option value="email">Email</option>
                                        <option value="langsung">Datang Langsung</option>
                                    </select>
                                    <i
                                        class="ri-arrow-down-s-line absolute right-2 top-1 text-slate-500 text-xs pointer-events-none"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" :disabled="!resiData"
                        class="w-full md:w-auto bg-redhover hover:bg-red text-white px-8 py-3 rounded-lg text-sm font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center justify-center gap-2 shrink-0 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="ri-save-3-line text-lg"></i> Catat Komplain
                    </button>
                </div>

            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">

            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex flex-col gap-1">
                    <h3 class="text-slate-900 text-base font-medium">Riwayat Komplain Customer</h3>
                    <p class="text-slate-500 text-sm">Daftar komplain customer yang telah dicatat dan statusnya</p>
                </div>

                {{-- Search Box untuk Riwayat --}}
                <div class="relative w-full sm:w-72">
                    <input type="text" x-model="historySearch" placeholder="Cari ID, Resi, atau Nama..."
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="ri-search-line"></i>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1000px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-slate-50/50">
                            <th class="px-6 py-4 font-medium">ID Komplain</th>
                            <th class="px-6 py-4 font-medium">Tanggal</th>
                            <th class="px-6 py-4 font-medium">No. Resi</th>
                            <th class="px-6 py-4 font-medium">Nama Customer</th>
                            <th class="px-6 py-4 font-medium">Kategori</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 text-center font-medium">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($komplains as $item)
                            {{-- Logika Pencarian Alpine JS Diletakkan di <tr> --}}
                            <tr x-show="historySearch === '' || $el.innerText.toLowerCase().includes(historySearch.toLowerCase())"
                                class="border-b border-slate-100 hover:bg-slate-50 transition-colors">

                                <td class="px-6 py-4 font-medium text-slate-900">{{ $item->id_komplain }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->created_at->format('d/m/Y, H:i') }}</td>
                                <td class="px-6 py-4 text-slate-900 font-mono">{{ $item->no_resi }}</td>
                                <td class="px-6 py-4 text-slate-900">{{ $item->nama_pelapor }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-slate-100 border border-slate-200 text-slate-800 text-xs font-medium px-2.5 py-1 rounded-md capitalize">
                                        {{ $item->kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match ($item->status) {
                                            'menunggu' => 'bg-amber-100 text-amber-800',
                                            'diproses' => 'bg-sky-100 text-sky-800',
                                            'selesai' => 'bg-emerald-100 text-emerald-800',
                                            default => 'bg-slate-100 text-slate-800'
                                        };
                                        $statusIcon = match ($item->status) {
                                            'menunggu' => 'ri-time-line',
                                            'diproses' => 'ri-loader-4-line animate-spin',
                                            'selesai' => 'ri-check-line',
                                            default => ''
                                        };
                                    @endphp
                                    <span
                                        class="{{ $statusColor }} text-xs font-medium px-2.5 py-1 rounded-md flex items-center w-max gap-1 capitalize">
                                        <i class="{{ $statusIcon }}"></i> {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" @click="openDetailModal({
                                                id: '{{ $item->id_komplain }}',
                                                resi: '{{ $item->no_resi }}',
                                                nama: '{{ $item->nama_pelapor }}',
                                                hp: '{{ $item->hp_pelapor }}',
                                                email: '{{ $item->email_pelapor ?? '-' }}',
                                                kategori: '{{ $item->kategori }}',
                                                tingkat: '{{ $item->tingkat_keparahan }}',
                                                deskripsi: `{{ Js::from($item->deskripsi) }}`,
                                                klaim: '{{ $item->estimasi_klaim ?? '-' }}',
                                                status: '{{ $item->status }}',
                                                solusi: `{{ Js::from($item->tindakan_solusi ?? '') }}`,
                                                channel: '{{ $item->channel }}',
                                                tanggal: '{{ $item->created_at->format('d/m/Y, H:i') }}'
                                            })"
                                        class="text-sky-600 hover:text-sky-800 hover:underline font-medium text-sm">
                                        Lihat Tindakan
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400 text-sm">
                                    <i class="ri-customer-service-2-line text-3xl block mb-2 opacity-40"></i>
                                    Belum ada riwayat komplain yang dicatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-sky-50 rounded-2xl p-6 shadow-sm border border-sky-200 flex items-start gap-4">
            <div class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-sky-100 text-sky-600 shrink-0">
                <i class="ri-information-fill text-lg"></i>
            </div>
            <div class="flex flex-col gap-3 w-full">
                <h3 class="text-sky-900 text-base font-semibold">SLA Penanganan Komplain Customer</h3>
                <ul class="flex flex-col gap-1.5 text-sky-800 text-sm">
                    <li>Komplain <span class="font-bold">Kritis</span>: Respons < 1 jam, penyelesaian < 4 jam</li>
                    <li>Komplain <span class="font-bold">Tinggi</span>: Respons < 2 jam, penyelesaian < 24 jam</li>
                    <li>Komplain <span class="font-bold">Sedang</span>: Respons < 4 jam, penyelesaian < 48 jam</li>
                    <li>Komplain <span class="font-bold">Rendah</span>: Respons < 8 jam, penyelesaian < 72 jam</li>
                </ul>
            </div>
        </div>

        {{-- POP-UP MODAL: LIHAT TINDAKAN & STATUS SOLUSI --}}
        <div x-show="isDetailModalOpen" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
            <div @click.outside="isDetailModalOpen = false"
                class="w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white rounded-2xl shadow-xl border border-slate-200 flex flex-col p-6 gap-6 relative hide-scrollbar">

                {{-- Tombol Silang Pojok Kanan Atas --}}
                <button @click="isDetailModalOpen = false"
                    class="absolute top-6 right-6 opacity-60 hover:opacity-100 text-slate-900">
                    <i class="ri-close-line text-2xl"></i>
                </button>

                <div class="flex flex-col gap-1 w-[90%]">
                    <h2 class="text-slate-900 text-lg font-semibold flex items-center gap-2">
                        <i class="ri-folder-info-line text-sky-600"></i> Detail Penanganan Tiket Komplain
                    </h2>
                    <p class="text-slate-500 text-sm">Informasi keluhan customer dan rekaman tindakan manajemen</p>
                </div>

                {{-- Status & Info Utama --}}
                <div
                    class="grid grid-cols-2 sm:grid-cols-4 bg-slate-50 border border-slate-200 rounded-xl p-4 gap-4 text-xs md:text-sm">
                    <div class="flex flex-col gap-0.5"><span class="text-slate-500">ID Tiket:</span><span
                            class="font-bold text-slate-900" x-text="detailData.id"></span></div>
                    <div class="flex flex-col gap-0.5"><span class="text-slate-500">No. Resi:</span><span
                            class="font-mono font-semibold text-slate-900" x-text="detailData.resi"></span></div>
                    <div class="flex flex-col gap-0.5"><span class="text-slate-500">Tanggal Catat:</span><span
                            class="font-medium text-slate-700" x-text="detailData.tanggal"></span></div>
                    <div class="flex flex-col gap-0.5">
                        <span class="text-slate-500">Status Solusi:</span>
                        <span :class="{
                            'bg-amber-100 text-amber-800 border-amber-200': detailData.status === 'menunggu',
                            'bg-sky-100 text-sky-800 border-sky-200': detailData.status === 'diproses',
                            'bg-emerald-100 text-emerald-800 border-emerald-200': detailData.status === 'selesai'
                        }" class="px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider w-max border mt-0.5"
                            x-text="detailData.status"></span>
                    </div>
                </div>

                {{-- Grid Detail Konten Keluhan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div class="flex flex-col gap-3 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                        <h4
                            class="font-semibold text-slate-900 border-b border-slate-200 pb-1 text-xs uppercase tracking-wider">
                            Informasi Pelapor</h4>
                        <p><span class="text-slate-500">Nama:</span> <span class="font-medium text-slate-800"
                                x-text="detailData.nama"></span></p>
                        <p><span class="text-slate-500">No. HP:</span> <span class="font-medium text-slate-800"
                                x-text="detailData.hp"></span></p>
                        <p><span class="text-slate-500">Email:</span> <span class="font-medium text-slate-800"
                                x-text="detailData.email"></span></p>
                        <p><span class="text-slate-500">Channel:</span> <span
                                class="font-medium text-slate-800 capitalize" x-text="detailData.channel"></span></p>
                    </div>

                    <div class="flex flex-col gap-3 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                        <h4
                            class="font-semibold text-slate-900 border-b border-slate-200 pb-1 text-xs uppercase tracking-wider ">
                            Klasifikasi Masalah</h4>
                        <p><span class="text-slate-500">Kategori:</span> <span
                                class="font-medium text-slate-800 capitalize" x-text="detailData.kategori"></span></p>
                        <p><span class="text-slate-500">Tingkat Parah:</span> <span
                                class="font-medium text-red-600 capitalize" x-text="detailData.tingkat"></span></p>
                        <p><span class="text-slate-500">Estimasi Klaim:</span> <span
                                class="font-medium text-slate-800 font-mono" x-text="detailData.klaim"></span></p>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5 text-sm">
                    <h4 class="font-semibold text-slate-900 text-xs uppercase tracking-wider ">Isi
                        Deskripsi Keluhan Customer:</h4>
                    <div class="bg-slate-50 border border-slate-200 p-3 rounded-xl text-slate-700 leading-relaxed italic"
                        x-text="detailData.deskripsi"></div>
                </div>

                {{-- TANDA BOX FEEDBACK MANAJER (READ-ONLY) --}}
                <div class="flex flex-col gap-2 border-t border-slate-200 pt-4">
                    <h4 class="font-semibold text-slate-900 flex items-center gap-1.5 text-sm">
                        <i class="ri-shield-user-line text-emerald-600"></i> Keputusan & Tindakan Manajer Cabang:
                    </h4>

                    {{-- Kondisi jika manajer sudah mengisi solusi --}}
                    <div x-show="detailData.solusi"
                        class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl text-sm text-emerald-900 leading-relaxed font-medium">
                        <p x-text="detailData.solusi"></p>
                    </div>

                    {{-- Kondisi jika manajer belum memberikan tindakan --}}
                    <div x-show="!detailData.solusi"
                        class="bg-amber-50/60 border border-amber-200 p-4 rounded-xl text-sm text-amber-800 flex items-center gap-2">
                        <i class="ri-time-line text-lg"></i>
                        <span>Belum ada tindakan penanganan resmi dari Manajemen. Tiket sedang dalam antrean review
                            Manajer Cabang.</span>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="button" @click="isDetailModalOpen = false"
                        class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                        Tutup Jendela
                    </button>
                </div>
            </div>
        </div>

    </div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>