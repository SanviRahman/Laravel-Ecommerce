<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'unread'  => 'badge badge-warning',
            'read'    => 'badge badge-info',
            'replied' => 'badge badge-success',
            'spam'    => 'badge badge-danger',
            default   => 'badge badge-secondary',
        };
    }

    /**
     * Get formatted created date
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y h:i A');
    }

    /**
     * Get short message preview
     */
    public function getMessagePreviewAttribute($length = 100)
    {
        return strlen($this->message) > $length
            ? substr($this->message, 0, $length) . '...'
            : $this->message;
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        if ($this->status == 'unread') {
            $this->update(['status' => 'read']);
        }
    }

    /**
     * Scope for unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope for today's messages
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}
