<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%')
                  ->orWhere('bidang', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $data = $query->paginate($perPage);

        return view('admin.pegawai.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'nip' => 'required|string|unique:pegawais,nip|max:50',
            'no_telp' => 'required|string|max:20',
            'status' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
        ]);

        // Calculate age automatically
        $tanggalLahir = Carbon::parse($validated['tanggal_lahir']);
        $umur = $tanggalLahir->age;

        $validated['umur'] = $umur;

        // Create pegawai
        Pegawai::create($validated);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function show(Pegawai $pegawai)
    {
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        // Validation
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'nip' => 'required|string|max:50|unique:pegawais,nip,' . $pegawai->id,
            'no_telp' => 'required|string|max:20',
            'status' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
        ]);

        // Calculate age automatically
        $tanggalLahir = Carbon::parse($validated['tanggal_lahir']);
        $umur = $tanggalLahir->age;

        $validated['umur'] = $umur;

        // Update pegawai
        $pegawai->update($validated);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diupdate!');
    }

    public function destroy(Pegawai $pegawai)
    {
        try {
            $pegawai->delete();
            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.pegawai.index')->with('error', 'Gagal menghapus data pegawai!');
        }
    }
}
