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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('expense_space_id');
            $table->integer('user_id');
            $table->integer('article_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('category_id');
            $table->integer('paid_by');
            $table->float('amount');
            $table->text('description')->nullable();
            $table->date('expense_date');
            $table->string('payment_method');
            $table->string('expense_type');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
