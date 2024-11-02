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
        Schema::create('quantitatif_articles', function (Blueprint $table) {
            $table->id();
            $table->integer('quantitatif_row_id')->constrained();
            $table->integer('room_id')->constrained();
            $table->integer('article_id');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantitatif_articles');
    }
};
