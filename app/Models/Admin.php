<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $table='admins';
    protected $primaryKey='id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name', 'email', 'password'];

    public function imports(): HasMany
    {
        return $this->hasMany(Import::class, 'admin_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'admin_id');
    }
}
