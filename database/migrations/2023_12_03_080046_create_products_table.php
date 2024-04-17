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
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->float('price');
            $table->string('image')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('currency')->default('eur');
            $table->boolean('active')->default(true);
            $table->foreignId('seller_user_id')->constrained('sellers', 'user_id')->onDelete('cascade');

            $table->timestamps();
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
