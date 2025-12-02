# Guida ai Metodi di Pagamento

## 🎯 Panoramica

Slamin supporta **3 metodi di pagamento** per le traduzioni:

1. **PayPal** (Consigliato) 💙
2. **Carta di Credito** (via Stripe) 💳
3. **Pagamento Offline** 💰

---

## 💙 PayPal (Metodo Principale)

### **Perché PayPal è consigliato?**
- ✅ Più usato in Italia
- ✅ Nessuna carta di credito necessaria
- ✅ Protezione acquirente inclusa
- ✅ Pagamento immediato
- ✅ Supporta saldo PayPal, carte, bonifico

### **Come paga l'utente con PayPal?**

1. **Nella pagina di checkout**, l'utente vede 3 tab
2. **PayPal è già selezionato** (default)
3. L'utente clicca sul **pulsante blu PayPal**
4. Viene **reindirizzato a PayPal.com** (sito sicuro)
5. **Accede al suo account PayPal** (o ne crea uno)
6. **Conferma il pagamento** con uno di questi metodi:
   - Saldo PayPal
   - Carta di credito/debito collegata
   - Bonifico bancario
7. **Torna automaticamente su Slamin**
8. **Pagamento completato!** ✅

### **L'utente DEVE avere un account PayPal?**
**NO!** PayPal permette anche pagamenti "come ospite" con carta di credito, ma è consigliato avere un account per:
- Protezione acquirente
- Storico pagamenti
- Rimborsi facilitati

---

## 💳 Carta di Credito (via Stripe)

### **Quando usare Stripe?**
- L'utente non ha PayPal
- L'utente preferisce pagare direttamente con carta
- Pagamenti internazionali

### **Come paga l'utente con Carta di Credito?**

1. **Nella pagina di checkout**, clicca sul tab **"💳 Carta di Credito"**
2. **Inserisce i dati della carta** direttamente nel form:
   - Numero carta
   - Data scadenza
   - CVV
   - Nome titolare
3. **Clicca "Paga €X.XX"**
4. **Stripe elabora il pagamento** (2-3 secondi)
5. **Pagamento completato!** ✅

### **L'utente DEVE avere un account Stripe?**
**NO!** Stripe è solo il processore di pagamento. L'utente:
- ❌ **NON** deve registrarsi su Stripe
- ❌ **NON** deve creare un account
- ✅ Inserisce solo i dati della carta
- ✅ Stripe elabora e basta

### **I dati della carta sono sicuri?**
**SÌ!** 
- 🔒 Stripe è **PCI DSS Level 1** certificato
- 🔒 I dati **NON** vengono salvati su Slamin
- 🔒 Crittografia **TLS 1.2+**
- 🔒 3D Secure supportato

---

## 💰 Pagamento Offline

### **Quando usare questo metodo?**
- Pagamento già effettuato tramite bonifico
- Pagamento in contanti (eventi dal vivo)
- Accordi speciali tra autore e traduttore

### **Come funziona?**

1. **Autore e traduttore si accordano** offline
2. **Autore paga** (bonifico, contanti, ecc.)
3. **Autore va su Slamin** → Checkout
4. **Seleziona "💰 Pagamento Offline"**
5. **Conferma** di aver pagato
6. **Admin verifica** manualmente
7. **Traduzione sbloccata** ✅

---

## 📊 Confronto Metodi

| Caratteristica | PayPal | Stripe | Offline |
|----------------|--------|--------|---------|
| **Velocità** | Immediato | Immediato | 1-2 giorni |
| **Account richiesto** | Consigliato | NO | NO |
| **Protezione** | Alta | Alta | Bassa |
| **Commissioni** | ~3.4% + €0.35 | ~2.9% + €0.25 | Nessuna |
| **Carte accettate** | Tutte | Tutte | N/A |
| **Rimborsi** | Facile | Facile | Manuale |

---

## 🔧 Configurazione (Per Admin)

### **1. Configurare PayPal**

#### A. Crea Account Business PayPal
1. Vai su https://www.paypal.com/it/business
2. Crea account Business
3. Verifica email e identità

#### B. Ottieni Credenziali API
1. Accedi a https://developer.paypal.com
2. Vai su **My Apps & Credentials**
3. Crea una **REST API app**
4. Copia **Client ID** e **Secret**

#### C. Configura in Slamin
```env
# Sandbox (Testing)
PAYPAL_CLIENT_ID=AYour_Sandbox_Client_ID
PAYPAL_CLIENT_SECRET=EYour_Sandbox_Secret
PAYPAL_MODE=sandbox

# Live (Produzione)
PAYPAL_CLIENT_ID=AYour_Live_Client_ID
PAYPAL_CLIENT_SECRET=EYour_Live_Secret
PAYPAL_MODE=live
```

### **2. Configurare Stripe**

#### A. Crea Account Stripe
1. Vai su https://stripe.com
2. Crea account
3. Attiva account (verifica identità)

#### B. Ottieni Chiavi API
1. Accedi a https://dashboard.stripe.com
2. Vai su **Developers** → **API keys**
3. Copia **Publishable key** e **Secret key**

#### C. Configura in Slamin
```env
# Test Mode
STRIPE_PUBLIC_KEY=pk_test_51...
STRIPE_SECRET_KEY=sk_test_51...
STRIPE_WEBHOOK_SECRET=whsec_...

# Live Mode
STRIPE_PUBLIC_KEY=pk_live_51...
STRIPE_SECRET_KEY=sk_live_51...
STRIPE_WEBHOOK_SECRET=whsec_...
```

---

## 🧪 Testing

### **Test PayPal (Sandbox)**
1. Usa account sandbox creato su developer.paypal.com
2. Email: `sb-xxxxx@personal.example.com`
3. Password: quella che hai impostato
4. Testa il flusso completo

### **Test Stripe**
Carte di test:
- **Successo**: `4242 4242 4242 4242`
- **3D Secure**: `4000 0025 0000 3155`
- **Rifiutata**: `4000 0000 0000 9995`
- **CVV**: qualsiasi 3 cifre
- **Data**: qualsiasi data futura

---

## ❓ FAQ

### **Q: L'utente può pagare senza registrarsi?**
**A:** Dipende:
- **PayPal**: Può pagare come ospite (ma account consigliato)
- **Stripe**: NO account necessario, solo dati carta
- **Offline**: NO account necessario

### **Q: Quali carte sono accettate?**
**A:** 
- Visa
- Mastercard
- American Express
- Maestro
- Discover (solo Stripe)

### **Q: I pagamenti sono sicuri?**
**A:** SÌ! Sia PayPal che Stripe sono:
- PCI DSS certificati
- Usati da milioni di siti
- Crittografia end-to-end

### **Q: Posso avere un rimborso?**
**A:** SÌ!
- **PayPal**: Apri controversia su PayPal
- **Stripe**: Contatta supporto Slamin
- **Offline**: Accordo diretto con traduttore

### **Q: Quanto tempo ci vuole?**
**A:** 
- **PayPal**: Immediato (2-5 secondi)
- **Stripe**: Immediato (2-3 secondi)
- **Offline**: 1-2 giorni lavorativi

---

## 📞 Supporto

### **Problemi con PayPal?**
- Contatta: https://www.paypal.com/it/smarthelp/contact-us
- Telefono: 800 822 056 (Italia)

### **Problemi con Stripe?**
- Contatta: support@slamin.it
- Stripe gestisce automaticamente

### **Problemi con Offline?**
- Contatta: admin@slamin.it

---

**Ultimo aggiornamento**: 2 Dicembre 2025  
**Versione**: 2.0.0 (con PayPal)

