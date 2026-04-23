# Hi 👋

Welcome to Hell'Press, a webapp build with Laravel and Vue to create and present your talk via the web.

Status: in development

## Setup

```bash
composer run setup
php artisan db:seed
```

or manually:

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run build
```

or manually using `pnpm`:

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
pnpm install
pnpm build
```

## Running the app:

```bash
composer run dev
```

or without Inertia HMR

```bash
composer run dev:ssr
```

## Running the background tasks:

```bash
php artisan schedule:work
```