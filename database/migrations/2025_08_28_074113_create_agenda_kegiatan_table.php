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
        Schema::create('agenda_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kegiatan', ['INTERNAL', 'EKSTERNAL']);
            $table->string('nama_kegiatan');
            $table->string('sumber');
            $table->string('tempat');
            $table->time('waktu');
            $table->string('pegawai_yang_ditugaskan');
            $table->enum('tindak_lanjut', ['DISPOSISI', 'DIHADIRI']);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_kegiatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_kegiatan');
    }
};
