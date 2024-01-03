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
        Schema::create('invoice_rows', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_section_id')->constrained();
            $table->string('designation');
            $table->decimal('coef')->default(1);
            $table->text('reference')->default('_');
            $table->integer('quantite')->default(1);
            $table->decimal('prix')->default(1);
            $table->integer('priorite')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_rows');
    }
};
