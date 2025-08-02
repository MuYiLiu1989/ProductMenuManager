<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->boolean('is_enable')->default(1)->comment('刪除後為0');
            $table->boolean('is_visible')->comment('啟用');
            $table->id();
            $table->string('name', 100)->comment('名稱');
            $table->foreignId('category_id')->references('id')->on('product_categories')->onDelete('cascade')->comment('分類ID');
            $table->unsignedInteger('stock')->comment('庫存');
            $table->unsignedInteger('price')->comment('價格');
            $table->unsignedInteger('sort')->comment('排序');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('created_at')->useCurrent();

            $table->index('is_enable', 'is_visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
