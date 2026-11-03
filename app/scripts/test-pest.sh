#!/usr/bin/env bash
# Runs Pest inside the app container against the isolated test database only.
# Usage: app/scripts/test-pest.sh [artisan test args, e.g. --filter=ReviewQuestionnaire]
set -euo pipefail

cd "$(dirname "$0")/../.."

docker compose exec -T \
  -e APP_ENV=testing \
  -e DB_CONNECTION=mysql \
  -e DB_DATABASE=orientformat_test \
  -e DB_USERNAME=orientformat_test \
  -e DB_PASSWORD=${TEST_DB_PASSWORD:-orientformat_test_password} \
  -e DB_URL= \
  -e DATABASE_URL= \
  app php artisan test "$@"
