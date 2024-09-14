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
            $table->string('id')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('image');
            $table->float('price');
            $table->integer('total_sales');
            $table->string('created_by');
            $table->integer('created_at');
            $table->string('updated_by');
            $table->integer('updated_at');
            $table->string('deleted_by');
            $table->integer('deleted_at');
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
