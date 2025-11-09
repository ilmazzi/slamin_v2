# 📝 QUILL EDITOR - Foglio di Carta

> **Editor WYSIWYG che sembra un vero quaderno poetico**

---

## 🎨 CARATTERISTICHE FOGLIO

### 1. **Righe Orizzontali (Come Quaderno)** 📏

```css
repeating-linear-gradient(
    transparent,
    transparent 39px,           /* Spazio tra righe */
    rgba(16, 185, 129, 0.12) 39px,  /* Riga verde */
    rgba(16, 185, 129, 0.12) 40px   /* 1px spessore */
)
```

**Effetto:** Righe verdi ogni 40px (altezza riga testo)

---

### 2. **Linea Verticale Rossa (Margine)** 📍

```css
linear-gradient(to right,
    rgba(220, 38, 38, 0.15) 0px,   /* Rosso semi-trasparente */
    rgba(220, 38, 38, 0.15) 2px,   /* 2px spessore */
    transparent 2px
)
background-position: 48px 0;        /* Margine sinistra */
```

**Effetto:** Linea rossa verticale a sinistra (come quaderni veri!)

---

### 3. **Texture Carta (Noise)** 📄

```css
.paper-bg::before {
    background-image: url("data:image/svg+xml,...
        <feTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' />
    ...");
    opacity: 0.03;
}
```

**Effetto:** Grana carta leggera e realistica

---

### 4. **Ombre Multiple (Stack di Fogli)** 📚

```css
box-shadow: 
    0 1px 1px rgba(0,0,0,0.15),       /* Ombra principale */
    0 10px 0 -5px #fafaf8,            /* Foglio sotto 1 */
    0 10px 1px -4px rgba(0,0,0,0.15), /* Ombra foglio 1 */
    0 20px 0 -10px #f5f5f3,           /* Foglio sotto 2 */
    0 20px 1px -9px rgba(0,0,0,0.15); /* Ombra foglio 2 */
```

**Effetto:** Sembra uno **stack di 3 fogli** di carta! 📚

---

### 5. **Colore Crema (Paper)** 🌾

```css
background: #fffef9;  /* Bianco crema caldo */
```

Non bianco puro (#ffffff) ma crema vintage!

---

## ✍️ QUILL EDITOR

### Toolbar Minimalista:

```javascript
toolbar: [
    ['bold', 'italic'],    // Grassetto e corsivo
    [{ 'align': [] }],     // Allineamenti
    ['clean']              // Pulisci formattazione
]
```

**Solo essenziale per poesia:**
- **Bold** - enfasi
- **Italic** - strofe particolari
- **Align** - centra, destra, sinistra
- **Clean** - rimuovi tutto

NO: font, size, color, lists (non servono per poesie!)

---

### Styling Poetico:

```css
font-family: 'Crimson Pro', Georgia, serif
font-size: 1.25rem     (20px - grande!)
line-height: 1.8       (molto spaziato)
padding: 3rem 2rem     (generoso)
min-height: 500px      (alto)
```

**Risultato:** Come scrivere in un vero diario! 📖

---

### Toolbar Verde:

```css
background: gradient warm-gray
border-bottom: 2px solid #a7f3d0  (verde Emerald!)
icons: stroke #10b981
hover: stroke #059669
```

**Effetto:** Toolbar con accento verde poetico

---

## 🔗 INTEGRAZIONE LIVEWIRE

### Sync Bidirezionale:

```javascript
// Quill → Livewire (quando scrivi)
quill.on('text-change', () => {
    content = quill.root.innerHTML;
});

// Livewire → Quill (quando carica bozza)
$watch('content', (value) => {
    quill.root.innerHTML = value;
});
```

### @entangle Magic:

```javascript
content: @entangle('content')
```

**= Sincronizzazione automatica!**

---

## 📐 VISUAL RESULT

```
┌─────────────────────────────────┐ ← Toolbar (grigio con verde)
│ [B] [I] [≡] [↻]                │
├─────────────────────────────────┤ ← Border verde
│ │                               │
│ │ Scrivi qui...                 │ ← Righe verdi
│ │ ────────────────────────────  │
│ │                               │
│ │ Ogni verso                    │
│ │ ────────────────────────────  │
│ │ ogni parola                   │
│ │ ────────────────────────────  │
│ │                               │
│ │ ────────────────────────────  │
│ │                               │
│ │ ────────────────────────────  │
└─────────────────────────────────┘
  └─ Fogli sotto (ombre)
```

**Linea rossa:** │ a sinistra (margine)  
**Righe verdi:** ──── orizzontali  
**Texture:** grana carta sottile  
**Ombre:** stack 3 fogli  

---

## 🎨 DETTAGLI REALISTICI

### Come Moleskine/Quaderno:
- ✅ Righe orizzontali (line ruling)
- ✅ Margine verticale rosso
- ✅ Colore crema (non bianco)
- ✅ Texture carta
- ✅ Ombre realistiche
- ✅ Font serif
- ✅ Spazi generosi

### Features:
- ✅ **40px** tra le righe (altezza standard)
- ✅ **48px** margine sinistro (standard USA)
- ✅ **2px** linea rossa margine
- ✅ **#fffef9** colore carta crema
- ✅ **Texture noise** opacity 3%
- ✅ **3 fogli** ombre sotto

---

## ⚡ FUNZIONALITÀ

### Formattazione Disponibile:
- **Bold** (Ctrl/Cmd + B)
- **Italic** (Ctrl/Cmd + I)
- **Align Left**
- **Align Center**
- **Align Right**
- **Clear Format**

### Auto-save:
- Ogni 30 secondi
- Salva HTML formattato
- Preserva bold/italic/align

### Restore:
- Carica bozze con formattazione intatta
- HTML rendering perfetto

---

## 🎯 ESPERIENZA UTENTE

**Si sente come scrivere su:**
- 📓 Quaderno Moleskine
- 📝 Blocco notes vintage
- ✍️ Diario personale
- 📜 Pergamena elegante

**NON come:**
- ❌ Google Docs
- ❌ Word processor
- ❌ Markdown editor
- ❌ Plain textarea

---

## 🚀 RICARICA E PROVA:

```
https://slamin_v2.test/poems/create
```

Dovresti vedere:
- ✅ **Label "Titolo" VISIBILE** (no quote sopra)
- ✅ **EDITOR GRANDE** con toolbar
- ✅ **Background CARTA** con righe verdi
- ✅ **Linea rossa** margine sinistro
- ✅ **Texture carta** sottile
- ✅ **Ombre 3D** (stack fogli)
- ✅ **Font serif** grande
- ✅ **Toolbar verde** con icons

**Scrivi qualcosa e guarda!** ✍️📖✨

---

**COME UN VERO QUADERNO POETICO!** 📓✨

