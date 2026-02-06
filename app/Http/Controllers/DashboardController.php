<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalReports = Report::count();
        $menungguReports = Report::where('status', 'menunggu')->count();
        $diprosesReports = Report::where('status', 'diproses')->count();
        $selesaiReports = Report::where('status', 'selesai')->count();
        $totalSiswa = User::where('role', 'siswa')->count();

        $recentReports = Report::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalReports',
            'menungguReports',
            'diprosesReports',
            'selesaiReports',
            'totalSiswa',
            'recentReports'
        ));
    }

    public function siswa()
    {
        $user = auth()->user();
        $myReports = Report::where('user_id', $user->id)->count();
        $menungguReports = Report::where('user_id', $user->id)->where('status', 'menunggu')->count();
        $diprosesReports = Report::where('user_id', $user->id)->where('status', 'diproses')->count();
        $selesaiReports = Report::where('user_id', $user->id)->where('status', 'selesai')->count();

        $recentReports = Report::where('user_id', $user->id)->latest()->take(5)->get();

        return view('siswa.dashboard', compact(
            'myReports',
            'menungguReports',
            'diprosesReports',
            'selesaiReports',
            'recentReports'
        ));
    }
}
