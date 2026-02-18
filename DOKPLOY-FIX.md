# Dokploy Deployment Fix - Messaging Issues

## Problem
Messaging/inbox functionality works locally but fails on Dokploy deployment. This is caused by session, HTTPS, and proxy configuration issues.

## Required Environment Variables in Dokploy

Add or update these environment variables in your Dokploy project settings:

### Critical for Messaging to Work:

```env
# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com  # MUST match your actual domain with HTTPS

# Session Configuration (CRITICAL for messaging)
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true  # IMPORTANT: Must be true for HTTPS
SESSION_SAME_SITE=lax
SESSION_DOMAIN=your-domain.com  # WITHOUT https:// or www.

# Database (adjust to your Dokploy setup)
DB_CONNECTION=mysql  # or postgresql
DB_HOST=your-db-host
DB_PORT=3306  # or 5432 for postgres
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

# Cache & Queue
CACHE_STORE=database
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=local  # or 's3' if using cloud storage
```

### Optional but Recommended:

```env
# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Mail (if using)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Post-Deployment Commands

After deploying, run these commands in Dokploy terminal:

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 775 storage bootstrap/cache
```

## Checklist for Messaging to Work

- [ ] **APP_URL** matches your production domain exactly (with https://)
- [ ] **SESSION_SECURE_COOKIE=true** is set
- [ ] **SESSION_DOMAIN** is set to your domain (without protocol)
- [ ] Database connection works (check with `php artisan migrate:status`)
- [ ] Sessions table exists (run `php artisan migrate --force` if not)
- [ ] Storage directories have write permissions (775)
- [ ] All caches are cleared after environment changes

## Common Issues & Solutions

### Issue 1: "419 Page Expired" or CSRF Token Mismatch
**Solution:**
- Set `SESSION_SECURE_COOKIE=true`
- Set `SESSION_DOMAIN` to match your domain
- Clear config cache: `php artisan config:clear`

### Issue 2: Livewire Components Not Updating
**Solution:**
- Ensure `APP_URL` is correct with HTTPS
- Clear all caches
- Check browser console for AJAX errors

### Issue 3: Messages Not Sending
**Solution:**
- Check database connection
- Verify sessions table exists: `php artisan migrate:status`
- Check storage/logs/laravel.log for errors

### Issue 4: Authentication Issues
**Solution:**
- Set `SESSION_SECURE_COOKIE=true` for HTTPS
- Set `SESSION_SAME_SITE=lax`
- Clear browser cookies and try again

## Testing After Fix

1. Clear browser cache and cookies
2. Log out and log back in
3. Navigate to inbox
4. Try sending a message
5. Check if message appears in conversation
6. Check if polling works (messages auto-refresh every 3 seconds)

## Debugging Commands

```bash
# Check if sessions are being stored
php artisan tinker
>>> DB::table('sessions')->count();

# Check if messages are being created
>>> DB::table('messages')->latest()->first();

# Check environment configuration
php artisan config:show session
php artisan config:show app
```

## Files Modified

- `bootstrap/app.php` - Added trusted proxies configuration
- `nixpacks.toml` - Added migrations and proper permissions
- This document for reference

## Need More Help?

If messaging still doesn't work:
1. Check Dokploy logs: View → Logs
2. Check Laravel logs: `storage/logs/laravel.log`
3. Check browser console for JavaScript errors (F12)
4. Verify database has recent messages in `messages` table
