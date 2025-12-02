# Analisi Fattibilità ActivityPub per Slamin

## 📋 Cos'è ActivityPub?

ActivityPub è un protocollo W3C per la creazione di social network federati e decentralizzati. Permette a diverse piattaforme di comunicare tra loro (come Mastodon, Pixelfed, PeerTube, ecc.).

## ✅ Vantaggi

1. **Fediverso** - Slamin diventa parte di una rete sociale decentralizzata
2. **Libertà** - Gli utenti possono seguire contenuti da qualsiasi server federato
3. **Privacy** - Nessun controllo centralizzato dei dati
4. **Interoperabilità** - Condivisione automatica su Mastodon, Pixelfed, ecc.
5. **Open Source** - Protocollo aperto e standardizzato

## 🎯 Cosa Significa per Slamin

### Funzionalità Abilitate:
- ✅ Utenti Mastodon possono seguire poeti su Slamin
- ✅ Poesie pubblicate su Slamin appaiono su Mastodon
- ✅ Commenti da Mastodon visibili su Slamin
- ✅ Eventi condivisibili nel fediverso
- ✅ Articoli federati automaticamente

## 🛠️ Implementazione Tecnica

### Librerie PHP/Laravel Disponibili:

1. **landrok/activitypub** (Consigliata)
   - Libreria PHP pura per ActivityPub
   - Supporta server e client
   - Gestisce WebFinger, Actor, Activities
   - GitHub: https://github.com/landrok/activitypub

2. **pixelfed/laravel-activitypub** 
   - Package Laravel specifico
   - Usato da Pixelfed (Instagram federato)
   - Più complesso ma completo

### Requisiti Tecnici:

1. **WebFinger** - Endpoint per discovery (es: `/.well-known/webfinger`)
2. **Actor Endpoints** - Ogni utente diventa un "actor" federato
3. **Inbox/Outbox** - Ricevere e inviare attività
4. **HTTP Signatures** - Autenticazione tra server
5. **JSON-LD** - Formato dati ActivityPub
6. **HTTPS obbligatorio** - Sicurezza federazione

### Database Changes Necessarie:

```sql
-- Tabella per attività federate
CREATE TABLE activitypub_activities (
    id BIGINT PRIMARY KEY,
    actor_id BIGINT,
    type VARCHAR(50), -- Create, Update, Delete, Follow, Like, etc
    object_type VARCHAR(50), -- Note (post), Article, Event, etc
    object_id BIGINT,
    data JSON, -- ActivityPub JSON completo
    remote_id VARCHAR(255), -- ID remoto se da server esterno
    created_at TIMESTAMP
);

-- Tabella per followers remoti
CREATE TABLE activitypub_followers (
    id BIGINT PRIMARY KEY,
    user_id BIGINT, -- Utente Slamin
    follower_actor VARCHAR(255), -- Actor remoto (es: @user@mastodon.social)
    inbox_url VARCHAR(255),
    shared_inbox_url VARCHAR(255),
    created_at TIMESTAMP
);

-- Tabella per following remoti
CREATE TABLE activitypub_following (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    following_actor VARCHAR(255),
    created_at TIMESTAMP
);
```

## 📊 Stima Complessità

### Fase 1: Base (2-3 settimane) ⭐⭐⭐
- ✅ WebFinger endpoint
- ✅ Actor profiles (utenti come actor)
- ✅ Outbox (pubblicazione contenuti)
- ✅ HTTP Signatures
- **Risultato**: Contenuti Slamin visibili su Mastodon

### Fase 2: Interazione (3-4 settimane) ⭐⭐⭐⭐
- ✅ Inbox (ricevere attività)
- ✅ Follow/Unfollow remoti
- ✅ Like/Boost da remoto
- ✅ Commenti federati
- **Risultato**: Interazione bidirezionale completa

### Fase 3: Avanzato (4-6 settimane) ⭐⭐⭐⭐⭐
- ✅ Collections (followers, following)
- ✅ Notifiche federate
- ✅ Media attachments
- ✅ Moderazione federata
- ✅ Blocklist condivise
- **Risultato**: Piattaforma completamente federata

## 💰 Costi/Benefici

### Costi:
- ⏱️ **Tempo sviluppo**: 9-13 settimane totali
- 💾 **Database**: +3 tabelle, più storage per cache
- 🔧 **Manutenzione**: Gestione inbox/outbox, moderazione remota
- 📡 **Server**: Più richieste HTTP (federazione)
- 🐛 **Debug**: Complessità testing con server remoti

### Benefici:
- 🌍 **Reach**: Milioni di utenti fediverso (Mastodon, Pixelfed, etc)
- 🆓 **Marketing gratuito**: Visibilità organica nel fediverso
- 🔓 **Open**: Allineamento con valori libertà/privacy
- 🚀 **Innovazione**: Prima piattaforma poetry slam federata
- 🤝 **Community**: Integrazione con community esistenti

## 🎯 Raccomandazione

### Approccio Consigliato: **GRADUALE**

1. **SUBITO (Questa sessione)** ✅
   - Aggiungi Instagram e TikTok alla condivisione
   - Migliora UX condivisione esistente

2. **FASE 1 (Prossime settimane)** 🟡
   - Implementa solo **Outbox** (pubblicazione)
   - Contenuti Slamin visibili su Mastodon
   - Basso rischio, alto valore

3. **FASE 2 (Dopo feedback)** 🟠
   - Se Fase 1 ha successo, aggiungi Inbox
   - Interazione bidirezionale completa

4. **FASE 3 (Futuro)** 🔴
   - Funzionalità avanzate se necessario

### Perché Graduale?
- ✅ Testa l'interesse degli utenti
- ✅ Riduce rischio tecnico
- ✅ Permette iterazioni basate su feedback
- ✅ Non blocca altre funzionalità

## 📚 Risorse Utili

- **Spec W3C**: https://www.w3.org/TR/activitypub/
- **Guida Mastodon**: https://docs.joinmastodon.org/spec/activitypub/
- **landrok/activitypub**: https://github.com/landrok/activitypub
- **ActivityPub Rocks**: https://activitypub.rocks/

## 🚦 Decisione

**FATTIBILE**: ✅ Sì, ma richiede impegno significativo

**PRIORITÀ SUGGERITA**: 
1. 🟢 Instagram + TikTok (SUBITO)
2. 🟡 ActivityPub Fase 1 - Outbox (PROSSIMO SPRINT)
3. 🟠 ActivityPub Fase 2 - Inbox (DOPO VALIDAZIONE)

---

**Vuoi procedere con Instagram/TikTok ora e pianificare ActivityPub per dopo?**

