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
        Schema::create('achat_rows', function (Blueprint $table) {
            $table->id();
            $table->integer('achat_id')->constrained()->cascadeOnDelete();
            $table->string('designation');
            $table->string('reference')->nullable();
            $table->integer('quantite')->default(0);
            $table->decimal('prix')->nullable();
            $table->decimal('tva')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achat_rows');
    }
};
