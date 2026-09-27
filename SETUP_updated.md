# Generic Laravel + Docker Template Setup

This repository is a reusable Laravel application template for Laravel + Blade, React, TypeScript, SCSS/Sass, Vite, Docker Compose, Caddy, optional MySQL, and later GitHub CI/CD.

Project-specific values belong in `.env`, not hard-coded into scripts.

## Current template layout

```text
project-root/
├── SetupUserAndPermissions.sh
├── deploy.sh
├── pullFromGitClean2.sh
├── cloud-init-prod-only.yml
├── compose.yml
├── Dockerfile
├── .gitignore
├── .dockerignore
├── SETUP.md
│
└── scripts/
    ├── environmentGuard.sh
    ├── setup-laravel.sh
    └── setup-frontend.sh
```

A guided master installer will later be added as:

```text
setup.sh
```

After Laravel/frontend setup, the project will also contain files such as:

```text
.env
.env.example
Caddyfile
vite.config.ts
tsconfig.json
artisan
composer.json
composer.lock
package.json
package-lock.json

app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

## Environment model

Development typically uses:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

Production typically uses:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://example.com
```

Reusable project/deployment metadata may include:

```env
APP_NAME="Example App"
APP_DOMAIN=example.com
COMPOSE_PROJECT_NAME=exampleapp
DEPLOY_USER=exampledeploy
DEPLOY_APP_DIR=/opt/exampleapp
```

Never commit the real `.env`. Commit `.env.example` only.

## scripts/environmentGuard.sh

Purpose:

- read `.env`
- read `APP_ENV`
- determine which script called it
- permit or block that script based on environment
- block unknown scripts by default
- require `APP_DEBUG=false` in production

Development-only entries should include:

```text
setup-laravel.sh
setup-frontend.sh
```

Production-only entries should include:

```text
deploy.sh
pullFromGitClean2.sh
```

If the guard still refers to `pullFromGitClean.sh`, update the production rule to:

```bash
deploy.sh|pullFromGitClean2.sh)
    ALLOWED_ENVIRONMENTS=(
        "production"
    )
    ;;
```

## scripts/setup-laravel.sh

Development-only.

Purpose:

- verify PHP and Composer
- detect an existing Laravel app
- create a Laravel skeleton when needed
- merge missing Laravel files into the template
- preserve existing template files
- install Composer dependencies
- create `.env` from `.env.example` when needed
- generate `APP_KEY`
- create a generic `Caddyfile`
- create Laravel runtime directories
- clear caches
- verify Laravel boots

## scripts/setup-frontend.sh

Development-only.

Purpose:

- install React / React DOM
- install TypeScript
- install React type definitions
- install `@vitejs/plugin-react`
- install Sass
- add npm scripts
- create frontend directories
- remove Laravel's default `vite.config.js` / `vite.config.mjs`
- create `vite.config.ts`
- create `tsconfig.json`
- create SCSS boilerplate
- create a React demo component
- create the React entry point
- create a reusable Blade template
- create a basic home page
- run TypeScript validation
- test the frontend production build

## SetupUserAndPermissions.sh

Production bootstrap script.

Purpose:

- create or reuse a deployment user
- optionally set its password
- add it to the Docker group
- create the application directory
- correct ownership
- secure `.env`
- add/update `DEPLOY_USER`
- add/update `DEPLOY_APP_DIR`
- make known project scripts executable when present
- verify ownership and permissions

SSH keys are intentionally not handled here.

This script may run before `.env` exists, so it does not depend on `environmentGuard.sh`.

## cloud-init-prod-only.yml

Production-only host bootstrap for a Docker 1-Click style server.

Purpose:

- update packages
- install useful host tools
- verify Docker
- verify Docker Compose
- enable Fail2ban
- configure swap
- install the reusable `laravel-host-setup` helper

It does not use Laravel `.env` because it can run before the app exists.

UFW is intentionally omitted; use the provider/cloud firewall.

## compose.yml

Shared Docker Compose definition.

Services:

```text
app     Laravel/PHP/Apache
caddy   HTTPS/reverse proxy
mysql   optional database profile
```

