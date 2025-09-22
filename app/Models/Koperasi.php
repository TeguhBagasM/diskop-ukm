<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    use HasFactory;

    protected $table = 'koperasi';

    protected $fillable = [
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

    protected $casts = [
        'tanggal_berdiri' => 'date',
        'modal_sendiri' => 'decimal:2',
        'modal_luar' => 'decimal:2',
        'volume_usaha' => 'decimal:2',
        'shu' => 'decimal:2',
        'jumlah_anggota' => 'integer'
    ];

    // Scope untuk filter berdasarkan status
    public function scopeActive($query)
    {
        return $query->where('status', 'AKTIF');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'TIDAK AKTIF');
    }

    // Scope untuk filter berdasarkan jenis
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_koperasi', $jenis);
    }

    // Scope untuk filter berdasarkan wilayah
    public function scopeByKecamatan($query, $kecamatan)
    {
        return $query->where('kecamatan', $kecamatan);
    }

    public function scopeByKelurahan($query, $kelurahan)
    {
        return $query->where('kelurahan', $kelurahan);
    }

    // Accessor untuk total modal
    public function getTotalModalAttribute()
    {
        return $this->modal_sendiri + $this->modal_luar;
    }

    // Accessor untuk format rupiah
    public function getFormattedModalSendiriAttribute()
    {
        return 'Rp ' . number_format((float)($this->modal_sendiri ?? 0), 0, ',', '.');
    }

    public function getFormattedModalLuarAttribute()
    {
        return 'Rp ' . number_format((float)($this->modal_luar ?? 0), 0, ',', '.');
    }

    public function getFormattedVolumeUsahaAttribute()
    {
        return 'Rp ' . number_format((float)($this->volume_usaha ?? 0), 0, ',', '.');
    }

    public function getFormattedShuAttribute()
    {
        return 'Rp ' . number_format((float)($this->shu ?? 0), 0, ',', '.');
    }

    // Method untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama_koperasi', 'LIKE', "%{$search}%")
              ->orWhere('alamat', 'LIKE', "%{$search}%")
              ->orWhere('kelurahan', 'LIKE', "%{$search}%")
              ->orWhere('kecamatan', 'LIKE', "%{$search}%")
              ->orWhere('ketua', 'LIKE', "%{$search}%");
        });
    }
}
