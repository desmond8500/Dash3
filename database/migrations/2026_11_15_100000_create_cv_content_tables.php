<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Un CV portait seulement un nom : contenu et personnalisation
        Schema::table('c_v_s', function (Blueprint $table) {
            $table->string('title')->nullable()->after('name');          // intitulé du poste
            $table->string('fullname')->nullable()->after('title');
            $table->text('summary')->nullable()->after('fullname');      // accroche (markdown)
            $table->string('photo')->nullable()->after('summary');
            $table->string('phone', 50)->nullable()->after('photo');
            $table->string('email')->nullable()->after('phone');
            $table->string('address')->nullable()->after('email');
            $table->string('website')->nullable()->after('address');
            // Personnalisation
            $table->string('accent_color', 20)->default('#1690b7')->after('website');
            $table->string('font', 60)->default('sans')->after('accent_color');   // sans | serif | mono
            $table->string('layout', 20)->default('deux_colonnes')->after('font'); // une_colonne | deux_colonnes
            $table->boolean('show_photo')->default(true)->after('layout');
        });

        Schema::create('cv_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('c_v_id')->index();
            $table->string('name');
            // experience | formation | competence | langue | libre
            $table->string('type', 30)->default('libre');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('cv_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cv_section_id')->index();
            $table->string('title');
            $table->string('subtitle')->nullable();   // employeur, école…
            $table->string('place')->nullable();
            $table->string('start_date', 20)->nullable(); // texte libre : 2022, 03/2022…
            $table->string('end_date', 20)->nullable();
            $table->boolean('current')->default(false);
            $table->text('description')->nullable();  // markdown
            $table->unsignedTinyInteger('level')->nullable(); // 1..5 pour compétences et langues
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_items');
        Schema::dropIfExists('cv_sections');
        Schema::table('c_v_s', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'fullname', 'summary', 'photo', 'phone', 'email', 'address', 'website',
                'accent_color', 'font', 'layout', 'show_photo',
            ]);
        });
    }
};
