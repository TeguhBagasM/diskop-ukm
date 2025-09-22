<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_file',
        'original_name',
        'file_path',
        'file_type',
        'bulan',
        'tahun',
        'kategori',
        'total_records',
        'processed_records',
        'status',
        'error_log',
        'uploaded_at'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'total_records' => 'integer',
        'processed_records' => 'integer'
    ];

    // Scope untuk filter berdasarkan kategori
    public function scopeKoperasi($query)
    {
        return $query->where('kategori', 'KOPERASI');
    }

    public function scopeUmkm($query)
    {
        return $query->where('kategori', 'UMKM');
    }

    // Scope untuk filter berdasarkan status
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'FAILED');
    }

    // Scope untuk filter berdasarkan periode
    public function scopeByPeriode($query, $tahun, $bulan = null)
    {
        $query->where('tahun', $tahun);

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        return $query;
    }

    // Accessor untuk progress percentage
    public function getProgressPercentageAttribute()
    {
        if ($this->total_records == 0) {
            return 0;
        }

        return round(($this->processed_records / $this->total_records) * 100, 2);
    }

    // Accessor untuk status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'COMPLETED' => 'badge-success',
            'PROCESSING' => 'badge-warning',
            'PENDING' => 'badge-info',
            'FAILED' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    // Method untuk mendapatkan nama bulan dalam bahasa Indonesia
    public function getBulanIndonesiaAttribute()
    {
        $bulan = [
            'Jan' => 'Januari',
            'Feb' => 'Februari',
            'Mar' => 'Maret',
            'Apr' => 'April',
            'May' => 'Mei',
            'Jun' => 'Juni',
            'Jul' => 'Juli',
            'Aug' => 'Agustus',
            'Sep' => 'September',
            'Oct' => 'Oktober',
            'Nov' => 'November',
            'Dec' => 'Desember'
        ];

        return $bulan[$this->bulan] ?? $this->bulan;
    }

    // Method untuk mendapatkan ukuran file yang readable
    public function getReadableFileSizeAttribute()
    {
        if (file_exists($this->file_path)) {
            $size = filesize($this->file_path);

            if ($size >= 1048576) {
                return round($size / 1048576, 2) . ' MB';
            } elseif ($size >= 1024) {
                return round($size / 1024, 2) . ' KB';
            } else {
                return $size . ' B';
            }
        }

        return 'N/A';
    }
}
