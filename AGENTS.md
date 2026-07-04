# Al-Ahza Travel Umroh — Agent Guide

## Stack
- Laravel 12 + Tailwind CSS v4 + Vite 6 + Intervention Image 4.x
- MySQL (local: `ahza-db`, host: 127.0.0.1, user: admin / pass: admin123)
- PHP 8.2+, Node 20+

# Hasil setelah prompting
Jadi setiap setelah melakukan agenting atau perubahan pada code maka diakhir kalau mau selesai kamu harus memberikan keterangan nama file apa saja yang diubah ya

## Agent Behavior & Output Rules (CRITICAL)
- **File Modification Rule:** Whenever you want to modify, overwrite, or create a file, you MUST NOT consider the task complete until the user explicitly reviews and approves the changes. Treat modified files as "Pending Approval" (similar to GitHub Copilot's keep/discard behavior).
- **Rollback Capability:** If the user rejects the changes or says "discard/cancel", you must automatically revert the files back to their original state immediately.
- **Speed & Output Rule:** DO NOT output or stream the entire modified code in the terminal response. DO NOT give long-winded explanations.
- **Summary Rule:** Only output a brief bullet-point summary of:
  1. What was changed/fixed.
  2. The exact solution/logic applied.
- **Final Output:** At the very end of every prompt, you MUST list all the filenames that were modified.

## Quick start
```bash
composer install && npm install
cp .env.example .env         # then configure DB
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build                 # or `npm run dev` for hot-reload
php artisan serve             # http://localhost:8000
# All-in-one: composer dev    # runs server + queue + logs + Vite concurrently
```

## Key commands
| Command | Purpose |
|---|---|
| `npm run build` | Build frontend assets for production |
| `npm run dev` | Vite dev server with HMR |
| `composer dev` | Runs `php artisan serve`, queue, logs, and Vite concurrently |
| `php artisan migrate --seed` | Run migrations + seeders |
| `php artisan app:setup-storage` | Storage link + public disk setup |
| `php artisan optimize:clear` | Clear all caches (required after .env changes) |

## Architecture
- **Single-page marketing site** (`resources/views/home.blade.php` includes sections from `sections/`)
- **Admin panel** at `/admin/login` — separate layout, no Vite assets (inline CSS)
- **Admin seed**: email `admin@alahza.test` / password `admin12345`
  - Defined in `.env.example` as `ADMIN_SEED_EMAIL` / `ADMIN_SEED_PASSWORD`
- **Public routes**: `/` (home), `/paket/{slug}` (package detail)
- **Admin routes** (behind `auth` + `is_admin` middleware): `/admin/dashboard`, `/admin/packages/*`, `/admin/testimonials/*`, `/admin/gallery/*`, `/admin/registrants/*`, `/admin/receipts/*`, `/admin/about`

## Vite / CSS images
- **CSS must reference images with relative paths** from `resources/css/app.css`, e.g., `url('../images/hero/hero-section.jpg')`
- Image files must reside under `resources/` (e.g., `resources/images/`) so Vite can hash and process them at build time
- **Do NOT use absolute paths** like `url('/images/hero/hero-section.jpg')` — these break in Vite dev server
- After adding new images, run `npm run build` to regenerate hashed assets

## Media / file uploads
- Uploads stored in `storage/app/public/` (public disk)
- URL helpers in `app/Support/helpers.php`:
  - `media_url($path)` — returns correct URL (tries `storage/` symlink first, falls back to `route('media.file')`)
  - `has_media($path)` — checks if file exists on public disk
- `ImageUploadService::storeOptimized()` compresses/resizes uploads to 1920px max width (JPEG 90 quality, progressive, stripped EXIF)

## Key middleware
| Alias | Class | Purpose |
|---|---|---|
| `is_admin` | `IsAdmin` | Checks `user->role === 'admin'` |
| `admin.nocache` | `AdminNoCache` | Sets no-cache headers on admin responses |
| `admin.session` | `AdminSessionExpired` | Session expiry detection for admin |

## Models / Scopes
- `HasSafeActiveScope` trait provides `active()` and `ordered()` scopes that check column existence before applying
- `Package::active()->ordered()` — common pattern for public queries
- Gallery images: filtered to those with existing files on disk via `Storage::disk('public')->exists()`

## Tests
- PHPUnit with Feature/Unit test suites
- Database tests are commented out in `phpunit.xml` — uncomment `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` before running DB tests
- Run: `php artisan test`

## Deployment (see `documents/DEPLOYMENT.md`)
- Run `deploy.sh` on server: pulls from git, rebuilds Vite, runs migrations, clears caches
- After changing `.env` in production, run `php artisan optimize:clear` to purge stale config cache
- Delete `bootstrap/cache/config.php`, `routes-v7.php`, `events.php` if uploaded manually
- Vite build output goes to `public/build/`

## Notes
- Section `home.blade.php` has gallery, instagram, and testimonials commented out
- No PHP linter config found despite `laravel/pint` being in dev deps — formatting conventions not enforced
