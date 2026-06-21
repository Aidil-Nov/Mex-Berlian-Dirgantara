<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - MEX Berlian Dirgantara</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-poppins text-gray-900 antialiased overflow-hidden">

        <div class="min-h-screen flex">

            <div class="hidden lg:flex flex-1 relative bg-slate-900 overflow-hidden">
                <img src="{{ asset('storage/images/Bg-Login.png') }}" alt="MEX Logistics background"
                    class="absolute inset-0 w-full h-full object-cover object-center z-0" />
                <div class="absolute inset-0 bg-slate-900/50 z-10"></div>
                <div class="relative z-20 flex flex-col justify-between p-16 w-full text-white">
                    <div>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/images/logo mex.png') }}" alt="Logo MEX"
                                class="h-16 w-auto drop-shadow-sm transition-transform hover:scale-105" />
                        </a>
                    </div>

                    <div class="flex flex-col gap-10 max-w-lg">
                        <div class="flex flex-col gap-4">
                            <h2 class="text-white text-3xl font-normal font-['Poppins'] leading-tight">
                                Welcome back,<br>
                                <span class="text-3xl font-semibold">Admin/Manager</span>
                            </h2>
                            <p class="text-slate-200 text-base font-normal font-['Poppins'] leading-relaxed">
                                Sign in to your admin account to manage and monitor all operations.
                            </p>
                        </div>

                        <div class="flex flex-col gap-6">

                            <div class="flex items-center gap-5">
                                <div
                                    class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center border border-white/10 shrink-0">
                                    <img src="{{ asset('storage/images/icons/shield.svg') }}" alt="Shield icon"
                                        class="w-7 h-7" />
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-white text-base font-medium font-['Poppins']">Secure Access</p>
                                    <p class="text-slate-300 text-sm font-normal font-['Poppins']">Your data is
                                        protected with advanced security</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div
                                    class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center border border-white/10 shrink-0">
                                    <img src="{{ asset('storage/images/icons/chart-line.svg') }}" alt="Chart line icon"
                                        class="w-7 h-7" />
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-white text-base font-medium font-['Poppins']">Real-time Monitoring
                                    </p>
                                    <p class="text-slate-300 text-sm font-normal font-['Poppins']">Monitor shipments and
                                        operations in real-time</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div
                                    class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center border border-white/10 shrink-0">
                                    <img src="{{ asset('storage/images/icons/group.svg') }}" alt="Group icon"
                                        class="w-7 h-7" />
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-white text-base font-medium font-['Poppins']">Complete Control</p>
                                    <p class="text-slate-300 text-sm font-normal font-['Poppins']">Manage users,
                                        shipments, and system settings</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-slate-400 text-sm font-normal font-['Poppins'] mt-auto">
                        &copy; {{ date('Y') }} PT Mex Logistics. All rights reserved.
                    </div>
                </div>
            </div>

            <div class="flex-1 bg-slate-50 flex justify-center items-center p-6 md:p-16 border-gray-800 border ">

                <div class="w-full max-w-xl bg-white shadow-2xl rounded-[32px] p-10 md:p-14 border border-slate-100">

                    <div class="flex flex-col items-center gap-3 mb-10">
                        <h1 class="text-center text-red text-5xl font-semibold font-['Poppins']">Login</h1>
                        <div class="w-full h-px bg-slate-200"></div>
                    </div>

                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                        @csrf

                        <div class="flex flex-col gap-2">
                            <label for="email" class="text-black text-sm font-medium font-['Poppins']">ID
                                Karyawan</label>

                            <div class="relative w-full flex items-center">
                                <div class="absolute left-4 text-slate-400 flex items-center justify-center">
                                    <i class="ri-user-line text-xl"></i>
                                </div>
                                <input id="email"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-100 text-slate-800 text-base font-normal font-['Poppins'] placeholder-slate-400 focus:outline-none focus:ring-0 border-none rounded-[16px] outline outline-1 outline-offset-[-1px] outline-slate-200"
                                    type="text" name="email" placeholder="Masukan ID Karyawan Anda..."
                                    value="{{ old('email') }}" required autofocus autocomplete="username" />
                            </div>

                            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="password"
                                class="text-black text-sm font-medium font-['Poppins']">Password</label>

                            <div class="relative w-full flex items-center">
                                <div
                                    class="absolute left-4 text-slate-400 flex items-center justify-center border-r border-slate-200 pr-3">
                                    <i class="ri-lock-line text-xl"></i>
                                </div>
                                <input id="password"
                                    class="w-full pl-16 pr-12 py-3.5 bg-slate-100 text-slate-800 text-base font-normal font-['Poppins'] placeholder-slate-400 focus:outline-none focus:ring-0 border-none rounded-[16px] outline outline-1 outline-offset-[-1px] outline-slate-200"
                                    type="password" name="password" placeholder="Masukan Password Anda..." required
                                    autocomplete="current-password" />

                                <div class="absolute right-4 text-slate-400 cursor-pointer">
                                    <i class="ri-eye-line text-xl"></i>
                                </div>
                            </div>

                            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                        </div>

                        <div class="flex items-center justify-end mt-10">
                            <button type="submit"
                                class="w-full bg-red hover:bg-red-700 text-white text-lg font-semibold font-['Poppins'] py-4 rounded-[20px] shadow-lg shadow-red-600/30 transition-colors duration-200 focus:outline-none">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </body>

</html>