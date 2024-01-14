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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->string('image')->nullable();
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('priority_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->float('price')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
