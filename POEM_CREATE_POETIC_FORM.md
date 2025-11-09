# 📝 FORM CREAZIONE POESIA - Design Poetico

> **"Scrivi la tua poesia in un ambiente ispirazionale"**  
> Form pensato come un diario letterario digitale

---

## 🎨 ELEMENTI POETICI

### 1. **Versi Ispiratori Fluttuanti** ✨

```
"Le parole sono ali dell'anima..."
"Ogni verso un battito del cuore"
"La poesia è musica silenziosa"
"Scrivi con il cuore, leggi con l'anima"
"Nel silenzio nascono i versi più belli"
"La bellezza delle parole non dette"
```

**Caratteristiche:**
- ✍️ Versi ispiratori fissi (non dal DB)
- 🍃 Fluttuano in background
- 💚 Verde Emerald opacity 10%
- 🌊 Movimento lento (25-40 secondi)
- ✨ Creano atmosfera contemplativa

---

### 2. **Header con Penna Decorativa** ✍️

```
        ✍
   Scrivi la Tua Poesia
"Lascia che le parole danzino sulla carta bianca"
```

- Penna gigante decorativa (emoji ✍️)
- Titolo 6xl con font Crimson Pro
- Citazione poetica ispirazionale
- Auto-save indicator verde

---

### 3. **Editor Come Diario Letterario** 📖

```
┌──────────────────────────────┐
│ │                            │  ← Linea verticale
│ │  Scrivi qui la tua poesia  │     (come pagina a righe)
│ │                            │
│ │  Ogni verso                │
│ │  ogni parola               │
│ │  ogni silenzio             │
│ │                            │
└──────────────────────────────┘
```

**Features:**
- ✅ Textarea grande (20 righe)
- ✅ Linea verticale decorativa (pl-12)
- ✅ Font Crimson Pro serif
- ✅ Placeholder poetico multilinea
- ✅ Leading-relaxed per leggibilità
- ✅ Word count + char count live
- ✅ Border colorato on focus

---

### 4. **Auto-Save ogni 30 secondi** 💾

```blade
<div wire:poll.30s="autoSave">
```

**Funziona così:**
1. Scrivi la poesia
2. Ogni 30 secondi: auto-save automatico
3. Indicator verde: "Bozza salvata alle 23:45"
4. Zero perdita dati!

**Method:**
```php
public function autoSave()
{
    if (empty($this->content)) return;
    
    $this->isDraft = true;
    $this->save(silent: true);  // Salva senza redirect
    $this->lastSaved = now()->format('H:i');
}
```

---

### 5. **Upload Immagine Drag & Drop** 🖼️

```
┌─────────────────────┐
│       ☁️            │
│  Clicca per         │
│  caricare immagine  │
│  JPG, PNG (max 2MB) │
└─────────────────────┘
```

**Livewire WithFileUploads:**
- ✅ Click to upload
- ✅ Preview immediata con `temporaryUrl()`
- ✅ Hover per rimuovere
- ✅ Max 2MB
- ✅ Validazione automatica

---

### 6. **Preview Modal** 👁️

Click "Anteprima" → Modal full-screen con:
- Titolo formattato
- Contenuto con classe `.poem-content`
- Stesso styling della view finale
- Preview esatta di come apparirà

---

## 🎯 LAYOUT STRUCTURE

```
┌──────────────────────────────────────┐
│         ✍️ Header Poetico            │
│                                      │
│  ┌────────────────────────────────┐ │
│  │  ❝ Titolo                      │ │
│  │  ────────────────              │ │
│  │                                │ │
│  │  │  Editor con linea          │ │
│  │  │  (come diario)             │ │
│  │  │                            │ │
│  │                                │ │
│  │  Descrizione                   │ │
│  └────────────────────────────────┘ │
│                                      │
│  ┌────────────────────────────────┐ │
│  │  🏷️ Metadata                   │ │
│  │  [Categoria] [Tipo] [Lingua]   │ │
│  │  [Tags]                        │ │
│  │  [Upload Immagine]             │ │
│  └────────────────────────────────┘ │
│                                      │
│  [Anteprima] [Salva Bozza] [Pubblica] │
└──────────────────────────────────────┘
```

---

## 🎨 DESIGN ELEMENTS

### Card Principale (Editor):
```css
backdrop-blur-2xl
bg-white/90
rounded-[3rem]           /* Extra rounded! */
shadow-2xl
border-2 border-primary-100
p-16                     /* Padding generoso */
```

### Input Titolo:
```css
text-2xl font-bold       /* Grande! */
font-poem                /* Serif */
px-6 py-4               /* Generoso */
rounded-2xl
```

### Textarea:
```css
rows="20"               /* Alta! */
font-poem text-lg
leading-relaxed
pl-12                   /* Spazio per linea */
```

### Metadata Card:
```css
backdrop-blur-xl
bg-white/85
rounded-3xl
shadow-xl
```

---

## ✨ MICRO-INTERACTIONS

