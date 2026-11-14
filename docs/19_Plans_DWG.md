# Plans et conversion DWG

Les plans d'un projet (onglet **Installations**) acceptent les PDF, les images (PNG, JPG, WEBP) et les **DWG**.
Un navigateur ne sait pas afficher un DWG : à l'import, Dash3 le convertit en PDF, qui sert ensuite au placement des équipements et à l'export.

## Chaîne de conversion

1. **DWG → DXF** : LibreDWG (`dwg2dxf`, par défaut) ou ODA File Converter (`DWG_DRIVER=oda`)
2. **DXF → PDF** : ezdxf (`ezdxf draw -o plan.pdf plan.dxf`)

Le code est dans `app/Services/DwgConverter.php`, la tâche dans `app/Jobs/ConvertDwgPlan.php`, les réglages dans `config/plans.php`.

## Installation sur le serveur

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
pip install "ezdxf[draw]"
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
