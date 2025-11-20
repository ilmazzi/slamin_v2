# Analisi Pannello Admin - Progetto Slamin

## 📋 Overview

Il progetto **slamin** ha un pannello admin completo strutturato con:
- **Pattern**: Controller-based (Laravel tradizionale, non Livewire)
- **Layout**: Layout master con sidebar e header
- **Route**: Tutte sotto prefisso `/admin/*`
- **Middleware**: Verifica ruolo admin per accesso

---

## 🏗️ Struttura del Pannello Admin

### 1. Controllers Admin (`app/Http/Controllers/Admin/`)

Il pannello è organizzato con controller separati per ogni sezione:

```
app/Http/Controllers/Admin/
├── AdminDashboardController.php    # Dashboard principale con statistiche
├── ArticleController.php           # CRUD articoli
├── CarouselController.php          # Gestione carousel
├── GigPositionController.php       # Gestione posizioni gig
├── KanbanController.php            # Sistema kanban
├── LogController.php               # Visualizzazione log
├── LogsController.php              # Gestione log (alternativo)
├── ModerationController.php        # Moderazione contenuti
├── PaymentAccountsController.php   # Gestione account pagamento utenti
├── PaymentSettingsController.php   # Impostazioni pagamenti
├── PayoutController.php            # Gestione payout
├── PeerTubeController.php          # Gestione PeerTube
├── PlaceholderSettingsController.php # Impostazioni placeholder
├── SocialSettingsController.php    # Impostazioni social
├── SystemSettingsController.php    # Impostazioni sistema generale
├── TestLogsController.php          # Test log
├── TranslationController.php       # Editor traduzioni
├── TranslationManagementController.php # Gestione traduzioni
├── UploadSettingsController.php    # Impostazioni upload
└── UserController.php              # Gestione utenti
```

### 2. Middleware

**AdminMiddleware** (`app/Http/Middleware/AdminMiddleware.php`):
- Verifica autenticazione
- Verifica ruolo `admin`
- Restituisce 403 se non autorizzato

**AdminAccess** (`app/Http/Middleware/AdminAccess.php`):
- Permette accesso a `admin` e `moderator`
- Usato per funzionalità che richiedono permessi meno restrittivi

### 3. Route Admin (`routes/web.php`)

Le route admin sono organizzate con prefisso `/admin`:

```php
// Dashboard principale
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Impostazioni separate per sezione
Route::prefix('admin/settings')->name('admin.settings.')->middleware(['auth'])->group(function () {
    Route::get('/', [SystemSettingsController::class, 'index'])->name('index');
    Route::post('/', [SystemSettingsController::class, 'update'])->name('update');
    
    Route::get('/placeholder', [PlaceholderSettingsController::class, 'index'])->name('placeholder');
    Route::put('/placeholder', [PlaceholderSettingsController::class, 'update'])->name('placeholder.update');
    
    Route::get('/payment', [PaymentSettingsController::class, 'index'])->name('payment.index');
    Route::post('/payment', [PaymentSettingsController::class, 'update'])->name('payment.update');
    
    Route::get('/upload', [UploadSettingsController::class, 'index'])->name('upload.index');
    Route::post('/upload', [UploadSettingsController::class, 'update'])->name('upload.update');
});

// Gestione traduzioni
Route::prefix('admin/translations')->name('admin.translations.')->middleware(['auth', 'admin'])->group(function () {
    // Editor traduzioni
    // Gestione traduzioni
});

// Carousel management
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('carousels', CarouselController::class)->names('carousels');
});

// Logs
Route::prefix('admin/logs')->name('admin.logs.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [LogsController::class, 'index'])->name('index');
    Route::get('/activity', [LogsController::class, 'activity'])->name('activity');
    Route::get('/errors', [LogsController::class, 'errors'])->name('errors');
});

// Moderation
// Payment accounts
// PeerTube
// Kanban
// etc.
```

---

## 📊 Dashboard Admin (`AdminDashboardController`)

### Statistiche Mostrate

1. **Statistiche Generali**:
   - Utenti totali
   - Eventi totali
   - Gig totali
   - Pagamenti totali
   - Video totali
   - Poesie totali
   - Gruppi totali
   - Messaggi totali

2. **Statistiche Utenti**:
   - Nuovi oggi
   - Nuovi questa settimana
   - Nuovi questo mese
   - Utenti attivi (ultimi 7 giorni)
   - Utenti premium
   - Traduttori

3. **Statistiche Eventi**:
   - Eventi oggi
   - Eventi questa settimana
   - Eventi questo mese
   - Eventi in arrivo
   - Eventi passati
   - Gig attivi

4. **Statistiche Pagamenti**:
   - Ricavi totali
   - Ricavi oggi
   - Ricavi questa settimana
   - Ricavi questo mese
   - Pagamenti pending
   - Pagamenti completati
   - Pagamenti falliti

