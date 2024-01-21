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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('projet_id')->nullable();
            $table->integer('devis_id')->nullable();
            $table->integer('level_id')->nullable();
            $table->integer('stage_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->integer('name');
            $table->integer('description');
            $table->integer('priority_id');
            $table->integer('statut_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
