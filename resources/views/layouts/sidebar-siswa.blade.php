<aside class="w-64 bg-white shadow-lg border-r border-gray-200">
    <div class="p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Siswa Panel</h2>
        <nav class="space-y-2">
            <a href="{{ route('siswa.dashboard') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('siswa.reports.create') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('siswa.reports.create') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Laporan
            </a>
            <a href="{{ route('siswa.reports') }}" class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('siswa.reports*') && !request()->routeIs('siswa.reports.create') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Daftar Laporan
            </a>
            <div class="pt-4 mt-4 border-t border-gray-200">
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Statistik Saya
                </div>
                <div class="mt-3 space-y-2">
                    <div class="px-4 py-2 flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Laporan</span>
                        <span class="text-sm font-medium text-gray-900">{{ \App\Models\Report::where('user_id', auth()->id())->count() }}</span>
                    </div>
                    <div class="px-4 py-2 flex items-center justify-between">
                        <span class="text-sm text-gray-600">Diproses</span>
                        <span class="text-sm font-medium text-orange-600">{{ \App\Models\Report::where('user_id', auth()->id())->where('status', 'diproses')->count() }}</span>
                    </div>
                    <div class="px-4 py-2 flex items-center justify-between">
                        <span class="text-sm text-gray-600">Selesai</span>
                        <span class="text-sm font-medium text-green-600">{{ \App\Models\Report::where('user_id', auth()->id())->where('status', 'selesai')->count() }}</span>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</aside>