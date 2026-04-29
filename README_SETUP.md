# README_SETUP (Windows PowerShell)

## Root Cause Found
The backend was not a valid Laravel application root. It had custom domain code (`app/`, `routes/`, `database/`) but was missing critical Laravel root files/folders like `artisan`, `public/index.php`, and `config/*`. This is why `php artisan ...` returned: `Could not open input file: artisan`.

## What was fixed
- Added `backend/artisan` entrypoint.
- Added required Laravel root directories/files:
  - `backend/config/` (app, database, queue, sanctum, cors)
  - `backend/public/index.php`
  - `backend/resources/`
  - `backend/storage/` scaffolding
  - `backend/.env`
- Updated `backend/composer.json` for Laravel 11 compatibility.
- Kept existing business logic/controllers/models/migrations/seeders intact.

## 1) Backend setup (PowerShell)
```powershell
cd .\backend
composer install
Copy-Item .env.example .env -Force
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

If you want MySQL locally, edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kemo_dashboard
DB_USERNAME=root
DB_PASSWORD=
```
Then run:
```powershell
php artisan migrate --seed
```

## 2) Frontend setup (PowerShell)
```powershell
cd ..\frontend
npm install
```

Create `.env` in `frontend`:
```env
VITE_API_BASE_URL=http://127.0.0.1:8000/api
```

Run frontend:
```powershell
npm run dev
```

## 3) Verify end-to-end
- Backend API: `http://127.0.0.1:8000/api/auth/login`
- Frontend: `http://127.0.0.1:5173`

## Notes about restricted CI/container environments
If you see `403` for Composer/NPM registry access, that is an environment network policy issue. Run the above commands on your machine or a build runner with package registry access.
