<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportItem extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'import_items';
    protected $fillable = ['import_id',
                         'book_id',
                         'book_title', 
                         'quantity', 
                         'import_price'];

    public function import(): BelongsTo
    {
        return $this->belongsTo(Import::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
