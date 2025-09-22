<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('koperasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_koperasi');
            $table->text('alamat');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->enum('status', ['AKTIF', 'TIDAK AKTIF'])->default('AKTIF');
            $table->enum('jenis_koperasi', [
                'Produksi',
                'Konsumen',
                'Simpan Pinjam',
                'Serba Usaha'
            ]);
            $table->string('no_badan_hukum')->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->string('ketua')->nullable();
            $table->string('sekretaris')->nullable();
            $table->string('bendahara')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->integer('jumlah_anggota')->default(0);
            $table->decimal('modal_sendiri', 15, 2)->default(0);
            $table->decimal('modal_luar', 15, 2)->default(0);
            $table->decimal('volume_usaha', 15, 2)->default(0);
            $table->decimal('shu', 15, 2)->default(0); // Sisa Hasil Usaha
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Index untuk pencarian yang lebih cepat
            $table->index(['kecamatan', 'kelurahan']);
            $table->index('status');
            $table->index('jenis_koperasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koperasi');
    }
};
