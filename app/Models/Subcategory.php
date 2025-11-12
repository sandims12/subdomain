<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai konvensi
    protected $table = 'subcategories';

    // Tentukan field yang bisa diisi
    protected $fillable = ['category_id', 'name'];

    // Relasi ke model Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
