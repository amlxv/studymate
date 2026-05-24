# AGENTS.md

## Cursor Cloud specific instructions

### Overview

StudyMate is a Laravel 10 + Vue 3 + Inertia.js student management and scheduling application. It uses MySQL as its database, Vite as the frontend build tool, and Tailwind CSS for styling.

### System dependencies

The VM requires PHP 8.2+, Composer, MySQL 8, and Node.js (22.x via nvm). These are installed at the system level and persisted via the VM snapshot. The update script handles `composer install` and `npm install` for dependency refresh.

### Starting services

1. **MySQL**: `sudo service mysql start && sudo chmod 755 /var/run/mysqld/`
   - The socket directory `/var/run/mysqld/` needs `chmod 755` after each restart so non-root users can connect.
   - Root user uses `mysql_native_password` auth with no password, matching `.env` defaults.

2. **Laravel dev server**: `php artisan serve --host=0.0.0.0 --port=8000`

3. **Vite dev server**: `npx vite --host 127.0.0.1 --port 5173`
   - **Important**: Must pass `--host 127.0.0.1` to force IPv4. Without it, Vite binds to `[::1]` (IPv6) and writes that to `public/hot`, which Chrome in this environment cannot connect to.

### .env configuration

- Copy `.env.example` to `.env` if `.env` does not exist: `cp .env.example .env`
- Set `APP_URL=http://127.0.0.1:8000` (include the port) so that Ziggy route generation works correctly for client-side navigation.
- Generate app key if missing: `php artisan key:generate`
- If you modify `APP_URL`, regenerate Ziggy routes: `php artisan ziggy:generate` and then rebuild assets or restart Vite.

### Running tests

- **PHPUnit**: `php artisan test`
  - Unit test passes. The feature test (`ExampleTest`) returns 500 because it hits the Inertia-rendered homepage without a full JS runtime — this is a pre-existing issue, not a regression.
  - Tests use MySQL (SQLite lines are commented out in `phpunit.xml`), so MySQL must be running.

### Linting

- **PHP (Pint)**: `./vendor/bin/pint --test` (check) or `./vendor/bin/pint` (fix)
- **JS/CSS (Prettier)**: `npx prettier --check "resources/**/*.{js,vue,css}"`
- Pre-existing style issues exist in both PHP and JS files.

### Key gotchas

- The `resources/js/ziggy.js` file is a generated route manifest. If `APP_URL` changes, regenerate it with `php artisan ziggy:generate`.
- When using production build (`npm run build`), remove `public/hot` first so Laravel serves from `public/build/` instead of proxying to Vite.
- Email verification is required for new users. For testing, mark users as verified directly: `mysql -u root -e "UPDATE laravel.users SET email_verified_at = NOW() WHERE email = 'youruser@example.com';"`
