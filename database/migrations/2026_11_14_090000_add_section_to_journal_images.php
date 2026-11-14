<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Photos rattachées à une section de journal (les anciennes restent au niveau du journal)
        Schema::table('journal_images', function (Blueprint $table) {
            $table->unsignedBigInteger('journal_section_id')->nullable()->after('journal_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('journal_images', function (Blueprint $table) {
            $table->dropColumn('journal_section_id');
        });
    }
};
