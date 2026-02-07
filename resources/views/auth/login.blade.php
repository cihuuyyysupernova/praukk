@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 fade-in">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo/Title -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Selamat Datang</h2>
            <p class="mt-2 text-gray-600">Sistem Laporan Kerusakan Fasilitas</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 card-hover">
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    @foreach($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </div>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Login Sebagai</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative">
                            <input type="radio" name="role" value="admin" class="peer sr-only" {{ old('role') == 'admin' ? 'checked' : '' }}>
                            <div class="p-4 border-2 rounded-lg cursor-pointer transition-all peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-gray-300">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Admin</span>
                                </div>
                            </div>
                        </label>

                        <label class="relative">
                            <input type="radio" name="role" value="siswa" class="peer sr-only" {{ old('role') == 'siswa' ? 'checked' : '' }}>
                            <div class="p-4 border-2 rounded-lg cursor-pointer transition-all peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-gray-300">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Siswa</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">
                        Email / Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" class="form-input pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" class="form-input pl-10 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn-primary w-full py-3 px-4 text-white font-semibold rounded-lg shadow-lg">
                        Masuk
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="ml-1 text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        Daftar sekarang
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection