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
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->integer('projet_id')->constrained();
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->string('fonction')->nullable();
            $table->string('service')->nullable();
            $table->string('photo')->nullable();
            $table->string('matricule')->nullable();
            $table->string('adresse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
