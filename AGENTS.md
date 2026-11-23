# Project Instructions

## Stack and architecture

- Laravel, PHP 8.4, Blade, Tailwind CSS 4, Vite, Alpine.js, and vanilla TypeScript/JavaScript.

## Project commands

- Repository root: the directory containing AGENTS.md and the Docker Compose configuration.
- Laravel root: app/. Run PHP, Artisan, Composer, and frontend commands from this directory.
- Run Docker Compose and repository-level Git commands from the repository root.
- Use the package manager specified by app/package.json and its lockfile.
- Prefer the project's existing scripts over invoking tools directly.

### PHP and Laravel

- PHP syntax: `cd app && php -l app/Http/Controllers/ExampleController.php`
- Targeted tests: `cd app && php artisan test --filter=TestName`
- Blade compilation: `cd app && php artisan view:cache`
- PHP formatting check: `cd app && vendor/bin/pint --test`

### Frontend

- Frontend build: `cd app && pnpm run build`
- Formatting check: `cd app && pnpm run format:check`
- Apply formatting: `cd app && pnpm run format`
- Linting: `cd app && pnpm run lint`
- Use Oxfmt for supported frontend files and Oxlint for JavaScript/TypeScript linting.
- Use Laravel Pint for PHP formatting. Do not run Oxfmt or Oxlint on PHP files.

## Blade

- Anonymous components: `app/resources/views/components/`; class-backed components: `app/app/View/Components/`.
- Prefer Blade for rendering and Alpine.js for lightweight client-side interactivity.
- Keep database queries and business logic out of Blade templates.
- Reuse existing Blade components before writing new markup, especially layouts, forms, buttons, typography, cards, and pagination.
- Use existing component APIs rather than duplicating markup, styling, or behavior.

## Validation

Run Docker commands from the repository root.

```bash
# Inspect recent logs
docker compose logs --tail=100 app

# Run targeted PHP tests
docker compose exec -e APP_ENV=testing app php artisan test --filter=TestName

# Run full PHP test suite when justified
docker compose exec -e APP_ENV=testing app php artisan test

# Build frontend assets
cd app && pnpm build
```

- Assume containers are already running. Do not restart, rebuild, or install dependencies unnecessarily.
- Always use `APP_ENV=testing` for PHP tests.
- Add or update tests for new behavior, bug fixes, or meaningful logic changes when existing coverage is insufficient.
- Prefer targeted tests before running the full suite.
- Styling, markup-only, and documentation changes do not require new tests.
- Run frontend builds only when relevant to modified assets or compilation behavior.
- Avoid repeated validation unless changes or failures justify it.
- Report validation failures or checks that could not be performed.

## Browser and visual testing

- For frontend styling and visual verification, follow the `frontend-design` skill.
- Minimize browser interactions and screenshot analysis unless necessary for correctness.

## Agent efficiency and scope

- Use targeted searches (`rg`, `rg --files`). Read relevant files only; expand investigation when necessary.
- Avoid repeated file reads, commands, repository-wide searches, and unrelated audits.
- Never generate images.

## Git workflow and commits

- After completing a task, do not automatically create a commit.
- At the end of the task, ask the user whether to commit the changes.
- Never push changes unless explicitly requested.
- Follow the European Commission Git Commit Guidelines:
  https://ec.europa.eu/component-library/v1.14.2/ec/docs/conventions/git/
- Use the commit message format: `<type>(<scope>): <subject>`.
- The scope is optional.
- Allowed types: `feat`, `fix`, `docs`, `style`, `refactor`, `perf`, `test`, `chore`.
- Write subjects in the imperative, present tense, starting with a lowercase letter and without a trailing period.
- Keep every commit message line within 100 characters.
- Include a body when useful to explain the motivation and changes.
- Use `BREAKING CHANGE:` in the footer when applicable.
- Before committing, inspect `git status` and the diff.
- Stage only files relevant to the completed task. Do not include unrelated changes.
- Never commit secrets, credentials, environment files, or generated artifacts that should remain untracked.
- If the user approves, create the commit using the proposed message.
- After committing, report the commit hash and message.

## Communication

- Be concise, technical, and action-oriented.
- After changes, briefly summarize what changed, validation performed, and any remaining issues.
- Update README.md when the changes affect its correctness.
- At the end of tasks involving file changes, propose an appropriate Git commit message and commit the changes, if the task is completed and doens't require further input from the user.
