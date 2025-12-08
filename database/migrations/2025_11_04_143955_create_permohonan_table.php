<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skpd_id');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('nama_subdomain')->nullable();
            $table->enum('lokasi', ['Indoor', 'Outdoor'])->nullable();
            $table->string('subjek', 100)->nullable();
            $table->text('deskiprsi')->nullable();
            $table->enum('vendor', ['iya', 'tidak']);
            $table->string('nama_vendor')->nullable();
            $table->string('file_pengajuan')->nullable();
            $table->enum('status', ['draft', 'menunggu', 'disetujui', 'ditolak'])->default('draft');
            $table->text('keterangan_admin')->nullable();
            $table->string('file_tindak_lanjut')->nullable();
            $table->timestamps();

            $table->foreign('skpd_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('permohonan');
    }
};