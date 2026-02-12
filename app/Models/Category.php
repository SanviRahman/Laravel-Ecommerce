<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Get products for this category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category');
    }

    /**
     * Check if category is clothing
     */
    public function isClothing()
    {
        $clothingNames = ['clothing', 'cloth', 'fashion', 'men', 'women', 'kids', 'apparel'];
        return in_array(strtolower($this->name), $clothingNames);
    }

    /**
     * Default sizes for clothing categories
     */
    public function getDefaultSizesAttribute()
    {
        return ['S', 'M', 'L', 'XL', 'XXL'];
    }
}
