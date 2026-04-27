# Kemo Business Dashboard (KemoTech)

Production-oriented multi-tenant SaaS dashboard targeting real estate, barbershops, and Tanzanian SMEs.

## Monorepo Structure

- `backend/` Laravel 11 API + Sanctum + MySQL schema + queue/event pipeline.
- `frontend/` React + Vite + Tailwind + Axios + React Router + Recharts.

## Backend Architecture

- Tenant isolation via `tenant` middleware (`business_id` bound from authenticated user).
- RBAC via `role` middleware (`admin`, `manager`, `staff`).
- REST API only (`backend/routes/api.php`).
- Validation via Form Requests.
- Queue event flow: `BookingCreated` => `SendBookingNotificationJob`.

## Database Schema

Tables:
- `businesses`
- `users`
- `customers`
- `services`
- `bookings`
- `payments`
- `notifications`
- `personal_access_tokens`

All tables include timestamps and strict foreign keys for tenant-aware relationships.

## API Endpoints

### Auth
- `POST /api/auth/register`
- `POST /api/auth/login`
- `POST /api/auth/logout`
- `GET /api/auth/me`

### Core Modules
- `GET /api/dashboard/summary`
- `GET /api/dashboard/export/{format}` (`csv` or `json`)
- `apiResource /api/customers`
- `apiResource /api/services`
- `apiResource /api/bookings`
- `apiResource /api/payments` (except delete)

### Notifications
- `GET /api/notifications`
- `PATCH /api/notifications/{notification}/read`

### Settings
- `GET /api/settings/business`
- `PUT /api/settings/business`
- `GET /api/settings/users`
- `PUT /api/settings/users/{id}/role`

## Setup Instructions

### 1) Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Configure `.env` for MySQL and queue driver (`database` recommended).

### 2) Frontend

```bash
cd frontend
npm install
npm run dev
```

Set `VITE_API_BASE_URL=http://127.0.0.1:8000/api` if needed.

### 3) Production Build

```bash
cd frontend
npm run build
```

## Seeded Credentials

- Admin: `admin@kemocuts.co.tz`
- Password: `Password123!`

## Notes

- Payment metadata supports local wallet integrations (M-Pesa / Airtel Money structure ready).
- Analytics/export hooks are API-ready using real persisted data.

## Audit Fixes Applied

- Fixed notification queue job to persist required `business_id` and `is_read` fields.
- Hardened booking and payment form-request validation to enforce tenant-safe foreign-key references.
- Added export-ready analytics endpoints in CSV/JSON and frontend download actions.
