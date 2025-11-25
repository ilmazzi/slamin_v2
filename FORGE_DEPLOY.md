# 🚀 Laravel Forge Deployment

## Setup Deployment Script

1. **Vai su Laravel Forge Dashboard**
   - Seleziona il tuo server
   - Vai alla sezione del sito `slamin.it`

2. **Configura Deploy Script**
   - Vai su **"Apps" > "Deploy Script"**
   - Copia il contenuto di `deploy.sh` nello script di deploy
   - Oppure usa direttamente: `bash /home/forge/slamin.it/deploy.sh`

3. **Abilita Quick Deploy (Opzionale)**
   - Attiva "Quick Deploy" se vuoi deploy automatici ad ogni push su `main`

4. **Primo Deploy Manuale**
   - Clicca su **"Deploy Now"** per eseguire il primo deploy

## Script di Deploy Include:

✅ Pull delle ultime modifiche da Git
✅ Install/Update Composer dependencies (production)
✅ Install/Update NPM dependencies
✅ Build assets con Vite (npm run build)
✅ Clear di tutte le cache Laravel
✅ Esecuzione migrazioni database
✅ Ottimizzazione per produzione (config, route, view cache)
✅ Clear cache Livewire
✅ Restart queue workers
✅ Reload PHP-FPM

## Comandi Manuali (se necessario)

Se devi eseguire comandi specifici via SSH:

```bash
# SSH nel server
ssh forge@your-server-ip

# Vai nella directory del progetto
cd /home/forge/slamin.it

# Pulisci cache Livewire
php artisan livewire:configure --optimize

# Ricompila assets
npm run build

# Pulisci tutte le cache
php artisan optimize:clear

# Ricrea cache ottimizzate
php artisan optimize
```

## Variabili d'Ambiente

Assicurati che nel file `.env` su Forge siano impostate:

```env
APP_ENV=production
APP_DEBUG=false
VITE_APP_URL=https://slamin.it
```

## Troubleshooting

### Assets non aggiornati
```bash
npm run build
php artisan view:clear
```

### Cache Livewire
```bash
php artisan livewire:configure --optimize
php artisan view:clear
```

### Permessi
```bash
sudo chown -R forge:forge /home/forge/slamin.it
sudo chmod -R 755 /home/forge/slamin.it/storage
sudo chmod -R 755 /home/forge/slamin.it/bootstrap/cache
```

## Deploy dalla CLI

Puoi anche triggerare un deploy dalla CLI usando il Forge API o webhook:

```bash
# Via webhook (se configurato)
curl -X POST https://forge.laravel.com/servers/YOUR_SERVER_ID/sites/YOUR_SITE_ID/deploy/http?token=YOUR_TOKEN
```

