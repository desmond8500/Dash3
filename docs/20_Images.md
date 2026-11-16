# Édition des images (rogner, pivoter, redimensionner)

Les images déjà enregistrées sur le disque `public` (logos, avatars, photos d'articles, photos de journal, icônes, photos de CV…) peuvent être retouchées par l'API. Le traitement utilise Intervention Image v4 (driver GD).

## Endpoints (token Sanctum requis)

| Méthode | URL | Rôle |
|---|---|---|
| GET | `/api/v1/images/info?path=…` | Dimensions, poids et version d'une image |
| POST | `/api/v1/images/edit` | Applique les opérations et enregistre |

`path` accepte ce que le front affiche déjà : URL complète (`https://…/storage/stock/articles/12/images/a.jpg`), `storage/…` ou chemin relatif au disque public.

### Corps de `POST /images/edit`

```json
{
  "path": "https://dash3.yonkou.info/storage/stock/articles/12/images/a.jpg",
  "rotate": 90,
  "flip_h": false,
  "flip_v": false,
  "crop": { "x": 120, "y": 40, "width": 800, "height": 600 },
  "resize": { "width": 400 },
  "quality": 90,
  "mode": "replace"
}
```

Ordre d'application : orientation EXIF → rotation (90/180/270, sens horaire) → miroir → rognage (en pixels de l'image **après** rotation) → redimensionnement.

- `resize` : avec une seule dimension, les proportions sont conservées ; avec les deux, la taille est imposée (max 8000 px).
- `mode` : `replace` écrase le fichier (les références en base restent valables) ; `copy` crée `nom-edit-AAAAMMJJ-HHMMSS.ext` à côté de l'original.

Réponse : `{ path, storage_path, url, width, height, size, version }` — `url` contient `?v=<version>` pour contourner le cache du navigateur.

## Droits

`config/images.php` liste les dossiers modifiables et la permission exigée pour chacun (mêmes permissions que les routes qui remplissent ces dossiers) :

| Dossier | Permission |
|---|---|
| `erp/`, `cvs/` | `erp` |
| `stock/` | `stock` |
| `medias/` | `medias` |

Tout autre chemin, les remontées (`..`), les liens symboliques sortant du disque et les fichiers non image sont refusés.

## Front web (Dash3Web)

- `ImageEditor.vue` : éditeur (cadre de rognage, proportions libres / 1:1 / 4:3 / 16:9…, rotation, miroir, redimensionnement).
- `ImageUploadModal.vue` : rognage / réduction **avant l'envoi** d'un nouveau logo, et bouton « Rogner / redimensionner l'image actuelle ».
- `ImageEditModal.vue` : retouche d'une image enregistrée (galerie d'article avec option « copie », photos de journal).
