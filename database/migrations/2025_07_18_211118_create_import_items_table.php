<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('import_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id(); // khóa chính tự động
            $table->string('import_id', 50); // foreign key đến imports.id
            $table->string('book_id', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('book_title');
            $table->integer('quantity');
            $table->decimal('import_price', 10, 2);

            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('import_id')
                ->references('id')->on('imports')
                ->onDelete('cascade');

            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('set null');

            // Ngăn trùng cùng một sách trong cùng 1 đơn nhập
            $table->unique(['import_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_items');
    }
};
