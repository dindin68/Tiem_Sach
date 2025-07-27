<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'title', 'author_id', 'publisher',
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

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_detail', 'book_id', 'promotion_id');
    }

    public function getActivePromotionAttribute()
    {
        return $this->promotions
            ->filter(function ($promotion) {
                return now()->between($promotion->start_date, $promotion->end_date);
            })
            ->first(); // Lấy khuyến mãi đầu tiên còn hiệu lực
    }

    public function getDiscountedPriceAttribute()
        {
            $promotion = $this->active_promotion;

            if ($promotion) {
                return $this->price * (1 - $promotion->discount_percentage / 100);
            }

            return null;
        }

        // Có khuyến mãi không?
    public function getIsDiscountedAttribute()
    {
        return $this->promotions()->exists();
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
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

    public function authors()
    {
        return $this->belongsToMany(Author::class,'author_book','book_id','author_id');
    }
}
