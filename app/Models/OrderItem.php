<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_title',
        'price',
        'quantity',
        'size',
        'total',
    ];

    // Add type casting
    protected $casts = [
        'price'    => 'decimal:2',
        'total'    => 'decimal:2',
        'quantity' => 'integer',
    ];

    // Relationship with ConfirmOrder
    public function order()
    {
        return $this->belongsTo(ConfirmOrder::class, 'order_id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate total automatically
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            if (empty($item->total)) {
                $item->total = $item->price * $item->quantity;
            }
        });
    }
    
    // REMOVED: public function orderItems() - এই মেথডটি সরিয়ে ফেলুন কারণ এটি কনফিউশন তৈরি করছে
}