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
        Schema::table('pvs', function (Blueprint $table) {
            $table->integer('invoice_id')->constrained();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->date('date')->nullable();
            $table->string('client')->nullable();
            $table->string('client_logo')->nullable();
            $table->string('bct')->nullable();
            $table->string('bct_logo')->nullable();
            $table->string('mo')->nullable();
            $table->string('mo_logo')->nullable();
            $table->string('me')->nullable();
            $table->string('me_logo')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pvs', function (Blueprint $table) {
            //
        });
    }
};
