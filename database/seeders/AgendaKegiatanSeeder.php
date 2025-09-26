<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgendaKegiatan;
use Carbon\Carbon;

class AgendaKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendaData = [
            [
                'jenis_kegiatan' => 'INTERNAL',
                'nama_kegiatan' => 'BIMTEK PERPAJAKAN',
                'sumber' => 'PPK',
                'tempat' => 'HOTEL LINGGA',
                'waktu' => '08:00',
                'tindak_lanjut' => 'DISPOSISI',
                'tanggal_kegiatan' => Carbon::today(),
            ],
            [
                'jenis_kegiatan' => 'INTERNAL',
                'nama_kegiatan' => 'BIMTEK KOPI',
                'sumber' => 'KPK',
                'tempat' => 'HOTEL SUNSHINE',
                'waktu' => '08:00',
                'tindak_lanjut' => 'DIHADIRI',
                'tanggal_kegiatan' => Carbon::today(),
            ],
            [
                'jenis_kegiatan' => 'INTERNAL',
                'nama_kegiatan' => 'MONEV KESEHATAN',
                'sumber' => 'PPK',
                'tempat' => 'KOPERASI BARAYA',
                'waktu' => '08:00',
                'tindak_lanjut' => 'DISPOSISI',
                'tanggal_kegiatan' => Carbon::today(),
            ],
            [
                'jenis_kegiatan' => 'EKSTERNAL',
                'nama_kegiatan' => 'RAPAT...',
                'sumber' => 'BAPPELITBANG',
                'tempat' => 'THE GAIA',
                'waktu' => '09:00',
                'tindak_lanjut' => 'DIHADIRI',
                'tanggal_kegiatan' => Carbon::today(),
            ],
        ];

        foreach ($agendaData as $agenda) {
            AgendaKegiatan::create($agenda);
        }
    }
}
