<aside class="w-64 bg-gray-800 text-white">
    <div class="p-4">
        <h2 class="text-lg font-semibold mb-4">Admin Menu</h2>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.reports') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.reports*') ? 'bg-gray-700' : '' }}">
                Semua Laporan
            </a>
        </nav>
    </div>
</aside>
