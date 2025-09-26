<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawais')->insert([
            [
                'nama' => 'Andi Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1995-04-10',
                'umur' => 29,
                'nip' => '1987654321',
                'no_telp' => '081234567890',
                'status' => 'Tetap',
                'pendidikan' => 'S1 Teknik Informatika',
                'jabatan' => 'Programmer',
                'bidang' => 'IT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1990-08-15',
                'umur' => 34,
                'nip' => '1987654322',
                'no_telp' => '081298765432',
                'status' => 'Kontrak',
                'pendidikan' => 'S1 Sistem Informasi',
                'jabatan' => 'System Analyst',
                'bidang' => 'IT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Citra Dewi',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1998-01-20',
                'umur' => 26,
                'nip' => '1987654323',
                'no_telp' => '082134567891',
                'status' => 'Tetap',
                'pendidikan' => 'S1 Ekonomi',
                'jabatan' => 'Staff Keuangan',
                'bidang' => 'Keuangan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Dewi Lestari',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1997-06-12',
                'umur' => 27,
                'nip' => '1987654324',
                'no_telp' => '083234567892',
                'status' => 'Kontrak',
                'pendidikan' => 'S1 Manajemen',
                'jabatan' => 'HRD',
                'bidang' => 'SDM',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Eko Saputra',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1992-11-05',
                'umur' => 32,
                'nip' => '1987654325',
                'no_telp' => '084234567893',
                'status' => 'Tetap',
                'pendidikan' => 'S1 Hukum',
                'jabatan' => 'Legal Staff',
                'bidang' => 'Hukum',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
