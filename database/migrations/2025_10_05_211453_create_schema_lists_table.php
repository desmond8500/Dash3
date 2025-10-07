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
        Schema::create('schema_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schema_id')->nullable();
            $table->unsignedBigInteger('item_id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('unit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schema_lists');
    }
};
