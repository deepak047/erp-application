<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'status',
        'total_amount',
    ];

    /**
     * An order has many order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}