<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('invoice_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('section');
            $table->integer('ordre')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_sections');
    }
};
