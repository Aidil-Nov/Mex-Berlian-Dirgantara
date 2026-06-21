@extends('layouts.frontend')

@section('content')

    <section class="relative w-full py-16 md:py-24 flex flex-col justify-center items-center overflow-hidden">

        <div class="absolute top-4 left-4 md:top-8 md:left-8 z-30">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-full backdrop-blur-md transition-all text-sm font-medium font-['Poppins'] border border-white/30">
                <i class="ri-arrow-left-line text-lg"></i> Kembali
            </a>
        </div>

        <img src="{{ asset('storage/images/map.jpeg') }}" class="absolute inset-0 w-full h-full object-cover z-0" />
        <div class="absolute inset-0 bg-[#2b6cb0]/80 mix-blend-multiply z-10"></div>

        <div class="relative z-20 w-full max-w-4xl mx-auto px-4 flex flex-col items-center gap-8 text-center mt-6">

            <div class="flex flex-col items-center gap-2">
                <div class="inline-flex items-center gap-2 text-red-500">
                    <i class="ri-map-pin-user-fill text-xl"></i>
                    <span class="text-white text-base md:text-lg font-normal font-['Poppins']">Tracking</span>
                </div>
                <h2 class="text-white text-3xl md:text-5xl font-medium font-['Poppins'] leading-tight">
                    Lacak Kargo Anda
                </h2>
            </div>

            <form action="{{ route('tracking.show') }}" method="GET"
                class="w-full max-w-2xl bg-white rounded-full flex items-center p-2 shadow-lg">
                <div class="pl-4 pr-2 text-slate-400">
                    <i class="ri-search-line text-2xl"></i>
                </div>
                <input type="text" name="no_resi" value="{{ $no_resi ?? '' }}"
                    placeholder="Masukkan ID Resi..."
                    class="flex-1 bg-transparent text-black text-lg font-medium font-['Poppins'] focus:outline-none border-none px-2 uppercase"
                    required />
                <button type="submit"
                    class="w-10 h-10 md:w-12 md:h-12 bg-red hover:bg-redhover text-white rounded-full flex justify-center items-center transition-colors">
                    <i class="ri-arrow-right-s-line text-2xl md:text-3xl"></i>
                </button>
            </form>

            {{-- STEPPER GRAPHIC PROGRESS BAR (DINAMIS BERDASARKAN STATUS TERAKHIR) --}}
            <div class="w-full max-w-3xl relative mt-8 md:mt-12">
                <div class="absolute top-8 left-16 right-16 border-t-2 border-dotted border-white/70 z-0 hidden md:block">
                </div>

                @php
                    $status = strtolower($kargo->status_terakhir);
                    $isXray = in_array($status, ['x-ray', 'loading', 'on flight', 'landing', 'selesai', 'di terima']);
                    $isFlight = in_array($status, ['loading', 'on flight', 'landing', 'selesai', 'di terima']);
                    $isDone = in_array($status, ['selesai', 'di terima']);
                @endphp

                <div class="relative z-10 flex flex-wrap md:flex-nowrap justify-between items-start w-full gap-8 md:gap-0">

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4 opacity-100">
                        <div class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg ring-[6px] ring-white/30">
                            <i class="ri-login-box-line text-3xl"></i>
                        </div>
                        <span class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Penerimaan<br>Kargo</span>
                    </div>

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4 {{ $isXray ? 'opacity-100' : 'opacity-40' }}">
                        <div class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg {{ $isXray ? 'ring-[6px] ring-white/30' : '' }}">
                            <i class="ri-shield-check-line text-3xl"></i>
                        </div>
                        <span class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Pemeriksaan<br>Bandara</span>
                    </div>

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4 {{ $isFlight ? 'opacity-100' : 'opacity-40' }}">
                        <div class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg {{ $isFlight ? 'ring-[6px] ring-white/30' : '' }}">
                            <i class="ri-plane-line text-3xl"></i>
                        </div>
                        <span class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Proses<br>Penerbangan</span>
                    </div>

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4 {{ $isDone ? 'opacity-100' : 'opacity-40' }}">
                        <div class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg {{ $isDone ? 'ring-[6px] ring-white/30' : '' }}">
                            <i class="ri-focus-3-line text-3xl"></i>
                        </div>
                        <span class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Kargo<br>Diterima</span>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="w-full max-w-4xl mx-auto px-4 py-12 flex flex-col items-center gap-8">

        <div class="px-8 py-2 bg-[#1e3a8a] rounded-full shadow-md">
            <span class="text-white text-base md:text-lg font-semibold font-['Poppins'] tracking-wide">Detail Pengiriman</span>
        </div>

        {{-- Panel Ringkasan Manifes Data Kargo --}}
        <div class="w-full max-w-2xl bg-slate-50 border border-slate-200 rounded-2xl p-6 grid grid-cols-2 sm:grid-cols-3 gap-6 text-sm font-['Poppins'] shadow-sm">
            <div><span class="text-slate-500 text-xs block">Rute Pengiriman:</span> <span class="font-semibold text-slate-800">{{ $kargo->kotaAsal->nama_kota }} &rarr; {{ $kargo->kotaTujuan->nama_kota }}</span></div>
            <div><span class="text-slate-500 text-xs block">Berat Barang:</span> <span class="font-semibold text-slate-800">{{ $kargo->berat }} kg</span></div>
            <div><span class="text-slate-500 text-xs block">Deskripsi Isi:</span> <span class="font-semibold text-slate-800">{{ $kargo->isi_barang }}</span></div>
            <div><span class="text-slate-500 text-xs block">Nama Penerima:</span> <span class="font-semibold text-slate-800">{{ $kargo->penerima->nama ?? '-' }}</span></div>
            
            @if($kargo->no_penerbangan)
                <div><span class="text-slate-500 text-xs block">Nomor Armada:</span> <span class="font-semibold text-slate-800 uppercase">{{ $kargo->no_penerbangan }}</span></div>
                <div>
                    <span class="text-slate-500 text-xs block">Live Status Radar:</span> 
                    <span class="font-semibold text-sky-700">
                        {{ $detailPesawat->status_penerbangan ?? 'Active' }}
                    </span>
                </div>
                @if(isset($detailPesawat->eta))
                    <div class="col-span-2 sm:col-span-3 bg-sky-50 border border-sky-100 rounded-lg p-3 text-sky-800 text-xs">
                        <i class="ri-time-line"></i> <strong>Estimasi Tiba (ETA):</strong> {{ $detailPesawat->eta }}
                    </div>
                @endif
            @endif
        </div>

        {{-- LOG TIMELINE PERGELEKAN STATUS ASLI DARI DATABASE --}}
        <div class="w-full max-w-2xl flex flex-col mt-4">

            @forelse($kargo->history as $log)
                <div class="flex items-stretch gap-4 md:gap-8 w-full group">

                    <div class="w-24 md:w-32 text-center shrink-0 pt-0.5">
                        <p class="text-black text-xs md:text-sm font-medium font-['Poppins'] leading-relaxed">
                            {{ \Carbon\Carbon::parse($log->waktu_update)->format('d/m/Y') }}
                        </p>
                        <p class="text-slate-500 text-xs md:text-sm font-normal font-['Poppins']">
                            {{ \Carbon\Carbon::parse($log->waktu_update)->format('H:i') }} WIB
                        </p>
                    </div>

                    <div class="relative flex flex-col items-center w-6 shrink-0">
                        <div class="w-4 h-4 md:w-5 md:h-5 bg-white border-2 {{ strtolower($log->status) === 'offload' ? 'border-red-500 bg-red-50' : 'border-red' }} rounded-full z-10 mt-1 shadow-sm"></div>

                        @if(!$loop->last)
                            <div class="absolute top-6 bottom-[-16px] w-px border-l-2 border-dotted border-slate-400 z-0"></div>
                        @endif
                    </div>

                    <div class="flex-1 pt-0.5 pb-10">
                        <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded border mb-1 uppercase {{ strtolower($log->status) === 'offload' ? 'bg-red-50 text-red-600 border-red-200' : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                            {{ $log->status }}
                        </span>
                        <p class="text-gray-700 text-sm md:text-base font-normal font-['Poppins'] leading-relaxed md:pr-10">
                            {{ $log->keterangan }}
                        </p>
                    </div>

                </div>
            @empty
                <div class="text-center text-slate-400 py-8 italic font-['Poppins'] text-sm">
                    Belum ada rekaman log perjalanan kargo.
                </div>
            @endforelse

        </div>

    </section>
@endsection