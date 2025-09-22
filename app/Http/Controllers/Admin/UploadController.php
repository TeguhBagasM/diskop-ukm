<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KoperasiTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\KoperasiImport;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
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
    return Excel::download(new KoperasiTemplateExport(), 'template_koperasi.xlsx');
}

}
