<?php
// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'image'
    ];

    // Scope untuk kategori tertentu
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}