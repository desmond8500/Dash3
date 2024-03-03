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
        Schema::create('invoice_acomptes', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->constrained();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('montant');
            $table->boolean('statut')->default(false);
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_acomptes');
    }
};
