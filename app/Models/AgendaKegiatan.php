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
        'tindak_lanjut',
        'keterangan',
        'tanggal_kegiatan',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'waktu' => 'datetime:H:i',
    ];

    // Relasi many-to-many dengan Pegawai
    public function pegawais()
    {
        return $this->belongsToMany(Pegawai::class, 'agenda_kegiatan_pegawai');
    }

    // Accessor untuk mendapatkan nama-nama pegawai yang ditugaskan
    public function getPegawaiYangDitugaskanAttribute()
    {
        return $this->pegawais->pluck('nama')->implode(', ');
    }

    // Accessor untuk status tindak lanjut
    public function getStatusBadgeAttribute()
    {
        return match($this->tindak_lanjut) {
            'DIHADIRI' => '<span class="badge bg-success">Dihadiri</span>',
            'DISPOSISI' => '<span class="badge bg-warning">Disposisi</span>',
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

    // Scope untuk filter berdasarkan pegawai yang ditugaskan
    public function scopeByPegawai($query, $pegawaiId)
    {
        return $query->whereHas('pegawais', function($q) use ($pegawaiId) {
            $q->where('pegawai_id', $pegawaiId);
        });
    }
}
