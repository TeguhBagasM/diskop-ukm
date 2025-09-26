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
        Schema::create('agenda_kegiatan_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_kegiatan_id')->constrained('agenda_kegiatan')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate assignments
            $table->unique(['agenda_kegiatan_id', 'pegawai_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_kegiatan_pegawais');
    }
};