5. **Statistiche Contenuti**:
   - Video totali/questo mese
   - Poesie totali/questo mese
   - Gruppi totali/questo mese
   - Messaggi totali/questo mese

6. **Attività Recente**:
   - Ultimi 5 utenti
   - Ultimi 5 eventi
   - Ultimi 5 pagamenti
   - Ultimi 5 gig

7. **Utenti Online**:
   - Conta utenti attivi negli ultimi 5 minuti

---

## 🎨 Layout e Viste

### Layout Master (`resources/views/layout/master.blade.php`)

Il layout master include:
- **Sidebar** (`@include('layout.sidebar')`)
- **Header** (`@include('layout.header')`)
- **Main content** (`@yield('main-content')`)
- **Chat widget** (se autenticato)
- **Loader/Splash screen**

### Viste Admin (`resources/views/admin/`)

Organizzate per sezione:

```
resources/views/admin/
├── dashboard.blade.php                    # Dashboard principale
├── article-reports/
│   └── index.blade.php                    # Lista report articoli
├── article-categories/
│   └── index.blade.php                    # Gestione categorie
├── article-tags/
│   └── index.blade.php                    # Gestione tag
├── articles/
│   ├── index.blade.php                    # Lista articoli
│   └── create.blade.php                   # Crea articolo
├── carousels/
│   ├── index.blade.php                    # Lista carousel
│   ├── create.blade.php                   # Crea carousel
│   ├── edit.blade.php                     # Modifica carousel
│   └── show.blade.php                     # Dettagli carousel
├── gig-positions/
│   ├── index.blade.php                    # Lista posizioni
│   ├── create.blade.php                   # Crea posizione
│   └── edit.blade.php                     # Modifica posizione
├── kanban/
│   ├── index.blade.php                    # Board kanban
│   └── task-details.blade.php             # Dettagli task
├── logs/
│   ├── index.blade.php                    # Lista log
│   ├── activity.blade.php                 # Log attività
│   ├── errors.blade.php                   # Log errori
│   ├── show.blade.php                     # Dettagli log
│   └── test.blade.php                     # Test log
├── moderation/
│   ├── index.blade.php                    # Dashboard moderazione
│   └── settings.blade.php                 # Impostazioni moderazione
├── payment-accounts/
│   └── index.blade.php                    # Gestione account pagamento
├── peertube/
│   ├── index.blade.php                    # Dashboard PeerTube
│   └── manage-users.blade.php             # Gestione utenti PeerTube
├── settings/
│   ├── index.blade.php                    # Impostazioni generali
│   ├── payment.blade.php                  # Impostazioni pagamenti
│   ├── placeholder.blade.php              # Impostazioni placeholder
│   └── upload.blade.php                   # Impostazioni upload
├── social-settings.blade.php              # Impostazioni social
└── translations/
    ├── index.blade.php                    # Lista lingue
    ├── create.blade.php                   # Crea lingua
    ├── show.blade.php                     # Editor traduzioni
    └── editor.blade.php                   # Editor file traduzioni
```

### Stile e UI

- Usa **Bootstrap** o framework CSS personalizzato
- Icone **Phosphor Icons** (`ph-duotone`, `ph`)
- Card layout con statistiche
- Tabelle responsive per liste
- Form con validazione
- Modal per azioni rapide

---

## 🔧 Funzionalità Principali

### 1. Dashboard (`AdminDashboardController`)

**Route**: `/admin/dashboard`

**Funzionalità**:
- Statistiche aggregate in tempo reale
- Grafici e metriche chiave
- Attività recente
- Utenti online

**Metodi privati**:
- `getGeneralStats()` - Statistiche generali
- `getUserStats()` - Statistiche utenti
- `getEventStats()` - Statistiche eventi
- `getPaymentStats()` - Statistiche pagamenti
- `getContentStats()` - Statistiche contenuti
- `getRecentActivity()` - Attività recente
- `getOnlineUsers()` - Utenti online

### 2. Gestione Utenti (`UserController`)

**Route**: `/admin/users` (presumibilmente)

**Funzionalità**:
- Lista utenti con paginazione
- Visualizzazione dettagli utente
- Modifica utente (nome, email, nickname, status)
- Gestione ruoli e permessi
- Eliminazione utente (con controlli sicurezza)
- Eliminazione account PeerTube associato
- Statistiche utente

**Metodi**:
- `index()` - Lista utenti
- `show(User $user)` - Dettagli utente (JSON)
- `update(Request $request, User $user)` - Aggiorna utente
- `destroy(User $user)` - Elimina utente

### 3. Moderazione (`ModerationController`)

**Route**: `/admin/moderation`

**Funzionalità**:
- Dashboard moderazione con statistiche
- Lista contenuti pending/approved/rejected
- Filtri per tipo contenuto (videos, poems, events, photos, articles)
- Filtri per stato (pending, approved, rejected)
- Ordinamento (newest, oldest, etc.)
- Approvazione contenuti
- Rifiuto contenuti
- Metti in attesa contenuti
- Note di moderazione
- Gestione report

