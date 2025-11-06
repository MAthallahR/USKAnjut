<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // The table name is 'produks' by Laravel convention
    
    
    protected $fillable = [
        'nama_produk',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',
    ];

    // Define the relationship to Ulasan (Reviews)
     public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'product_id');
    }

    // Accessor untuk rata-rata rating
    public function getAverageRatingAttribute()
    {
        return $this->ulasans()->avg('rating') ?: 0;
    }

    // Accessor untuk jumlah ulasan
    public function getTotalReviewsAttribute()
    {
        return $this->ulasans()->count();
    }
}