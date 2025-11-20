# Piano Conversione Controller Admin → Livewire Components

## 📋 Strategia di Conversione

Convertiremo tutti i controller admin di **slamin** in componenti Livewire 3 seguendo la [documentazione ufficiale Livewire](https://livewire.laravel.com/docs/3.x/quickstart).

## ✅ Componenti Completati

### 1. AdminDashboard ✅
- **File**: `app/Livewire/Admin/Dashboard/AdminDashboard.php`
- **Vista**: `resources/views/livewire/admin/dashboard/admin-dashboard.blade.php` (da creare)
- **Route**: `/admin/dashboard` → `AdminDashboard::class`
- **Stato**: Componente creato, vista da creare

## 📝 Componenti da Convertire (Priorità)

### Priorità Alta

1. **UserController** → `Admin/Users/UserList`
   - Lista utenti con paginazione
   - Filtri e ricerca
   - Modifica/eliminazione utente
   - Gestione ruoli e permessi

2. **ModerationController** → `Admin/Moderation/ModerationIndex`
   - Dashboard moderazione
   - Coda contenuti pending
   - Azioni approva/rifiuta/metti in attesa
   - Filtri per tipo contenuto

3. **ArticleController** → `Admin/Articles/ArticleList`
   - Lista articoli
   - CRUD articoli
   - Moderazione articoli

4. **SystemSettingsController** → `Admin/Settings/SystemSettings`
   - Gestione impostazioni sistema
   - Gruppi impostazioni (upload, payment, system, etc.)

### Priorità Media

5. **LogsController** → `Admin/Logs/LogList`
   - Visualizzazione log attività
   - Filtri log
   - Download log

6. **PaymentSettingsController** → `Admin/Settings/PaymentSettings`
   - Impostazioni pagamenti
   - Configurazione Stripe/PayPal

7. **UploadSettingsController** → `Admin/Settings/UploadSettings`
   - Impostazioni upload
   - Limiti file

8. **PlaceholderSettingsController** → `Admin/Settings/PlaceholderSettings`
   - Impostazioni placeholder

### Priorità Bassa

9. **CarouselController** → `Admin/Carousels/CarouselList`
10. **PaymentAccountsController** → `Admin/PaymentAccounts/PaymentAccountList`
11. **PeerTubeController** → `Admin/PeerTube/PeerTubeIndex`
12. **TranslationController** → `Admin/Translations/TranslationEditor`
13. **TranslationManagementController** → `Admin/Translations/TranslationManagement`
14. **GigPositionController** → `Admin/GigPositions/GigPositionList`
15. **KanbanController** → `Admin/Kanban/KanbanBoard`
16. **PayoutController** → `Admin/Payouts/PayoutList`
17. **SocialSettingsController** → `Admin/Settings/SocialSettings`
18. **TestLogsController** → `Admin/Logs/TestLogs`
19. **LogController** → `Admin/Logs/LogShow` (se diverso da LogsController)

## 🔧 Pattern di Conversione

### Struttura Componente Livewire

```php
<?php

namespace App\Livewire\Admin\{Section};

use Livewire\Component;
use Livewire\WithPagination; // Se serve paginazione
use Livewire\WithFileUploads; // Se serve upload file
use Illuminate\Support\Facades\Auth;
use App\Models\{Model};

class {ComponentName} extends Component
{
    use WithPagination; // Opzionale
    
    // Public properties (reactive)
    public $property1 = '';
    public $property2 = [];
    
    // URL query parameters (Livewire 3)
    #[Url]
    public $filter = '';
    
    // Mount method (equivalente a constructor/index)
    public function mount()
    {
        // Verifica permessi admin
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
        
        // Inizializzazione
    }
    
    // Public methods (actions - possono essere chiamate dal browser)
    public function actionName($param)
    {
        // Logica azione
    }
    
    // Computed properties (accessibili come $this->propertyName)
    public function getComputedPropertyProperty()
    {
        return // calcolo
    }
    
    // Render method (sempre presente)
    public function render()
    {
        return view('livewire.admin.{section}.{component-name}')
            ->layout('components.layouts.app');
    }
}
```

### Convertire Metodi Controller → Metodi Livewire

1. **index()** → `mount()` + `render()`
   - Logica iniziale in `mount()`
   - Dati per vista in `render()` o computed properties

2. **show($id)** → `mount($model)` + `render()`
   - Model binding in `mount()`
   - Vista dettagli in `render()`

3. **create()** → `mount()` + form properties + `store()`
   - Form inizializzato in `mount()`
   - Proprietà pubbliche per campi form
   - `store()` per salvataggio

4. **store(Request $request)** → `store()` method
   - Validazione con `$this->validate()`
   - Salvataggio
   - Redirect con `$this->redirect()`

5. **update(Request $request, $id)** → `update($id)` method
   - Similar a store ma con model esistente

6. **destroy($id)** → `delete($id)` method
   - Eliminazione
   - Redirect o emit event

### Gestione Form e Validazione

```php
// Validazione in Livewire
public function save()
{
    $this->validate([
        'field1' => 'required|string|max:255',
        'field2' => 'nullable|email',
    ]);
    
    // Salvataggio
    Model::create([
        'field1' => $this->field1,
        'field2' => $this->field2,
    ]);
    
    session()->flash('message', 'Salvato con successo!');
    
    return $this->redirect(route('admin.model.index'), navigate: true);
}
```

### Gestione File Upload

```php
use Livewire\WithFileUploads;

class Component extends Component
{
    use WithFileUploads;
    
    public $file;
    
    public function save()
    {
        $this->validate([
            'file' => 'image|max:2048',
        ]);
        
        $path = $this->file->store('uploads', 'public');
        // Salvataggio path
    }
}
```

### Paginazione

```php
use Livewire\WithPagination;

class Component extends Component
{
    use WithPagination;
    
    public function render()
    {
        $items = Model::paginate(10);
        
        return view('livewire.admin.section.component', [
            'items' => $items
        ])->layout('components.layouts.app');
    }
}
```

### Filtri e Ricerca

```php
#[Url] // Mantiene filtro nell'URL
public $search = '';

#[Url]
public $status = 'all';

public function updatingSearch() // Hook quando search cambia
{
    $this->resetPage(); // Reset paginazione
}

public function render()
{
    $query = Model::query();
    
    if ($this->search) {
        $query->where('name', 'like', '%' . $this->search . '%');
    }
    
    if ($this->status !== 'all') {
        $query->where('status', $this->status);
    }
    
    $items = $query->paginate(10);
    
    return view('livewire.admin.section.component', [
        'items' => $items
    ])->layout('components.layouts.app');
}
```

## 📂 Struttura File

```
app/Livewire/Admin/
├── Dashboard/
│   └── AdminDashboard.php ✅
├── Users/
│   ├── UserList.php (da creare)
│   ├── UserShow.php (da creare)
│   └── UserEdit.php (da creare)
├── Moderation/
│   └── ModerationIndex.php (da creare)
├── Articles/
│   ├── ArticleList.php (da creare)
│   └── ArticleEdit.php (da creare)
├── Settings/
│   ├── SystemSettings.php (da creare)
│   ├── PaymentSettings.php (da creare)
│   └── UploadSettings.php (da creare)
├── Logs/
│   └── LogList.php (da creare)
└── ...

resources/views/livewire/admin/
├── dashboard/
│   └── admin-dashboard.blade.php (da creare)
├── users/
│   ├── user-list.blade.php (da creare)
│   └── user-edit.blade.php (da creare)
├── moderation/
│   └── moderation-index.blade.php (da creare)
├── articles/
│   └── article-list.blade.php (da creare)
└── ...
```

## 🛣️ Route Livewire

```php
// routes/web.php

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard\AdminDashboard::class)
        ->name('dashboard');
    
    // Users
    Route::get('/users', \App\Livewire\Admin\Users\UserList::class)
        ->name('users.index');
    
    // Moderation
    Route::get('/moderation', \App\Livewire\Admin\Moderation\ModerationIndex::class)
        ->name('moderation.index');
    
    // Articles
    Route::get('/articles', \App\Livewire\Admin\Articles\ArticleList::class)
        ->name('articles.index');
    
    // Settings
    Route::get('/settings', \App\Livewire\Admin\Settings\SystemSettings::class)
        ->name('settings.index');
});
```

## ✅ Checklist Conversione

Per ogni controller:

- [ ] Creare componente Livewire in `app/Livewire/Admin/{Section}/{ComponentName}.php`
- [ ] Convertire `mount()` con verifica permessi admin
- [ ] Convertire metodi pubblici in azioni Livewire
- [ ] Convertire computed properties dove necessario
- [ ] Creare vista Blade in `resources/views/livewire/admin/{section}/{component-name}.blade.php`
- [ ] Adattare vista per usare proprietà Livewire invece di variabili
- [ ] Convertire form per usare `wire:model`
- [ ] Convertire link/button per usare `wire:click` dove necessario
- [ ] Aggiornare route per usare componente Livewire
- [ ] Testare funzionalità

## 📚 Riferimenti

- [Livewire 3.x Quickstart](https://livewire.laravel.com/docs/3.x/quickstart)
- [Livewire 3.x Components](https://livewire.laravel.com/docs/3.x/components)
- [Livewire 3.x Forms](https://livewire.laravel.com/docs/3.x/forms)
- [Livewire 3.x Pagination](https://livewire.laravel.com/docs/3.x/pagination)

## 🚀 Prossimi Passi

1. ✅ Completare vista AdminDashboard
2. ⏭️ Convertire UserController
3. ⏭️ Convertire ModerationController
4. ⏭️ Convertire ArticleController
5. ⏭️ Convertire SystemSettingsController
6. ⏭️ Continuare con gli altri controller

