<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permohonan;

class Subdomain extends Model
{
    use HasFactory;

    protected $table = 'subdomain';

    protected $fillable = [
        'permohonan_id',
        'skpd_id',               // id user skpd
        'nama_subdomain',

        // kolom detail aplikasi (opsional, boleh dipakai nanti)
        'nama_aplikasi',
        'anggaran', 
        'sifat',                 // Online / Offline
        'tahun_penganggaran',
        'layanan',
        'platform_os',
        'jenis_aplikasi',
        'database_engine',
        'bahasa_pemrograman',
        'ip_pointing',
        'status_aplikasi',       // Aktif / Tidak Aktif
        'pengelola',
        'ket_pembangunan',
        'kendala_pembangunan',
        'rencana_tindak_lanjut',

        'kondisi',               // aktif / nonaktif / error
        'status',                // aktif / nonaktif
        'tanggal_permohonan',
        'link',
    ];

    public function skpd()
    {
        return $this->belongsTo(\App\Models\User::class, 'skpd_id');
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }
}