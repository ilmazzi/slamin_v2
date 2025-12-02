# Setup Finale Sistema Pagamenti

## ✅ **Configurazione Implementata**

### **1. Commissioni a Carico del Cliente**

Il cliente (autore) paga **TUTTO**:
- ✅ Compenso traduttore
- ✅ Commissione Slamin (10%)
- ✅ Commissione Stripe (2.9% + €0.25)

### **2. Metodi di Pagamento Accettati**

**SOLO wallet digitali:**
- 💙 **PayPal**
- 🤖 **Google Pay**
- 🍎 **Apple Pay**

**NO carte di credito/debito** (per ora)

---

## 💰 **Esempio Calcolo**

### **Traduzione da €100:**

```
┌─────────────────────────────────────┐
│ RIEPILOGO PAGAMENTO                 │
├─────────────────────────────────────┤
│ Compenso traduttore:    €100.00     │
│ Commissione servizio:    €10.00     │
│ Costi di elaborazione:    €3.29     │
├─────────────────────────────────────┤
│ TOTALE DA PAGARE:       €113.29     │
└─────────────────────────────────────┘
```

**Flusso dei Soldi:**
```
Cliente paga: €113.29
    ↓
Stripe prende: €3.29 (2.9% + €0.25)
    ↓
Slamin riceve: €110.00
    ↓
Slamin trattiene: €10.00 (commissione)
    ↓
Traduttore riceve: €100.00 (come concordato!)
```

**Guadagno Netto Slamin: €10.00** 🎯

---

## 📊 **Confronto con Sistema Precedente**

### **Prima (commissioni su Slamin):**
```
Cliente paga: €100.00
Stripe prende: €2.90
Slamin riceve: €97.10
Slamin trattiene: €10.00
Traduttore riceve: €87.10
────────────────────────
Guadagno Slamin: €7.10
```

### **Adesso (commissioni su cliente):**
```
Cliente paga: €113.29
Stripe prende: €3.29
Slamin riceve: €110.00
Slamin trattiene: €10.00
Traduttore riceve: €100.00
────────────────────────
Guadagno Slamin: €10.00
```

**Differenza: +€2.90 per transazione (+41%!)** 🚀

---

## 🎯 **Vantaggi della Soluzione**

### **Per Slamin:**
- ✅ **+41% di guadagno** per transazione
- ✅ **Commissioni prevedibili** (sempre 10%)
- ✅ **Nessun costo nascosto**
- ✅ **Scalabile**

### **Per il Traduttore:**
- ✅ **Riceve esattamente** quanto concordato
- ✅ **Nessuna sorpresa** sul compenso
- ✅ **Trasparente**

### **Per il Cliente:**
- ✅ **Breakdown chiaro** di tutti i costi
- ✅ **Nessuna sorpresa** dopo
- ✅ **Metodi di pagamento popolari** (PayPal, Google Pay, Apple Pay)

---

## 🔧 **Configurazione Stripe Dashboard**

### **1. Abilita PayPal**
1. Vai su https://dashboard.stripe.com
2. **Settings** → **Payment methods**
3. Abilita **PayPal**
4. Configura webhook per PayPal

### **2. Abilita Google Pay**
1. Già abilitato di default
2. Verifica in **Payment methods**

### **3. Abilita Apple Pay**
1. Già abilitato di default
2. Verifica dominio in **Settings** → **Apple Pay**

### **4. Disabilita Carte (Opzionale)**
Se vuoi forzare solo wallet:
1. **Settings** → **Payment methods**
2. Disabilita **Cards**

**NOTA**: Con la configurazione attuale nel codice, le carte non vengono mostrate anche se abilitate in Stripe.

---

## 📱 **Come Appare al Cliente**

### **Pagina Checkout:**

