<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;          // ⬅️ penting, import User
use App\Models\Permohonan;

class Subdomain extends Model
{
    use HasFactory;

    protected $table = 'subdomain';

    protected $fillable = [
        'permohonan_id',
        'skpd_id',              // id user yang role-nya = skpd
        'nama_subdomain',
        'status',               // aktif / nonaktif / error
        'tanggal_permohonan',
        'link',
    ];

    // SKPD sekarang diambil dari tabel users
    public function skpd()
{
    return $this->belongsTo(\App\Models\User::class, 'skpd_id');
}

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }
}
