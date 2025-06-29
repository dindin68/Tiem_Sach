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
        Schema::create('import_item', function (Blueprint $table) {
            $table->string('import_id', 50);
            $table->string('book_id', 50);
            $table->integer('quantity');
            $table->decimal('import_price', 10, 2);
            $table->primary(['import_id', 'book_id']);
            $table->foreign('import_id')->references('id')->on('import');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_item');
    }
};
