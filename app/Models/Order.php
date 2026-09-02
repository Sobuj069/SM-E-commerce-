<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'postal_code',
        'total_amount',
        'coupon_code',
        'discount_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'courier_name',
        'consignment_id',
        'tracking_code',
        'courier_status',
        'courier_charge',
        'fraud_risk_score',
        'fraud_status',
        'fraud_notes',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'courier_charge' => 'decimal:2',
        'fraud_risk_score' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}