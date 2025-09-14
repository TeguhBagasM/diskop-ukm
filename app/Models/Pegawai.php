<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //mass assigment
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

}
