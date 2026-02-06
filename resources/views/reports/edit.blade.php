@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.reports.show', $report) }}" class="text-blue-600 hover:text-blue-800">
            ← Kembali ke Detail Laporan
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Laporan</h1>
    
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-gray-800 mb-2">Informasi Laporan</h3>
                <p><strong>Judul:</strong> {{ $report->title }}</p>
                <p><strong>Pelapor:</strong> {{ $report->user->name }}</p>
                <p><strong>Lokasi:</strong> {{ $report->location }}</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                        Status Laporan
                    </label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="menunggu" {{ $report->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $report->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $report->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="feedback">
                        Feedback ke Siswa
                    </label>
                    <textarea name="feedback" id="feedback" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Berikan feedback atau tanggapan kepada siswa...">{{ old('feedback', $report->feedback) }}</textarea>
                    <p class="text-gray-500 text-sm mt-1">Feedback akan ditampilkan kepada siswa yang membuat laporan.</p>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.reports.show', $report) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
