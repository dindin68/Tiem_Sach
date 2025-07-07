<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionHistory extends Model
{
    public $timestamps = false;

    protected $table = 'promotion_history';

    protected $fillable = [
        'book_id',
        'promotion_id',
        'discount_percentage',
        'start_date',
        'end_date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

}

