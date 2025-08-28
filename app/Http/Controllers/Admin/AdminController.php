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
        $todayAgenda = AgendaKegiatan::whereDate('tanggal_kegiatan', Carbon::today())
                                   ->orderBy('waktu', 'asc')
                                   ->get();

        // Statistik untuk cards
        $monthlyAgenda = AgendaKegiatan::whereMonth('tanggal_kegiatan', Carbon::now()->month)
                                     ->whereYear('tanggal_kegiatan', Carbon::now()->year)
                                     ->count();

        $pendingAgenda = AgendaKegiatan::where('tindak_lanjut', 'PENDING')
                                     ->whereDate('tanggal_kegiatan', '>=', Carbon::today())
                                     ->count();

        $completedAgenda = AgendaKegiatan::where('tindak_lanjut', 'SELESAI')
                                       ->whereMonth('tanggal_kegiatan', Carbon::now()->month)
                                       ->whereYear('tanggal_kegiatan', Carbon::now()->year)
                                       ->count();

        return view('admin.dashboard', compact(
            'todayAgenda',
            'monthlyAgenda',
            'pendingAgenda',
            'completedAgenda'
        ));
    }
}
