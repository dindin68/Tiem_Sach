<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'book_id', 'path'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
