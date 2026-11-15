<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Légende affichée sous la photo, dans la page comme dans le rapport PDF
        Schema::table('journal_images', function (Blueprint $table) {
            $table->string('caption')->nullable()->after('folder');
        });
    }

    public function down(): void
    {
        Schema::table('journal_images', function (Blueprint $table) {
            $table->dropColumn('caption');
        });
    }
};
