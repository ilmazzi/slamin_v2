# Analisi Sistema e Progettazione Pannello Admin

## 📋 Indice
1. [Sistema Attuale](#sistema-attuale)
2. [Funzionalità Esistenti](#funzionalità-esistenti)
3. [Entità da Gestire](#entità-da-gestire)
4. [Struttura Pannello Admin Proposta](#struttura-pannello-admin-proposta)
5. [Sistema di Ruoli e Permessi](#sistema-ruoli-permessi)
6. [Specifiche Tecniche](#specifiche-tecniche)

---

## 🔍 Sistema Attuale

### Stack Tecnologico
- **Framework**: Laravel (con Livewire)
- **Frontend**: Livewire Components + Blade Templates
- **Database**: MySQL
- **Sistema Ruoli**: Temporaneo (TODO: migrare a Spatie Permission)

### Architettura
- **Pattern**: MVC + Livewire Components
- **Traits**: HasModeration, HasComments, HasLikes, HasViews, Reportable
- **Services**: BadgeService, LoggingService, ActivityService, etc.
- **Models**: 33+ modelli principali

---

## ✅ Funzionalità Esistenti

### 1. Admin Panel Parziale
- ✅ **ArticleLayoutManager** (`/admin/articles/layout`)
  - Gestione layout articoli nella homepage
  - Drag & drop posizionamento articoli
  - Search modal per selezionare articoli
  
- ✅ **BadgeManagement** (`app/Livewire/Admin/Gamification/BadgeManagement.php`)
  - CRUD badge (crea, modifica, elimina)
  - Upload icona badge
  - Toggle attivo/non attivo
  - Assegnazione manuale badge a utenti
  - Search utenti per assegnazione

- ✅ **UserBadges** (`app/Livewire/Admin/Gamification/UserBadges.php`)
  - Visualizza badge assegnati agli utenti
  - Filtri per badge e utente
  - Rimozione badge da utenti

### 2. Sistema di Moderazione
- ✅ **HasModeration Trait**
  - Stati: `pending`, `approved`, `rejected`
  - Metodi: `approve()`, `reject()`, `setPending()`
  - Auto-approval configurabile via SystemSetting
  - Logging automatico delle azioni di moderazione
  
- ✅ **Contenuti con Moderazione**
  - Articles (con status: draft, published, archived)
  - Videos
  - Poems
  - Events
  - Photos
  - Gigs
  - Carousels

### 3. Sistema di Report/Segnalazioni
- ✅ **Reportable Trait**
  - Relazioni polimorfe con Reports
  - Stati: `pending`, `reviewed`, `resolved`
  - Scopes: `activeReports()`, `pendingReports()`
  
- ✅ **ArticleReport Model**
  - Segnalazioni specifiche per articoli
  - Campi: reason, description, status

### 4. Activity Log
- ✅ **ActivityLog Model**
  - Categorie: auth, events, videos, users, admin, system, media, permissions, etc.
  - Livelli: info, warning, error, critical
  - Tracciamento IP, user agent, response time
  - Relazione polimorfa con modelli

### 5. System Settings
- ✅ **SystemSetting Model**
  - Gestione chiave-valore
  - Gruppi: upload, video, payment, system
  - Tipi: string, integer, boolean, json, float
  - Cache integrata

---

## 📦 Entità da Gestire

### 👥 1. Gestione Utenti
**Modello**: `User`
**Funzionalità necessarie**:
- ✅ Lista utenti con paginazione e filtri
- ✅ Visualizzazione dettagli utente
- ✅ Modifica profilo utente
- ✅ Gestione ruoli e permessi
- ✅ Ban/sospensione utenti
- ✅ Attivazione/disattivazione account
- ✅ Eliminazione utente (soft delete)
- ✅ Statistiche utente (contenuti, attività)
- ✅ Gestione badge utente (già parzialmente fatto)
- ✅ Storico attività utente

**Campi chiave**:
- name, nickname, email, status
- roles (temporaneo, da migrare a Spatie)
- created_at, last_seen_at
- profile_photo, banner_image

### 📰 2. Gestione Articoli
**Modello**: `Article`
**Funzionalità necessarie**:
- ✅ Lista articoli con filtri (stato, categoria, autore, data)
- ✅ Visualizzazione anteprima articolo
- ✅ Modifica articolo
- ✅ Eliminazione articolo
- ✅ Moderazione (approva, rifiuta, metti in attesa)
- ✅ Gestione categoria articolo
- ✅ Gestione tag articolo
- ✅ Toggle featured
- ✅ Gestione pubblicazione (published_at)
- ✅ Layout manager (già esiste)

**Campi chiave**:
- title, content, excerpt (JSON multi-lingua)
- status: draft, published, archived
- moderation_status: pending, approved, rejected
- category_id, user_id, featured
- views_count, likes_count, comments_count

### 🎬 3. Gestione Video
**Modello**: `Video`
**Funzionalità necessarie**:
- ✅ Lista video con filtri
- ✅ Visualizzazione video
- ✅ Modifica video
- ✅ Eliminazione video
- ✅ Moderazione (approva, rifiuta, metti in attesa)
- ✅ Gestione stato PeerTube
- ✅ Toggle visibilità (is_public)
- ✅ Statistiche visualizzazioni

**Campi chiave**:
- title, description
- moderation_status, is_public, status
- peertube_video_id, peertube_status
- views_count, likes_count, comments_count
- user_id

### 📝 4. Gestione Poesie
**Modello**: `Poem`
**Funzionalità necessarie**:
- ✅ Lista poesie con filtri
- ✅ Visualizzazione poesia
- ✅ Modifica poesia
- ✅ Eliminazione poesia
- ✅ Moderazione
- ✅ Gestione traduzioni
- ✅ Toggle visibilità

**Campi chiave**:
- title, content (JSON multi-lingua)
- slug, type, language
- moderation_status, is_public
- views_count, likes_count, comments_count
- user_id

### 🎪 5. Gestione Eventi
**Modello**: `Event`
**Funzionalità necessarie**:
- ✅ Lista eventi con filtri (stato, categoria, data, organizzatore)
- ✅ Visualizzazione dettagli evento
- ✅ Modifica evento
- ✅ Eliminazione evento
- ✅ Moderazione
- ✅ Gestione partecipanti
- ✅ Gestione scoring (già esiste parzialmente)
- ✅ Gestione inviti
- ✅ Toggle visibilità (is_public)

**Campi chiave**:
- title, description, category
- status: draft, published, cancelled, completed
- moderation_status
- start_datetime, end_datetime
- organizer_id, venue_owner_id
- max_participants, entry_fee
- is_public, is_online

### 💼 6. Gestione Gigs (Lavori/Traduzioni)
**Modello**: `Gig`
**Funzionalità necessarie**:
- ✅ Lista gigs con filtri
- ✅ Visualizzazione gig
- ✅ Modifica gig
- ✅ Eliminazione gig
- ✅ Moderazione
- ✅ Gestione applicazioni
- ✅ Gestione negoziazioni
- ✅ Toggle urgent/featured

**Campi chiave**:
- title, description
- moderation_status, status
- user_id, requester_id
- deadline, is_closed, is_urgent, is_featured
- positions (JSON)

### 📸 7. Gestione Foto
**Modello**: `Photo`
**Funzionalità necessarie**:
- ✅ Lista foto con filtri
- ✅ Visualizzazione foto
- ✅ Modifica foto
- ✅ Eliminazione foto
- ✅ Moderazione
- ✅ Toggle visibilità

### 🎠 8. Gestione Carousel
**Modello**: `Carousel`
**Funzionalità necessarie**:
- ✅ Lista carousel
- ✅ CRUD carousel
- ✅ Moderazione
- ✅ Gestione ordine

### ⚠️ 9. Gestione Report/Segnalazioni
**Modello**: `Report` (polimorfo)
**Funzionalità necessarie**:
- ✅ Lista report con filtri (stato, tipo contenuto, data)
- ✅ Visualizzazione dettagli report
- ✅ Gestione stato report (pending → reviewed → resolved)
- ✅ Azioni rapide (approva, rifiuta contenuto segnalato)
- ✅ Statistiche report
- ✅ Report per tipo contenuto (Articles, Videos, Poems, etc.)

**Campi chiave**:
- reportable_type, reportable_id (polimorfo)
- user_id, reason, description
- status: pending, reviewed, resolved
- reviewed_by, reviewed_at

### 🏷️ 10. Gestione Categorie e Tag
**Modelli**: `ArticleCategory`, `ArticleTag`
**Funzionalità necessarie**:
- ✅ CRUD categorie articoli
- ✅ CRUD tag articoli
- ✅ Gestione traduzioni categorie/tag
- ✅ Associazione articoli

### 👥 11. Gestione Gruppi (se presente)
**Modello**: `Group` (verificare esistenza)
**Funzionalità necessarie**:
- ✅ Lista gruppi
- ✅ Visualizzazione dettagli gruppo
- ✅ Modifica gruppo
- ✅ Eliminazione gruppo
- ✅ Gestione membri
- ✅ Gestione permessi

### 🎖️ 12. Gamification (parzialmente fatto)
**Modelli**: `Badge`, `UserBadge`, `UserPoints`, `PointTransaction`, `GamificationLevel`
**Funzionalità necessarie**:
- ✅ Gestione badge (già fatto - BadgeManagement)
- ✅ Gestione badge utenti (già fatto - UserBadges)
- ✅ Gestione livelli gamification
- ✅ Gestione punti utenti
- ✅ Transazioni punti (storico)
- ✅ Configurazione sistema punti

### 📊 13. Statistiche e Analytics
**Funzionalità necessarie**:
- ✅ Dashboard con statistiche generali
- ✅ Statistiche utenti (registrazioni, attivi, etc.)
- ✅ Statistiche contenuti (articoli, video, poesie pubblicate)
- ✅ Statistiche moderazione (contenuti in attesa, approvati, rifiutati)
- ✅ Statistiche report (pending, resolved)
- ✅ Statistiche eventi (creati, completati, etc.)
- ✅ Grafici temporali

### ⚙️ 14. Impostazioni Sistema
**Modello**: `SystemSetting`
**Funzionalità necessarie**:
- ✅ Gestione impostazioni per gruppo
  - Upload (dimensioni massime, tipi file)
  - Video (limiti upload, configurazione PeerTube)
  - Payment (Stripe, PayPal, commissioni)
  - System (manutenzione, registrazione)
  - Moderation (auto-approval per tipo contenuto)
- ✅ Interfaccia per modificare impostazioni
- ✅ Validazione valori

### 📜 15. Activity Log
**Modello**: `ActivityLog`
**Funzionalità necessarie**:
- ✅ Visualizzazione log attività
- ✅ Filtri per categoria, livello, utente, data
- ✅ Dettagli log entry
- ✅ Esportazione log
- ✅ Statistiche log

### 💬 16. Gestione Commenti (Unified)
**Modello**: `UnifiedComment`
**Funzionalità necessarie**:
- ✅ Lista commenti (tutti i tipi di contenuto)
- ✅ Filtri per tipo contenuto, autore, data
- ✅ Moderazione commenti
- ✅ Eliminazione commenti
- ✅ Risposte a commenti

---

## 🏗️ Struttura Pannello Admin Proposta

### Layout Base
```
/admin
├── /dashboard              (Dashboard principale)
├── /users                  (Gestione utenti)
│   ├── /                    (Lista utenti)
│   ├── /{user}             (Dettagli utente)
│   └── /{user}/edit        (Modifica utente)
├── /content                (Gestione contenuti)
│   ├── /articles           (Articoli)
│   ├── /videos             (Video)
│   ├── /poems              (Poesie)
│   ├── /events             (Eventi)
│   ├── /gigs               (Gigs)
│   ├── /photos             (Foto)
│   └── /carousels          (Carousel)
├── /moderation             (Moderazione)
│   ├── /pending            (Contenuti in attesa)
│   ├── /approved           (Contenuti approvati)
│   └── /rejected           (Contenuti rifiutati)
├── /reports                (Segnalazioni)
│   ├── /                    (Lista report)
│   ├── /pending            (Report in attesa)
│   └── /{report}           (Dettagli report)
├── /categories             (Categorie e Tag)
│   ├── /articles           (Categorie articoli)
│   └── /tags               (Tag articoli)
├── /gamification           (Gamification)
│   ├── /badges             (Gestione badge - già esiste)
│   ├── /user-badges        (Badge utenti - già esiste)
│   ├── /levels             (Livelli)
│   └── /points             (Punti e transazioni)
├── /groups                 (Gruppi - se presente)
├── /settings               (Impostazioni sistema)
│   ├── /general            (Impostazioni generali)
│   ├── /upload             (Impostazioni upload)
│   ├── /payment            (Impostazioni pagamenti)
│   └── /moderation         (Impostazioni moderazione)
├── /activity-log           (Log attività)
└── /articles/layout        (Layout articoli - già esiste)
```

### Menu Navigazione Proposto
1. **Dashboard** - Statistiche e overview
2. **Utenti** - Gestione utenti, ruoli, ban
3. **Contenuti**
   - Articoli
   - Video
   - Poesie
   - Eventi
   - Gigs
   - Foto
   - Carousel
4. **Moderazione** - Coda moderazione, contenuti pending
5. **Segnalazioni** - Gestione report
6. **Categorie & Tag** - Gestione categorie e tag
7. **Gamification** - Badge, livelli, punti
8. **Gruppi** - Gestione gruppi (se presente)
9. **Impostazioni** - Configurazione sistema
10. **Activity Log** - Log attività sistema

---

## 🔐 Sistema Ruoli e Permessi

### Situazione Attuale
- ✅ Sistema ruoli temporaneo in `User` model
- ❌ TODO: Migrare a Spatie Laravel Permission
- ✅ Metodi: `hasRole()`, `hasAnyRole()`, `isAdmin()`, `isModerator()`

### Ruoli Attuali
- `admin` - Accesso completo
- `moderator` - Moderazione contenuti
- `editor` - Gestione contenuti (articoli)
- `organizer` - Gestione eventi
- `poet` - Utente base
- `judge` - Giudice eventi
- `venue_owner` - Proprietario venue
- `audience` - Spettatore

### Permessi Necessari (da implementare)
- `admin.access` - Accesso pannello admin
- `admin.users.view` - Visualizzare utenti
- `admin.users.edit` - Modificare utenti
- `admin.users.delete` - Eliminare utenti
- `admin.content.view` - Visualizzare contenuti
- `admin.content.edit` - Modificare contenuti
- `admin.content.delete` - Eliminare contenuti
- `admin.content.moderate` - Moderare contenuti
- `admin.reports.view` - Visualizzare report
- `admin.reports.manage` - Gestire report
- `admin.settings.view` - Visualizzare impostazioni
- `admin.settings.edit` - Modificare impostazioni
- `admin.logs.view` - Visualizzare log

---

## 🛠️ Specifiche Tecniche

### Componenti Livewire da Creare

#### 1. Dashboard
- `App\Livewire\Admin\Dashboard\AdminDashboard.php`
- Statistiche principali
- Grafici (Chart.js o Alpine.js)
- Lista attività recenti
- Link rapidi

#### 2. Utenti
- `App\Livewire\Admin\Users\UserList.php` - Lista utenti
- `App\Livewire\Admin\Users\UserShow.php` - Dettagli utente
- `App\Livewire\Admin\Users\UserEdit.php` - Modifica utente
- Filtri: ruolo, stato, data registrazione
- Azioni: ban, attiva/disattiva, elimina

#### 3. Contenuti
Per ogni tipo di contenuto:
- `App\Livewire\Admin\Content\{Type}List.php` - Lista
- `App\Livewire\Admin\Content\{Type}Show.php` - Dettagli
- `App\Livewire\Admin\Content\{Type}Edit.php` - Modifica

Tipi: Articles, Videos, Poems, Events, Gigs, Photos, Carousels

#### 4. Moderazione
- `App\Livewire\Admin\Moderation\PendingContent.php` - Coda moderazione
- `App\Livewire\Admin\Moderation\ContentModeration.php` - Componente moderazione
- Filtri per tipo contenuto
- Azioni rapide: approva, rifiuta, metti in attesa

#### 5. Report
- `App\Livewire\Admin\Reports\ReportList.php` - Lista report
- `App\Livewire\Admin\Reports\ReportShow.php` - Dettagli report
- Filtri: stato, tipo contenuto, data
- Azioni: review, resolve

#### 6. Categorie e Tag
- `App\Livewire\Admin\Categories\CategoryManager.php` - Gestione categorie
- `App\Livewire\Admin\Categories\TagManager.php` - Gestione tag

#### 7. Settings
- `App\Livewire\Admin\Settings\SettingsManager.php` - Gestore generale
- Componenti per ogni gruppo di impostazioni

#### 8. Activity Log
- `App\Livewire\Admin\ActivityLog\ActivityLogList.php` - Lista log
- Filtri: categoria, livello, utente, data range
- Esportazione CSV

### Middleware
- `AdminMiddleware` - Verifica ruolo admin
- `PermissionMiddleware` - Verifica permessi specifici

### Layout Admin
- `resources/views/layouts/admin.blade.php` - Layout principale admin
- Menu sidebar
- Header con notifiche
- Footer

### Route Admin
Tutte le route admin dovrebbero essere sotto `/admin` con middleware `auth` e verifica ruolo.

---

## 📝 Note Implementazione

### Priorità Alta
1. ✅ Dashboard admin con statistiche
2. ✅ Gestione utenti (CRUD, ban)
3. ✅ Coda moderazione unificata
4. ✅ Gestione report
5. ✅ Impostazioni sistema

### Priorità Media
6. ✅ CRUD completo per tutti i contenuti
7. ✅ Gestione categorie/tag
8. ✅ Activity log viewer
9. ✅ Statistiche avanzate

### Priorità Bassa
10. ✅ Esportazioni dati
11. ✅ Notifiche admin
12. ✅ Ricerche avanzate

### Considerazioni
- Usare Livewire per interattività
- Paginazione per liste lunghe
- Filtri avanzati con Alpine.js
- Modal per azioni rapide
- Conferme per azioni distruttive
- Feedback utente (toast notifications)
- Responsive design
- Dark mode support

---

## 🚀 Prossimi Passi

1. ✅ Creare layout admin base
2. ✅ Implementare dashboard con statistiche
3. ✅ Implementare gestione utenti
4. ✅ Implementare coda moderazione
5. ✅ Implementare gestione report
6. ✅ Implementare CRUD contenuti
7. ✅ Implementare impostazioni sistema
8. ✅ Implementare activity log viewer
9. ✅ Testing completo
10. ✅ Documentazione finale

---

**Data Analisi**: 2025-01-XX
**Versione**: 1.0

