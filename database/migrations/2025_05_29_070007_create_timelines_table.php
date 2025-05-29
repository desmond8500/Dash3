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
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('projet_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('systeme_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('article_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('provider_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('achat_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('building_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('stage_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('journal_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }
};
