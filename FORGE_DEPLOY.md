# 🔧 FORGE DEPLOYMENT - URGENT FIX

## ❌ Problema Attuale:
```
Route [gigs.workspace] not defined
```

## ✅ Soluzione:

### **Opzione 1: Via SSH (PIÙ VELOCE)**

```bash
# Connettiti al server
ssh forge@slamin.it

# Vai nella directory
cd /home/forge/slamin.it

# Pull
git pull origin main

# Migrations
php artisan migrate --force

# IMPORTANTE: Clear + Cache routes
php artisan route:clear
php artisan route:cache

# Clear altre cache
php artisan config:clear
php artisan config:cache
php artisan view:clear

# Restart queue
php artisan queue:restart

# Exit
exit
```

### **Opzione 2: Via Forge Dashboard**

1. Vai su **Laravel Forge Dashboard**
2. Seleziona il sito **slamin.it**
3. Vai su **Deployments**
4. Clicca **Deploy Now**
5. Aspetta che finisca
6. Vai su **Commands**
7. Esegui questi comandi uno alla volta:
   ```
   php artisan route:clear
   php artisan route:cache
   php artisan config:cache
   php artisan migrate --force
   ```

### **Opzione 3: Deploy Script Automatico**

Se hai uno script di deploy su Forge, aggiungi:

```bash
cd /home/forge/slamin.it
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan queue:restart
```

---

## 🔍 Verifica che funzioni:

Dopo il deploy, controlla i log:

```bash
tail -f storage/logs/laravel.log | grep "gigs.workspace"
```

**NON** dovresti più vedere l'errore "Route not defined".

---

## 📊 Log Attuali (Prima del Fix):

```
✅ Notification sent successfully
❌ Route [gigs.workspace] not defined
```

Questo conferma che:
- ✅ La notifica viene inviata correttamente
- ✅ Il destinatario è corretto (user 51)
- ❌ La route non è cached sul server

**Dopo il fix vedrai:**
```
✅ Notification sent successfully
✅ Notification saved to database
✅ User 51 receives notification
```
