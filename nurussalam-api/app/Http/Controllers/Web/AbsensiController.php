<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        $absensis = Absensi::with(['santri', 'jadwal'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('absensi.index', compact('absensis', 'tanggal'));
    }
}
