# Fix Storage 403 Error su Forge

## Problema
Errore 403 quando si cerca di accedere a file in `/storage/chat-attachments/`:
```
GET https://slamin.it/storage/chat-attachments/xxx.svg 403 (Forbidden)
```

## Soluzione

### 1. Verificare/Creare il link simbolico storage

Su Forge, eseguire nel terminale del sito:

```bash
php artisan storage:link
```

Questo crea il link simbolico `public/storage` → `storage/app/public`

### 2. Verificare i permessi delle cartelle

```bash
# Naviga nella directory del progetto
cd /home/forge/slamin.it  # o il path corretto del tuo sito

# Imposta i permessi corretti
sudo chown -R forge:forge storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Assicurati che la cartella chat-attachments esista e abbia i permessi corretti
mkdir -p storage/app/public/chat-attachments
chmod -R 775 storage/app/public/chat-attachments
```

### 3. Verificare che i file siano nella posizione corretta

I file devono essere salvati in `storage/app/public/chat-attachments/` per essere accessibili pubblicamente tramite `/storage/chat-attachments/`.

Se i file sono attualmente in `storage/app/private/` o altrove, devono essere spostati:

```bash
# Verifica dove sono i file
ls -la storage/app/public/chat-attachments/
ls -la storage/app/private/chat-attachments/  # se esiste

# Se i file sono in private, spostali in public
mv storage/app/private/chat-attachments/* storage/app/public/chat-attachments/
```

### 4. Verificare la configurazione Nginx

Su Forge, verifica che Nginx permetta di servire file dalla cartella storage. Di solito è già configurato, ma assicurati che non ci siano restrizioni eccessive.

### 5. Verificare SELinux (se attivo)

```bash
# Verifica lo status di SELinux
getenforce

# Se è "Enforcing", potresti dover permettere l'accesso ai file
sudo chcon -R -t httpd_sys_content_t storage/app/public/
```

### 6. Script completo per Forge

Esegui questo script completo sul server:

```bash
#!/bin/bash
cd /home/forge/slamin.it  # Sostituisci con il path corretto

# Crea il link simbolico
php artisan storage:link

# Crea le cartelle necessarie
mkdir -p storage/app/public/chat-attachments
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs

# Imposta i permessi
sudo chown -R forge:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Assicurati che www-data possa leggere i file
sudo chmod -R 755 storage/app/public

echo "Storage configurato correttamente!"
```

### 7. Verificare la configurazione dell'applicazione

Assicurati che i file di chat vengano salvati usando il disco 'public':

```php
// Dovrebbe essere:
Storage::disk('public')->put('chat-attachments/filename.svg', $content);

// NON:
Storage::disk('local')->put('chat-attachments/filename.svg', $content);
```

### 8. Test dopo la configurazione

Dopo aver applicato le modifiche:

1. Verifica che il link simbolico esista:
   ```bash
   ls -la public/storage
   # Dovrebbe mostrare: public/storage -> /path/to/storage/app/public
   ```

2. Verifica che i file siano accessibili:
   ```bash
   curl -I https://slamin.it/storage/chat-attachments/test.svg
   # Dovrebbe restituire 200, non 403
   ```

3. Controlla i log di Nginx se necessario:
   ```bash
   sudo tail -f /var/log/nginx/error.log
   ```

## Note importanti

- **Non committare** la cartella `storage/app/public/chat-attachments/` nel git (dovrebbe essere in `.gitignore`)
- I file in `storage/app/public/` sono pubblicamente accessibili
- I file in `storage/app/private/` NON sono accessibili pubblicamente senza un controller che li serva

