<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'title', 'author', 'publisher',
        'price', 'stock', 'imported', 'sold', 'category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function importItems(): HasMany
    {
        return $this->hasMany(ImportItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promotionDetails(): HasMany
    {
        return $this->hasMany(PromotionDetail::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function getPrimaryImageAttribute()
    {
        return $this->images()->first()?->path;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public const UPDATED_AT = null; 
}
