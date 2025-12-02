# Ottimizzazioni Performance Locale

## 🐌 Problemi Identificati

### 1. **Polling Eccessivo di Livewire**

Attualmente ci sono **6 componenti** che fanno polling simultaneo:

| Componente | Intervallo | Impatto |
|------------|-----------|---------|
| `badge-notification.blade.php` | **1s** | 🔴 CRITICO |
| `translation-management.blade.php` | **500ms** | 🔴 CRITICO |
| `translation-workspace.blade.php` | 5s | 🟡 MEDIO |
| `chat-show.blade.php` | 5s | 🟡 MEDIO |
| `notification-animation.blade.php` | 5s | 🟡 MEDIO |
| `notification-center.blade.php` | 10s | 🟢 BASSO |

**Problema**: Ogni polling fa una richiesta HTTP completa al server, rallentando tutto.

### 2. **Reverb Non Avviato**

Il `.env` ha `BROADCAST_CONNECTION=reverb` ma il server Reverb non è in esecuzione.
Livewire tenta di connettersi a `ws://slamin.test:8080` e fallisce, causando timeout.

## ✅ Soluzioni Immediate

### **Soluzione 1: Disabilita Reverb in Locale** (VELOCE)

Modifica `.env`:
```env
# Prima (lento)
BROADCAST_CONNECTION=reverb

# Dopo (veloce)
BROADCAST_CONNECTION=log
```

Poi:
```bash
php artisan config:clear
```

### **Soluzione 2: Riduci Polling Aggressivo**

#### A. Badge Notification (1s → 30s)
```blade
<!-- Prima -->
<div wire:poll.1s="pollForBadge" wire:poll.keep-alive>

<!-- Dopo -->
<div wire:poll.30s="pollForBadge">
```

#### B. Translation Management (500ms → 5s)
```blade
<!-- Prima -->
wire:poll.500ms

<!-- Dopo -->
wire:poll.5s
```

#### C. Notification Animation (5s → rimuovi se non necessario)
Questo componente fa polling anche quando non ci sono notifiche!

### **Soluzione 3: Usa Reverb Correttamente** (MIGLIORE)

Se vuoi usare Reverb per real-time:

1. **Avvia Reverb**:
```bash
php artisan reverb:start
```

2. **Rimuovi polling dove non serve**:
   - Badge notifications → usa eventi Reverb
   - Notification center → usa eventi Reverb
   - Chat → usa eventi Reverb

3. **Mantieni polling solo per fallback**:
```blade
<div wire:poll.30s="loadNotifications">
    <!-- Polling come fallback se WebSocket disconnesso -->
</div>
```

## 🚀 Ottimizzazioni Aggiuntive

### 1. **Cache Query Pesanti**

Aggiungi cache per query frequenti:
```php
// Prima (lento)
$notifications = auth()->user()->notifications()->latest()->get();

// Dopo (veloce)
$notifications = Cache::remember(
    'user.notifications.' . auth()->id(),
    now()->addSeconds(10),
    fn() => auth()->user()->notifications()->latest()->get()
);
```

### 2. **Lazy Loading Componenti**

Per componenti non critici:
```blade
<div wire:init="loadData">
    @if($dataLoaded)
        <!-- Contenuto pesante -->
    @else
        <div>Caricamento...</div>
    @endif
</div>
```

### 3. **Debounce Input**

Per ricerche e filtri:
```blade
<input wire:model.live.debounce.500ms="search">
```

### 4. **OPcache per PHP**

Verifica che OPcache sia abilitato in `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

### 5. **Vite Build per Sviluppo**

Se stai usando `npm run dev`, passa a:
```bash
npm run build
```

Il dev server di Vite può essere lento su Windows.

## 📊 Test Performance

### Prima delle Ottimizzazioni
```bash
# Apri DevTools → Network
# Conta le richieste in 10 secondi
# Probabile risultato: 20-30 richieste
```

### Dopo le Ottimizzazioni
```bash
# Stesso test
# Risultato atteso: 2-5 richieste
```

## 🎯 Piano di Implementazione

### **Fase 1: Quick Wins** (5 minuti)
1. ✅ Disabilita Reverb → `BROADCAST_CONNECTION=log`
2. ✅ Riduci polling badge → 30s
3. ✅ Riduci polling translation-management → 5s

### **Fase 2: Ottimizzazioni** (30 minuti)
1. Implementa cache per notifiche
2. Lazy load componenti pesanti
3. Debounce input di ricerca

### **Fase 3: Real-time con Reverb** (2 ore)
1. Configura Reverb correttamente
2. Sostituisci polling con eventi
3. Mantieni polling solo come fallback

## 🔍 Debug Performance

### Identifica Bottleneck
```bash
# Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev

# Poi apri il browser e vedi:
# - Query lente
# - Componenti lenti
# - Request time
```

### Monitor Query
```php
// In AppServiceProvider
DB::listen(function ($query) {
    if ($query->time > 100) { // Query > 100ms
        Log::warning('Slow query', [
            'sql' => $query->sql,
            'time' => $query->time
        ]);
    }
});
```

## 📝 Checklist

- [ ] Disabilita Reverb in locale
- [ ] Riduci polling badge a 30s
- [ ] Riduci polling translation-management a 5s
- [ ] Verifica OPcache abilitato
- [ ] Usa `npm run build` invece di `npm run dev`
- [ ] Aggiungi cache per query frequenti
- [ ] Testa performance con DevTools

---

**Risultato Atteso**: Riduzione del 70-80% del tempo di caricamento 🚀

