<x-app-layout>
    <div x-data="{ 
            activeTab: 'diproses', 
            isModalOpen: false,
            isDropdownOpen: false,
            searchQuery: '', // <-- Variabel untuk Search Box
            penerbanganAktif: {{ $penerbanganAktif }}, 
            modalData: {
                resi: '', pengirim: '', asal: '', tujuan: '', status_saat_ini: '', id_asal: '', id_tujuan: ''
            },
            openModal(resi, pengirim, asal, tujuan, status, id_asal, id_tujuan) {
                this.modalData = { resi, pengirim, asal, tujuan, status_saat_ini: status, id_asal, id_tujuan };
                this.form.status = '';
                this.form.keterangan = '';
                this.isModalOpen = true;
            },
            form: { status: '', keterangan: '' },
            selectStatus(statusName) {
                this.form.status = statusName;
                this.isDropdownOpen = false;
            },
            // ==========================================
            // LOGIKA STATE MACHINE (ATURAN LOMPAT STATUS)
            // ==========================================
            isStatusDisabled(optionName) {
                const current = this.modalData.status_saat_ini ? this.modalData.status_saat_ini.toLowerCase() : '';
                const option = optionName.toLowerCase();

                // Offload selalu terbuka kapan saja (kecuali sudah selesai, tapi modal Selesai kan disabled)
                if (option === 'offload') return false;

                // Aturan Urutan
                if (current === 'entry') return option !== 'x-ray';
                if (current === 'x-ray') return option !== 'loading';          
                if (current === 'loading' || current === 'on flight') return true; 
                if (current === 'landing') return option !== 'di terima';
                // Jika sedang Offload, bisa dikembalikan ke track normal
                if (current === 'offload') return !['entry', 'x-ray', 'loading'].includes(option);
                return true; 
            }
        }" class="w-full flex flex-col gap-6 font-sans p-6 md:p-8 relative">

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <i class="ri-checkbox-circle-fill text-xl"></i><span
                    class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
                <i class="ri-error-warning-fill text-xl"></i><span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Kelola Status Pengiriman</h1>
            <p class="text-slate-600 text-base font-normal">Update dan pantau status pengiriman kargo</p>
        </div>

        {{-- Wrapper untuk Tabs dan Search Box --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

            {{-- Bagian Tab Navigasi --}}
            <div class="w-full overflow-x-auto hide-scrollbar">
                <div class="inline-flex bg-slate-200/80 p-1.5 rounded-2xl gap-1 min-w-max">
                    <button @click="activeTab = 'diproses'"
                        :class="activeTab === 'diproses' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-300/50'"
                        class="px-5 py-2 rounded-xl text-sm font-medium transition-all focus:outline-none">
                        Sedang Diproses
                    </button>
                    <button @click="activeTab = 'tertunda'"
                        :class="activeTab === 'tertunda' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-300/50'"
                        class="px-5 py-2 rounded-xl text-sm font-medium transition-all focus:outline-none flex items-center gap-2">
                        Tertunda / Offload
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    </button>
                    <button @click="activeTab = 'selesai'"
                        :class="activeTab === 'selesai' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-300/50'"
                        class="px-5 py-2 rounded-xl text-sm font-medium transition-all focus:outline-none">
                        Selesai / Tiba di Tujuan
                    </button>
                </div>
            </div>

            {{-- Bagian Search Box --}}
            <div class="relative w-full sm:w-80 shrink-0">
                <input type="text" x-model="searchQuery" placeholder="Cari Resi, Pengirim, atau Kota..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors shadow-sm">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i class="ri-search-line text-lg"></i>
                </div>
            </div>

        </div>

        {{-- ============================== TAB 1: DIPROSES ============================== --}}
        <div x-show="activeTab === 'diproses'" x-transition
            class="bg-white rounded-2xl shadow-[0px_1px_2px_-1px_rgba(0,0,0,0.10),0px_1px_3px_0px_rgba(0,0,0,0.10)] outline outline-[0.67px] outline-offset-[-0.67px] outline-black/10 flex flex-col"
            style="display: none;">
            <div class="bg-white p-6 border-b border-slate-100 flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold">Kargo Sedang Diproses</h3>
                <p class="text-slate-500 text-sm">Daftar kargo yang sedang dalam tahap entry, X-Ray, loading, atau on
                    flight</p>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1000px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-slate-50/50">
                            <th class="px-6 py-4 font-medium">Nomor Resi</th>
                            <th class="px-6 py-4 font-medium">Pengirim</th>
                            <th class="px-6 py-4 font-medium">Asal</th>
                            <th class="px-6 py-4 font-medium">Tujuan</th>
                            <th class="px-6 py-4 font-medium">Penerbangan</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium">Waktu Update</th>
                            <th class="px-6 py-4 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($diproses as $item)
                            <tr x-show="searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase())"
                                class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $item->no_resi }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->pengirim->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->kotaAsal->nama_kota ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->kotaTujuan->nama_kota ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-0.5">
                                        <span
                                            class="text-slate-900 font-medium uppercase">{{ $item->no_penerbangan ?? '-' }}</span>
                                        @if($item->maskapai)
                                            <span class="text-slate-500 text-xs">{{ $item->maskapai }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeColor = match (strtolower($item->status_terakhir)) {
                                            'entry' => 'bg-slate-100 text-slate-800',
                                            'x-ray' => 'bg-accent text-blue', // Warna Custom Theme
                                            'loading' => 'bg-yellow-100 text-yellow-800',
                                            'on flight' => 'bg-purple-100 text-purple-800',
                                            'landing' => 'bg-teal-100 text-teal-800',
                                            'offload' => 'bg-red/10 text-red', // Warna Custom Theme
                                            'selesai', 'di terima' => 'bg-emerald-100 text-emerald-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="{{ $badgeColor }} text-xs font-medium px-3 py-1.5 rounded-md uppercase">
                                        {{ $item->status_terakhir }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $item->history->first()->waktu_update ?? $item->created_at }}
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        @click="openModal('{{ $item->no_resi }}', '{{ $item->pengirim->nama ?? '-' }}', '{{ $item->kotaAsal->nama_kota ?? '-' }}', '{{ $item->kotaTujuan->nama_kota ?? '-' }}', '{{ $item->status_terakhir }}', '{{ $item->id_kota_asal }}', '{{ $item->id_kota_tujuan }}')"
                                        class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 hover:text-sky-600 hover:border-sky-300 flex items-center gap-1.5 mx-auto transition-all shadow-sm">
                                        <i class="ri-edit-box-line text-lg"></i> Update
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-6 text-slate-500">Tidak ada kargo yang sedang
                                    diproses.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ============================== TAB 2: TERTUNDA / OFFLOAD ============================== --}}
        <div x-show="activeTab === 'tertunda'" x-transition
            class="bg-white rounded-2xl shadow-[0px_1px_2px_-1px_rgba(0,0,0,0.10),0px_1px_3px_0px_rgba(0,0,0,0.10)] outline outline-[0.67px] outline-offset-[-0.67px] outline-red-200 flex flex-col"
            style="display: none;">
            <div class="bg-red-50/30 p-6 border-b border-red-100 flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                    <i class="ri-error-warning-fill text-red-600"></i> Kargo Tertunda / Offload
                </h3>
                <p class="text-slate-500 text-sm">Daftar kargo yang bermasalah dan memerlukan perhatian khusus</p>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[1100px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-slate-50/50">
                            <th class="px-6 py-4 font-medium">Nomor Resi</th>
                            <th class="px-6 py-4 font-medium">Pengirim</th>
                            <th class="px-6 py-4 font-medium">Asal</th>
                            <th class="px-6 py-4 font-medium">Tujuan</th>
                            <th class="px-6 py-4 font-medium">Penerbangan</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium">Waktu Update</th>
                            <th class="px-6 py-4 font-medium">Keterangan</th>
                            <th class="px-6 py-4 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($tertunda as $item)
                            <tr x-show="searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase())"
                                class="border-b border-red-100 bg-red-50/20 hover:bg-red-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $item->no_resi }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->pengirim->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->kotaAsal->nama_kota ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->kotaTujuan->nama_kota ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-0.5">
                                        <span
                                            class="text-slate-900 font-medium uppercase">{{ $item->no_penerbangan ?? '-' }}</span>
                                        @if($item->maskapai)
                                            <span class="text-slate-500 text-xs">{{ $item->maskapai }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-red/10 text-red text-xs font-medium px-3 py-1.5 rounded-md uppercase">
                                        {{ $item->status_terakhir }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $item->history->first()->waktu_update ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->history->first()->keterangan ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <button
                                        @click="openModal('{{ $item->no_resi }}', '{{ $item->pengirim->nama ?? '-' }}', '{{ $item->kotaAsal->nama_kota ?? '-' }}', '{{ $item->kotaTujuan->nama_kota ?? '-' }}', '{{ $item->status_terakhir }}', '{{ $item->id_kota_asal }}', '{{ $item->id_kota_tujuan }}')"
                                        class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-red-50 hover:text-red-600 hover:border-red-200 flex items-center gap-1.5 mx-auto transition-all shadow-sm">
                                        <i class="ri-edit-box-line text-lg"></i> Update
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-6 text-slate-500">Tidak ada kargo tertunda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ============================== TAB 3: SELESAI ============================== --}}
        <div x-show="activeTab === 'selesai'" x-transition
            class="bg-white rounded-2xl shadow-[0px_1px_2px_-1px_rgba(0,0,0,0.10),0px_1px_3px_0px_rgba(0,0,0,0.10)] outline outline-[0.67px] outline-offset-[-0.67px] outline-emerald-200 flex flex-col"
            style="display: none;">
            <div class="bg-emerald-50/30 p-6 border-b border-emerald-100 flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold flex items-center gap-2">
                    <i class="ri-checkbox-circle-fill text-emerald-600"></i> Kargo Tiba di Tujuan
                </h3>
                <p class="text-slate-500 text-sm">Daftar kargo yang sudah sampai dan diterima</p>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-900 text-sm font-semibold bg-slate-50/50">
                            <th class="px-6 py-4 font-medium">Nomor Resi</th>
                            <th class="px-6 py-4 font-medium">Asal &rarr; Tujuan</th>
                            <th class="px-6 py-4 font-medium">Penerbangan</th>
                            <th class="px-6 py-4 font-medium">Waktu Tiba</th>
                            <th class="px-6 py-4 font-medium">Nama Penerima</th>
                            <th class="px-6 py-4 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($selesai as $item)
                            <tr x-show="searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase())"
                                class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $item->no_resi }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->kotaAsal->nama_kota ?? '-' }} <span
                                        class="text-slate-400 mx-1">&rarr;</span> {{ $item->kotaTujuan->nama_kota ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-0.5">
                                        <span
                                            class="text-slate-900 font-medium uppercase">{{ $item->no_penerbangan ?? '-' }}</span>
                                        @if($item->maskapai)
                                            <span class="text-slate-500 text-xs">{{ $item->maskapai }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $item->history->first()->waktu_update ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-900">{{ $item->penerima->nama ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <button
                                        class="bg-white border border-slate-200 text-slate-700 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-slate-50 cursor-not-allowed opacity-50 flex items-center gap-1.5 mx-auto shadow-sm"
                                        disabled>
                                        <i class="ri-check-double-line text-lg"></i> Final
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-slate-500">Belum ada kargo selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ============================== MODAL UPDATE STATUS ============================== --}}
        <div x-show="isModalOpen" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">

            <div @click.outside="isModalOpen = false; isDropdownOpen = false"
                class="w-full max-w-[500px] max-h-[95vh] overflow-y-auto bg-white rounded-[10px] shadow-[0px_4px_6px_-4px_rgba(0,0,0,0.10),_0_10px_15px_-3px_rgba(0,0,0,0.1)] outline outline-[0.67px] outline-offset-[-0.67px] outline-black/10 flex flex-col p-6 gap-6 relative hide-scrollbar">

                <button @click="isModalOpen = false" type="button"
                    class="absolute top-6 right-6 opacity-70 hover:opacity-100 flex flex-col gap-0.5 w-4 h-4 justify-center items-center">
                    <div class="w-4 h-0.5 bg-neutral-950 rotate-45 absolute rounded-full"></div>
                    <div class="w-4 h-0.5 bg-neutral-950 -rotate-45 absolute rounded-full"></div>
                </button>

                <div class="flex flex-col gap-1 w-[90%]">
                    <h2 class="text-neutral-950 text-lg font-semibold leading-5">Update Status Pengiriman</h2>
                    <p class="text-gray-500 text-sm font-normal leading-5">Ubah status kargo dan tambahkan keterangan
                        jika diperlukan</p>
                </div>

                <div class="w-full bg-slate-50 rounded-[10px] p-4 flex flex-col gap-3">
                    <div class="flex justify-between items-start">
                        <span class="text-slate-600 text-sm font-normal">Nomor Resi:</span>
                        <span class="text-slate-900 text-sm font-semibold" x-text="modalData.resi"></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-slate-600 text-sm font-normal">Pengirim:</span>
                        <span class="text-slate-900 text-sm font-normal" x-text="modalData.pengirim"></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-slate-600 text-sm font-normal">Rute:</span>
                        <span class="text-slate-900 text-sm font-normal"><span x-text="modalData.asal"></span> → <span
                                x-text="modalData.tujuan"></span></span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-slate-600 text-sm font-normal">Status Saat Ini:</span>
                        <div class="px-2 py-0.5 bg-blue-100 rounded-lg flex justify-center items-center">
                            <span class="text-blue-800 text-xs font-medium leading-4 uppercase"
                                x-text="modalData.status_saat_ini"></span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.kelola-status-pengiriman.update') }}" method="POST"
                    class="flex flex-col gap-6">
                    @csrf
                    <input type="hidden" name="no_resi" x-model="modalData.resi">
                    <input type="hidden" name="status" x-model="form.status">

                    <div class="flex flex-col gap-2 relative">
                        <label class="text-neutral-950 text-sm font-medium leading-4">Status Baru</label>

                        <div @click="isDropdownOpen = !isDropdownOpen"
                            class="w-full h-9 px-3 py-2 bg-zinc-100 rounded-lg outline outline-[0.67px] outline-offset-[-0.67px] outline-black/0 flex justify-between items-center cursor-pointer">
                            <span class="text-sm font-medium leading-5"
                                :class="form.status === '' ? 'text-gray-500' : 'text-neutral-950'"
                                x-text="form.status === '' ? 'Pilih status baru' : form.status"></span>
                            <div
                                class="w-2 h-1 border-l-[1.33px] border-b-[1.33px] border-gray-500 -rotate-45 mb-1 opacity-50">
                            </div>
                        </div>

                        <div x-show="isDropdownOpen" @click.outside="isDropdownOpen = false" x-transition.opacity
                            style="display: none;"
                            class="absolute top-[65px] left-0 w-full p-2 bg-white rounded-2xl shadow-xl border border-black/10 z-[60] flex flex-col gap-1 max-h-44 overflow-y-auto">
                            <template x-for="item in ['Entry', 'X-Ray', 'Loading', 'Offload', 'Di Terima']">
                                <div @click="!isStatusDisabled(item) ? selectStatus(item) : null"
                                    :class="isStatusDisabled(item) ? 'opacity-50 bg-slate-50 cursor-not-allowed' : 'bg-zinc-100 hover:bg-zinc-200 cursor-pointer'"
                                    class="w-full shrink-0 min-h-[36px] px-3 py-2 rounded-lg outline outline-[0.67px] outline-offset-[-0.67px] outline-black/0 flex items-center justify-between transition-colors">
                                    <span :class="isStatusDisabled(item) ? 'text-slate-400' : 'text-black'"
                                        class="text-sm font-medium leading-5" x-text="item"></span>

                                    <i x-show="isStatusDisabled(item)" class="ri-lock-fill text-slate-300 text-sm"></i>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-show="form.status === 'Loading'" x-transition
                        class="flex flex-col gap-2 bg-slate-50 p-4 rounded-lg border border-slate-200">

                        <label for="data_penerbangan" class="text-neutral-950 text-sm font-medium leading-4">Pilih
                            Pesawat (Live Radar)</label>
                        <div class="relative">
                            <select name="data_penerbangan" id="data_penerbangan"
                                class="w-full h-9 px-3 py-1 bg-white rounded-lg outline outline-[0.67px] outline-black/20 text-sm font-normal text-neutral-950 focus:outline-blue-500 appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Pilih Jadwal Tersedia --</option>

                                <template
                                    x-for="jadwal in penerbanganAktif.filter(p => parseInt(p.id_kota_asal) === parseInt(modalData.id_asal) && parseInt(p.id_kota_tujuan) === parseInt(modalData.id_tujuan))"
                                    :key="jadwal.no_penerbangan">
                                    <option :value="jadwal.no_penerbangan + '||' + jadwal.maskapai"
                                        x-text="jadwal.maskapai + ' (' + jadwal.no_penerbangan + ')'"></option>
                                </template>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <div
                                    class="w-2 h-1 border-l-[1.33px] border-b-[1.33px] border-gray-500 -rotate-45 mb-1 opacity-50">
                                </div>
                            </div>
                        </div>

                        <div x-show="penerbanganAktif.filter(p => parseInt(p.id_kota_asal) === parseInt(modalData.id_asal) && parseInt(p.id_kota_tujuan) === parseInt(modalData.id_tujuan)).length === 0"
                            class="text-xs text-red-600 font-medium mt-1 flex flex-col gap-1">
                            <div class="flex items-center gap-1"><i class="ri-error-warning-fill"></i> Tidak ada jadwal
                                pesawat aktif untuk rute ini di Radar.</div>
                            <span class="text-[10px] text-red-500 ml-4">(Pastikan API Key valid dan terhubung
                                internet)</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-neutral-950 text-sm font-medium leading-4">Keterangan (Opsional)</label>
                        <textarea name="keterangan" x-model="form.keterangan" rows="2"
                            class="w-full px-3 py-2 bg-zinc-100 rounded-lg outline outline-[0.67px] outline-offset-[-0.67px] outline-black/0 text-sm font-normal leading-5 text-neutral-950 placeholder-gray-500 resize-none focus:ring-0 focus:outline-blue-500"
                            placeholder="Tambahkan catatan jika diperlukan"></textarea>
                    </div>

                    <div class="w-full p-3 bg-blue-50 rounded-[10px]">
                        <p class="text-blue-800 text-xs font-normal leading-4">
                            <span class="font-bold">Info:</span> Sistem akan otomatis merekam ID Admin
                            ({{ Auth::user()->nama ?? 'Admin' }}) dan Waktu Update saat Anda menyimpan perubahan.
                        </p>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <x-button type="button" variant="outline" @click="isModalOpen = false; isDropdownOpen = false"
                            class="!text-neutral-950 !border-black/10 hover:!bg-gray-50 !rounded-lg !font-medium !shadow-none">
                            Batal
                        </x-button>

                        <x-button type="submit" color="blue" variant="solid" x-bind:disabled="form.status === ''"
                            class="!bg-blue hover:!bg-bluehover !rounded-lg !font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                            Simpan Perubahan
                        </x-button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-app-layout>