<?php

namespace App\Imports;

use App\Models\Koperasi;
use App\Models\FileUpload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class KoperasiImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, WithBatchInserts, WithChunkReading
{
    use Importable, SkipsErrors;

    protected $fileUploadId;
    protected $rowCount = 0;

    public function __construct($fileUploadId)
    {
        $this->fileUploadId = $fileUploadId;
    }

    public function model(array $row)
    {
        $this->rowCount++;

        // Update file upload progress
        if ($this->rowCount % 10 == 0) { // Update every 10 rows
            FileUpload::find($this->fileUploadId)->update([
                'processed_records' => $this->rowCount,
                'status' => 'PROCESSING'
            ]);
        }

        return new Koperasi([
            'nama_koperasi' => $row['nama_koperasi'] ?? '',
            'alamat' => $row['alamat'] ?? '',
            'kelurahan' => $row['kelurahan'] ?? '',
            'kecamatan' => $row['kecamatan'] ?? '',
            'status' => $this->validateStatus($row['status'] ?? ''),
            'jenis_koperasi' => $this->validateJenis($row['jenis_koperasi'] ?? ''),
            'no_badan_hukum' => $row['no_badan_hukum'] ?? null,
            'tanggal_berdiri' => $this->parseDate($row['tanggal_berdiri'] ?? null),
            'ketua' => $row['ketua'] ?? null,
            'sekretaris' => $row['sekretaris'] ?? null,
            'bendahara' => $row['bendahara'] ?? null,
            'no_telepon' => $row['no_telepon'] ?? null,
            'email' => $row['email'] ?? null,
            'jumlah_anggota' => $this->parseInteger($row['jumlah_anggota'] ?? 0),
            'modal_sendiri' => $this->parseDecimal($row['modal_sendiri'] ?? 0),
            'modal_luar' => $this->parseDecimal($row['modal_luar'] ?? 0),
            'volume_usaha' => $this->parseDecimal($row['volume_usaha'] ?? 0),
            'shu' => $this->parseDecimal($row['shu'] ?? 0),
            'keterangan' => $row['keterangan'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_koperasi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'status' => 'required|in:AKTIF,TIDAK AKTIF',
            'jenis_koperasi' => 'required|in:Produksi,Konsumen,Simpan Pinjam,Serba Usaha',
            'email' => 'nullable|email',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'modal_sendiri' => 'nullable|numeric|min:0',
            'modal_luar' => 'nullable|numeric|min:0',
            'volume_usaha' => 'nullable|numeric|min:0',
            'shu' => 'nullable|numeric|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_koperasi.required' => 'Nama koperasi wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'kelurahan.required' => 'Kelurahan wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'status.in' => 'Status harus AKTIF atau TIDAK AKTIF',
            'jenis_koperasi.in' => 'Jenis koperasi harus salah satu dari: Produksi, Konsumen, Simpan Pinjam, Serba Usaha',
            'email.email' => 'Format email tidak valid',
        ];
    }

    public function onError(\Throwable $e)
    {
        // Log error to file upload record
        $fileUpload = FileUpload::find($this->fileUploadId);
        $currentError = $fileUpload->error_log ?? '';
        $newError = "Baris {$this->rowCount}: " . $e->getMessage() . "\n";

        $fileUpload->update([
            'error_log' => $currentError . $newError
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    // Helper methods for data cleaning
    private function validateStatus($status)
    {
        $status = strtoupper(trim($status));
        if (in_array($status, ['AKTIF', 'ACTIVE', '1', 'TRUE', 'YA'])) {
            return 'AKTIF';
        } elseif (in_array($status, ['TIDAK AKTIF', 'INACTIVE', '0', 'FALSE', 'TIDAK', 'NO'])) {
            return 'TIDAK AKTIF';
        }
        return 'AKTIF'; // Default
    }

    private function validateJenis($jenis)
    {
        $jenis = ucfirst(strtolower(trim($jenis)));
        $validJenis = ['Produksi', 'Konsumen', 'Simpan Pinjam', 'Serba Usaha'];

        foreach ($validJenis as $valid) {
            if (strpos(strtolower($jenis), strtolower($valid)) !== false) {
                return $valid;
            }
        }

        return 'Konsumen'; // Default
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Handle Excel date number format
            if (is_numeric($date)) {
                return Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($date - 2);
            }

            // Handle string dates
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseInteger($value)
    {
        if (empty($value) || !is_numeric($value)) {
            return 0;
        }
        return (int) $value;
    }

    private function parseDecimal($value)
    {
        if (empty($value) || !is_numeric($value)) {
            return 0.00;
        }

        // Remove currency symbols and separators
        $value = preg_replace('/[^\d.-]/', '', $value);
        return (float) $value;
    }
}
