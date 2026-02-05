<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConfirmOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'name',
        'email',
        'phone',
        'address',
        'notes',
        'subtotal',
        'shipping',
        'tax',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'customer_type',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // FIX: Specify the foreign key column
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(Str::random(8)) . '-' . time();
    }

    /**
     * Boot method to generate order number automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
            
            // Set customer type if not set
            if (empty($order->customer_type)) {
                $order->customer_type = $order->user_id ? 'registered' : 'guest';
            }
        });
    }

    public function scopeGuestOrders($query)
    {
        return $query->where('customer_type', 'guest');
    }

    public function scopeRegisteredOrders($query)
    {
        return $query->where('customer_type', 'registered');
    }
}