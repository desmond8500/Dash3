<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Dash3Web :
 * - modèles de badge propres à un client (client_id, orientation, couleur) ;
 * - localisation des projets et des fournisseurs (adresse, latitude, longitude) ;
 * - catégorie des documents de projet (catalogue, flyer, plan d'accès…) ;
 * - documents et liens des fournisseurs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('badge_modeles', function (Blueprint $table) {
            if (! Schema::hasColumn('badge_modeles', 'client_id')) $table->unsignedBigInteger('client_id')->nullable()->index()->after('id');
            if (! Schema::hasColumn('badge_modeles', 'orientation')) $table->string('orientation', 20)->default('portrait')->after('file');
            if (! Schema::hasColumn('badge_modeles', 'color')) $table->string('color', 20)->nullable()->after('orientation');
        });

        Schema::table('projets', function (Blueprint $table) {
            if (! Schema::hasColumn('projets', 'address')) $table->string('address')->nullable();
            if (! Schema::hasColumn('projets', 'latitude')) $table->decimal('latitude', 10, 7)->nullable();
            if (! Schema::hasColumn('projets', 'longitude')) $table->decimal('longitude', 10, 7)->nullable();
        });

        Schema::table('providers', function (Blueprint $table) {
            if (! Schema::hasColumn('providers', 'latitude')) $table->decimal('latitude', 10, 7)->nullable();
            if (! Schema::hasColumn('providers', 'longitude')) $table->decimal('longitude', 10, 7)->nullable();
        });

        Schema::table('project_docs', function (Blueprint $table) {
            if (! Schema::hasColumn('project_docs', 'category')) $table->string('category', 50)->nullable()->after('document_path');
        });

        if (! Schema::hasTable('provider_documents')) {
            Schema::create('provider_documents', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('provider_id')->index();
                $table->string('name');
                $table->string('category', 50)->nullable();
                $table->string('path');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('provider_links')) {
            Schema::create('provider_links', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('provider_id')->index();
                $table->string('name');
                $table->string('url', 2048);
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_links');
        Schema::dropIfExists('provider_documents');
        Schema::table('project_docs', fn (Blueprint $t) => $t->dropColumn('category'));
        Schema::table('providers', fn (Blueprint $t) => $t->dropColumn(['latitude', 'longitude']));
        Schema::table('projets', fn (Blueprint $t) => $t->dropColumn(['address', 'latitude', 'longitude']));
        Schema::table('badge_modeles', fn (Blueprint $t) => $t->dropColumn(['client_id', 'orientation', 'color']));
    }
};
