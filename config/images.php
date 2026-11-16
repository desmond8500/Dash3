<?php

/*
|--------------------------------------------------------------------------
| Édition des images (API /api/v1/images/*)
|--------------------------------------------------------------------------
| Seules les images du disque « public » rangées sous l'un de ces dossiers
| peuvent être rognées / redimensionnées. Chaque dossier exige la même
| permission (spatie/laravel-permission) que les routes qui le remplissent.
*/

return [
    'editable' => [
        'erp/' => 'erp',      // logos clients / projets, photos des journaux, documents
        'cvs/' => 'erp',      // photos des CV
        'stock/' => 'stock',  // images d'articles, logos marques / fournisseurs, icônes
        'medias/' => 'medias', // avatars des personas
    ],

    // Qualité JPEG / WebP par défaut à l'enregistrement
    'quality' => 90,
];