### Input Focus:
```css
focus:border-primary-500
focus:ring-4 focus:ring-primary-500/20
transition-all duration-300
```
**Effetto:** Ring luminoso verde!

### Hover Upload:
```css
group-hover:border-primary-500
group-hover:bg-primary-50/50
```
**Effetto:** Area si colora di verde!

### Hover Preview Image:
```css
group-hover:opacity-100    /* Mostra overlay */
```
**Effetto:** Button "Rimuovi" appare!

### Button Pubblica:
```css
hover:-translate-y-1
hover:shadow-2xl
```
**Effetto:** Si solleva con ombra!

---

## 💾 AUTO-SAVE SYSTEM

### Come funziona:

```
T0:     Inizi a scrivere
T30:    Auto-save (bozza creata)
        ↓ "Bozza salvata alle 23:00"
T60:    Auto-save (bozza aggiornata)
        ↓ "Bozza salvata alle 23:01"
T90:    Auto-save
        ↓ "Bozza salvata alle 23:02"
...
```

### Indicator:
```html
<div class="bg-primary-50 text-primary-600">
    ✓ Bozza salvata alle 23:45
</div>
```

### Persistenza:
- Salva in DB come `is_draft = true`
- Se ricarichi pagina: `?restore=1` → carica ultima bozza
- Zero perdita dati!

---

## 🎭 VALIDAZIONE

### Campi Required:
```php
content: required|min:10|max:10000
language: required
```

### Campi Optional:
```php
title: nullable|max:255
description: nullable|max:500
category: nullable
poemType: nullable
tags: nullable|max:255
thumbnail: nullable|image|max:2048
```

**= Puoi pubblicare anche solo il contenuto!**

---

## 📱 RESPONSIVE

### Mobile:
- Stack verticale
- Padding ridotto (p-8)
- Textarea full width
- Buttons stack verticale

### Desktop:
- Grid 2 colonne per metadata
- Padding generoso (p-16)
- Buttons orizzontali
- Preview ampia

---

## 🌟 CARATTERISTICHE SPECIALI

### 1. **Placeholder Multilinea Poetico**
```
Scrivi qui la tua poesia...

Ogni verso
ogni parola
ogni silenzio

ha il suo significato...
```

### 2. **Quote Gigante Decorativa**
```
❝ [Input Titolo]
```

### 3. **Linea Verticale**
```
│ Editor content
│ Come pagina di diario
```

### 4. **Stats Live**
```
127 parole • 845 caratteri
```

### 5. **Upload con Icon Cloud**
```
☁️ ↑
Clicca per caricare
```

---

## 🎯 USER FLOW

### 1. Arriva sulla pagina:
- Vede versi ispiratori
- Ambiente poetico
- Call to action chiaro

### 2. Inizia a scrivere:
- Focus su textarea
- Ring verde appare
- Conta parole live

### 3. Dopo 30 secondi:
- Auto-save silenzioso
- Indicator: "Bozza salvata"
- Può continuare tranquillo

### 4. Preview:
- Click "Anteprima"
- Modal con preview esatta
- Vede come apparirà

### 5. Pubblica:
- Click "Pubblica"
- Loading indicator
- Redirect a poem-show
- Success message

---

## 🎨 ISPIRAZIONE DESIGN

**Come scrivere in:**
- 📔 Moleskine notebook
- ✍️ Macchina da scrivere vintage
- ☕ Caffè letterario
- 📚 Biblioteca antica
- 🕯️ Studio a lume di candela

**Non come:**
- ❌ Form admin
- ❌ Spreadsheet
- ❌ Dashboard
- ❌ Social media post

---

## ✅ TUTTI I REQUISITI SODDISFATTI

### Funzionalità:
- ✅ CRUD completo
- ✅ Auto-save (30 sec)
- ✅ Upload immagine
- ✅ Preview live
- ✅ Salva bozza
- ✅ Pubblica
- ✅ Validazione
- ✅ Error handling
- ✅ Success messages
- ✅ Loading states

### Design:
- ✅ Layout poetico
- ✅ Versi ispiratori
- ✅ Font Crimson Pro
- ✅ Quote decorative
- ✅ Colori delicati
- ✅ Animazioni fluide
- ✅ Glassmorphism
- ✅ Responsive

### Livewire:
- ✅ 100% Livewire
- ✅ Zero JS custom
- ✅ WithFileUploads
- ✅ Wire:poll per auto-save
- ✅ Real-time validation
- ✅ Loading indicators

---

## 🚀 PROVA ORA:

```
https://slamin_v2.test/poems/create
```

Dovresti vedere:
- ✍️ Penna decorativa gigante
- 🍃 Versi ispiratori che fluttuano
- 📝 Editor poetico con linea laterale
- 💾 Auto-save ogni 30 secondi
- 🖼️ Upload con preview
- 👁️ Button anteprima
- ✨ Button pubblica con gradient

**Scrivi qualche verso e guarda la magia!** 📖✨

