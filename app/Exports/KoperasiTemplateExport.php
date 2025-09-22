<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class KoperasiTemplateExport implements FromArray
{
    public function array(): array
    {
        return [
            // Header
            [
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
            ],
            // Sample row
            [
                'Koperasi Sejahtera Mandiri',
                'Jl. Raya Bandung No. 123',
                'Cimahi',
                'Cimahi',
                'AKTIF',
                'Konsumen',
                '518/BH/KWK.11/III/2023',
                '2023-03-15',
                'Budi Santoso',
                'Ani Kartini',
                'Candra Wijaya',
                '022-1234567',
                'koperasi@example.com',
                50,
                150000000,
                75000000,
                400000000,
                30000000,
                'Koperasi yang bergerak di bidang konsumen'
            ]
        ];
    }
}
