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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->constrained()->cascadeOnDelete();
            $table->integer('client_id')->constrained()->nullable();
            $table->integer('projet_id')->constrained()->nullable();
            $table->integer('devis_id')->constrained()->nullable();
            $table->string('title');
            $table->date('date');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
