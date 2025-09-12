<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaKegiatan;
use Carbon\Carbon;
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

        // Order by tanggal_kegiatan and waktu
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
            'sumber' => 'required',
            'tempat' => 'required|string|max:255',
            'waktu' => 'required',
            'pegawai_yang_ditugaskan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'tindak_lanjut' => 'required|in:DISPOSISI,DIHADIRI',
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
            'sumber' => 'required',
            'tempat' => 'required|string|max:255',
            'waktu' => 'required',
            'pegawai_yang_ditugaskan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'tindak_lanjut' => 'required|in:DISPOSISI,DIHADIRI',
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
            'tindak_lanjut' => 'required|in:DISPOSISI,DIHADIRI',
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

public function calendar(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n')); // numeric month

        // Convert numeric month to month name
        $monthName = Carbon::createFromDate($year, $month, 1)->format('F');

        // Get agenda data for the specified month
        $agendaData = $this->getAgendaData($year, $month);

        // Calculate statistics
        $monthlyAgenda = $this->getMonthlyAgendaCount($year, $month);
        $workingDays = $this->getWorkingDays($year, $month);
        $holidays = $this->getHolidays($year, $month);
        $nationalHolidays = $this->getNationalHolidays($year, $month);

        return view('admin.agenda.calendar', compact(
            'year', 'monthName', 'agendaData',
            'monthlyAgenda', 'workingDays', 'holidays', 'nationalHolidays'
        ))->with([
            'currentYear' => $year,
            'currentMonth' => $monthName
        ]);
    }

    private function getAgendaData($year, $month)
    {
        // Get agenda kegiatan for the specified month
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $agendaKegiatan = AgendaKegiatan::whereBetween('tanggal_kegiatan', [$startDate, $endDate])
            ->get();

        $agendaData = [];

        foreach ($agendaKegiatan as $agenda) {
            $date = Carbon::parse($agenda->tanggal_kegiatan)->format('Y-m-d');

            if (!isset($agendaData[$date])) {
                $agendaData[$date] = [];
            }

            $agendaData[$date][] = [
                'name' => $agenda->nama_kegiatan,
                'type' => 'agenda',
                'time' => $agenda->waktu,
                'place' => $agenda->tempat,
                'status' => $agenda->tindak_lanjut
            ];
        }

        // Add weekend days as holidays
        $agendaData = $this->addWeekendHolidays($agendaData, $year, $month);

        // Add national holidays (you can customize this)
        $agendaData = $this->addNationalHolidays($agendaData, $year, $month);

        return $agendaData;
    }

    private function addWeekendHolidays($agendaData, $year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $current = $startDate->copy();

        while ($current <= $endDate) {
            $dateStr = $current->format('Y-m-d');

            if ($current->isSaturday()) {
                if (!isset($agendaData[$dateStr])) {
                    $agendaData[$dateStr] = [];
                }
                $agendaData[$dateStr][] = [
                    'name' => 'Hari Libur Sabtu',
                    'type' => 'holiday'
                ];
            } elseif ($current->isSunday()) {
                if (!isset($agendaData[$dateStr])) {
                    $agendaData[$dateStr] = [];
                }
                $agendaData[$dateStr][] = [
                    'name' => 'Hari Libur Minggu',
                    'type' => 'holiday'
                ];
            }

            $current->addDay();
        }

        return $agendaData;
    }

    private function addNationalHolidays($agendaData, $year, $month)
    {
        // Define national holidays (you can move this to a config file or database)
        $nationalHolidays = [
            // Format: 'month-day' => 'Holiday Name'
            '01-01' => 'Tahun Baru Masehi',
            '08-17' => 'Hari Kemerdekaan RI',
            '12-25' => 'Hari Raya Natal',
            // Add more holidays as needed
        ];

        foreach ($nationalHolidays as $monthDay => $holidayName) {
            list($holidayMonth, $holidayDay) = explode('-', $monthDay);

            if ($month == (int)$holidayMonth) {
                $dateStr = sprintf('%04d-%02d-%02d', $year, $holidayMonth, $holidayDay);

                if (!isset($agendaData[$dateStr])) {
                    $agendaData[$dateStr] = [];
                }

                $agendaData[$dateStr][] = [
                    'name' => $holidayName,
                    'type' => 'national_holiday'
                ];
            }
        }

        return $agendaData;
    }

    private function getMonthlyAgendaCount($year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        return AgendaKegiatan::whereBetween('tanggal_kegiatan', [$startDate, $endDate])->count();
    }

    private function getWorkingDays($year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $workingDays = 0;
        $current = $startDate->copy();

        while ($current <= $endDate) {
            if (!$current->isWeekend()) {
                $workingDays++;
            }
            $current->addDay();
        }

        return $workingDays;
    }

    private function getHolidays($year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $holidays = 0;
        $current = $startDate->copy();

        while ($current <= $endDate) {
            if ($current->isWeekend()) {
                $holidays++;
            }
            $current->addDay();
        }

        return $holidays;
    }

    private function getNationalHolidays($year, $month)
    {
        // Count national holidays for the month
        // This is a simplified version - you might want to use a proper holiday library
        $nationalHolidays = [
            '01-01' => 'Tahun Baru Masehi',
            '08-17' => 'Hari Kemerdekaan RI',
            '12-25' => 'Hari Raya Natal',
        ];

        $count = 0;
        foreach ($nationalHolidays as $monthDay => $holidayName) {
            list($holidayMonth, $holidayDay) = explode('-', $monthDay);
            if ($month == (int)$holidayMonth) {
                $count++;
            }
        }

        return $count;
    }

    public function getAgendaForDate(Request $request)
    {
        $date = $request->get('date');

        $agendaKegiatan = AgendaKegiatan::whereDate('tanggal_kegiatan', $date)
            ->get();

        return response()->json([
            'date' => $date,
            'agenda' => $agendaKegiatan
        ]);
    }
}
