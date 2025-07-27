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
        Schema::create('order_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id(); // Khóa chính tự tăng
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            $table->string('book_id', 50)->nullable(); // Cho phép null khi sách bị xóa
            $table->string('book_title');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('amount', 10, 2);
            $table->text('notice')->nullable();

            // (Tuỳ chọn) liên kết đến bảng books nếu bạn muốn
            $table->foreign('book_id')->references('id')->on('books')->onDelete('set null');

            // Nếu muốn tránh trùng sách trong cùng 1 đơn hàng:
            $table->unique(['order_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
