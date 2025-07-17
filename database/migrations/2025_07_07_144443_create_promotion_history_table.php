<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promotion_history', function (Blueprint $table) {
            $table->id();
            $table->string('book_id');            
            $table->decimal('discount_percentage', 5, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('promotion_id', 50)->nullable();
            
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_history');
    }
};

