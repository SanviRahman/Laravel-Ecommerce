<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_title',
        'product_description',
        'product_quantity',
        'product_price',
        'product_discount_price',
        'product_category',
        'product_brand',
        'product_sku',
        'product_image',
        'available_sizes',
        'measurement_details',
    ];

    protected $casts = [
        'available_sizes' => 'array',
    ];

    /**
     * Check if product is clothes category
     */
    public function isClothesCategory()
    {
        // First check by category relationship
        if ($this->category) {
            $clothingNames = ['clothing', 'cloth', 'fashion', 'men', 'women', 'kids', 'apparel', 't-shirt', 'shirt', 'pant', 'dress', 'jacket'];
            return in_array(strtolower($this->category->name), $clothingNames);
        }

        // Then check by category ID or name
        $clothingCategories = ['Clothing', 'clothing', 'Cloth', 'cloth', 'Fashion', 'fashion', 'Men', 'Women', 'Kids', 'Apparel'];
        return in_array($this->product_category, $clothingCategories);
    }

    /**
     * Get available sizes
     */
    public function getAvailableSizesAttribute()
    {
        if (! empty($this->available_sizes)) {
            return is_array($this->available_sizes)
                ? $this->available_sizes
                : json_decode($this->available_sizes, true);
        }

        // Try to get from category default sizes
        if ($this->category && method_exists($this->category, 'default_sizes')) {
            return $this->category->default_sizes;
        }

        return ['S', 'M', 'L', 'XL', 'XXL'];
    }

    /**
     * Relationship with category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category');
    }
}
