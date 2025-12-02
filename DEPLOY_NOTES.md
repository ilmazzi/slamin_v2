# 🚀 Deploy Notes - Translation Workspace System

## Comandi da eseguire sul server di produzione:

```bash
# 1. Pull delle modifiche
git pull origin main

# 2. Install/Update dependencies (se necessario)
composer install --no-dev --optimize-autoloader

# 3. Run migrations
php artisan migrate --force

# 4. Clear all caches
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 5. Optimize (IMPORTANTE!)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Restart queue workers (se usi le code)
php artisan queue:restart
```

## Nuove Route Aggiunte:

- `GET /gigs/applications/{application}/workspace` → `gigs.workspace`

## Nuove Tabelle:

- `translation_versions` - Storico versioni traduzioni
- `translation_comments` - Commenti su traduzioni
- Colonne aggiunte a `poem_translations`:
  - `gig_application_id`
  - `version`
  - `submitted_at`
  - `approved_at`
  - `approved_by`
  - `translated_text`
  - `target_language`

## Nuove Notifiche:

- `TranslationWorkspaceNotification` - 5 tipi di eventi workspace

## Test Checklist:

- [ ] Route `gigs.workspace` accessibile
- [ ] Migrations eseguite correttamente
- [ ] Workspace si apre da gig accettato
- [ ] Salvataggio traduzione funziona
- [ ] Commenti si creano
- [ ] Notifiche arrivano all'altro utente
- [ ] Storico versioni visibile
- [ ] Approvazione traduzione funziona

---

**Se le notifiche non arrivano**, controlla i log:
```bash
tail -f storage/logs/laravel.log | grep "🔔"
```

Dovresti vedere:
```
🔔 Sending translation_updated notification
from: [user_id]
to: [other_user_id]
```

