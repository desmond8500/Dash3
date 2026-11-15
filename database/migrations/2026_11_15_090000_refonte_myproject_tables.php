<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // La table des transactions n'avait que son id : budget (achats prévisionnels et dépenses)
        Schema::table('myproject_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('myproject_transactions', 'myproject_id')) {
                $table->unsignedBigInteger('myproject_id')->after('id')->index();
            }
            $table->string('name')->nullable()->after('myproject_id');
            $table->decimal('amount', 14, 2)->default(0)->after('name');
            $table->unsignedInteger('quantity')->default(1)->after('amount');
            $table->date('transaction_date')->nullable()->after('quantity');
            $table->text('description')->nullable()->after('transaction_date');
            // prevision : achat prévu ; depense : dépense effectuée
            $table->string('type', 20)->default('prevision')->after('description')->index();
            $table->string('status', 20)->nullable()->after('type');
        });

        // Liens de recherche (documentation, tutoriels, boutiques…)
        Schema::create('myproject_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('myproject_id')->index();
            $table->string('name');
            $table->string('link', 2048);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Notes du projet
        Schema::create('myproject_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('myproject_id')->index();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });

        // Tâches rattachées à un projet personnel
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('myproject_id')->nullable()->after('journal_section_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('myproject_id');
        });
        Schema::dropIfExists('myproject_notes');
        Schema::dropIfExists('myproject_links');
        Schema::table('myproject_transactions', function (Blueprint $table) {
            $table->dropColumn(['name', 'amount', 'quantity', 'transaction_date', 'description', 'type', 'status']);
        });
    }
};
