<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained();
            $table->string('client_name')->nullable();
            $table->string('projet_name')->nullable();
            $table->string('reference');
            $table->text('description');
            $table->string('modalite')->nullable();
            $table->string('note')->nullable();
            $table->string('statut')->default('Nouveau');
            $table->decimal('tax')->default('0');
            $table->decimal('remise')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
