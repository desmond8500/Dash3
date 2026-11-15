<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Conversion des plans DWG en PDF */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('converted_file')->nullable()->after('file');
            $table->string('conversion_status', 20)->nullable()->after('converted_file'); // pending | processing | done | failed
            $table->text('conversion_error')->nullable()->after('conversion_status');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['converted_file', 'conversion_status', 'conversion_error']);
        });
    }
};
