# Automated tests

Three layers, each with its own runner. All commands run from `app/` unless noted.

| Layer                 | Tool       | Location         | Command          |
| --------------------- | ---------- | ---------------- | ---------------- |
| Frontend unit (jsdom) | Vitest     | `tests/Vitest/`  | `pnpm test`      |
| Backend feature       | Pest       | `tests/Feature/` | `pnpm test:pest` |
| Browser regression    | Playwright | `e2e/review/`    | `pnpm test:e2e`  |

## Database safety

The development database (`project_database`) is never used by tests.

- Tests use the dedicated MySQL database `orientformat_test` with user `orientformat_test`
  (credentials pinned in `phpunit.xml`, `scripts/test-pest.sh` and `e2e/support/env.ts`).
- `Tests\Support\TestDatabaseGuard` runs when the Pest application boots, in the Playwright
  fixture script and in the Playwright server front controller. Anything other than
  `APP_ENV=testing` + `orientformat_test` + `orientformat_test` aborts with an exception.
  Docker Compose injects `DB_*` for the dev database into the container, which overrides
  `phpunit.xml`, so a bare `docker compose exec app php artisan test` is refused by design.
- `AppServiceProvider` calls `DB::prohibitDestructiveCommands()` for every database whose name
  does not end in `_test`, so `migrate:fresh`, `db:wipe`, etc. are blocked on dev/production.
- Pest uses `DatabaseTransactions` only (never `RefreshDatabase`/`DatabaseMigrations`).
- Playwright seeds the fixture questionnaire (review id `9001`, ids `90001+`) and resets only its
  own `review_results` rows between tests.

## Setup

1. Containers running (`docker compose up -d`); the `db` service must be healthy.
2. Create the isolated database (drops and recreates **only** `orientformat_test`; the schema
   comes from `tests/schema/mysql-schema.sql`, a structure-only dump):
   `pnpm test:db:setup`
3. `pnpm install` and, once, `pnpm exec playwright install chromium`.
4. PHP must be available on the host for Playwright (it starts `php -S` and connects to the
   published MySQL port `127.0.0.1:3306`; override with `E2E_DB_HOST` / `E2E_DB_PORT`,
   `E2E_PORT` for the web port, default `8099`).

## Running

```bash
pnpm test                 # Vitest (jsdom unit tests)
pnpm test:pest            # all Pest tests in Docker against orientformat_test
pnpm test:pest --filter=ReviewQuestionnaire
pnpm test:e2e             # builds assets, starts an isolated PHP server, runs Playwright
pnpm exec playwright test e2e/review/dependencies.spec.ts   # a single spec (needs a prior build)
```

The Playwright server mirrors `public/` without the Vite `hot` file, so it always serves built
assets and never depends on the Vite dev server. It uses a cookie session, array cache and
stderr logging, so it does not write to `storage/`.

## Backend validation

`ReviewController::store` validates through `StoreReviewRequest` and `App\Services\Review\ReviewQuestionnaire`,
which mirror the rules in `resources/js/ui/review.ts` (required rows, option values, 1-100 numbers and the
`s2d2`/`s6d2`/`s7d2` dependencies). Visibility is recomputed server-side; hidden dependents are discarded.
Only students may submit and a completed questionnaire cannot be submitted again (validation error / 409).

## Fixtures

Feature tests never read development records. `Tests\Support\BaselineFixture` (seeded in every Feature test inside
the transaction) provides the `public` config, sections and tests; `ResultsFixture` adds a class with students and
results; `ReviewFixture` provides the questionnaire. Everything runs on a freshly initialised `orientformat_test`
(`bash scripts/test-db-setup.sh`, schema from `tests/schema/mysql-schema.sql`).

## CI / portability

`DB_HOST`/`DB_PORT` (Pest) and `E2E_DB_HOST`/`E2E_DB_PORT`/`E2E_DB_PASSWORD` (Playwright) are overridable; the
database name (`orientformat_test`) and user (`orientformat_test`) are not. Set `TEST_DB_PASSWORD` to change the
password used by `scripts/test-pest.sh`. Destructive Artisan commands are prohibited unless `APP_ENV=testing`
and the database is `orientformat_test`.

## Formatting

`.oxfmtrc.json` and `.oxlintrc.json` ignore `public/`, `vendor/`, `legacy/`, `storage/` and `tests/schema/`, so
`pnpm format` never touches vendored assets such as `public/js/filament`.
