# OrientFormat

OrientFormat is a web platform supporting educational orientation activities. It provides experiences for students and workflows for teachers and administrators, bringing an existing set of educational activities into a Laravel-based application.

The application combines modern Laravel functionality with legacy components that remain part of the project. The repository includes a Docker-based development setup, an administration interface, and automated tests.

## Technology stack

| Area | Technology |
| --- | --- |
| Backend | PHP 8.4+, Laravel 13 |
| Administration | Filament 5 |
| Database | MySQL / MariaDB |
| Frontend | Tailwind CSS 4, Vite 7, JavaScript |
| Documents and exports | DomPDF, Laravel Excel, Browsershot |
| Error monitoring | Sentry |
| Tests | Pest 4, PHPUnit 12, Vitest 5, Playwright |
| Formatting and linting | Laravel Pint, Oxfmt, Oxlint |
| Environment | Docker and Docker Compose |

Dependency versions are described in `app/composer.json` and `app/package.json`; installed versions depend on the lockfiles.

## Application structure

```text
orientformat/
├── app/                          # Laravel application
│   ├── app/                      # Application code
│   ├── config/                   # Laravel configuration
│   ├── database/                 # Migrations, factories, seeders
│   ├── e2e/                      # End-to-end tests
│   ├── legacy/                   # Legacy compatibility components
│   ├── public/                   # Public assets and entry point
│   ├── resources/                # Views, styles and scripts
│   ├── routes/                    # Route files by functional area
│   ├── tests/                     # PHP and frontend tests
│   ├── composer.json
│   └── package.json
├── docker/app/                   # Application container definition
├── docker-compose.yml           # Development service configuration
├── production-compose.yml       # Production service configuration
└── README.md
```

Routes are separated by responsibility, including authentication, student, teacher, administrator, administration-panel, and legacy routes. See `app/routes/` for their current definitions.

## Local development

### Requirements

- Docker and Docker Compose for the containerized setup.
- PHP 8.4+ and Composer if running Laravel commands directly on the host.
- A compatible Node.js runtime and pnpm 12 if running frontend commands on the host.
- A configured database service or an accessible MySQL/MariaDB instance.

### Configuration

Create the appropriate local environment files based on the application's configuration and the Compose file. Keep passwords, tokens, application keys, and database connection details in local environment variables or an approved secret-management system, never in tracked configuration files.

The Compose configuration determines which services, environment variables, ports, and volumes are required for your setup. Review it before starting containers.

### Start the application

From the repository root:

```bash
docker compose -f docker-compose.yml up -d --build
```

To inspect the running services and logs:

```bash
docker compose -f docker-compose.yml ps
docker compose -f docker-compose.yml logs -f
```

The Laravel application lives in `app/`. For host-based development, install its dependencies there:

```bash
cd app
composer install
pnpm install
```

For a new, disposable development database, run migrations after confirming the correct database connection:

```bash
php artisan migrate
```

**Database safety:** Do not run destructive migration or test commands against an existing development or production database. Verify the environment and database connection first. Some legacy database tables may not be fully covered by Laravel migrations.

### Frontend development

From `app/`:

```bash
pnpm dev
```

Build production assets with:

```bash
pnpm build
```

## Testing and code quality

Run these commands from `app/` after configuring an **isolated testing database**:

```bash
# PHP tests
php artisan test

# Frontend unit tests
pnpm test

# Browser tests (with the required Playwright setup)
pnpm exec playwright test

# PHP formatting check
vendor/bin/pint --test

# JavaScript and TypeScript checks
pnpm lint
pnpm format:check
```

To format source code, use `vendor/bin/pint` for PHP and `pnpm format` for frontend files. Confirm formatting scope and generated-file exclusions before running project-wide commands.

## Deployment

`production-compose.yml` contains the production-oriented Compose configuration. Deployment should supply its secrets externally and use the environment-specific service, storage, networking, and database settings required by the hosting platform.

Before deploying, confirm the application image, database access, persistent volumes, backups, asset build, and required Laravel configuration. Database changes should be planned and backed up independently of application deployment.

## Security and repository hygiene

- Never commit `.env` files, database exports, secret keys, or credential-bearing configuration.
- Keep development and production credentials separate and rotate exposed values.
- Do not add real student data or other personal information to fixtures, logs, examples, or documentation.
- Use isolated databases for tests and local experimentation.
- Review changes to Docker Compose, application configuration, and documentation for secrets before committing.

## Licensing

No open-source license for the application is declared here. The license metadata of third-party dependencies does not automatically grant permission to redistribute the project. Consult the project owner before reusing or distributing project-specific code or content.
