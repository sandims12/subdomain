<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            if (!Schema::hasColumn('permohonan', 'keterangan_admin')) {
                $table->text('keterangan_admin')->nullable()->after('status');
            }
            if (!Schema::hasColumn('permohonan', 'file_tindak_lanjut')) {
                $table->string('file_tindak_lanjut')->nullable()->after('keterangan_admin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            if (Schema::hasColumn('permohonan', 'file_tindak_lanjut')) {
                $table->dropColumn('file_tindak_lanjut');
            }
            if (Schema::hasColumn('permohonan', 'keterangan_admin')) {
                $table->dropColumn('keterangan_admin');
            }
        });
    }
};

