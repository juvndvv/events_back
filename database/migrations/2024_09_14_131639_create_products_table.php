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
            $table->string('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->float('price')->nullable();
            $table->integer('total_sales')->nullable();
            $table->string('created_by')->nullable();
            $table->integer('created_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('updated_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->integer('deleted_at')->nullable();
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
