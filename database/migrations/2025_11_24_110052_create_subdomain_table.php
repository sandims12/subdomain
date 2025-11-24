<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subdomain', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skpd_id');
            $table->unsignedBigInteger('permohonan_id');
            $table->string('nama_subdomain');
            $table->string('nama_aplikasi')->nullable();
            $table->enum('sifat', ['Online', 'Offline'])->nullable();
            $table->string('tahun_penganggaran', 4)->nullable();
            $table->string('layanan')->nullable();
            $table->string('platform_os', 100)->nullable();
            $table->string('jenis_aplikasi', 100)->nullable();
            $table->string('database_engine', 100)->nullable();
            $table->string('bahasa_pemrograman', 100)->nullable();
            $table->enum('status_aplikasi', ['Aktif', 'Tidak Aktif'])->nullable();
            $table->string('pengelola')->nullable();
            $table->text('ket_pembangunan')->nullable();
            $table->text('kendala_pembangunan')->nullable();
            $table->text('rencana_tindak_lanjut')->nullable();
            $table->enum('kondisi', ['aktif', 'nonaktif', 'error'])->default('aktif');
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Pending'])->nullable();
            $table->timestamp('tanggal_permohonan')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();

            $table->foreign('permohonan_id')->references('id')->on('permohonan')->onDelete('cascade');
            $table->foreign('skpd_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('subdomain');
    }
};
