<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'name', 'percentage_discount',
        'minimum_amount', 'start_date', 'end_date', 'status'
    ];
}
