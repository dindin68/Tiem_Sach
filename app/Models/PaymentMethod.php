<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name'];
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_method_id', 'id');
    }
}
