# Plans et conversion DWG

Les plans d'un projet (onglet **Installations**) acceptent les PDF, les images (PNG, JPG, WEBP) et les **DWG**.
Un navigateur ne sait pas afficher un DWG : à l'import, Dash3 le convertit en PDF, qui sert ensuite au placement des équipements et à l'export.

## Chaîne de conversion

1. **DWG → DXF** : LibreDWG (`dwg2dxf`, par défaut) ou ODA File Converter (`DWG_DRIVER=oda`)
2. **DXF → PDF** : ezdxf (`ezdxf draw -o plan.pdf plan.dxf`)

Le code est dans `app/Services/DwgConverter.php`, la tâche dans `app/Jobs/ConvertDwgPlan.php`, les réglages dans `config/plans.php`.

## Hébergement mutualisé alwaysdata

Pas d'accès root ni d'`apt` : tout s'installe dans le compte (`~/.local`).

### 1. Installer les outils (une fois, en SSH)

Activer SSH pour l'utilisateur (Accès distant › SSH), se connecter, puis depuis le dossier de Dash3 :

```console
bash scripts/install-dwg-tools.sh
```

Le script installe `dwg2dxf` dans `~/.local/bin` et `ezdxf` + `matplotlib` avec pip dans `~/.local`.

`dwg2dxf` est d'abord téléchargé tout compilé depuis les releases du dépôt
(workflow GitHub Actions `.github/workflows/libredwg.yml`, tag `libredwg-0.13.3`) :
la compilation de LibreDWG demande plus de mémoire qu'une session SSH mutualisée
n'en accorde (« gcc: fatal error: Killed signal terminated program cc1 »).
Si le binaire n'est pas disponible, le script compile sur place avec des options économes
(un seul job, `-O1` puis `-O0`, sans débogage). `COMPILE=1` force la compilation.
Pour une autre version de LibreDWG : `LIBREDWG_VERSION=0.13.3 bash scripts/install-dwg-tools.sh`.

### 2. Configurer `.env`

```dotenv
DWG_DRIVER=libredwg
DWG2DXF_BIN=/home/<compte>/.local/bin/dwg2dxf
EZDXF_BIN=/home/<compte>/.local/bin/ezdxf
DWG_EXTRA_PATH=/home/<compte>/.local/bin
DWG_PDF_DPI=150

# Conversion en arrière-plan (évite les délais d'expiration des requêtes web)
QUEUE_CONNECTION=database
```

```console
php artisan config:clear
php artisan migrate               # tables plans + table jobs
php artisan plans:convert --check
```

### 3. Lancer la file d'attente

Dans l'administration alwaysdata, **Avancé › Services** › Ajouter un service :

- Commande : `php /home/<compte>/<dossier-dash3>/artisan queue:work --sleep=3 --tries=1 --max-time=3600`
- Répertoire de travail : `/home/<compte>/<dossier-dash3>`

Le service est relancé automatiquement s'il s'arrête. Ses journaux sont dans `~/admin/logs/services/`.

**Sans service** (alternative) : une **tâche planifiée** toutes les 5 minutes avec
`php /home/<compte>/<dossier-dash3>/artisan plans:convert`
convertit les DWG en attente.

### Limites

- Les très gros DWG peuvent dépasser la mémoire ou le temps alloués : augmenter `DWG_CONVERT_TIMEOUT`, baisser `DWG_PDF_DPI`, ou exporter le plan en PDF depuis le logiciel de DAO.
- ODA File Converter (AppImage) nécessite FUSE, généralement indisponible en mutualisé : rester sur LibreDWG.

## Installation sur un serveur dédié / VPS

### LibreDWG (recommandé, libre)

Compiler depuis les sources (https://www.gnu.org/software/libredwg/) :

```console
sudo apt install build-essential autoconf automake libtool texinfo pkg-config git
git clone --recurse-submodules https://git.savannah.gnu.org/git/libredwg.git
cd libredwg && sh autogen.sh && ./configure --disable-bindings && make -j4 && sudo make install && sudo ldconfig
dwg2dxf --version
```

Ou, si Homebrew est installé : `brew install libredwg`.

### ezdxf

```console
pip install ezdxf matplotlib
ezdxf draw --formats      # doit lister « pdf »
```

Si `ezdxf` n'est pas dans le PATH de l'utilisateur web, indiquer le chemin complet dans `.env` (`EZDXF_BIN=/usr/local/bin/ezdxf`).

### ODA File Converter (option)

Paquet DEB / RPM / AppImage sur https://www.opendesign.com/guestfiles/oda_file_converter, puis :

```dotenv
DWG_DRIVER=oda
ODA_CONVERTER_BIN=/usr/bin/ODAFileConverter
```

## Réglages (.env)

```dotenv
DWG_DRIVER=libredwg
DWG2DXF_BIN=dwg2dxf
EZDXF_BIN=ezdxf
DWG_CONVERT_TIMEOUT=180
```

Avec `QUEUE_CONNECTION=sync` (valeur actuelle), la conversion se fait pendant l'import.
Pour les gros fichiers, passer en `QUEUE_CONNECTION=database` et lancer un worker : `php artisan queue:work`.

## Commandes

```console
php artisan migrate                 # tables des plans et colonnes de conversion
php artisan plans:convert --check   # vérifie que les outils sont installés
php artisan plans:convert           # convertit les DWG en attente
php artisan plans:convert 12        # (re)convertit le plan 12
php artisan plans:convert --failed  # relance les conversions en échec
```

## API

- `POST /api/v1/plans` (multipart `file`) : import ; un DWG passe en `conversion_status = pending` puis `done` ou `failed`
- `GET /api/v1/plans/{id}/file` : fichier d'origine ; `?variant=pdf` : PDF converti
- `POST /api/v1/plans/{id}/convert` : relancer la conversion
- `GET|PUT /api/v1/plans/{id}/markers` : emplacements des équipements
