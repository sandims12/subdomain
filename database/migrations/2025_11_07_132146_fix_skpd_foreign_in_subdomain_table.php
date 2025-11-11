<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subdomain', function (Blueprint $table) {
            // Hapus constraint foreign key lama yang menuju ke tabel skpd
            $table->dropForeign(['skpd_id']);

            // Ubah relasi foreign key agar mengacu ke tabel users
            $table->foreign('skpd_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('subdomain', function (Blueprint $table) {
            $table->dropForeign(['skpd_id']);
            $table->foreign('skpd_id')->references('id')->on('skpd')->onDelete('cascade');
        });
    }
};
