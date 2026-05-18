@extends('layouts.guest')

@section('content')

    @php
        $riwayatKargo = [
            [
                'tanggal' => '10/05/2026',
                'jam' => '16:30',
                'desc' => 'Paket telah diterima oleh [Nama Penerima] di alamat tujuan.'
            ],
            [
                'tanggal' => '10/05/2026',
                'jam' => '13:15',
                'desc' => 'Pesawat telah mendarat di Bandara tujuan. Barang sedang dalam proses bongkar muat (unloading).'
            ],
            [
                'tanggal' => '10/05/2026',
                'jam' => '10:00',
                'desc' => 'Kargo sedang dalam penerbangan menuju kota tujuan menggunakan maskapai mitra.'
            ],
            [
                'tanggal' => '10/05/2026',
                'jam' => '08:30',
                'desc' => 'Barang telah divalidasi dan sedang dimuat ke dalam pesawat.'
            ],
            [
                'tanggal' => '10/05/2026',
                'jam' => '06:45',
                'desc' => 'Pemeriksaan keamanan mandiri selesai dilakukan oleh fasilitas Regulated Agent PT MEX.'
            ],
            [
                'tanggal' => '09/05/2026',
                'jam' => '05:20',
                'desc' => 'Barang telah diterima di Unit Kargo Bandara Supadio dan data telah masuk ke manifes sistem.'
            ],
        ];
    @endphp

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
                <input type="text" name="no_resi" value="{{ $no_resi ?? request('no_resi') }}"
                    placeholder="Masukkan ID Resi..."
                    class="flex-1 bg-transparent text-black text-lg font-medium font-['Poppins'] focus:outline-none border-none px-2 uppercase"
                    required />
                <button type="submit"
                    class="w-10 h-10 md:w-12 md:h-12 bg-red hover:bg-redhover text-white rounded-full flex justify-center items-center transition-colors">
                    <i class="ri-arrow-right-s-line text-2xl md:text-3xl"></i>
                </button>
            </form>

            <div class="w-full max-w-3xl relative mt-8 md:mt-12">
                <div class="absolute top-8 left-16 right-16 border-t-2 border-dotted border-white/70 z-0 hidden md:block">
                </div>

                <div class="relative z-10 flex flex-wrap md:flex-nowrap justify-between items-start w-full gap-8 md:gap-0">

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4">
                        <div
                            class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg ring-[6px] ring-white/30">
                            <i class="ri-login-box-line text-3xl"></i>
                        </div>
                        <span
                            class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Penerimaan<br>Kargo</span>
                    </div>

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4">
                        <div
                            class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg ring-[6px] ring-white/30">
                            <i class="ri-shield-check-line text-3xl"></i>
                        </div>
                        <span
                            class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Pemeriksaan</span>
                    </div>

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4">
                        <div
                            class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg ring-[6px] ring-white/30">
                            <i class="ri-truck-line text-3xl"></i>
                        </div>
                        <span
                            class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Pengiriman</span>
                    </div>

                    <div class="flex flex-col items-center gap-3 w-1/2 md:w-1/4">
                        <div
                            class="w-16 h-16 bg-white text-[#1e3a8a] rounded-full flex items-center justify-center shadow-lg ring-[6px] ring-white/30">
                            <i class="ri-focus-3-line text-3xl"></i>
                        </div>
                        <span
                            class="text-white text-sm font-medium font-['Poppins'] text-center leading-snug">Diterima</span>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="w-full max-w-4xl mx-auto px-4 py-16 flex flex-col items-center gap-12">

        <div class="px-8 py-2 bg-[#1e3a8a] rounded-full shadow-md">
            <span class="text-white text-base md:text-lg font-semibold font-['Poppins'] tracking-wide">Detail</span>
        </div>

        <div class="w-full max-w-2xl flex flex-col mt-4">

            @foreach($riwayatKargo as $riwayat)
                <div class="flex items-stretch gap-4 md:gap-8 w-full group">

                    <div class="w-24 md:w-32 text-center shrink-0 pt-0.5">
                        <p class="text-black text-xs md:text-sm font-medium font-['Poppins'] leading-relaxed">
                            {{ $riwayat['tanggal'] }}</p>
                        <p class="text-black text-xs md:text-sm font-normal font-['Poppins']">{{ $riwayat['jam'] }}</p>
                    </div>

                    <div class="relative flex flex-col items-center w-6 shrink-0">
                        <div class="w-4 h-4 md:w-5 md:h-5 bg-white border-2 border-red rounded-full z-10 mt-1 shadow-sm"></div>

                        @if(!$loop->last)
                            <div class="absolute top-6 bottom-[-16px] w-px border-l-2 border-dotted border-slate-400 z-0"></div>
                        @endif
                    </div>

                    <div class="flex-1 pt-0.5 pb-10">
                        <p class="text-black text-sm md:text-base font-normal font-['Poppins'] leading-relaxed md:pr-10">
                            {{ $riwayat['desc'] }}
                        </p>
                    </div>

                </div>
            @endforeach

        </div>

    </section>
@endsection