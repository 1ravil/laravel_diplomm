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
        Schema::create('deliviries', function (Blueprint $table) {
            $table->bigIncrements('id'); // bigserial
            $table->integer('product_id'); // int
            $table->integer('store_id'); // int
            $table->string('delivery_id'); // varchar
            $table->integer('product_count'); // int
            $table->primary('id'); // Устанавливаем id как первичный ключ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliviries');
    }
};
