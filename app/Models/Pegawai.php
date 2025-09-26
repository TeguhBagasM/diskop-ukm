<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'umur',
        'nip',
        'no_telp',
        'status',
        'pendidikan',
        'jabatan',
        'bidang',
    ];

    // Relasi many-to-many dengan AgendaKegiatan
    public function agendaKegiatans()
    {
        return $this->belongsToMany(AgendaKegiatan::class, 'agenda_kegiatan_pegawai');
    }

    // Accessor untuk mendapatkan full name dengan NIP
    public function getFullIdentityAttribute()
    {
        return $this->nama . ' (' . $this->nip . ')';
    }

    // Scope untuk mencari pegawai berdasarkan nama atau NIP
    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nip', 'like', '%' . $search . '%');
    }
}
