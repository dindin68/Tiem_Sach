<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['id', 'customer_id', 'address_id', 'date_order', 'status', 'payment_method_id', 'shipping_fee', 'total_cost', 'notice'];

    public const UPDATED_AT = null;

    public const CREATED_AT = 'date_order';
    protected $casts = [
        'date_order' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(\App\Models\PaymentMethod::class, 'payment_method_id', 'id');
    }



}
