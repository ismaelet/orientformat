#!/usr/bin/env bash
# Creates (or resets) the isolated test database. Only ever touches the
# database named below; the development database is never modified.
set -euo pipefail

TEST_DB="orientformat_test"
TEST_USER="orientformat_test"
TEST_PASS="orientformat_test_password"

cd "$(dirname "$0")/../.."

case "$TEST_DB" in
  *_test) ;;
  *) echo "Refusing to run: database name must end with _test" >&2; exit 1 ;;
esac

compose() { docker compose "$@"; }
mysql_root() { compose exec -T db sh -c 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$@" 2>/dev/null' -- "$@"; }

mysql_root -e "
  DROP DATABASE IF EXISTS \`$TEST_DB\`;
  CREATE DATABASE \`$TEST_DB\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  CREATE USER IF NOT EXISTS '$TEST_USER'@'%' IDENTIFIED BY '$TEST_PASS';
  GRANT ALL PRIVILEGES ON \`$TEST_DB\`.* TO '$TEST_USER'@'%';
  FLUSH PRIVILEGES;"

mysql_root "$TEST_DB" < app/tests/schema/mysql-schema.sql
echo "Test database '$TEST_DB' is ready."
