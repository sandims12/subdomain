<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();

            // FK ke SKPD (bukan users)
            $table->foreignId('skpd_id')->constrained('skpd')->onDelete('cascade');

            // FK category + subcategory
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->nullOnDelete();

            // Data permohonan
            $table->string('lokasi')->nullable();
            $table->string('subjek')->nullable();
            $table->text('deskripsi')->nullable();

            $table->string('file_pengajuan')->nullable();

            // status permohonan
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');

            // admin
            $table->text('keterangan_admin')->nullable();
            $table->string('file_tindak_lanjut')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};
