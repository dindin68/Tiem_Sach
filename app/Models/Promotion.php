<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'start_date', 'end_date', 'discount_percentage'];

    public function details(): HasMany
    {
        return $this->hasMany(PromotionDetail::class);
    }
}
