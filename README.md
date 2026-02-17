# WinkelPlek

A modern, Marktplaats-inspired marketplace built with Laravel + Livewire + Flux UI.

## Requirements

- PHP 8.2+ with common extensions (OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON)
- Composer
- Node.js 18+ and npm
- A local database (SQLite works out of the box)

## Quick Start (SQLite)

1) Install dependencies

```bash
composer install
npm install
```

2) Configure environment

```bash
copy .env.example .env
php artisan key:generate
```

3) Set up the database

SQLite is already configured for tests. For local use, create the file:

```bash
type NUL > database\database.sqlite
```

4) Run migrations + seed data

```bash
php artisan migrate --seed
```

5) Start the app (two terminals)

Terminal A:
```bash
php artisan serve
```

Terminal B:
```bash
npm run dev
```

Open http://127.0.0.1:8000 in your browser.

## Useful Commands

- Run tests:
```bash
php artisan test
```

- Rebuild the database with seed data:
```bash
php artisan migrate:fresh --seed
```

- Build production assets:
```bash
npm run build
```

## Common Troubleshooting

- If you see a missing key error: run `php artisan key:generate`.
- If pages look unstyled: ensure `npm run dev` is running.
- If migrations fail: check your `.env` database settings.

## Demo Accounts (Seeded)

- sanne@winkelplek.nl / password
- milan@winkelplek.nl / password
