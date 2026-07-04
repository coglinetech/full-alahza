# Al-Ahza Deployment Checklist

This project failed in production with:

- `SQLSTATE[HY000] [1045] Access denied for user 'root'@'127.0.0.1' (using password: NO)`

That means runtime config is using invalid database credentials (often from a local `.env` or stale config cache).

## 1) Set correct production `.env`

Use your hosting database credentials, not local Laragon defaults.

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://alahza.g2j.co.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_HOSTING_DB_NAME
DB_USERNAME=YOUR_HOSTING_DB_USER
DB_PASSWORD=YOUR_HOSTING_DB_PASSWORD

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

## 2) Clear stale Laravel caches

Run this on the server after editing `.env`:

```bash
php artisan optimize:clear
```

If you use manual upload / file manager, make sure these files are not carried from local machine:

- `bootstrap/cache/config.php`
- `bootstrap/cache/routes-v7.php`
- `bootstrap/cache/events.php`

## 3) Rebuild cache with correct environment

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 4) Database setup

```bash
php artisan migrate --force
```

## 5) Storage setup for media files

```bash
php artisan app:setup-storage
```

## 6) Quick verification

```bash
php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB OK';"
```

If this prints `DB OK`, refresh the website.
