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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->string('folder');
            $table->string('status');
            $table->string('reference');
            $table->text('description');
            $table->integer('montant');
            $table->date('date')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
