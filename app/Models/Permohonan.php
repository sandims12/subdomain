<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';

// Add category_id and subcategory_id to the fillable properties in the model
protected $fillable = [
    'skpd_id',
    'nama_subdomain',
    'category_id',
    'subcategory_id',
    'status',
    'keterangan_admin',
    'file_tindak_lanjut',
];


    public function skpd()
    {
        return $this->belongsTo(User::class, 'skpd_id');
    }

    public function subdomain()
    {
        return $this->hasOne(Subdomain::class, 'permohonan_id');
    }

    // Menambahkan relasi ke kategori
public function category()
{
    return $this->belongsTo(Category::class);
}

// Menambahkan relasi ke subkategori
public function subcategory()
{
    return $this->belongsTo(Subcategory::class);
}

}