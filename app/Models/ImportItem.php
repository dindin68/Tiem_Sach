<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportItem extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['import_id', 'book_id', 'quantity', 'import_price'];

    public function import(): BelongsTo
    {
        return $this->belongsTo(Import::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
