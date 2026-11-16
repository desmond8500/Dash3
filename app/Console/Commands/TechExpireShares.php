<?php

namespace App\Console\Commands;

use App\Models\TechShare;
use App\Notifications\TechShareExpiring;
use App\Support\TechAdmins;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

/**
 * Cycle de vie des informations temporaires partagées avec les techniciens :
 *  1. tâche clôturée → l'information liée expire après le délai de grâce ;
 *  2. alerte à l'auteur avant l'expiration (une fois par date d'expiration) ;
 *  3. expiration : contenu et fichier purgés, plus visibles dans l'application.
 *
 * Planifiée toutes les 15 minutes (app/Console/Kernel.php).
 */
class TechExpireShares extends Command
{
    protected $signature = 'tech:expire-shares {--dry-run : Affiche ce qui serait fait sans rien modifier}';

    protected $description = 'Prévient avant expiration et purge les informations techniciens expirées';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $now = now();

        // 1. Informations liées à une tâche terminée
        $grace = $now->copy()->addHours(config('tech.task_close_grace_hours', 24));
        $taskBound = TechShare::active()
            ->where('expires_with_task', true)
            ->whereHas('task', fn ($q) => $q->where('statut_id', '>=', config('tech.task_done_status', 4)))
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', $grace))
            ->get();

        foreach ($taskBound as $share) {
            $this->line("Tâche terminée → #{$share->id} « {$share->title} » expirera le {$grace->format('d/m/Y H:i')}");
            if (! $dry) {
                $share->update(['expires_at' => $grace, 'expiry_notified_at' => null]);
            }
        }

        // 2. Alertes avant expiration
        $warnLimit = $now->copy()->addHours(config('tech.notify_before_hours', 24));
        $expiring = TechShare::active()
            ->with(['creator', 'technicians'])
            ->whereNull('expiry_notified_at')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', $warnLimit)
            ->get();

        foreach ($expiring as $share) {
            $recipients = $share->creator ? collect([$share->creator]) : TechAdmins::all();
            $this->line("Alerte → #{$share->id} « {$share->title} » ({$recipients->count()} destinataire(s))");
            if (! $dry) {
                Notification::send($recipients, new TechShareExpiring($share));
                $share->update(['expiry_notified_at' => $now]);
            }
        }

        // 3. Expiration
        $expired = TechShare::whereNull('expired_at')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', $now)
            ->get();

        foreach ($expired as $share) {
            $this->line("Expirée → #{$share->id} « {$share->title} »");
            if (! $dry) {
                $share->expireNow();
            }
        }

        $this->info(sprintf(
            '%d liée(s) à une tâche terminée, %d alerte(s), %d expirée(s)%s',
            $taskBound->count(),
            $expiring->count(),
            $expired->count(),
            $dry ? ' (simulation)' : ''
        ));

        return self::SUCCESS;
    }
}
