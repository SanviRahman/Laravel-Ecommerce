<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAddCard extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'price',
        'product_title',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for guest cart
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId)->whereNull('user_id');
    }

    // Scope for user cart
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Merge guest cart with user cart on login
    public static function mergeCarts($sessionId, $userId)
    {
        $guestCartItems = self::forSession($sessionId)->get();

        foreach ($guestCartItems as $guestItem) {
            // Check if user already has this product in cart
            $userCartItem = self::forUser($userId)
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($userCartItem) {
                // Update quantity
                $userCartItem->quantity += $guestItem->quantity;
                $userCartItem->save();
                $guestItem->delete();
            } else {
                // Transfer to user
                $guestItem->update([
                    'user_id'    => $userId,
                    'session_id' => null,
                ]);
            }
        }
    }
}
