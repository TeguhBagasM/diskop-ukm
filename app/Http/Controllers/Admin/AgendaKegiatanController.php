<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AgendaKegiatanController extends Controller
{
    /**
     * Display a listing of the agenda kegiatan.
     */
    public function index(Request $request): View
    {
        $query = AgendaKegiatan::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_kegiatan', 'like', "%{$searchTerm}%")
                  ->orWhere('pegawai_yang_ditugaskan', 'like', "%{$searchTerm}%")
                  ->orWhere('tempat', 'like', "%{$searchTerm}%")
                  ->orWhere('jenis_kegiatan', 'like', "%{$searchTerm}%")
                  ->orWhere('sumber', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by jenis kegiatan
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_kegiatan', $request->jenis);
        }

        // Filter by sumber
        if ($request->has('sumber') && $request->sumber != '') {
            $query->where('sumber', $request->sumber);
        }

        // Order by tanggal and waktu
        $query->orderBy('tanggal_kegiatan', 'desc')
              ->orderBy('waktu', 'asc');

        $perPage = $request->get('per_page', 10);
        $agendaKegiatan = $query->paginate($perPage);

        return view('admin.agenda.index', compact('agendaKegiatan'));
    }

    /**
     * Show the form for creating a new agenda kegiatan.
     */
    public function create(): View
    {
        return view('admin.agenda.create');
    }

    /**
     * Store a newly created agenda kegiatan in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_kegiatan' => 'required|in:INTERNAL,EKSTERNAL',
            'nama_kegiatan' => 'required|string|max:255',
            'sumber' => 'required|in:PPK,KPK,BAPPELITBANG',
            'tempat' => 'required|string|max:255',
            'waktu' => 'required',
            'pegawai_yang_ditugaskan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'tindak_lanjut' => 'required|in:PENDING,SELESAI,BATAL',
            'keterangan' => 'nullable|string',
        ]);

        AgendaKegiatan::create($validated);

        return redirect()->route('admin.agenda.index')
                        ->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified agenda kegiatan.
     */
    public function show(AgendaKegiatan $agenda): View
    {
        return view('admin.agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified agenda kegiatan.
     */
    public function edit(AgendaKegiatan $agenda): View
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified agenda kegiatan in storage.
     */
    public function update(Request $request, AgendaKegiatan $agenda): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_kegiatan' => 'required|in:INTERNAL,EKSTERNAL',
            'nama_kegiatan' => 'required|string|max:255',
            'sumber' => 'required|in:PPK,KPK,BAPPELITBANG',
            'tempat' => 'required|string|max:255',
            'waktu' => 'required',
            'pegawai_yang_ditugaskan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'tindak_lanjut' => 'required|in:PENDING,SELESAI,BATAL',
            'keterangan' => 'nullable|string',
        ]);

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')
                        ->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified agenda kegiatan from storage.
     */
    public function destroy(AgendaKegiatan $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()->route('admin.agenda.index')
                        ->with('success', 'Agenda kegiatan berhasil dihapus.');
    }

    /**
     * Update status tindak lanjut
     */
    public function updateStatus(Request $request, AgendaKegiatan $agenda): RedirectResponse
    {
        $validated = $request->validate([
            'tindak_lanjut' => 'required|in:PENDING,SELESAI,BATAL',
        ]);

        $agenda->update(['tindak_lanjut' => $validated['tindak_lanjut']]);

        return redirect()->back()
                        ->with('success', 'Status tindak lanjut berhasil diperbarui.');
    }

    /**
     * Export agenda kegiatan to Excel/PDF
     */
    public function export(Request $request)
    {
        // Implementation for export functionality
        // You can use packages like Laravel Excel or DomPDF
    }

    /**
     * Get agenda kegiatan for AJAX requests
     */
    public function getAgendaJson(Request $request)
    {
        $query = AgendaKegiatan::query();

        if ($request->has('date')) {
            $query->whereDate('tanggal_kegiatan', $request->date);
        }

        $agendas = $query->orderBy('waktu', 'asc')->get();

        return response()->json($agendas);
    }
}
