<?php

/*
|--------------------------------------------------------------------------
| Plans : conversion des fichiers DWG en PDF
|--------------------------------------------------------------------------
|
| Un navigateur ne sait pas afficher un DWG. À l'import, le DWG est converti :
|   1. DWG → DXF : LibreDWG (dwg2dxf) ou ODA File Converter
|   2. DXF → PDF : ezdxf (« ezdxf draw », moteur Matplotlib)
|
| Installation sur le serveur (exemple Ubuntu / Debian) :
|   - LibreDWG : compiler depuis https://www.gnu.org/software/libredwg/
|     (ou « brew install libredwg »), vérifier : dwg2dxf --version
|   - ezdxf     : pip install ezdxf matplotlib   (vérifier : ezdxf draw --formats)
|   - ODA (option) : paquet DEB / AppImage « ODA File Converter »
|
| Hébergement mutualisé (alwaysdata…) : scripts/install-dwg-tools.sh installe
| tout dans ~/.local sans droits root (voir docs/19_Plans_DWG.md).
|
*/

return [
    // libredwg | oda
    'dwg_driver' => env('DWG_DRIVER', 'libredwg'),

    // Exécutables : chemin complet conseillé sur un hébergement mutualisé
    // (ex. alwaysdata : /home/<compte>/.local/bin/dwg2dxf).
    // Une commande avec arguments est acceptée : EZDXF_BIN="python3 -m ezdxf"
    'dwg2dxf_bin' => env('DWG2DXF_BIN', 'dwg2dxf'),
    'oda_bin' => env('ODA_CONVERTER_BIN', 'ODAFileConverter'),
    'ezdxf_bin' => env('EZDXF_BIN', 'ezdxf'),

    // Dossiers ajoutés au PATH des commandes (outils installés dans le compte),
    // séparés par « : ». Par défaut : ~/.local/bin de l'utilisateur.
    'extra_path' => env('DWG_EXTRA_PATH', ($_SERVER['HOME'] ?? getenv('HOME') ?: '') . '/.local/bin'),

    // Version DXF produite par ODA
    'oda_dxf_version' => env('ODA_DXF_VERSION', 'ACAD2018'),

    // Durée maximale d'une conversion (secondes)
    'timeout' => (int) env('DWG_CONVERT_TIMEOUT', 180),

    // Mémoire limitée sur un mutualisé : résolution du PDF produit par ezdxf
    'dpi' => (int) env('DWG_PDF_DPI', 150),
];
