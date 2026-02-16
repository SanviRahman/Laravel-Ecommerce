<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmOrder extends Model
{
    use HasFactory;

    protected $table = 'confirm_orders';

    protected $fillable = [
        'user_id',
        'session_id',
        'order_number',
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
        'stripe_session_id',
        'stripe_payment_intent_id',
        'paid_amount',
        'payment_date',
        'is_paid',
        'mobile_banking_method',
        'mobile_number',
        'transaction_id',
        'bank_name',
        'account_number',
    ];

    protected $casts = [
        'subtotal'     => 'decimal:2',
        'shipping'     => 'decimal:2',
        'tax'          => 'decimal:2',
        'total'        => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'payment_date' => 'datetime',
        'is_paid'      => 'boolean',
    ];

    /**
     * Get the order items for this order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /**
     * Get the items for this order (alias for orderItems)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
