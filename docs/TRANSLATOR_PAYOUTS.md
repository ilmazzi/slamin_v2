# Come i Traduttori Ricevono il Pagamento

## 🎯 La Tua Domanda

> **"Se usano la carta, i traduttori come ricevono il pagamento?"**

Ottima domanda! Ecco come funziona:

---

## 💰 Sistema di Payout

### **Scenario Attuale (Già Implementato)**

Quando un cliente paga con carta (o PayPal via Stripe):

1. **Cliente paga €100** per una traduzione
2. **Stripe trattiene** la commissione (~2.9% + €0.25 = €3.15)
3. **Slamin riceve** €96.85 sul conto Stripe
4. **Slamin calcola** la sua commissione (es. 10% = €10)
5. **Resta da pagare al traduttore**: €90

### **Come il Traduttore Riceve i Soldi?**

Ci sono **3 opzioni**:

---

## 🔵 **Opzione 1: Stripe Connect** (Automatico - Consigliato)

### **Come Funziona:**

1. **Traduttore collega il suo conto bancario** a Stripe Connect
2. **Quando il pagamento è completato**, Stripe trasferisce automaticamente i €90 al traduttore
3. **Tempo di arrivo**: 2-7 giorni lavorativi sul conto bancario

### **Vantaggi:**
- ✅ **Automatico** - nessun intervento manuale
- ✅ **Veloce** - 2-7 giorni
- ✅ **Sicuro** - gestito da Stripe
- ✅ **Tracciabile** - storico completo
- ✅ **Commissioni basse** - Stripe Connect è gratuito per trasferimenti

### **Svantaggi:**
- ❌ Traduttore deve collegare il conto bancario
- ❌ Richiede verifica identità (KYC)

### **Implementazione:**

Già parzialmente implementato in:
- `app/Services/PayoutService.php` - Gestisce trasferimenti Stripe Connect
- `app/Models/User.php` - Ha campi `stripe_connect_account_id`, `stripe_connect_status`
- `database/migrations/2025_09_08_105654_add_payment_accounts_to_users_table.php`

**Cosa serve fare:**
1. Traduttore va su "Impostazioni" → "Metodi di Pagamento"
2. Clicca "Collega Stripe Connect"
3. Inserisce dati bancari
4. Stripe verifica identità
5. **FATTO!** Riceverà pagamenti automatici

---

## 🟢 **Opzione 2: Bonifico Manuale** (Semplice)

### **Come Funziona:**

1. **Admin vede pagamento completato** nella dashboard
2. **Admin fa bonifico bancario** manuale al traduttore
3. **Admin marca il payout come completato** nel sistema

### **Vantaggi:**
- ✅ **Nessuna configurazione** per il traduttore
- ✅ **Nessuna verifica** KYC necessaria
- ✅ **Flessibile** - puoi usare qualsiasi metodo

### **Svantaggi:**
- ❌ **Manuale** - richiede intervento admin
- ❌ **Lento** - dipende da quando fai il bonifico
- ❌ **Più lavoro** per te

### **Implementazione:**

Già implementato:
- Dashboard admin mostra pagamenti da processare
- Campo `payout_status` in `translation_payments`:
  - `pending` = da pagare
  - `pending_manual` = bonifico manuale richiesto
  - `transferred` = pagato

---

## 🟡 **Opzione 3: PayPal Payout** (Alternativa)

### **Come Funziona:**

1. **Traduttore fornisce email PayPal**
2. **Quando pagamento completato**, sistema invia payout via PayPal API
3. **Traduttore riceve** su conto PayPal

### **Vantaggi:**
- ✅ **Veloce** - quasi istantaneo
- ✅ **Popolare** - molti hanno PayPal
- ✅ **Automatico** - nessun intervento manuale

### **Svantaggi:**
- ❌ **Commissioni** - PayPal prende ~2% sul payout
- ❌ **Richiede integrazione** PayPal Payouts API
- ❌ **Doppia commissione** - Stripe + PayPal

### **Implementazione:**

Parzialmente implementato:
- Campi `paypal_email`, `paypal_verified` in tabella `users`
- Da implementare: PayPal Payouts API

---

## 📊 Confronto Opzioni

| Caratteristica | Stripe Connect | Bonifico Manuale | PayPal Payout |
|----------------|----------------|------------------|---------------|
| **Velocità** | 2-7 giorni | 1-3 giorni | Istantaneo |
| **Automatico** | ✅ Sì | ❌ No | ✅ Sì |
| **Commissioni** | Gratis | Gratis | ~2% |
| **Setup traduttore** | KYC richiesto | Solo IBAN | Solo email |
| **Lavoro admin** | Zero | Alto | Zero |

---

## 🎯 La Mia Raccomandazione

### **Per Slamin:**

**Usa Stripe Connect come metodo principale + Bonifico Manuale come fallback**

