<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Absensi;
use App\Models\Pengumuman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSantri = Santri::count();

        $today = Carbon::today()->toDateString();
        $totalHadir = Absensi::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        $totalAbsen = Absensi::whereDate('tanggal', $today)->count();

        $kehadiran = $totalAbsen > 0 ? round(($totalHadir / $totalAbsen) * 100) : 0;

        $pengumumanAktif = Pengumuman::count();

        // Chart Data: 7 Hari Terakhir
        $chartData = [];
        $chartLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = Absensi::whereDate('tanggal', $date)->where('status', 'hadir')->count();
        }

        return view('dashboard.index', compact('totalSantri', 'kehadiran', 'pengumumanAktif', 'chartLabels', 'chartData'));
    }
}
