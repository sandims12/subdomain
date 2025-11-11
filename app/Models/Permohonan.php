<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';

    protected $fillable = [
        'skpd_id',
        'nama_subdomain',
        'file_pengajuan',
        'status',               // menunggu, disetujui, ditolak
        'keterangan_admin',     // ⬅️ tambahkan ini
        'file_tindak_lanjut',   // sudah benar
    ];

    public function skpd()
    {
        return $this->belongsTo(User::class, 'skpd_id');
    }

    public function subdomain()
    {
        return $this->hasOne(Subdomain::class, 'permohonan_id');
    }
}