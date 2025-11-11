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
        Schema::create('subdomain', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skpd_id')->constrained('skpd')->onDelete('cascade');
            $table->foreignId('permohonan_id')->constrained('permohonan')->onDelete('cascade');
            
            $table->string('nama_subdomain');
            
            // kondisi teknis subdomain (aktif/nonaktif/error)
            $table->enum('kondisi', ['aktif', 'nonaktif', 'error'])->default('aktif');
            
            // status administratif (disetujui/menunggu/ditolak)
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            
            // tanggal pembuatan subdomain berdasarkan waktu permohonan disetujui
            $table->timestamp('tanggal_permohonan')->nullable();
            
            // link langsung ke subdomain
            $table->string('link')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdomain');
    }
};
