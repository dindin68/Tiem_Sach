<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id', 'customer_id', 'phone',
        'recipient_name', 'house_number', 'ward', 'district', 'city'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public $timestamps = false;
}