<x-app-layout>
    <div class="w-full flex flex-col gap-6 font-sans">

        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 text-2xl font-semibold leading-8">Kelola Data Kargo</h1>
            <p class="text-slate-600 text-base font-normal">Input data customer dan kargo baru</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                <i class="ri-checkbox-circle-fill text-xl"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
                <i class="ri-error-warning-fill text-xl"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.kelola-data-kargo.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white rounded-2xl shadow-sm border border-sky-200 overflow-hidden flex flex-col">
                    <div class="bg-sky-50/50 p-4 border-b border-sky-100 flex items-center gap-3">
                        <div
                            class="w-8 h-8 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center shrink-0">
                            <i class="ri-user-shared-fill text-lg"></i>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-slate-900 text-base font-medium">Area 1: Data Pengirim</h3>
                            <p class="text-slate-500 text-xs">Informasi customer pengirim</p>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col gap-5">
                        <div class="flex flex-col gap-1.5">
                            <label for="nama_pengirim" class="text-slate-900 text-sm font-medium">Nama Pengirim</label>
                            <input type="text" id="nama_pengirim" name="nama_pengirim"
                                value="{{ old('nama_pengirim') }}" placeholder="Masukkan nama pengirim"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors">
                            @error('nama_pengirim') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="hp_pengirim" class="text-slate-900 text-sm font-medium">No. HP Pengirim</label>
                            <input type="text" id="hp_pengirim" name="hp_pengirim" value="{{ old('hp_pengirim') }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors">
                            @error('hp_pengirim') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="alamat_pengirim" class="text-slate-900 text-sm font-medium">Alamat Lengkap
                                Pengirim</label>
                            <textarea id="alamat_pengirim" name="alamat_pengirim" rows="3"
                                placeholder="Masukkan alamat lengkap"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors resize-none">{{ old('alamat_pengirim') }}</textarea>
                            @error('alamat_pengirim') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="tipe_customer" class="text-slate-900 text-sm font-medium">Tipe Customer</label>
                            <div class="relative">
                                <select id="tipe_customer" name="tipe_customer"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition-colors appearance-none">
                                    <option value="" disabled {{ old('tipe_customer') ? '' : 'selected' }}>Pilih tipe
                                        customer</option>
                                    <option value="retail" {{ old('tipe_customer') == 'retail' ? 'selected' : '' }}>Retail
                                        / Personal</option>
                                    <option value="corporate" {{ old('tipe_customer') == 'corporate' ? 'selected' : '' }}>
                                        Corporate / B2B</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="ri-arrow-down-s-line text-lg"></i>
                                </div>
                            </div>
                            @error('tipe_customer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-emerald-200 overflow-hidden flex flex-col h-fit">
                    <div class="bg-emerald-50/50 p-4 border-b border-emerald-100 flex items-center gap-3">
                        <div
                            class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center shrink-0">
                            <i class="ri-user-received-fill text-lg"></i>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-slate-900 text-base font-medium">Area 2: Data Penerima</h3>
                            <p class="text-slate-500 text-xs">Informasi customer penerima</p>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col gap-5">
                        <div class="flex flex-col gap-1.5">
                            <label for="nama_penerima" class="text-slate-900 text-sm font-medium">Nama Penerima</label>
                            <input type="text" id="nama_penerima" name="nama_penerima"
                                value="{{ old('nama_penerima') }}" placeholder="Masukkan nama penerima"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                            @error('nama_penerima') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="hp_penerima" class="text-slate-900 text-sm font-medium">No. HP Penerima</label>
                            <input type="text" id="hp_penerima" name="hp_penerima" value="{{ old('hp_penerima') }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                            @error('hp_penerima') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="alamat_penerima" class="text-slate-900 text-sm font-medium">Alamat Lengkap
                                Penerima</label>
                            <textarea id="alamat_penerima" name="alamat_penerima" rows="3"
                                placeholder="Masukkan alamat lengkap"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors resize-none">{{ old('alamat_penerima') }}</textarea>
                            @error('alamat_penerima') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-purple-200 overflow-hidden flex flex-col">
                <div class="bg-purple-50/50 p-4 border-b border-purple-100 flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center shrink-0">
                        <i class="ri-box-3-fill text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-slate-900 text-base font-medium">Area 3: Detail Kargo</h3>
                        <p class="text-slate-500 text-xs">Informasi detail barang yang akan dikirim</p>
                    </div>
                </div>

                <div class="p-6 flex flex-col gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col gap-1.5">
                            <label for="no_resi" class="text-slate-900 text-sm font-medium">Nomor Resi</label>
                            <input type="text" id="no_resi" name="no_resi" readonly value="{{ $no_resi }}"
                                class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-sm text-slate-600 cursor-not-allowed focus:outline-none">
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="berat" class="text-slate-900 text-sm font-medium">Berat (kg)</label>
                            <input type="number" id="berat" name="berat" value="{{ old('berat') }}" placeholder="0"
                                min="0" step="0.1"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                            @error('berat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="isi_barang" class="text-slate-900 text-sm font-medium">Isi Barang</label>
                            <input type="text" id="isi_barang" name="isi_barang" value="{{ old('isi_barang') }}"
                                placeholder="Deskripsi isi barang"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                            @error('isi_barang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <hr class="border-slate-200">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex flex-col gap-1.5">
                            <label for="jenis_barang" class="text-slate-900 text-sm font-medium">Jenis Barang</label>
                            <div class="relative">
                                <select id="jenis_barang" name="jenis_barang"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors appearance-none cursor-pointer">
                                    <option value="" disabled {{ old('jenis_barang') ? '' : 'selected' }}>Pilih jenis
                                        barang</option>
                                    @foreach($jenis_barang as $jb)
                                        <option value="{{ $jb->id }}" {{ old('jenis_barang') == $jb->id ? 'selected' : '' }}>
                                            {{ $jb->nama_jenis }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="ri-arrow-down-s-line text-lg"></i>
                                </div>
                            </div>
                            @error('jenis_barang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="kota_asal" class="text-slate-900 text-sm font-medium">Kota Asal
                                (Terkunci)</label>
                            <div class="relative">
                                <select id="kota_asal" name="kota_asal"
                                    class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none transition-colors appearance-none cursor-not-allowed pointer-events-none font-semibold">
                                    @foreach($kota_asal as $ka)
                                        <option value="{{ $ka->id }}" selected>
                                            {{ $ka->nama_kota }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                    <i class="ri-lock-fill text-lg"></i>
                                </div>
                            </div>
                            @error('kota_asal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="kota_tujuan" class="text-slate-900 text-sm font-medium">Kota Tujuan</label>
                            <div class="relative">
                                <select id="kota_tujuan" name="kota_tujuan"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors appearance-none cursor-pointer">
                                    <option value="" disabled {{ old('kota_tujuan') ? '' : 'selected' }}>Pilih kota
                                        tujuan</option>
                                    @foreach($kota_tujuan as $kt)
                                        <option value="{{ $kt->id }}" {{ old('kota_tujuan') == $kt->id ? 'selected' : '' }}>
                                            {{ $kt->nama_kota }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="ri-arrow-down-s-line text-lg"></i>
                                </div>
                            </div>
                            @error('kota_tujuan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-sky-600 hover:bg-sky-700 text-white px-8 py-3 rounded-lg text-sm font-medium transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 flex items-center gap-2">
                    <i class="ri-save-3-line text-lg"></i> Simpan Data Kargo
                </button>
            </div>

        </form>

        <div class="bg-slate-50 rounded-2xl p-6 shadow-sm border border-slate-200 flex items-start gap-4">
            <div
                class="mt-1 flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 text-slate-700 shrink-0">
                <i class="ri-information-line text-lg"></i>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="text-slate-900 text-base font-semibold">Informasi</h3>
                <p class="text-slate-600 text-sm leading-relaxed max-w-5xl">
                    Formulir ini menggunakan tabel Master untuk Kota (Asal/Tujuan) dan Jenis Barang. Data Pengirim dan
                    Penerima disimpan terpisah sesuai dengan struktur ERD. Nomor Resi akan digenerate otomatis oleh
                    sistem.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>