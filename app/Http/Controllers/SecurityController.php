<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SecurityController extends Controller
{
    public function LogsAnalyst(Request $request): View
    {
        $query = $request->user()->analyzelogins();

        // Tambahkan filter tambahan jika perlu, misalnya by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Paginate dengan query string agar filter tetap saat pindah halaman
        $logs = $query->latest()->paginate(20)->withQueryString();
        return view('logsanalyst', compact('logs'));
    }

    /**
     * Menampilkan halaman Security Analyst dengan filter status dan tanggal.
     */
    public function SecurityControl(Request $request): View
    {
        $query = $request->user()->analyzesecurity();

        // Hanya ambil log dengan status "triggered" saja
        $query->where('status', 'triggered');

        // Tambahkan filter tambahan jika perlu, misalnya by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Paginate dengan query string agar filter tetap saat pindah halaman
        $logs = $query->latest()->paginate(20)->withQueryString();
        return view('security', compact('logs'));
    }

    /**
     * Memperbarui status log menjadi 'resolved' (jika masih 'triggered') + optional notes.
     */
    public function updateSecurityLog(Request $request, $logId): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:resolved',
            'notes' => 'nullable|string|max:1000', // Opsional, hanya jika disimpan
        ]);

        $log = $request->user()->analyzesecurity()->findOrFail($logId);

        // Hanya update jika log masih "triggered"
        if ($log->status === 'triggered') {
            $log->update($request->only(['status', 'notes']));
        }

        return redirect()->route('security.incidents')->with('success', 'status-updated');
    }

    public function ResolvedSecurity(Request $request): View
    {
        $query = $request->user()->analyzesecurity();

        // Hanya ambil log dengan status "triggered" saja
        $query->where('status', 'resolved');

        // Tambahkan filter tambahan jika perlu, misalnya by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Paginate dengan query string agar filter tetap saat pindah halaman
        $logs = $query->latest()->paginate(20)->withQueryString();
        return view('resolved', compact('logs'));
    }
}
