<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaKegiatan extends Model
{
    use HasFactory;

    protected $table = 'agenda_kegiatan';

    protected $fillable = [
        'jenis_kegiatan',
        'nama_kegiatan',
        'sumber',
        'tempat',
        'waktu',
        'pegawai_yang_ditugaskan',
        'tindak_lanjut',
        'keterangan',
        'tanggal_kegiatan',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'waktu' => 'datetime:H:i',
    ];

    // Accessor untuk status tindak lanjut
    public function getStatusBadgeAttribute()
    {
        return match($this->tindak_lanjut) {
            'SELESAI' => '<span class="badge bg-success">Selesai</span>',
            'PENDING' => '<span class="badge bg-warning">Pending</span>',
            'BATAL' => '<span class="badge bg-danger">Batal</span>',
            default => '<span class="badge bg-secondary">-</span>'
        };
    }

    // Scope untuk filter berdasarkan jenis kegiatan
    public function scopeInternal($query)
    {
        return $query->where('jenis_kegiatan', 'INTERNAL');
    }

    public function scopeEksternal($query)
    {
        return $query->where('jenis_kegiatan', 'EKSTERNAL');
    }

    // Scope untuk filter berdasarkan sumber
    public function scopeBySumber($query, $sumber)
    {
        return $query->where('sumber', $sumber);
    }
}
