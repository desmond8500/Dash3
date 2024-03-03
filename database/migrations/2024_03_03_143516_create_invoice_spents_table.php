<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('invoice_spents', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->constrained();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('montant');
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_spents');
    }
};
