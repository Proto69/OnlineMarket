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
        Schema::table('punishments', function (Blueprint $table) {
            if (Schema::hasColumn('punishments', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            
            $table->integer('object_id');
            $table->boolean('is_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('punishments', function (Blueprint $table) {
            $table->dropColumn('object_id');
            $table->dropColumn('is_product');
            $table->foreignId('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }
};
