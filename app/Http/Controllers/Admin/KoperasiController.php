<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Koperasi;
// use App\Models\FileUpload;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\KoperasiImport;

class KoperasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Koperasi::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by jenis koperasi
        if ($request->filled('jenis')) {
            $query->byJenis($request->jenis);
        }

        // Filter by kecamatan
        if ($request->filled('kecamatan')) {
            $query->byKecamatan($request->kecamatan);
        }

        $perPage = $request->get('per_page', 10);
        $data = $query->orderBy('nama_koperasi', 'asc')->paginate($perPage);

        return view('admin.koperasi.index', compact('data'));
    }

    public function show(Koperasi $koperasi)
    {
        return view('admin.koperasi.show', compact('koperasi'));
    }

    public function create()
    {
        return view('admin.koperasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'status' => 'required|in:AKTIF,TIDAK AKTIF',
            'jenis_koperasi' => 'required',
            'no_badan_hukum' => 'nullable|string|max:100',
            'tanggal_berdiri' => 'nullable|date',
            'ketua' => 'nullable|string|max:100',
            'sekretaris' => 'nullable|string|max:100',
            'bendahara' => 'nullable|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'modal_sendiri' => 'nullable|numeric|min:0',
            'modal_luar' => 'nullable|numeric|min:0',
            'volume_usaha' => 'nullable|numeric|min:0',
            'shu' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        Koperasi::create($request->all());

        return redirect()->route('admin.koperasi.index')
                        ->with('success', 'Data koperasi berhasil ditambahkan.');
    }

    public function edit(Koperasi $koperasi)
    {
        return view('admin.koperasi.edit', compact('koperasi'));
    }

    public function update(Request $request, Koperasi $koperasi)
    {
        $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'status' => 'required|in:AKTIF,TIDAK AKTIF',
            'jenis_koperasi' => 'required',
            'no_badan_hukum' => 'nullable|string|max:100',
            'tanggal_berdiri' => 'nullable|date',
            'ketua' => 'nullable|string|max:100',
            'sekretaris' => 'nullable|string|max:100',
            'bendahara' => 'nullable|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'modal_sendiri' => 'nullable|numeric|min:0',
            'modal_luar' => 'nullable|numeric|min:0',
            'volume_usaha' => 'nullable|numeric|min:0',
            'shu' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $koperasi->update($request->all());

        return redirect()->route('admin.koperasi.index')
                        ->with('success', 'Data koperasi berhasil diperbarui.');
    }

    public function destroy(Koperasi $koperasi)
    {
        $koperasi->delete();

        return redirect()->route('admin.koperasi.index')
                        ->with('success', 'Data koperasi berhasil dihapus.');
    }
}
