# Sistema di Pagamento per Traduzioni

## 📋 Panoramica

Il sistema di pagamento per le traduzioni è completamente integrato con Stripe e supporta sia pagamenti online che offline.

## 🔧 Componenti Implementati

### 1. **Modelli e Database**
- `TranslationPayment` - Gestisce i record di pagamento
- `translation_payments` table - Memorizza tutti i dati di pagamento
- Relazione `GigApplication::payment()` - Collega application e pagamento

### 2. **Servizi**
- `PaymentService` - Calcolo commissioni, formattazione importi
- `PayoutService` - Trasferimento fondi ai traduttori via Stripe Connect

### 3. **Componenti Livewire**
- `PaymentCheckout` - Pagina di checkout con Stripe Elements
- `PaymentSuccess` - Conferma pagamento e verifica PaymentIntent

### 4. **Route**
```php
/gigs/applications/{application}/payment          // Checkout
/gigs/applications/{application}/payment/success  // Success page
```

## 🚀 Configurazione Necessaria

### 1. **Variabili d'Ambiente (.env)**
```env
# Stripe API Keys
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

### 2. **System Settings (Admin Panel)**
Accedi a `/admin/settings/payment` e configura:
- **Commissione traduzioni (%)**: Default 10% (0.10)
- **Commissione fissa (€)**: Default 0.00€
- **Metodi di pagamento abilitati**: Stripe, PayPal
- **Stripe abilitato**: true
- **Modalità Stripe**: test / live

### 3. **Stripe Dashboard**
1. Vai su https://dashboard.stripe.com
2. Crea un account o accedi
3. Copia le chiavi API (Developers > API keys)
4. Configura i webhook (Developers > Webhooks):
   - Endpoint: `https://slamin.it/stripe/webhook`
   - Eventi: `payment_intent.succeeded`, `payment_intent.payment_failed`

## 💳 Flusso di Pagamento

### **Scenario 1: Pagamento Online (Stripe)**

1. **Traduzione Approvata**
   - L'autore vede il pulsante "💳 Procedi al Pagamento"
   
2. **Checkout Page**
   - Riepilogo: importo, commissione, totale
   - Form Stripe Elements per carta di credito
   - Calcolo automatico commissione piattaforma
   
3. **Pagamento**
   - Stripe elabora il pagamento
   - Redirect a pagina di successo
   - Verifica PaymentIntent
   - Aggiorna status a `completed`
   
4. **Post-Pagamento**
   - Email ricevuta al cliente
   - Notifica al traduttore
   - Traduzione disponibile
   - Application status → `completed`

### **Scenario 2: Pagamento Offline**

1. **Traduzione Approvata**
   - L'autore clicca "💳 Procedi al Pagamento"
   
2. **Checkout Page**
   - Seleziona tab "💰 Pagamento Offline"
   - Conferma di aver pagato tramite altri metodi
   
3. **Registrazione**
   - Pagamento registrato come `completed`
   - Payout status → `pending_manual`
   - Admin deve verificare manualmente
   
4. **Verifica Admin**
   - Admin accede a `/admin/payments/payouts`
   - Verifica il pagamento offline
   - Trasferisce fondi al traduttore

## 📊 Calcolo Commissioni

```php
Esempio con €100:
- Compenso traduttore: €100.00
- Commissione piattaforma (10%): €10.00
- Commissione fissa: €0.00
- TOTALE CLIENTE: €100.00
- RICEVE TRADUTTORE: €90.00
- RICEVE PIATTAFORMA: €10.00
```

## 🔐 Sicurezza

- **PCI Compliance**: Stripe gestisce tutti i dati delle carte
- **No Card Storage**: Nessun dato carta memorizzato nel database
- **3D Secure**: Supportato automaticamente da Stripe
- **Webhook Signature**: Verifica autenticità webhook Stripe

## 🛠️ Testing

### **Carte di Test Stripe**
```
Successo: 4242 4242 4242 4242
3D Secure: 4000 0025 0000 3155
Rifiutata: 4000 0000 0000 9995

CVV: qualsiasi 3 cifre
Data: qualsiasi data futura
```

### **Test Flow**
1. Crea un gig di traduzione
2. Applica come traduttore
3. Accetta l'application
4. Carica traduzione nel workspace
5. Invia per revisione
6. Approva traduzione (come autore)
7. Vai al checkout
8. Usa carta di test
9. Verifica pagamento completato

## 📈 Monitoraggio

### **Dashboard Admin**
- `/admin/payments/accounts` - Account pagamento utenti
- `/admin/payments/payouts` - Gestione payout ai traduttori

### **Logs**
```bash
# Verifica pagamenti
tail -f storage/logs/laravel.log | grep -i payment

# Errori Stripe
tail -f storage/logs/laravel.log | grep -i stripe
```

## 🐛 Troubleshooting

### **Errore: "Stripe key not found"**
```bash
# Verifica .env
cat .env | grep STRIPE

# Pulisci cache config
php artisan config:clear
```

### **Errore: "PaymentIntent creation failed"**
- Verifica chiavi Stripe corrette
- Controlla modalità (test vs live)
- Verifica saldo account Stripe

### **Pagamento non si completa**
- Controlla webhook configurati
- Verifica logs Stripe Dashboard
- Testa con carta di test

## 🔄 Prossimi Step (Opzionali)

### **Fase 1: Stripe Connect** (Per payout automatici)
1. Abilita Stripe Connect nell'admin
2. Traduttori collegano account Stripe
3. Payout automatici dopo pagamento

### **Fase 2: PayPal Integration**
1. Configura PayPal SDK
2. Aggiungi PayPal come metodo di pagamento
3. Implementa webhook PayPal

### **Fase 3: Fatturazione**
1. Genera fatture PDF
2. Invio automatico via email
3. Archivio fatture nel profilo

## 📞 Supporto

Per problemi con i pagamenti:
1. Controlla logs Laravel
2. Verifica Stripe Dashboard
3. Contatta supporto Stripe se necessario

---

**Ultimo aggiornamento**: 2 Dicembre 2025
**Versione**: 1.0.0

