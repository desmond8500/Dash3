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
        Schema::create('fiche_zones', function (Blueprint $table) {
            $table->id();
            $table->integer('fiche_id')->constrained();
            $table->integer('order')->default(1);
            $table->string('equipement')->nullable();
            $table->string('name');
            $table->string('number');
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiche_zones');
    }
};
