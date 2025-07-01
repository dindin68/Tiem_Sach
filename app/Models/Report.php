<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name', 'generate_at', 'type_report', 'admin_id'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
