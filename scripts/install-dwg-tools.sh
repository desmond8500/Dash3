#!/usr/bin/env bash
#
# Installe les outils de conversion DWG → PDF dans ~/.local, sans droits root
# (hébergement mutualisé alwaysdata, ou tout serveur Linux).
#
#   - LibreDWG (dwg2dxf) : binaire précompilé du dépôt (GitHub Actions) ;
#     à défaut, compilé sur place (COMPILE=1 pour forcer la compilation)
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
JOBS="${JOBS:-1}"   # mutualisé : un seul fichier compilé à la fois (mémoire limitée)
BUILD="$HOME/tmp/libredwg-build"
# Binaire précompilé publié par le dépôt Dash3 (GitHub Actions)
PREBUILT_URL="${PREBUILT_URL:-https://github.com/desmond8500/Dash3/releases/download/libredwg-$LIBREDWG_VERSION/dwg2dxf-linux-x86_64}"

echo "==> Dossier d'installation : $PREFIX"
mkdir -p "$PREFIX/bin" "$BUILD"

# ---------------------------------------------------------------- LibreDWG
if command -v "$PREFIX/bin/dwg2dxf" >/dev/null 2>&1; then
  echo "==> LibreDWG déjà installé : $("$PREFIX/bin/dwg2dxf" --version | head -1)"
elif [ "${COMPILE:-0}" != "1" ] && wget -q "$PREBUILT_URL" -O "$PREFIX/bin/dwg2dxf" \
     && chmod +x "$PREFIX/bin/dwg2dxf" && "$PREFIX/bin/dwg2dxf" --version >/dev/null 2>&1; then
  # Binaire compilé par GitHub Actions (.github/workflows/libredwg.yml) : rien à compiler
  echo "==> dwg2dxf précompilé installé : $("$PREFIX/bin/dwg2dxf" --version | head -1)"
else
  rm -f "$PREFIX/bin/dwg2dxf"
  echo "==> Binaire précompilé indisponible : compilation sur le serveur"
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

  echo "==> Compilation (10 à 20 minutes sur un mutualisé)"
  # Mémoire limitée : sans infos de débogage, optimisation légère, un seul job,
  # et sans l'écriture DWG (inutile ici : on ne fait que lire le DWG et écrire du DXF).
  # Si le compilateur est encore tué faute de mémoire, on recommence sans optimisation.
  build() {
    local cflags="$1"
    make distclean >/dev/null 2>&1 || true
    CFLAGS="$cflags" ./configure --prefix="$PREFIX" --disable-shared --enable-static \
        --disable-bindings --disable-write >/dev/null 2>configure.log
    make -j"$JOBS" >/dev/null 2>make.log
  }
  if ! build "-O1 -g0"; then
    echo "    Échec (mémoire ?), nouvel essai sans optimisation (-O0)"
    tail -n 3 make.log || true
    if ! build "-O0 -g0"; then
      echo "!! La compilation échoue encore. Dernières lignes :"
      tail -n 15 make.log || true
      echo "!! Solution de repli : compiler sur un autre Linux x86_64 puis copier dwg2dxf dans $PREFIX/bin (voir docs/19_Plans_DWG.md)."
      exit 1
    fi
  fi
  make install >/dev/null
  if [ ! -x "$PREFIX/bin/dwg2dxf" ]; then
    echo "    dwg2dxf absent avec --disable-write : recompilation complète"
    make distclean >/dev/null 2>&1 || true
    CFLAGS="-O0 -g0" ./configure --prefix="$PREFIX" --disable-shared --enable-static --disable-bindings >/dev/null 2>configure.log
    make -j"$JOBS" >/dev/null 2>make.log
    make install >/dev/null
  fi
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
