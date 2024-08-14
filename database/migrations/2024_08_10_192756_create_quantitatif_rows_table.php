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
        Schema::create('quantitatif_rows', function (Blueprint $table) {
            $table->id();
            $table->integer('quantitatif_id')->constrained();
            $table->integer('article_id')->nullable();
            $table->integer('quantite')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantitatif_rows');
    }
};
