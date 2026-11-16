<?php

/*
|--------------------------------------------------------------------------
| Espace technicien (application Dash3Tech)
|--------------------------------------------------------------------------
| Les informations partagées avec les techniciens sont temporaires : chacune
| a une date d'expiration et/ou expire à la clôture de la tâche liée.
| La commande `tech:expire-shares` (planifiée toutes les 15 min) prévient
| l'auteur du partage avant l'expiration, puis purge le contenu expiré.
*/

return [

    // Délai (heures) avant expiration où l'auteur du partage est prévenu
    'notify_before_hours' => (int) env('TECH_NOTIFY_BEFORE_HOURS', 24),

    // Délai de grâce (heures) entre la clôture d'une tâche et l'expiration
    // des informations liées à cette tâche (option « expire avec la tâche »)
    'task_close_grace_hours' => (int) env('TECH_TASK_CLOSE_GRACE_HOURS', 24),

    // Durée maximale d'un partage (jours)
    'max_share_days' => (int) env('TECH_MAX_SHARE_DAYS', 90),

    // Statut à partir duquel une tâche est considérée terminée (4 = Terminé, 5 = Clôturé)
    'task_done_status' => (int) env('TECH_TASK_DONE_STATUS', 4),

    // Statuts qu'un technicien peut appliquer à une tâche (pas « Clôturé »)
    'technician_statuses' => [1, 2, 3, 4],

    // Envoyer aussi les alertes par e-mail (en plus de la notification Dash3)
    'notify_mail' => (bool) env('TECH_NOTIFY_MAIL', false),

    // À l'expiration : supprimer le contenu et le fichier joint (le titre reste pour l'historique)
    'purge_on_expiry' => true,

    // Nom du rôle et de la permission spatie
    'role' => 'technicien',
    'permission' => 'tech',
];
