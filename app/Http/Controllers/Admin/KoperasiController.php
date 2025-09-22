<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Koperasi;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KoperasiImport;
use Illuminate\Support\Facades\Storage;

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
            'jenis_koperasi' => 'required|in:Produksi,Konsumen,Simpan Pinjam,Serba Usaha',
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
            'jenis_koperasi' => 'required|in:Produksi,Konsumen,Simpan Pinjam,Serba Usaha',
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

    // Upload File Excel
    public function uploadIndex()
    {
        $files = FileUpload::koperasi()
                          ->orderBy('uploaded_at', 'desc')
                          ->paginate(10);

        return view('admin.koperasi.upload', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
            'bulan' => 'required|string',
            'tahun' => 'required|integer|min:2020|max:' . (date('Y') + 1)
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Generate unique filename
        $filename = time() . '_' . str_replace(' ', '_', $originalName);

        // Store file
        $path = $file->storeAs('uploads/koperasi/' . $request->tahun . '/' . sprintf('%02d', array_search($request->bulan, [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ]) + 1), $filename, 'public');

        // Create file upload record
        $fileUpload = FileUpload::create([
            'nama_file' => $filename,
            'original_name' => $originalName,
            'file_path' => 'storage/' . $path,
            'file_type' => 'excel',
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'kategori' => 'KOPERASI',
            'status' => 'PENDING'
        ]);

        try {
            // Process Excel file
            $import = new KoperasiImport($fileUpload->id);
            Excel::import($import, storage_path('app/public/' . $path));

            $fileUpload->update([
                'status' => 'COMPLETED',
                'total_records' => $import->getRowCount(),
                'processed_records' => $import->getRowCount()
            ]);

            return redirect()->route('admin.koperasi.upload.index')
                            ->with('success', 'File berhasil diupload dan diproses!');

        } catch (\Exception $e) {
            $fileUpload->update([
                'status' => 'FAILED',
                'error_log' => $e->getMessage()
            ]);

            return redirect()->route('admin.koperasi.upload.index')
                            ->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    public function deleteUpload($id)
    {
        $fileUpload = FileUpload::findOrFail($id);

        // Delete physical file
        if (file_exists(public_path($fileUpload->file_path))) {
            unlink(public_path($fileUpload->file_path));
        }

        // Delete record
        $fileUpload->delete();

        return redirect()->route('admin.koperasi.upload.index')
                        ->with('success', 'File berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $headers = [
            'nama_koperasi',
            'alamat',
            'kelurahan',
            'kecamatan',
            'status',
            'jenis_koperasi',
            'no_badan_hukum',
            'tanggal_berdiri',
            'ketua',
            'sekretaris',
            'bendahara',
            'no_telepon',
            'email',
            'jumlah_anggota',
            'modal_sendiri',
            'modal_luar',
            'volume_usaha',
            'shu',
            'keterangan'
        ];

        return response()->streamDownload(function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            // Add sample data
            $sampleData = [
                'Koperasi Sejahtera Mandiri',
                'Jl. Raya Bandung No. 123',
                'Cimahi',
                'Cimahi',
                'AKTIF',
                'Konsumen',
                '518/BH/KWK.11/III/2023',
                '2023-03-15',
                'Budi Santoso',
                'Ani Kartini',
                'Candra Wijaya',
                '022-1234567',
                'koperasi@example.com',
                50,
                150000000,
                75000000,
                400000000,
                30000000,
                'Koperasi yang bergerak di bidang konsumen'
            ];
            fputcsv($file, $sampleData);

            fclose($file);
        }, 'template_koperasi.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
