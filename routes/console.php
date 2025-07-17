<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\Promotion;
use App\Models\PromotionHistory;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Khuyến mãi: xóa KM hết hạn và lưu lịch sử
Artisan::command('promotions:remove-expired', function () {
    $now = now();

    $expiredPromotions = Promotion::where('end_date', '<', $now)->get();

    foreach ($expiredPromotions as $promotion) {
        $bookIds = DB::table('promotion_detail')
            ->where('promotion_id', $promotion->id)
            ->pluck('book_id');

        foreach ($bookIds as $bookId) {
            PromotionHistory::create([
                'book_id' => $bookId,
                'promotion_id' => $promotion->id,
                'discount_percentage' => $promotion->discount_percentage,
                'start_date' => $promotion->start_date,
                'end_date' => $promotion->end_date,
            ]);
        }
        //Xóa liên kết KM (sách về giá gốc)
        DB::table('promotion_detail')
            ->where('promotion_id', $promotion->id)->delete();
    }

    $this->info('Đã xoá khuyến mãi hết hạn và lưu lịch sử.');
    
})->purpose('Xoá khuyến mãi hết hạn và lưu lịch sử');