#### **Perché?**
1. **Stripe Connect** è automatico e scalabile
2. **Bonifico Manuale** per chi non vuole/può usare Stripe Connect
3. **Nessuna doppia commissione** (come con PayPal)
4. **Tutto in un unico dashboard** (Stripe)

#### **Flusso Ideale:**

```
Cliente paga €100 con carta
    ↓
Stripe riceve €96.85 (dopo commissione Stripe)
    ↓
Slamin trattiene €10 (commissione piattaforma)
    ↓
Resta €86.85 per il traduttore
    ↓
┌─────────────────────────────────┐
│ Traduttore ha Stripe Connect?   │
└─────────────────────────────────┘
        ↓                    ↓
       SÌ                   NO
        ↓                    ↓
  Trasferimento          Admin fa
  automatico             bonifico
  in 2-7 giorni          manuale
```

---

## 🔧 Implementazione Tecnica

### **Stripe Connect (Già Pronto al 80%)**

#### **Lato Traduttore:**

1. **Pagina "Metodi di Pagamento"** nel profilo
2. **Pulsante "Collega Stripe Connect"**
3. **Redirect a Stripe** per onboarding
4. **Stripe verifica** identità e conto bancario
5. **Redirect back** a Slamin
6. **Status aggiornato** a `connected`

#### **Lato Sistema:**

```php
// Quando pagamento completato
$payment = TranslationPayment::find($id);

if ($payment->translator->stripe_connect_account_id) {
    // Trasferimento automatico
    $payoutService = new PayoutService();
    $payoutService->transferToTranslator($payment);
} else {
    // Marca come "da pagare manualmente"
    $payment->update(['payout_status' => 'pending_manual']);
}
```

Già implementato in:
- `app/Services/PayoutService.php` → `transferToTranslator()`

---

## 📋 Checklist Implementazione

### **Già Fatto:**
- ✅ Database fields per Stripe Connect
- ✅ `PayoutService` per trasferimenti
- ✅ `TranslationPayment` model con payout tracking
- ✅ Calcolo commissioni automatico

### **Da Fare:**
- [ ] Pagina "Metodi di Pagamento" nel profilo traduttore
- [ ] Pulsante "Collega Stripe Connect"
- [ ] Onboarding flow Stripe Connect
- [ ] Dashboard admin per payout manuali
- [ ] Notifiche email per payout completati

---

## 💡 Esempio Pratico

### **Scenario: Mario traduce una poesia per €100**

1. **Cliente paga €100** con carta Visa
2. **Stripe prende €3.15** (commissione)
3. **Slamin riceve €96.85**
4. **Slamin calcola commissione**: 10% di €100 = €10
5. **Mario deve ricevere**: €100 - €10 = €90

#### **Se Mario ha Stripe Connect:**
- Sistema trasferisce automaticamente **€90** a Mario
- Arrivano sul suo conto in **2-7 giorni**
- Mario riceve **notifica email**
- **ZERO lavoro per te**

#### **Se Mario NON ha Stripe Connect:**
- Sistema marca payout come `pending_manual`
- **Tu vedi nella dashboard** "Mario da pagare: €90"
- **Tu fai bonifico** a Mario
- **Tu marchi come pagato** nel sistema
- Mario riceve i soldi in **1-3 giorni**

---

## ❓ FAQ

### **Q: I traduttori pagano commissioni per ricevere?**
**A:** 
- **Stripe Connect**: NO, gratis
- **Bonifico**: NO, gratis
- **PayPal**: SÌ, ~2%

### **Q: Quanto tempo ci vuole?**
**A:**
- **Stripe Connect**: 2-7 giorni lavorativi
- **Bonifico**: 1-3 giorni lavorativi
- **PayPal**: Istantaneo

### **Q: Il traduttore DEVE avere Stripe Connect?**
**A:** NO! Può ricevere bonifico manuale. Ma Stripe Connect è più comodo per tutti.

### **Q: Posso tenere i soldi su Slamin e pagare dopo?**
**A:** SÌ! Il campo `payout_status` permette di:
- Trattenere i soldi
- Pagare in batch (es. una volta al mese)
- Gestire dispute prima di pagare

### **Q: E se c'è una disputa?**
**A:** 
1. **NON trasferire** al traduttore finché non è risolta
2. Stripe tiene i soldi in "pending"
3. Risolvi la disputa
4. Poi trasferisci (o rimborsa)

---

## 🚀 Next Steps

**Per attivare Stripe Connect:**

1. Vai su https://dashboard.stripe.com
2. Attiva **Stripe Connect**
3. Configura **Standard Account** (più semplice)
4. Copia le chiavi API
5. Implementa la pagina "Metodi di Pagamento"

**Vuoi che implementi la pagina per collegare Stripe Connect?** 🎯

---

**Ultimo aggiornamento**: 2 Dicembre 2025  
**Versione**: 1.0.0

