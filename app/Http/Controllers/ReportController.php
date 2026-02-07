<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Report::with('user');

        if ($user->isAdmin()) {
            // Admin filters
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            if ($request->filled('month')) {
                $query->whereMonth('created_at', $request->month);
            }
        } else {
            // Siswa only sees their own reports
            $query->where('user_id', $user->id);
        }

        $reports = $query->latest()->get();

        // Get data for filters (admin only)
        $users = [];
        if ($user->isAdmin()) {
            $users = User::where('role', 'siswa')->get();
        }

        return view('reports.index', compact('reports', 'users'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category' => 'required|in:infrastruktur,elektronik,kebersihan,keamanan,lainnya',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'category' => $validated['category'],
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reports', 'public');
            $data['photo_url'] = $photoPath;
        }

        Report::create($data);

        return redirect()->route(auth()->user()->isAdmin() ? 'admin.reports' : 'siswa.reports')
            ->with('success', 'Laporan berhasil dikirim!');
    }

    public function show(Report $report)
    {
        $this->authorize('view', $report);
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        $this->authorize('update', $report);
        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $this->authorize('update', $report);

        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
            'feedback' => 'nullable|string'
        ]);

        $report->update($validated);

        return redirect()->route('admin.reports')
            ->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy(Report $report)
    {
        $this->authorize('delete', $report);

        if ($report->photo_url) {
            Storage::disk('public')->delete($report->photo_url);
        }

        $report->delete();

        return redirect()->route('admin.reports')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}
