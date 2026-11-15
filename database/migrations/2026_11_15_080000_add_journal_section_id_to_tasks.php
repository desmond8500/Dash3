<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tâches rattachées à une section de journal
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('journal_section_id')->nullable()->after('journal_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('journal_section_id');
        });
    }
};
