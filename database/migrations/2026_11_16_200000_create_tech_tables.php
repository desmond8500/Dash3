<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Espace technicien (Dash3Tech) : affectation des tâches, informations
 * temporaires, rapports d'intervention et demandes d'accès.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Notifications Laravel (canal database) : alertes avant expiration, nouveaux rapports…
        if (! Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }

        // Techniciens affectés à une tâche
        Schema::create('task_technician', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['task_id', 'user_id']);
        });

        // Informations temporaires partagées avec un ou plusieurs techniciens
        Schema::create('tech_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('category', 20)->default('info'); // info | materiel | acces | document
            $table->string('title');
            $table->text('content')->nullable();
            $table->foreignId('task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->foreignId('projet_id')->nullable()->constrained('projets')->nullOnDelete();
            $table->foreignId('article_id')->nullable()->constrained('articles')->nullOnDelete();
            $table->foreignId('building_id')->nullable()->constrained('buildings')->nullOnDelete();
            $table->string('file_path')->nullable();   // disque privé « local »
            $table->string('file_name')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->boolean('expires_with_task')->default(false);
            $table->timestamp('expiry_notified_at')->nullable();
            $table->timestamp('expired_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('tech_share_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tech_share_id')->constrained('tech_shares')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->unique(['tech_share_id', 'user_id']);
        });

        // Rapports d'intervention (client_uuid : envoi idempotent depuis le mode hors ligne)
        Schema::create('tech_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('client_uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->foreignId('projet_id')->nullable()->constrained('projets')->nullOnDelete();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('status', 20)->default('submitted'); // submitted | validated | rejected
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('review_note')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tech_report_photos', function (Blueprint $table) {
            $table->id();
            $table->uuid('client_uuid')->nullable()->unique();
            $table->foreignId('tech_report_id')->constrained('tech_reports')->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        // Demandes d'accès à une information ; une demande acceptée crée un partage temporaire
        Schema::create('tech_access_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('client_uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject');
            $table->text('reason')->nullable();
            $table->foreignId('task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->foreignId('projet_id')->nullable()->constrained('projets')->nullOnDelete();
            $table->foreignId('article_id')->nullable()->constrained('articles')->nullOnDelete();
            $table->string('status', 20)->default('pending'); // pending | approved | rejected
            $table->foreignId('decided_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('decided_at')->nullable();
            $table->text('response')->nullable();
            $table->foreignId('tech_share_id')->nullable()->constrained('tech_shares')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tech_access_requests');
        Schema::dropIfExists('tech_report_photos');
        Schema::dropIfExists('tech_reports');
        Schema::dropIfExists('tech_share_user');
        Schema::dropIfExists('tech_shares');
        Schema::dropIfExists('task_technician');
        // La table notifications est conservée : d'autres modules peuvent l'utiliser.
    }
};
