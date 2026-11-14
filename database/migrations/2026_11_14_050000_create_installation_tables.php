<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Installations d'un projet :
 *   Projet › Bâtiment › Système (ex. vidéosurveillance)
 *     › Équipement de base (ex. NVR : IP, modèle, ports…)
 *       › Équipements secondaires (ex. caméras, disques durs)
 * et plans (PDF, image, DWG) sur lesquels on place les équipements.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Système installé dans un bâtiment (vidéosurveillance, alarme, incendie…)
        Schema::create('installation_systemes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('building_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('systeme_id')->nullable(); // catalogue « systemes » (facultatif)
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Équipements : parent_id null = équipement de base, sinon équipement secondaire
        Schema::create('equipements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installation_systeme_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('equipements')->cascadeOnDelete();
            $table->unsignedBigInteger('article_id')->nullable(); // lien facultatif vers le stock
            $table->string('name');
            $table->string('type')->nullable();   // NVR, Caméra, Disque dur…
            $table->string('modele')->nullable();
            $table->json('caracteristiques')->nullable(); // { "Adresse IP": "192.168.1.10", "Ports": "16" }
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Plans importés (PDF, image ; DWG stocké en attendant une conversion)
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('building_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('file');
            $table->string('mime')->nullable();
            $table->string('kind', 10)->default('image'); // image | pdf | dwg
            $table->timestamps();
        });

        // Emplacement d'un équipement sur un plan (coordonnées relatives 0..1)
        Schema::create('plan_markers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipement_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('page')->default(1);
            $table->decimal('x', 8, 6);
            $table->decimal('y', 8, 6);
            $table->string('label')->nullable();
            $table->string('icon')->nullable();
            $table->string('color', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_markers');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('equipements');
        Schema::dropIfExists('installation_systemes');
    }
};
