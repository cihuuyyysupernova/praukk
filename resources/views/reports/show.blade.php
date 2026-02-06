@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="mb-6">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.reports') : route('siswa.reports') }}" class="text-blue-600 hover:text-blue-800">
            ← Kembali ke Daftar Laporan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ $report->title }}</h1>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($report->status == 'menunggu') bg-yellow-100 text-yellow-800
                    @elseif($report->status == 'diproses') bg-orange-100 text-orange-800
                    @else bg-green-100 text-green-800 @endif">
                    {{ ucfirst($report->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Pelapor</h3>
                    <p class="text-gray-900">{{ $report->user->name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Laporan</h3>
                    <p class="text-gray-900">{{ $report->created_at->format('d F Y H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Lokasi</h3>
                    <p class="text-gray-900">{{ $report->location }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Email Pelapor</h3>
                    <p class="text-gray-900">{{ $report->user->email }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Deskripsi Kerusakan</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $report->description }}</p>
                </div>
            </div>

            @if($report->photo_url)
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Foto Kerusakan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <img src="{{ asset('storage/' . $report->photo_url) }}" alt="Foto Kerusakan" class="max-w-full h-auto rounded-lg shadow-md" style="max-height: 400px;">
                    </div>
                </div>
            @endif

            @if($report->feedback)
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Feedback dari Admin</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $report->feedback }}</p>
                    </div>
                </div>
            @endif

            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.reports.edit', $report) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Status & Feedback
                    </a>
                    <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                            Hapus Laporan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
