#!/usr/bin/env bash
# Starts the application for Playwright against the isolated test database.
# Expects APP_ENV=testing and the DB_* variables from e2e/support/env.ts.
set -euo pipefail

cd "$(dirname "$0")/.."

: "${E2E_PORT:?E2E_PORT is required}"

case "${DB_DATABASE:-}" in
  *_test) ;;
  *) echo "Refusing to start: DB_DATABASE must end with _test" >&2; exit 1 ;;
esac

# Mirror public/ without the Vite "hot" file so the built assets are served.
PUBLIC_DIR="${E2E_PUBLIC_DIR:-$(mktemp -d)}"
mkdir -p "$PUBLIC_DIR"
for entry in public/*; do
  name="$(basename "$entry")"
  [ "$name" = "hot" ] || [ "$name" = "index.php" ] || ln -sfn "$(pwd)/$entry" "$PUBLIC_DIR/$name"
done

exec php -S "127.0.0.1:$E2E_PORT" -t "$PUBLIC_DIR" tests/Support/e2e-router.php
