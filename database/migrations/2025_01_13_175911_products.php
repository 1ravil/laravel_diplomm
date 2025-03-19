<?php

use App\Models\Categories;
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
            $table->bigIncrements('id'); // bigserial
            $table->string('product_name'); // varchar
            $table->foreignIdFor(Categories::class); // int
            $table->integer('product_price'); // int
            $table->string('product_color'); // varchar
            $table->text('product_description'); // varchar (можно использовать text для больших описаний)
            $table->timestamps(); // добавляет created_at и updated_at
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