**Tipi contenuto supportati**:
- Videos
- Poems
- Events
- Photos
- Articles
- Carousels

**Metodi principali**:
- `index(Request $request)` - Dashboard moderazione
- `approve(Request $request, $type, $id)` - Approva contenuto
- `reject(Request $request, $type, $id)` - Rifiuta contenuto
- `setPending(Request $request, $type, $id)` - Metti in attesa
- Metodi privati per filtri e query

### 4. Gestione Articoli (`ArticleController`)

**Route**: `/admin/articles`

**Funzionalità**:
- CRUD completo articoli
- Lista articoli
- Crea articolo
- Modifica articolo
- Elimina articolo
- Upload immagine featured
- Gestione categorie e tag
- Gestione slug
- Auto-approvazione per admin

**Metodi**:
- `index()` - Lista articoli
- `create()` - Form creazione
- `store(Request $request)` - Salva articolo
- `show(Article $article)` - Dettagli
- `edit(Article $article)` - Form modifica
- `update(Request $request, Article $article)` - Aggiorna
- `destroy(Article $article)` - Elimina

### 5. Impostazioni Sistema (`SystemSettingsController`)

**Route**: `/admin/settings`

**Funzionalità**:
- Visualizzazione impostazioni per gruppo
- Modifica impostazioni
- Reset impostazioni
- Validazione valori
- Cache delle impostazioni

**Gruppi impostazioni**:
- General
- Upload (dimensioni file, tipi consentiti)
- Payment (Stripe, PayPal, commissioni)
- Placeholder
- Social

### 6. Logs (`LogsController`)

**Route**: `/admin/logs`

**Funzionalità**:
- Visualizzazione log attività
- Visualizzazione log errori
- Filtri per categoria, livello, utente
- Download log
- Cancellazione log
- Dettagli log entry

**Tipi log**:
- Activity logs
- Error logs
- System logs

### 7. Traduzioni (`TranslationController`, `TranslationManagementController`)

**Route**: `/admin/translations`

**Funzionalità**:
- Editor traduzioni file
- Gestione lingue
- Creazione file traduzione
- Copia da italiano
- Sincronizzazione traduzioni
- Reset traduzioni

---

## 🔐 Sistema di Autenticazione e Autorizzazione

### Verifica Ruoli

Tutti i controller verificano il ruolo admin:

```php
// Nel controller
if (!auth()->user()->hasRole('admin')) {
    abort(403, 'Accesso negato');
}

// O nel middleware
$this->middleware('auth');
// + verifica ruolo in middleware o route
```

### Ruoli Supportati

- `admin` - Accesso completo admin
- `moderator` - Accesso moderazione (AdminAccess middleware)
- Altri ruoli (poet, organizer, etc.) - Non hanno accesso admin

---

## 📝 Note Implementazione

### Pattern Usato

1. **Controller-based** (non Livewire):
   - Logica nel controller
   - Viste Blade semplici
   - AJAX per interazioni dinamiche

2. **Route grouping**:
   - Prefisso `/admin` per tutte le route admin
   - Middleware `auth` sempre presente
   - Middleware ruolo admin dove necessario

3. **Viste organizzate**:
   - Cartella `admin/` per tutte le viste admin
   - Sottocartelle per ogni sezione
   - Layout master condiviso

4. **Statistiche**:
   - Calcolate nel controller
   - Passate alla vista
   - Refresh su richiesta (non real-time)

### UI/UX

- **Card layout** per statistiche
- **Tabelle** per liste
- **Modal** per azioni rapide
- **Form** standard Laravel
- **Toast/Flash messages** per feedback
- **Badges** per stati
- **Icone** Phosphor Icons

---

## 🚀 Differenze con Slamin_v2

### Slamin (originale):
- ✅ Controller-based
- ✅ Blade views
- ✅ Route grouping `/admin/*`
- ✅ Middleware per ruolo admin
- ✅ Dashboard con statistiche
- ✅ Moderation controller completo
- ✅ Settings controller separati

### Slamin_v2 (attuale):
- ✅ Livewire components (parziale)
- ✅ BadgeManagement, ArticleLayoutManager già presenti
- ✅ HasModeration trait
- ✅ Reportable trait
- ✅ ActivityLog model
- ❌ Dashboard admin non presente
- ❌ Moderation admin non presente
- ❌ Settings admin non presente

---

## 📌 Raccomandazioni per Slamin_v2

1. **Mantenere Livewire** (più moderno e reattivo)
2. **Adattare struttura route** `/admin/*`
3. **Replicare dashboard** con statistiche simili
4. **Usare ModerationController** come riferimento per moderazione
5. **Creare Settings components** Livewire invece di controller
6. **Mantenere organizzazione viste** in `admin/`
7. **Implementare middleware** admin per Livewire routes

---

**Data Analisi**: 2025-01-XX
**Versione**: 1.0

