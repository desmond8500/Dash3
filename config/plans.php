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
|   - ezdxf     : pip install "ezdxf[draw]"   (vérifier : ezdxf draw --formats)
|   - ODA (option) : paquet DEB / AppImage « ODA File Converter »
|
*/

return [
    // libredwg | oda
    'dwg_driver' => env('DWG_DRIVER', 'libredwg'),

    // Chemins des exécutables
    'dwg2dxf_bin' => env('DWG2DXF_BIN', 'dwg2dxf'),
    'oda_bin' => env('ODA_CONVERTER_BIN', 'ODAFileConverter'),
    'ezdxf_bin' => env('EZDXF_BIN', 'ezdxf'),

    // Version DXF produite par ODA
    'oda_dxf_version' => env('ODA_DXF_VERSION', 'ACAD2018'),

    // Durée maximale d'une conversion (secondes)
    'timeout' => (int) env('DWG_CONVERT_TIMEOUT', 180),
];
