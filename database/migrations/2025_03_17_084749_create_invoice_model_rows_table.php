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
        Schema::create('invoice_model_rows', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_model_id')->constrained();
            $table->integer('article_id')->constrained()->nullable();
            $table->string('designation')->nullable();
            $table->text('description')->nullable();
            $table->decimal('coef')->default(1);
            $table->text('reference')->default('_');
            $table->integer('quantite')->default(1);
            $table->decimal('prix')->default(0);
            $table->integer('priorite_id')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_model_rows');
    }
};
