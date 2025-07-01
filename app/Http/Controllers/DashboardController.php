<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\AnalyzeLogin;
use App\Models\AnalyzeSecurityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function Dashboard(Request $request): View
    {
        $user = Auth::user()->loadCount(['analyzeLogins', 'analyzesecurity']);
        $totalActivityCount = $user->analyze_logins_count + $user->analyzesecurity_count;

        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->copy()->subDays($i)->format('Y-m-d');
            $days->push($date);
        }

        Carbon::setLocale('id');
        $chartLabels = $days->map(fn($date) =>
            Carbon::parse($date)->translatedFormat('d F Y')
        );

        $chartHumanData = $days->map(fn($date) =>
            AnalyzeLogin::whereDate('created_at', $date)
                ->where('client_id', $user->client_id)
                ->count()
        );

        $chartPotentialData = $days->map(fn($date) =>
            AnalyzeSecurityLog::whereDate('created_at', $date)
                ->where('client_id', $user->client_id)
                ->count()
        );

        $chartTotalData = $days->map(fn($date, $index) =>
            $chartHumanData[$index] + $chartPotentialData[$index]
        );

        return view('dashboard', compact(
            'user',
            'totalActivityCount',
            'chartLabels',
            'chartHumanData',
            'chartPotentialData',
            'chartTotalData'
        ));
    }

    public function liveStats(Request $request)
    {
        $user = Auth::user();

        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->copy()->subDays($i)->format('Y-m-d');
            $days->push($date);
        }

        Carbon::setLocale('id');
        $chartLabels = $days->map(fn($date) =>
            Carbon::parse($date)->translatedFormat('d F Y')
        );

        $chartHumanData = $days->map(fn($date) =>
            AnalyzeLogin::whereDate('created_at', $date)
                ->where('client_id', $user->client_id)
                ->count()
        );

        $chartPotentialData = $days->map(fn($date) =>
            AnalyzeSecurityLog::whereDate('created_at', $date)
                ->where('client_id', $user->client_id)
                ->count()
        );

        $chartTotalData = $days->map(fn($date, $index) =>
            $chartHumanData[$index] + $chartPotentialData[$index]
        );

        return response()->json([
            'labels' => $chartLabels,
            'human' => $chartHumanData,
            'potential' => $chartPotentialData,
            'total' => $chartTotalData,
        ]);
    }


    public function resetData(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $user->resetAnalysisData();

        return redirect()->back()->with('success', 'rest-updated');
    }
}