<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewMedia extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'review_id', 'media_type', 'media_urlL', 'date'];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
