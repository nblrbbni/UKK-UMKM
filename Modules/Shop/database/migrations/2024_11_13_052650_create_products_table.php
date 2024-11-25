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

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_category_id');
            $table->string('product_name', 100)->unique();
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('stok_quantity');
            $table->string('info', 50);
            $table->integer('weight');
            $table->string('image1_url', 255)->nullable();
            $table->string('image2_url', 255)->nullable();
            $table->string('image3_url', 255)->nullable();
            $table->string('image4_url', 255)->nullable();
            $table->string('image5_url', 255)->nullable();
            $table->timestamps();

            $table->foreign('product_category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
