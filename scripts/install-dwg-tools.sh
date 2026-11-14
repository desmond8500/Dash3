#!/usr/bin/env bash
#
# Installe les outils de conversion DWG → PDF dans ~/.local, sans droits root
# (hébergement mutualisé alwaysdata, ou tout serveur Linux).
#
#   - LibreDWG (dwg2dxf) : compilé depuis les sources GNU, binaire statique
#   - ezdxf + matplotlib : via pip, dans ~/.local
#
# Usage (en SSH, depuis le dossier de Dash3) :
#   bash scripts/install-dwg-tools.sh
#
# Puis, dans .env :
#   DWG2DXF_BIN=$HOME/.local/bin/dwg2dxf
#   EZDXF_BIN=$HOME/.local/bin/ezdxf
# et vérifier : php artisan plans:convert --check
#
set -euo pipefail

PREFIX="${PREFIX:-$HOME/.local}"
LIBREDWG_VERSION="${LIBREDWG_VERSION:-0.13.3}"
PYTHON="${PYTHON:-python3}"
JOBS="${JOBS:-2}"   # mutualisé : peu de cœurs, compilation raisonnable
BUILD="$HOME/tmp/libredwg-build"

echo "==> Dossier d'installation : $PREFIX"
mkdir -p "$PREFIX/bin" "$BUILD"

# ---------------------------------------------------------------- LibreDWG
if command -v "$PREFIX/bin/dwg2dxf" >/dev/null 2>&1; then
  echo "==> LibreDWG déjà installé : $("$PREFIX/bin/dwg2dxf" --version | head -1)"
else
  echo "==> Téléchargement de LibreDWG $LIBREDWG_VERSION"
  cd "$BUILD"
  ARCHIVE="libredwg-$LIBREDWG_VERSION.tar.xz"
  if ! wget -q "https://ftp.gnu.org/gnu/libredwg/$ARCHIVE" -O "$ARCHIVE"; then
    echo "    Archive introuvable, essai avec .tar.gz"
    ARCHIVE="libredwg-$LIBREDWG_VERSION.tar.gz"
    wget -q "https://ftp.gnu.org/gnu/libredwg/$ARCHIVE" -O "$ARCHIVE"
  fi
  rm -rf "libredwg-$LIBREDWG_VERSION"
  tar xf "$ARCHIVE"
  cd "libredwg-$LIBREDWG_VERSION"

  echo "==> Compilation (quelques minutes)"
  # Binaire statique : pas besoin de LD_LIBRARY_PATH pour PHP
  ./configure --prefix="$PREFIX" --disable-shared --enable-static \
              --disable-bindings --disable-python --disable-docs >/dev/null
  make -j"$JOBS" >/dev/null
  make install >/dev/null
  echo "==> LibreDWG installé : $("$PREFIX/bin/dwg2dxf" --version | head -1)"
fi

# ---------------------------------------------------------------- ezdxf
echo "==> Installation d'ezdxf et matplotlib (pip, dans $PREFIX)"
"$PYTHON" -m pip install --user --upgrade --quiet ezdxf matplotlib
EZDXF="$PREFIX/bin/ezdxf"
if [ ! -x "$EZDXF" ]; then
  echo "    Exécutable ezdxf non trouvé dans $PREFIX/bin : utilisez EZDXF_BIN=\"$PYTHON -m ezdxf\""
  EZDXF="$PYTHON -m ezdxf"
fi
$EZDXF draw --formats | grep -qi pdf && echo "==> ezdxf : export PDF disponible"

cat <<MSG

Installation terminée. Ajoutez dans le .env de Dash3 :

  DWG_DRIVER=libredwg
  DWG2DXF_BIN=$PREFIX/bin/dwg2dxf
  EZDXF_BIN=$EZDXF
  DWG_EXTRA_PATH=$PREFIX/bin

puis : php artisan config:clear && php artisan plans:convert --check
MSG
