#!/bin/zsh
# Deploys the committed state of this repository over SSH, using your own SSH key.
# Run from your Mac: ./deploy.sh
#
# Frontend assets are built locally and committed (npm run build). The server's .env,
# public/.htaccess, storage, caches and the SQLite database are never overwritten or deleted;
# migrations run on the server after the upload.
set -euo pipefail
cd "$(dirname "$0")"

# TODO: fill in once the server details are known.
HOST=${DEPLOY_HOST:-}
DEST=${DEPLOY_PATH:-}

if [[ -z $HOST || -z $DEST ]]; then
	echo "Set HOST and DEST in deploy.sh (or DEPLOY_HOST / DEPLOY_PATH) first."
	exit 1
fi
if [[ -n $(git status --porcelain) ]]; then
	echo "You have uncommitted changes. Commit them first; only committed code is deployed."
	exit 1
fi
if [[ ! -f public/build/manifest.json ]]; then
	echo "public/build is missing. Run 'npm run build' and commit the result."
	exit 1
fi

echo "Running tests…"
php artisan test

STAGE=$(mktemp -d)
trap 'rm -rf "$STAGE"' EXIT
# mktemp creates the folder as 700; rsync would copy that onto the site folder and lock out the web server.
chmod 755 "$STAGE"

echo "Preparing $(git rev-parse --short HEAD)…"
git archive HEAD | tar -x -C "$STAGE"
composer install --working-dir="$STAGE" --no-interaction --no-progress --no-dev --optimize-autoloader --quiet

echo "Uploading…"
rsync -az --delete \
	--exclude '/.github' --exclude '/node_modules' --exclude '/tests' --exclude '/artwork' --exclude '/scripts' \
	--exclude '/.env' --exclude '/public/hot' --exclude '/deploy.sh' \
	--filter 'protect /public/.htaccess' \
	--filter 'protect /storage/**' \
	--filter 'protect /bootstrap/cache/*.php' \
	--filter 'protect /database/database.sqlite' \
	"$STAGE/" "$HOST:$DEST/"

echo "Migrating and refreshing caches…"
ssh "$HOST" "cd '$DEST' && touch database/database.sqlite && php artisan migrate --force >/dev/null && php artisan optimize:clear >/dev/null && php artisan optimize >/dev/null"

echo "Deployed $(git rev-parse --short HEAD) to $HOST:$DEST"
