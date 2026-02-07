@extends('layouts.app')

@section('title', auth()->user()->role === 'admin' ? 'Semua Laporan' : 'Daftar Laporan')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        @if(auth()->user()->role === 'admin')
        Semua Laporan
        @else
        Daftar Laporan Saya
        @endif
    </h1>

    @if(auth()->user()->role === 'siswa')
    <div class="mb-6">
        <a href="{{ route('siswa.reports.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Buat Laporan Baru
        </a>
    </div>
    @endif

    <!-- Filter Section (Admin Only) -->
    @if(auth()->user()->role === 'admin')
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
        <form action="{{ route('admin.reports') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Siswa</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    <option value="infrastruktur" {{ request('category') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="elektronik" {{ request('category') == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                    <option value="kebersihan" {{ request('category') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                    <option value="keamanan" {{ request('category') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                    <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">
                    Filter
                </button>
                <a href="{{ route('admin.reports') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg">
                    Reset
                </a>
            </div>
        </form>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if(auth()->user()->role === 'admin')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reports as $report)
                        <tr>
                            @if(auth()->user()->role === 'admin')
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->user->name }}</td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $report->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($report->category) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($report->status == 'menunggu') bg-yellow-100 text-yellow-800
                                            @elseif($report->status == 'diproses') bg-orange-100 text-orange-800
                                            @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ auth()->user()->role === 'admin' ? route('admin.reports.show', $report) : route('siswa.reports.show', $report) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.reports.edit', $report) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" class="inline ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8">
                <p class="text-gray-500 mb-4">
                    @if(auth()->user()->role === 'admin')
                    Belum ada laporan.
                    @else
                    Anda belum membuat laporan.
                    @endif
                </p>
                @if(auth()->user()->role === 'siswa')
                <a href="{{ route('siswa.reports.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Buat Laporan Pertama
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection