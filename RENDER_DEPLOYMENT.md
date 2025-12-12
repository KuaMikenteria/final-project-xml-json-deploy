# Render Deployment Configuration Guide

## Overview
This Laravel application is a Resort Reservation System with a single-page interface featuring Personal Information and Booking Reservation forms, plus a database dashboard with CRUD operations.

---

## Render Service Configuration

### Service Type
**Web Service** (not Static Site)

### Basic Settings

#### 1. **Language/Runtime Environment**
```
PHP
```
- Choose **PHP** from the runtime environment dropdown
- Render will automatically detect PHP applications

#### 2. **Region**
```
Singapore (closest to Philippines) OR
Oregon (US West) OR
Frankfurt (EU)
```
- Select based on your primary user base location
- Services in the same region can communicate over private networks

#### 3. **Build Command**
```bash
composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache
```
**Alternative (if you need to compile assets):**
```bash
composer install --no-dev --optimize-autoloader && npm ci && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

#### 4. **Start Command**
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```
**OR** (if using Render's built-in PHP support):
```bash
php -S 0.0.0.0:$PORT -t public
```

---

## Environment Variables

Set these in Render Dashboard → Your Service → Environment Variables:

### Required Variables

```env
APP_NAME="Resort Reservation System"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-service-name.onrender.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=postgresql
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### How to Set Environment Variables:

1. **APP_KEY**: Generate using:
   ```bash
   php artisan key:generate --show
   ```
   Copy the output and set it as `APP_KEY` in Render

2. **Database Variables**: 
   - Create a **PostgreSQL** database in Render
   - Copy the connection details from the database dashboard
   - Set `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

3. **APP_URL**: 
   - Set to your Render service URL (e.g., `https://resort-reservation.onrender.com`)

---

## Database Setup

### 1. Create PostgreSQL Database in Render
1. Go to Render Dashboard → **New** → **PostgreSQL**
2. Choose a name (e.g., `resort-reservation-db`)
3. Select the same region as your web service
4. Click **Create Database**
5. Copy the connection details

### 2. Run Migrations
After deployment, run migrations via Render Shell or add to build command:

**Option A: Via Render Shell**
```bash
cd /opt/render/project/src
php artisan migrate --force
```

**Option B: Add to Build Command** (not recommended for production)
```bash
composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## Step-by-Step Deployment

### 1. Connect Repository
- Connect your GitHub/GitLab repository to Render
- Render will auto-detect PHP

### 2. Configure Service
- **Name**: `resort-reservation` (or your preferred name)
- **Region**: Choose based on your users
- **Branch**: `main` or `master`
- **Root Directory**: Leave empty (or `./` if needed)

### 3. Set Build & Start Commands
- Use the commands provided above

### 4. Add Environment Variables
- Add all required variables from the list above
- **Important**: Set `APP_KEY` before first deployment

### 5. Create Database
- Create PostgreSQL database
- Link it to your web service
- Copy database credentials to environment variables

### 6. Deploy
- Click **Create Web Service**
- Render will build and deploy automatically
- First deployment may take 5-10 minutes

### 7. Run Migrations
- After first successful deployment, open Render Shell
- Run: `php artisan migrate --force`

---

## Post-Deployment Checklist

- [ ] Environment variables set correctly
- [ ] Database created and linked
- [ ] Migrations run successfully
- [ ] Application accessible via URL
- [ ] Forms submit correctly
- [ ] Database operations (CRUD) working
- [ ] Search filtering functional
- [ ] View modal displays details correctly

---

## Testing with Postman

### Base URL
```
https://your-service-name.onrender.com/api/reservations
```

### Endpoints

#### 1. **Create Reservation** (POST)
```
POST /api/reservations
Content-Type: application/json
Accept: application/json

Body:
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone_number": "09123456789",
  "municipality_city": "Manila",
  "country": "Philippines",
  "resort": "Kuya Boy Beach Resort",
  "check_in_date": "2024-12-15",
  "check_out_date": "2024-12-20",
  "number_of_guests": 2,
  "payment_method": "GCash"
}
```

#### 2. **List Reservations** (GET)
```
GET /api/reservations
Accept: application/json

Query Parameters (optional):
?search=john
```

#### 3. **Get Single Reservation** (GET)
```
GET /api/reservations/{id}
Accept: application/json
```

#### 4. **Update Reservation** (PUT)
```
PUT /api/reservations/{id}
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: {token}

Body: (same as create)
```

#### 5. **Delete Reservation** (DELETE)
```
DELETE /api/reservations/{id}
Accept: application/json
X-CSRF-TOKEN: {token}
```

### Postman Collection Setup

1. Create a new Collection: "Resort Reservation API"
2. Set Collection Variables:
   - `base_url`: `https://your-service-name.onrender.com`
   - `csrf_token`: Get from browser cookies or API response

3. Add Pre-request Script (for CSRF token):
```javascript
pm.sendRequest({
    url: pm.variables.get("base_url"),
    method: 'GET'
}, function (err, res) {
    if (res) {
        const cookies = res.cookies.all();
        const csrfCookie = cookies.find(c => c.name === 'XSRF-TOKEN');
        if (csrfCookie) {
            pm.collectionVariables.set("csrf_token", csrfCookie.value);
        }
    }
});
```

---

## Troubleshooting

### Common Issues

1. **500 Error on First Load**
   - Check if `APP_KEY` is set
   - Verify database connection
   - Check logs in Render Dashboard

2. **Database Connection Failed**
   - Verify database credentials
   - Ensure database is in same region
   - Check `DB_CONNECTION=postgresql` (not `mysql`)

3. **Migrations Not Running**
   - Run manually via Render Shell
   - Check database permissions

4. **CSRF Token Mismatch**
   - Ensure `APP_URL` matches your Render URL
   - Clear browser cookies
   - Check session configuration

5. **Assets Not Loading**
   - Run `npm run build` in build command
   - Check `public/build` directory exists
   - Verify Vite configuration

---

## Performance Optimization

### Recommended Settings

1. **Enable Caching**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Optimize Autoloader**:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. **Database Indexing** (if needed):
   - Add indexes for frequently searched columns
   - Run via migration

---

## Security Notes

- ✅ Never commit `.env` file
- ✅ Set `APP_DEBUG=false` in production
- ✅ Use strong `APP_KEY`
- ✅ Enable HTTPS (automatic on Render)
- ✅ Validate all inputs (already implemented)
- ✅ Use CSRF protection (Laravel default)

---

## Support

For Render-specific issues:
- Render Documentation: https://render.com/docs
- Render Support: support@render.com

For Laravel issues:
- Laravel Documentation: https://laravel.com/docs
- Laravel Community: https://laracasts.com/discuss

---

**Last Updated**: December 2024
**Laravel Version**: 11.x
**PHP Version**: 8.2+



