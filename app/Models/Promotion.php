<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Promotion extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'start_date', 'end_date', 'discount_percentage'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'promotion_detail', 'promotion_id', 'book_id');
    }

    public function isActive()
    {
        return Carbon::now()->between(
            Carbon::parse($this->start_date),
            Carbon::parse($this->end_date)
        );
    }

}
