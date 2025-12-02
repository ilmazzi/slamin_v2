# Flusso Pagamento Gig - Analisi e Implementazione

## 📋 Situazione Attuale

Quando un proprietario di gig **accetta una candidatura**:
- ✅ Application status → `accepted`
- ✅ Gig status → `closed`
- ✅ Notifica inviata al candidato
- ❌ **MANCA**: Gestione pagamento
- ❌ **MANCA**: Tracking in dashboard

## 🎯 Requisiti

### Opzione 1: Pagamento Immediato
1. Dopo accettazione → Redirect a pagina pagamento
2. Integrazione Stripe/PayPal
3. Escrow (soldi trattenuti fino a completamento)
4. Rilascio pagamento quando traduzione completata

### Opzione 2: Salva per Dopo (PIÙ SEMPLICE) ⭐
1. Dopo accettazione → Salva nella dashboard
2. Sezione "Lavori Accettati" per richiedente
3. Sezione "Lavori Assegnati" per traduttore
4. Pulsante "Procedi al Pagamento" quando pronto
5. Pulsante "Marca come Completato"

## 🛠️ Implementazione Consigliata: Opzione 2

### 1. Dashboard Sections (Già esistente?)

Verificare se esiste già:
- `/dashboard` - Dashboard utente
- Tab "I Miei Gig"
- Tab "Candidature"

### 2. Nuove Sezioni Dashboard

**Per Richiedente (Owner):**
```
📋 Lavori da Pagare
- Gig accettati
- Candidato assegnato
- Compenso concordato
- [Procedi al Pagamento] [Marca Completato]
```

**Per Traduttore (Applicant):**
```
✍️ Lavori Assegnati
- Gig ricevuti
- Compenso concordato
- Deadline
- [Carica Traduzione] [Contatta Cliente]
```

### 3. Stati Application

Aggiungere nuovi stati:
- `pending` - In attesa
- `accepted` - Accettato (ATTUALE)
- `in_progress` - In corso (NUOVO)
- `completed` - Completato (NUOVO)
- `paid` - Pagato (NUOVO)
- `rejected` - Rifiutato

### 4. Tabella Payments (Futura)

```sql
CREATE TABLE gig_payments (
    id BIGINT PRIMARY KEY,
    gig_application_id BIGINT,
    amount DECIMAL(10,2),
    currency VARCHAR(3) DEFAULT 'EUR',
    payment_method VARCHAR(50), -- stripe, paypal, bank_transfer
    payment_intent_id VARCHAR(255), -- Stripe payment intent
    status VARCHAR(50), -- pending, completed, failed, refunded
    paid_at TIMESTAMP,
    created_at TIMESTAMP
);
```

### 5. Flusso Completo

```
1. Candidatura inviata → status: pending
2. Negoziazione → messaggi scambiati
3. Accettazione → status: accepted
   ↓
4. Dashboard richiedente:
   - "Hai accettato [Nome] per [Gig]"
   - [Procedi al Pagamento] → Stripe/PayPal
   - [Marca come Completato] → se pagamento offline
   ↓
5. Pagamento completato → status: paid
   ↓
6. Traduttore carica lavoro → status: completed
   ↓
7. Richiedente conferma → Chiusura definitiva
```

## 💡 Implementazione Minima (SUBITO)

### Step 1: Dashboard Widget (1-2 ore)

Aggiungere in `/dashboard`:

**Richiedente:**
```blade
@if($acceptedGigs->count() > 0)
<div class="bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-300 dark:border-yellow-700 rounded-xl p-6">
    <h3 class="font-bold text-yellow-900 dark:text-yellow-100 mb-4">
        ⚠️ Lavori Accettati - Azione Richiesta
    </h3>
    @foreach($acceptedGigs as $gig)
        <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 mb-3">
            <h4 class="font-bold">{{ $gig->title }}</h4>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                Traduttore: {{ $gig->acceptedApplication->user->name }}
            </p>
            <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                Compenso: {{ $gig->acceptedApplication->proposed_compensation }}
            </p>
            <div class="flex gap-2 mt-3">
                <a href="#" class="px-4 py-2 bg-green-600 text-white rounded-lg">
                    💳 Procedi al Pagamento
                </a>
                <button class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 rounded-lg">
                    ✓ Marca Completato
                </button>
            </div>
        </div>
    @endforeach
</div>
@endif
```

**Traduttore:**
```blade
@if($assignedGigs->count() > 0)
<div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-300 dark:border-green-700 rounded-xl p-6">
    <h3 class="font-bold text-green-900 dark:text-green-100 mb-4">
        ✍️ Lavori Assegnati
    </h3>
    @foreach($assignedGigs as $application)
        <div class="bg-white dark:bg-neutral-800 rounded-lg p-4 mb-3">
            <h4 class="font-bold">{{ $application->gig->title }}</h4>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                Cliente: {{ $application->gig->user->name }}
            </p>
            <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                Compenso: {{ $application->proposed_compensation }}
            </p>
            <a href="{{ route('gigs.show', $application->gig) }}" 
               class="inline-block mt-3 px-4 py-2 bg-primary-600 text-white rounded-lg">
                Visualizza Dettagli
            </a>
        </div>
    @endforeach
</div>
@endif
```

### Step 2: Metodi nel Controller

```php
// In DashboardIndex.php o nuovo DashboardGigs.php

public function getAcceptedGigsProperty()
{
    return Gig::where('user_id', Auth::id())
        ->whereHas('applications', fn($q) => $q->where('status', 'accepted'))
        ->with('acceptedApplication.user')
        ->get();
}

public function getAssignedGigsProperty()
{
    return GigApplication::where('user_id', Auth::id())
        ->where('status', 'accepted')
        ->with('gig.user')
        ->get();
}
```

## 🚀 Prossimi Passi

1. ✅ **FATTO**: Fix notifiche duplicate
2. ✅ **FATTO**: Blocca chat dopo accept/reject
3. ✅ **FATTO**: Mantieni storico messaggi
4. 🟡 **TODO**: Widget dashboard (richiede decisione utente)
5. 🔴 **FUTURO**: Integrazione pagamenti Stripe/PayPal

---

**Vuoi che implementi i widget nella dashboard ora?**

