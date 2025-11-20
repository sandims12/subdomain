<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subdomain', function (Blueprint $table) {
            $table->id();

            $table->foreignId('skpd_id')->constrained('skpd')->onDelete('cascade');
            $table->foreignId('permohonan_id')->constrained('permohonan')->onDelete('cascade');

            $table->string('nama_subdomain');

            $table->enum('kondisi', ['aktif', 'nonaktif', 'error'])->default('aktif');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamp('tanggal_permohonan')->nullable();
            $table->string('link')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subdomain');
    }
};
