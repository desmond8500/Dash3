<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nombre d'équipements identiques (synchronisé avec les emplacements posés sur les plans)
        // et emplacement dans le bâtiment (niveau, local)
        Schema::table('equipements', function (Blueprint $table) {
            $table->unsignedInteger('quantite')->default(1)->after('modele');
            $table->unsignedBigInteger('stage_id')->nullable()->after('article_id')->index();
            $table->unsignedBigInteger('room_id')->nullable()->after('stage_id')->index();
        });

        // Icônes pour matérialiser les équipements sur les plans, liées aux articles par leurs tags
        Schema::create('icons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag')->nullable()->index();   // tag d'article (spatie/tags), ex. « caméra »
            $table->string('tabler', 60)->nullable();     // icône Tabler, ex. « ti-camera »
            $table->string('image')->nullable();          // ou image envoyée (storage/…)
            $table->string('color', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('icons');
        Schema::table('equipements', function (Blueprint $table) {
            $table->dropColumn(['quantite', 'stage_id', 'room_id']);
        });
    }
};
