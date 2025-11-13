<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi (fillable)
    protected $fillable = ['category_id', 'name'];

    // Relasi dengan Category (bisa diakses dengan $subcategory->category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
