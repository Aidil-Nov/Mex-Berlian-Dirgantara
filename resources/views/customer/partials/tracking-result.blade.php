@extends('layouts.frontend')

@section('content')

    <section class="relative w-full py-16 md:py-24 flex flex-col justify-center items-center overflow-hidden">

        <div class="absolute top-4 left-4 md:top-8 md:left-8 z-30">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-full backdrop-blur-md transition-all text-sm font-medium font-primary border border-white/30">
                <i class="ri-arrow-left-line text-lg"></i> Kembali
            </a>
        </div>

        <img src="{{ asset('storage/images/map.jpeg') }}" class="absolute inset-0 w-full h-full object-cover z-0" />
        {{-- Menggunakan warna custom 'blue' dari theme --}}
        <div class="absolute inset-0 bg-blue/80 mix-blend-multiply z-10"></div>

        <div class="relative z-20 w-full max-w-4xl mx-auto px-4 flex flex-col items-center gap-8 text-center mt-6">

            <div class="flex flex-col items-center gap-2">
                <div class="inline-flex items-center gap-2 text-red">
                    <i class="ri-map-pin-user-fill text-xl"></i>
                    <span class="text-white text-base md:text-lg font-normal font-primary">Tracking</span>
                </div>
                <h2 class="text-white text-3xl md:text-5xl font-medium font-primary leading-tight">
                    Lacak Kargo Anda
                </h2>
            </div>

            <form action="{{ route('tracking.show') }}" method="GET"
                class="w-full max-w-2xl bg-white rounded-full flex items-center p-1.5 md:p-2 shadow-lg mt-4 md:mt-0">

                <div class="pl-3 md:pl-4 pr-1 md:pr-2 text-surface-muted shrink-0">
                    <i class="ri-search-line text-xl md:text-2xl"></i>
                </div>

                <input type="text" name="no_resi" value="{{ $no_resi ?? '' }}" placeholder="Masukkan ID Resi..."
                    class="flex-1 min-w-0 bg-transparent text-surface-text text-sm md:text-lg font-medium font-primary focus:outline-none border-none px-2 uppercase truncate"
                    required />

                {{-- WAJIB shrink-0 agar tombol tidak terdorong/keluar layar --}}
                <button type="submit"
                    class="w-10 h-10 md:w-12 md:h-12 bg-red hover:bg-redhover text-white rounded-full flex justify-center items-center shrink-0 transition-colors">
                    <i class="ri-arrow-right-s-line text-2xl md:text-3xl"></i>
                </button>
            </form>

            {{-- STEPPER GRAPHIC PROGRESS BAR (VERSI SUPER PRESISI & FULL THEME) --}}
            @if($kargo->history->count() > 0)
                <div class="w-full max-w-4xl relative mt-8 md:mt-16 px-4 md:px-0 mx-auto">

                    <div
                        class="hidden md:block absolute top-8 left-[10%] right-[10%] border-t-[3px] border-dotted border-white/50 z-0">
                    </div>

                    @php
                        $status = strtolower($kargo->status_terakhir ?? '');
                        $isXray = in_array($status, ['x-ray', 'loading', 'on flight', 'landing', 'selesai', 'di terima', 'cargo siap di ambil']);
                        $isFlight = in_array($status, ['loading', 'on flight', 'landing', 'selesai', 'di terima', 'cargo siap di ambil']);
                        $isArrived = in_array($status, ['landing', 'selesai', 'di terima', 'cargo siap di ambil']);
                        $isDone = in_array($status, ['selesai', 'di terima', 'cargo siap di ambil']);
                    @endphp

                    <div class="relative z-10 flex flex-col md:flex-row justify-between w-full gap-8 md:gap-0">

                        {{-- TAHAP 1: PENERIMAAN --}}
                        <div
                            class="relative z-10 flex flex-row md:flex-col items-center justify-start md:justify-center w-full md:w-1/5 gap-4 md:gap-3">
                            <div
                                class="md:hidden absolute left-[22px] top-[48px] bottom-[-32px] border-l-[3px] border-dotted border-white/50 z-0">
                            </div>

                            {{-- Menggunakan text-blue dari theme --}}
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-white text-blue rounded-full flex items-center justify-center shadow-lg ring-[6px] ring-white/20 shrink-0 z-10">
                                <i class="ri-login-box-line text-xl md:text-2xl"></i>
                            </div>
                            <div class="text-left md:text-center w-[calc(100%-4rem)] md:w-full">
                                <span
                                    class="text-white text-base md:text-sm font-semibold font-primary leading-tight block">Penerimaan<br
                                        class="hidden md:block">Kargo</span>
                            </div>
                        </div>

                        {{-- TAHAP 2: X-RAY --}}
                        <div
                            class="relative z-10 flex flex-row md:flex-col items-center justify-start md:justify-center w-full md:w-1/5 gap-4 md:gap-3 {{ $isXray ? 'opacity-100' : 'opacity-40' }}">
                            <div
                                class="md:hidden absolute left-[22px] top-[48px] bottom-[-32px] border-l-[3px] border-dotted border-white/50 z-0">
                            </div>

                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-white text-blue rounded-full flex items-center justify-center shadow-lg {{ $isXray ? 'ring-[6px] ring-white/20' : '' }} shrink-0 z-10">
                                <i class="ri-shield-check-line text-xl md:text-2xl"></i>
                            </div>
                            <div class="text-left md:text-center w-[calc(100%-4rem)] md:w-full">
                                <span
                                    class="text-white text-base md:text-sm font-semibold font-primary leading-tight block">Pemeriksaan<br
                                        class="hidden md:block">Bandara</span>
                            </div>
                        </div>

                        {{-- TAHAP 3: FLIGHT --}}
                        <div
                            class="relative z-10 flex flex-row md:flex-col items-center justify-start md:justify-center w-full md:w-1/5 gap-4 md:gap-3 {{ $isFlight ? 'opacity-100' : 'opacity-40' }}">
                            <div
                                class="md:hidden absolute left-[22px] top-[48px] bottom-[-32px] border-l-[3px] border-dotted border-white/50 z-0">
                            </div>

                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-white text-blue rounded-full flex items-center justify-center shadow-lg {{ $isFlight ? 'ring-[6px] ring-white/20' : '' }} shrink-0 z-10">
                                <i class="ri-plane-line text-xl md:text-2xl"></i>
                            </div>
                            <div class="text-left md:text-center w-[calc(100%-4rem)] md:w-full">
                                <span
                                    class="text-white text-base md:text-sm font-semibold font-primary leading-tight block">Proses<br
                                        class="hidden md:block">Penerbangan</span>
                            </div>
                        </div>

                        {{-- TAHAP 4: ARRIVED --}}
                        <div
                            class="relative z-10 flex flex-row md:flex-col items-center justify-start md:justify-center w-full md:w-1/5 gap-4 md:gap-3 {{ $isArrived ? 'opacity-100' : 'opacity-40' }}">
                            <div
                                class="md:hidden absolute left-[22px] top-[48px] bottom-[-32px] border-l-[3px] border-dotted border-white/50 z-0">
                            </div>

                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-white text-blue rounded-full flex items-center justify-center shadow-lg {{ $isArrived ? 'ring-[6px] ring-white/20' : '' }} shrink-0 z-10">
                                <i class="ri-building-4-line text-xl md:text-2xl"></i>
                            </div>
                            <div class="text-left md:text-center w-[calc(100%-4rem)] md:w-full">
                                <span
                                    class="text-white text-base md:text-sm font-semibold font-primary leading-tight block">Tiba
                                    di Gudang<br class="hidden md:block">Tujuan</span>
                            </div>
                        </div>

                        {{-- TAHAP 5: DONE --}}
                        <div
                            class="relative z-10 flex flex-row md:flex-col items-center justify-start md:justify-center w-full md:w-1/5 gap-4 md:gap-3 {{ $isDone ? 'opacity-100' : 'opacity-40' }}">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-white text-blue rounded-full flex items-center justify-center shadow-lg {{ $isDone ? 'ring-[6px] ring-white/20' : '' }} shrink-0 z-10">
                                <i class="ri-focus-3-line text-xl md:text-2xl"></i>
                            </div>
                            <div class="text-left md:text-center w-[calc(100%-4rem)] md:w-full">
                                <span
                                    class="text-white text-base md:text-sm font-semibold font-primary leading-tight block">Cargo
                                    siap<br class="hidden md:block">di ambil</span>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                {{-- Fallback UI --}}
                <div
                    class="w-full max-w-2xl mt-8 md:mt-12 bg-white/10 border border-white/20 rounded-2xl p-6 md:p-8 backdrop-blur-md shadow-lg flex flex-col items-center justify-center text-center">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 text-white animate-pulse">
                        <i class="ri-loader-2-line text-3xl animate-spin"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold font-primary mb-2">Menunggu Proses Operasional</h3>
                    <p class="text-white/80 text-sm md:text-base font-normal font-primary max-w-lg">
                        Data manifes kargo Anda telah terdaftar di sistem kami. Saat ini kargo sedang menunggu pembaruan status
                        pertama dari petugas lapangan di hanggar keberangkatan.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <section class="w-full max-w-4xl mx-auto px-4 py-12 flex flex-col items-center gap-8">

        {{-- Menggunakan bg-blue dari theme --}}
        <div class="px-8 py-2 bg-blue rounded-full shadow-md">
            <span class="text-white text-base md:text-lg font-semibold font-primary tracking-wide">Detail Pengiriman</span>
        </div>

        <div
            class="w-full max-w-2xl bg-surface border border-surface-border rounded-2xl p-6 grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm font-primary shadow-sm">
            <div><span class="text-surface-muted text-xs block">Rute Pengiriman:</span> <span
                    class="font-semibold text-surface-text">{{ $kargo->kotaAsal->nama_kota }} &rarr;
                    {{ $kargo->kotaTujuan->nama_kota }}</span></div>
            <div><span class="text-surface-muted text-xs block">Berat Barang:</span> <span
                    class="font-semibold text-surface-text">{{ $kargo->berat }} kg</span></div>
            <div><span class="text-surface-muted text-xs block">Deskripsi Isi:</span> <span
                    class="font-semibold text-surface-text">{{ $kargo->isi_barang }}</span></div>

            <div><span class="text-surface-muted text-xs block">Nama Pengirim:</span> <span
                    class="font-semibold text-surface-text">{{ $kargo->pengirim->nama ?? '-' }}</span></div>
            <div><span class="text-surface-muted text-xs block">Telepon Pengirim:</span> <span
                    class="font-semibold text-surface-text">{{ $kargo->pengirim->no_hp ?? '-' }}</span></div>
            <div><span class="text-surface-muted text-xs block">Nama Penerima:</span> <span
                    class="font-semibold text-surface-text">{{ $kargo->penerima->nama ?? '-' }}</span></div>

            @if($kargo->no_penerbangan)
                <div
                    class="col-span-2 sm:col-span-3 border-t border-surface-border mt-2 pt-4 grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <div><span class="text-surface-muted text-xs block">Maskapai:</span> <span
                            class="font-semibold text-surface-text">{{ $detailPesawat->maskapai ?? $kargo->maskapai ?? '-' }}</span>
                    </div>
                    <div><span class="text-surface-muted text-xs block">Nomor Armada:</span> <span
                            class="font-semibold text-surface-text uppercase">{{ $kargo->no_penerbangan }}</span></div>
                    <div>
                        <span class="text-surface-muted text-xs block">Live Status Radar:</span>
                        {{-- Menggunakan warna info untuk status aktif --}}
                        <span class="font-semibold text-info-text">
                            {{ $detailPesawat->status_penerbangan ?? 'Active' }}
                        </span>
                    </div>
                </div>

                @if(isset($detailPesawat->eta))
                    {{-- Menggunakan grup warna info (bg-info-light, text-info-text) --}}
                    <div
                        class="col-span-2 sm:col-span-3 bg-info-light border border-info rounded-lg p-3 text-info-text text-xs mt-2">
                        <i class="ri-time-line"></i> <strong>Estimasi Tiba (ETA):</strong> {{ $detailPesawat->eta }}
                    </div>
                @endif
            @endif
        </div>

        {{-- LOG TIMELINE --}}
        <div class="w-full max-w-2xl flex flex-col mt-4">

            @forelse($kargo->history as $log)
                <div class="flex items-stretch gap-4 md:gap-8 w-full group">

                    <div class="w-24 md:w-32 text-center shrink-0 pt-0.5">
                        <p class="text-surface-text text-xs md:text-sm font-medium font-primary leading-relaxed">
                            {{ \Carbon\Carbon::parse($log->waktu_update)->format('d/m/Y') }}
                        </p>
                        <p class="text-surface-muted text-xs md:text-sm font-normal font-primary">
                            {{ \Carbon\Carbon::parse($log->waktu_update)->format('H:i') }} WIB
                        </p>
                    </div>

                    <div class="relative flex flex-col items-center w-6 shrink-0">
                        {{-- Menggunakan utilitas warna operasional Red & Info --}}
                        <div
                            class="w-4 h-4 md:w-5 md:h-5 bg-white border-2 {{ strtolower($log->status) === 'offload' ? 'border-red bg-red/10' : 'border-info' }} rounded-full z-10 mt-1 shadow-sm">
                        </div>

                        @if(!$loop->last)
                            <div class="absolute top-6 bottom-[-16px] w-px border-l-2 border-dotted border-surface-border z-0">
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 pt-0.5 pb-10">
                        <span
                            class="inline-block text-[10px] font-bold px-2 py-0.5 rounded border mb-1 uppercase {{ strtolower($log->status) === 'offload' ? 'bg-red/10 text-red border-red/20' : 'bg-surface border-surface-border text-surface-text' }}">
                            {{ $log->status }}
                        </span>
                        <p class="text-surface-muted text-sm md:text-base font-normal font-primary leading-relaxed md:pr-10">
                            {{ $log->keterangan }}
                        </p>
                    </div>

                </div>
            @empty
                <div class="text-center text-surface-muted py-8 italic font-primary text-sm">
                    Belum ada rekaman log perjalanan kargo.
                </div>
            @endforelse

        </div>

    </section>
@endsection