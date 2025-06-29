<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotion_detail', function (Blueprint $table) {
            $table->string('promotion_id', 50);
            $table->string('book_id', 50);
            $table->primary(['promotion_id', 'book_id']);
            $table->foreign('promotion_id')->references('id')->on('promotions');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_detail');
    }
};