Normal startup:

```bash
docker compose up -d
```

With MySQL:

```bash
docker compose --profile database up -d
```

Do not publish MySQL port `3306` publicly. Laravel should reach it with `DB_HOST=mysql`.

## Dockerfile

Uses a multi-stage build:

```text
Node stage
  -> npm ci
  -> TypeScript
  -> React
  -> SCSS
  -> Vite build

Composer stage
  -> production PHP dependencies

Final runtime stage
  -> PHP
  -> Apache
  -> Laravel
  -> compiled frontend assets
```

Node/npm/TypeScript/Sass/Vite and Composer build tooling do not need to run as production services.

## Caddyfile

Created by `setup-laravel.sh`.

It is generic and should use an environment variable such as:

```env
APP_DOMAIN=example.com
```

Caddy handles HTTP, HTTPS, automatic TLS certificates, renewal, and reverse proxying to the Laravel container.

## deploy.sh

Production-only.

Purpose:

- verify production environment
- verify Git / Docker / Compose
- fetch `origin/main`
- reset production to the known Git state
- rebuild the application image
- start/update containers
- wait for health checks
- run migrations if MySQL is active
- optimize Laravel
- prune unused Docker images

Do not run it as root.

## pullFromGitClean2.sh

This file is still part of the template and should be treated as production-only.

It overlaps somewhat with `deploy.sh`. Later, decide whether `deploy.sh` replaces it or whether both remain as separate production workflows.

For now, keep it and list it in `environmentGuard.sh`.

## Ignore files

Root:

```text
.gitignore
.dockerignore
```

Laravel also uses `.gitignore` files in writable directories such as:

```text
bootstrap/cache/
storage/logs/
storage/framework/cache/
storage/framework/cache/data/
storage/framework/sessions/
storage/framework/views/
```

The current scripts do not intentionally overwrite these ignore files. Laravel installation may create defaults, so the final master installer should preserve/finalize the template versions after Laravel scaffolding.

## Recommended first test

Do the first full setup locally:

```text
1. Run the future master setup.sh
2. Verify Laravel starts
3. Verify Vite starts
4. Verify SCSS works
5. Verify the React demo works
6. Make a visible change
7. Run:
   php artisan test
   npm run typecheck
   npm run build
8. Commit
9. Push to GitHub
10. Configure CI/CD
11. Add basic tests
12. Push another change
13. Verify CI
14. Only then move to production
```

## Production bootstrap order

```text
DigitalOcean Docker 1-Click Droplet
        ↓
cloud-init-prod-only.yml
        ↓
host prepared
        ↓
SetupUserAndPermissions.sh
        ↓
deployment user / ownership configured
        ↓
repository available
        ↓
production .env configured
        ↓
deploy.sh or pullFromGitClean2.sh
        ↓
Docker Compose
        ↓
Caddy + Laravel
        ↓
optional MySQL
```

## Future master setup.sh

Not created yet.

Planned responsibilities:

```text
1. Make all .sh files executable
2. Detect project root
3. Ask which environment is being configured
4. Ask for project-specific values
5. Create/update .env
6. Run setup-laravel.sh when appropriate
7. Run setup-frontend.sh when appropriate
8. Run production bootstrap pieces when appropriate
9. Validate final configuration
10. Print the next recommended actions
```

This will be the guided entry point for the reusable template.

## Executable permissions

The future `setup.sh` will make shell scripts executable automatically. Git tracks the executable bit.

Expected executable scripts include:

```text
setup.sh
SetupUserAndPermissions.sh
deploy.sh
pullFromGitClean2.sh
scripts/environmentGuard.sh
scripts/setup-laravel.sh
scripts/setup-frontend.sh
```

YAML, Dockerfile, Markdown, and ignore files do not need executable permissions.

## Security reminders

- never commit `.env`
- never commit private SSH keys
- use `APP_DEBUG=false` in production
- keep MySQL internal to Docker
- expose only required ports
- use a cloud firewall
- avoid manual edits to production source
- use strong database passwords
- remember Docker group membership is effectively root-level access