```
┌─────────────────────────────────────┐
│ Riepilogo                           │
├─────────────────────────────────────┤
│ Traduttore: Mario Rossi             │
│ Poesia: "La Notte Stellata"        │
│                                     │
│ Compenso traduttore:    €100.00     │
│ Commissione servizio:    €10.00     │
│ Costi di elaborazione:    €3.29     │
│ ─────────────────────────────────   │
│ TOTALE:                 €113.29     │
│                                     │
│ Il traduttore riceverà €100.00      │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ Metodo di Pagamento                 │
├─────────────────────────────────────┤
│ ℹ️ Metodi accettati:                │
│ 💙 PayPal  🤖 Google Pay  🍎 Apple Pay│
│                                     │
│ [Seleziona metodo di pagamento]    │
│                                     │
│ [Paga €113.29]                      │
└─────────────────────────────────────┘
```

---

## 🧪 **Testing**

### **Test con Stripe:**

1. **Configura chiavi test** nel `.env`:
```env
STRIPE_PUBLIC_KEY=pk_test_51...
STRIPE_SECRET_KEY=sk_test_51...
```

2. **Test PayPal via Stripe:**
   - Usa account PayPal Sandbox
   - Email: `sb-xxxxx@personal.example.com`

3. **Test Google Pay:**
   - Usa Chrome con account Google test
   - Aggiungi carta test: `4242 4242 4242 4242`

4. **Test Apple Pay:**
   - Usa Safari su Mac/iPhone
   - Aggiungi carta test in Wallet

---

## 💡 **Best Practices**

### **1. Comunicazione Trasparente**
Mostra sempre il breakdown completo:
- ✅ Compenso traduttore
- ✅ Commissione servizio
- ✅ Costi elaborazione

### **2. Conferma Prima del Pagamento**
```
"Stai per pagare €113.29 per la traduzione di [Titolo].
Il traduttore riceverà €100.00 come concordato."
```

### **3. Email di Conferma**
Invia email con:
- Riepilogo pagamento
- Ricevuta PDF
- Link alla traduzione

---

## 📈 **Proiezioni Guadagno**

### **100 traduzioni/mese da €100:**

| Mese | Entrate | Commissioni | Guadagno Netto |
|------|---------|-------------|----------------|
| 1 | €11,329 | €329 | €1,000 |
| 3 | €33,987 | €987 | €3,000 |
| 6 | €67,974 | €1,974 | €6,000 |
| 12 | €135,948 | €3,948 | €12,000 |

**Guadagno annuo: €12,000!** 💰

---

## ⚙️ **Configurazione .env**

```env
# Stripe
STRIPE_PUBLIC_KEY=pk_test_51...
STRIPE_SECRET_KEY=sk_test_51...
STRIPE_WEBHOOK_SECRET=whsec_...

# System Settings (via admin panel)
# Commissione Slamin: 10% (0.10)
# Commissione fissa: €0.00
```

---

## 🚀 **Next Steps**

### **Per Andare Live:**

1. ✅ Testa in locale con chiavi test
2. ✅ Verifica calcoli commissioni
3. ✅ Testa tutti i metodi di pagamento
4. ✅ Configura webhook Stripe
5. ✅ Passa a chiavi live in produzione
6. ✅ Testa con pagamento reale piccolo (€1)
7. ✅ Monitora prime transazioni

### **Opzionale (Futuro):**

- [ ] Implementa Stripe Connect per payout automatici
- [ ] Aggiungi supporto carte (se richiesto)
- [ ] Implementa fatturazione automatica
- [ ] Dashboard analytics pagamenti

---

## ❓ FAQ

### **Q: Il cliente può pagare con carta?**
**A:** No, per ora solo PayPal, Google Pay, Apple Pay. Puoi abilitare le carte rimuovendo la configurazione `paymentMethodOrder` nello script Stripe.

### **Q: Posso cambiare la commissione?**
**A:** Sì, vai su `/admin/settings/payment` e modifica la percentuale.

### **Q: Come faccio il payout al traduttore?**
**A:** Per ora manualmente via bonifico. In futuro: Stripe Connect automatico.

### **Q: E se il cliente vuole un rimborso?**
**A:** Gestisci tramite Stripe Dashboard → Payments → Refund. Il sistema aggiorna automaticamente lo status.

---

**Ultimo aggiornamento**: 2 Dicembre 2025  
**Versione**: 2.0.0 (Commissioni su Cliente)

