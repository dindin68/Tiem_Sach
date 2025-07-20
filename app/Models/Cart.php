<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Cart extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','customer_id', 'total_cost'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($cart) {
            if (empty($cart->id)) {
                $cart->id = strtoupper(Str::random(8)); // 8 ký tự A-Z0-9
            }
        });
    }
    public function updateTotalCost()
    {
        $this->total_cost = $this->items()->sum('amount');
        $this->save();
    }

}
