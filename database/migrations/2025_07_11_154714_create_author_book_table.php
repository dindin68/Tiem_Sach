<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('author_book')) {
            Schema::create('author_book', function (Blueprint $table) {
                $table->string('author_id', 50);
                $table->string('book_id', 50);

                $table->primary(['author_id', 'book_id']);

                $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
                $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('author_book');
    }
};

