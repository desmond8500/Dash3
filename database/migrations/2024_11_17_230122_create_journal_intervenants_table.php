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
        Schema::create('journal_intervenants', function (Blueprint $table) {
            $table->id();
            $table->integer('journal_id')->constrained();
            $table->integer('contact_id')->constrained()->nullable();
            $table->integer('team_id')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_intervenants');
    }
};
