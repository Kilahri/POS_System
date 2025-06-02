<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity');
            $table->integer('min_stock_level')->default(10);
            $table->string('sku')->unique();
            $table->unsignedBigInteger('category_id'); // EXPLICIT type matching 'categories.id'
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign key constraint defined explicitly
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
