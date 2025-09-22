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
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('file_type')->default('excel');
            $table->string('bulan');
            $table->year('tahun');
            $table->enum('kategori', ['UMKM', 'KOPERASI'])->default('KOPERASI');
            $table->integer('total_records')->default(0);
            $table->integer('processed_records')->default(0);
            $table->enum('status', ['PENDING', 'PROCESSING', 'COMPLETED', 'FAILED'])->default('PENDING');
            $table->text('error_log')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();

            // Index untuk pencarian
            $table->index(['kategori', 'tahun', 'bulan']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_uploads');
    }
};
