<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;

    protected $table = 'skpd';

    protected $fillable = [
        'nama_skpd',
        'email',
        'password',
    ];

    /**
     * Relasi ke tabel permohonan
     * Satu SKPD bisa mengajukan banyak permohonan
     */
    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'skpd_id');
    }

    /**
     * Relasi ke tabel subdomain
     * Satu SKPD bisa memiliki banyak subdomain
     */
    public function subdomain()
    {
        return $this->hasMany(Subdomain::class, 'skpd_id');
    }
}
