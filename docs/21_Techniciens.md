# Espace technicien (Dash3Tech)

Application mobile pour les techniciens sur site. Elle utilise l'API de Dash3 sous `/api/v1/tech/*`.

## Comptes

- Rôle `technicien`, avec une seule permission : `tech`. Il ne donne accès ni à l'ERP, ni au stock, ni aux devis.
- La création, la modification et le retrait d'accès se font via `/api/v1/tech-admin/technicians`.
- Retirer l'accès enlève le rôle et révoque les sessions mobiles.

## Écran d'administration : `/techniciens`

Accessible depuis le menu **ERP > Techniciens** (permission `erp`). Une **cloche** dans la barre du haut affiche le nombre d'alertes non lues et mène à la page.

| Onglet | Rôle |
|---|---|
| **Alertes** | informations qui expirent dans moins de 24 h, à prolonger en un clic (+1 j, +7 j). Notifications : expirations, nouveaux rapports, nouvelles demandes |
| **Comptes** | créer, modifier ou retirer un technicien. Le badge « connecté » indique une session mobile active. « Déconnecter les téléphones » sert si un appareil est perdu |
| **Affectations** | affecter des techniciens à une tâche. Les informations déjà partagées sur la tâche suivent les ajouts et les retraits |
| **Informations** | partager une information temporaire : type, contenu, tâche, fiche article, destinataires, date limite (raccourcis 1 j, 3 j, 1 semaine, 1 mois), « expire aussi à la fin de la tâche », pièce jointe. Pour chaque destinataire, un badge indique s'il l'a lue. Actions : prolonger, modifier, retirer |
| **Rapports** | lire un rapport (texte, photos, position GPS), puis **Valider** ou **À revoir**. « À revoir » exige un commentaire, que le technicien voit dans l'app |
| **Demandes** | **Accorder** : crée une information réservée au demandeur, avec une date de fin d'accès (raccourcis ce soir, demain, 1 semaine). **Refuser**, avec un motif facultatif |

Les règles métier sont réunies dans `App\Support\TechService`, que l'écran web et l'API `/tech-admin` utilisent tous les deux.

## Ce que voit un technicien

| Donnée | Règle |
|---|---|
| Tâches | uniquement celles qui lui sont affectées (table `task_technician`) ; les tâches « Clôturé » sont masquées |
| Informations | uniquement celles qui lui sont partagées et encore valides |
| Matériel | désignation, référence, description, caractéristiques, marque, image. **Jamais le prix ni le stock** |
| Rapports / demandes | seulement les siens |

## Informations temporaires (`tech_shares`)

Chaque information a **toujours** une date d'expiration, de `max_share_days` jours au plus (90 par défaut) :

- **date choisie** à chaque partage (`expires_at`) ;
- **expire avec la tâche** (`expires_with_task`) : quand la tâche passe en « Terminé », l'information expire après `task_close_grace_hours` heures (24 par défaut). Si une date a aussi été choisie, c'est la plus proche qui s'applique.

La commande `tech:expire-shares`, planifiée toutes les 15 minutes :

1. ramène l'expiration des informations liées à une tâche terminée ;
2. **prévient l'auteur** `notify_before_hours` heures avant l'expiration (24 par défaut), par une notification Dash3, et par e-mail si `TECH_NOTIFY_MAIL=true`. Prolonger un partage relance l'alerte pour la nouvelle date ;
3. à l'échéance, **purge le contenu et le fichier joint**. Seul le titre reste, pour l'historique.

Les fichiers joints sont stockés sur le disque privé `local`. Ils ne sont servis que tant que le partage est valide.

Sur le téléphone, l'application supprime aussi de son cache local toute information dont la date est passée, même hors ligne.

> Le planificateur Laravel doit tourner sur le serveur :
> `* * * * * cd /chemin/dash3 && php artisan schedule:run >> /dev/null 2>&1`

## Rapports et demandes d'accès

- Rapports : titre, texte, photos, position GPS facultative. Ils sont envoyés avec un `client_uuid` : un envoi répété après une coupure réseau ne crée pas de doublon.
- Demande d'accès : une fois acceptée (`approve`, avec une `expires_at` obligatoire), elle crée une information temporaire de catégorie `acces`, réservée au demandeur.
- Chaque nouveau rapport et chaque nouvelle demande notifie les utilisateurs qui ont la permission `erp`.

## Routes

### Technicien (`can:tech`)

```
GET   tech/me
GET   tech/sync                     instantané complet pour le hors ligne
GET   tech/tasks | tech/tasks/{id}
PATCH tech/tasks/{id}/status        statuts 1 à 4
GET   tech/shares | tech/shares/{id} | tech/shares/{id}/file
GET   tech/reports
POST  tech/reports                  client_uuid, task_id?, title, content?, latitude?, longitude?, reported_at?
POST  tech/reports/{id}/photos      photo, client_uuid?, caption?
GET   tech/access-requests
POST  tech/access-requests          client_uuid, subject, reason?, task_id?, article_id?
```

### Administration (`can:erp`)

```
GET|POST         tech-admin/technicians      PATCH|DELETE tech-admin/technicians/{id}
GET|PUT          tech-admin/tasks/{task}/technicians      { user_ids: [] }
GET|POST         tech-admin/shares           POST|DELETE  tech-admin/shares/{share}
GET              tech-admin/reports          GET|PATCH    tech-admin/reports/{report}
GET              tech-admin/reports/{report}/photos/{photo}
GET              tech-admin/access-requests?status=pending|approved|rejected|all
POST             tech-admin/access-requests/{id}/approve | reject
GET              tech-admin/notifications    POST tech-admin/notifications/{id}/read
```

## Configuration (`config/tech.php`)

`TECH_NOTIFY_BEFORE_HOURS`, `TECH_TASK_CLOSE_GRACE_HOURS`, `TECH_MAX_SHARE_DAYS`, `TECH_TASK_DONE_STATUS`, `TECH_NOTIFY_MAIL`.
