# 🎨 Guida Colori - Sistema Semplice

## 🚀 Quick Start

```bash
# Gestione colori
http://localhost:8000/colors

# Demo completa
http://localhost:8000/parallax
```

---

## 🎨 Come Funziona

### 1️⃣ Scegli Colore
- Vai su `/colors`
- Scegli preset (Sky, Emerald, Orange, Rose, Slate)
- Personalizza il colore (opzionale)

### 2️⃣ Genera
- Clicca "Genera Palette"
- Vedi 11 sfumature (50-950)
- Algoritmo CIELab professionale

### 3️⃣ Applica
- Clicca "✓ Applica Palette"
- Esegui `npm run dev`
- Done! 🎉

---

## 📦 File Importanti

```
resources/css/
├── _variables.scss    # Variabili SCSS colori
└── app.css            # Tailwind + utility classes

app/Services/
└── SimpleColorGenerator.php    # Generatore CIELab

app/Livewire/
└── SimpleThemeManager.php       # UI gestione

resources/views/parallax/
└── index.blade.php              # Pagina principale
```

---

## 🎨 Palette Principale

Usa `primary-*` (50-950) per l'identità del sito:
```html
<button class="bg-primary-500">Button</button>
<div class="bg-primary-50">Background chiaro</div>
<h1 class="text-primary-700">Heading</h1>
```

---

## ✅ Semantici (Fissi)

Sempre gli stessi (tipo Tailwind):
```html
<div class="bg-success">✅ Success (#10b981 verde)</div>
<div class="bg-warning">⚠️ Warning (#f59e0b arancione)</div>
<div class="bg-error">❌ Error (#ef4444 rosso)</div>
<div class="bg-info">ℹ️ Info (#3b82f6 blu)</div>
```

---

## ⚙️ Build Vite

```bash
# Development (hot reload)
npm run dev

# Production
npm run build
```

Vite compila `resources/css/app.css` → `public/build/assets/app-[hash].css`

---

**That's it!** Sistema semplice e pulito. 🚀

