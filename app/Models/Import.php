<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Import extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'date', 'provider', 'total_cost', 'admin_id'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ImportItem::class);
    }
}
