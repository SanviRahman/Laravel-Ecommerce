<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_title',
        'product_description',
        'product_quantity',
        'product_price',
        'product_category',
        'product_image',
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category');
    }
}
