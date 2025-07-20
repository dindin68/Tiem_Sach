<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['cart_id', 'book_id','unit_price', 'quantity', 'amount', 'notice'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted()
    {
        static::saved(function ($item) {
            $item->cart->updateTotalCost();
        });

        static::deleted(function ($item) {
            $item->cart->updateTotalCost();
        });
    }

    
}
