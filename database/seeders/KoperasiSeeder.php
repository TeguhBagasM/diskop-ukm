<?php

namespace Database\Seeders;

use App\Models\Koperasi;
use Illuminate\Database\Seeder;

class KoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $koperasiData = [
            [
                'nama_koperasi' => 'KOPERASI PEGAWAI GERAKAN HIJAU INDONESIA',
                'alamat' => 'JALAN SANTOSA EKOWISATA BAMBU LEMBANG ASRI JALAN CIMANGGU INDAH UTARA 5 LEMBANG',
                'kelurahan' => 'KELURAHAN',
                'kecamatan' => 'CIMAHI',
                'status' => 'AKTIF',
                'jenis_koperasi' => 'Produksi',
                'no_badan_hukum' => '518/BH/KWK.11/III/2018',
                'tanggal_berdiri' => '2018-03-15',
                'ketua' => 'Budi Santoso',
                'sekretaris' => 'Ani Kartini',
                'bendahara' => 'Candra Wijaya',
                'no_telepon' => '022-2086543',
                'email' => 'koperasi.ghi@gmail.com',
                'jumlah_anggota' => 45,
                'modal_sendiri' => 125000000,
                'modal_luar' => 75000000,
                'volume_usaha' => 350000000,
                'shu' => 25000000,
                'keterangan' => 'Koperasi yang bergerak di bidang ekowisata dan produk ramah lingkungan'
            ],
            [
                'nama_koperasi' => 'Koperasi Karyawan SUKA Budi Bakti Cibaduy',
                'alamat' => 'Jl Sukabakti III No.15',
                'kelurahan' => 'CIMAHI',
                'kecamatan' => 'CIMAHI',
                'status' => 'AKTIF',
                'jenis_koperasi' => 'Konsumen',
                'no_badan_hukum' => '425/BH/KWK.11/VII/2019',
                'tanggal_berdiri' => '2019-07-22',
                'ketua' => 'Dedi Supriadi',
                'sekretaris' => 'Erni Rahayu',
                'bendahara' => 'Fajar Nugraha',
                'no_telepon' => '022-6654321',
                'email' => 'koperasi.sukabudi@gmail.com',
                'jumlah_anggota' => 32,
                'modal_sendiri' => 85000000,
                'modal_luar' => 50000000,
                'volume_usaha' => 220000000,
                'shu' => 18000000,
                'keterangan' => 'Koperasi konsumen untuk kebutuhan sehari-hari karyawan'
            ],
            [
                'nama_koperasi' => 'Koperasi Sejahtera Hebat Teranggi',
                'alamat' => 'Jl Stasiun Cimanggu Jl Cimanggu Tengah Jl OLX Ruko 07',
                'kelurahan' => 'CIMAHI',
                'kecamatan' => 'CIMAHI',
                'status' => 'AKTIF',
                'jenis_koperasi' => 'Konsumen',
                'no_badan_hukum' => '362/BH/KWK.11/IX/2020',
                'tanggal_berdiri' => '2020-09-10',
                'ketua' => 'Gina Marlina',
                'sekretaris' => 'Hendra Gunawan',
                'bendahara' => 'Indah Permata',
                'no_telepon' => '022-7778899',
                'email' => 'koperasi.sejahtera@gmail.com',
                'jumlah_anggota' => 28,
                'modal_sendiri' => 95000000,
                'modal_luar' => 65000000,
                'volume_usaha' => 280000000,
                'shu' => 22000000,
                'keterangan' => 'Koperasi yang melayani kebutuhan konsumen di wilayah Cimanggu'
            ],
            [
                'nama_koperasi' => 'Koperasi Rakyat Tunas Mandiri',
                'alamat' => 'Jl Sukajagoan No.07 Desa 03',
                'kelurahan' => 'CIMAHI',
                'kecamatan' => 'CIMAHI',
                'status' => 'AKTIF',
                'jenis_koperasi' => 'Konsumen',
                'no_badan_hukum' => '518/BH/KWK.11/V/2017',
                'tanggal_berdiri' => '2017-05-18',
                'ketua' => 'Joko Widodo',
                'sekretaris' => 'Kartika Sari',
                'bendahara' => 'Lukman Hakim',
                'no_telepon' => '022-5544332',
                'email' => 'koperasi.tunasmandiri@gmail.com',
                'jumlah_anggota' => 38,
                'modal_sendiri' => 110000000,
                'modal_luar' => 80000000,
                'volume_usaha' => 320000000,
                'shu' => 28000000,
                'keterangan' => 'Koperasi rakyat yang fokus pada pemberdayaan ekonomi masyarakat'
            ],
            [
                'nama_koperasi' => 'Koperasi Usri Desa Tani Mulai Cerdey',
                'alamat' => 'Jl Kehutanan No.07 Cerdey',
                'kelurahan' => 'CIMAHI',
                'kecamatan' => 'CIMAHI',
                'status' => 'TIDAK AKTIF',
                'jenis_koperasi' => 'Konsumen',
                'no_badan_hukum' => '289/BH/KWK.11/XII/2016',
                'tanggal_berdiri' => '2016-12-05',
                'ketua' => 'Maman Suryaman',
                'sekretaris' => 'Nurlaela',
                'bendahara' => 'Oscar Pratama',
                'no_telepon' => '022-3344556',
                'email' => 'koperasi.tanmulcerdey@gmail.com',
                'jumlah_anggota' => 15,
                'modal_sendiri' => 45000000,
                'modal_luar' => 25000000,
                'volume_usaha' => 120000000,
                'shu' => 8000000,
                'keterangan' => 'Koperasi pertanian yang saat ini tidak aktif beroperasi'
            ]
        ];

        foreach ($koperasiData as $data) {
            Koperasi::create($data);
        }
    }
}
