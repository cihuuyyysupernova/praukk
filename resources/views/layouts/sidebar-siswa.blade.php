<aside class="w-64 bg-gray-800 text-white">
    <div class="p-4">
        <h2 class="text-lg font-semibold mb-4">Siswa Menu</h2>
        <nav class="space-y-2">
            <a href="{{ route('siswa.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('siswa.dashboard') ? 'bg-gray-700' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('siswa.reports.create') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('siswa.reports.create') ? 'bg-gray-700' : '' }}">
                Buat Laporan
            </a>
            <a href="{{ route('siswa.reports') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('siswa.reports*') && !request()->routeIs('siswa.reports.create') ? 'bg-gray-700' : '' }}">
                Daftar Laporan
            </a>
        </nav>
    </div>
</aside>
