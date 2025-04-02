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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->integer('quantitatif_row_id')->constrained();
            $table->integer('article_id')->constrained()->nullable();
            $table->integer('room_id')->constrained()->nullable();
            $table->string('designation')->nullable();
            $table->string('reference')->nullable();
            $table->string('type')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
