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
        Schema::create('review_media', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('review_id', 50);
            $table->string('media_type', 50);
            $table->text('media_urlL');
            $table->dateTime('date');
            $table->foreign('review_id')->references('id')->on('review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_media');
    }
};
