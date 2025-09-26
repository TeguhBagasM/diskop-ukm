<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function index()
    {
        // Ambil agenda kegiatan hari ini
        $todayAgenda = AgendaKegiatan::with('pegawais')
                                ->whereDate('tanggal_kegiatan', '>=', Carbon::today())
                                ->orderBy('tanggal_kegiatan', 'desc')
                                ->orderBy('waktu', 'desc')
                                ->limit(10)
                                ->get();

        // Statistik untuk cards
        $monthlyAgenda = AgendaKegiatan::whereMonth('tanggal_kegiatan', Carbon::now()->month)
                                     ->whereYear('tanggal_kegiatan', Carbon::now()->year)
                                     ->count();

        $disposisiAgenda = AgendaKegiatan::where('tindak_lanjut', 'DISPOSISI')
                                     ->whereDate('tanggal_kegiatan', '>=', Carbon::today())
                                     ->count();

        $dihadiriAgenda = AgendaKegiatan::where('tindak_lanjut', 'DIHADIRI')
                                       ->whereMonth('tanggal_kegiatan', Carbon::now()->month)
                                       ->whereYear('tanggal_kegiatan', Carbon::now()->year)
                                       ->count();

        return view('admin.dashboard', compact(
            'todayAgenda',
            'monthlyAgenda',
            'disposisiAgenda',
            'dihadiriAgenda'
        ));
    }
}
