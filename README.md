# 🎨 SLAMIN Color System

Sistema semplice per gestire colori - 1 palette + semantici fissi tipo Tailwind.

---

## 🚀 Quick Start

```bash
# 1. Installa dipendenze
npm install
composer install

# 2. Setup ambiente
cp .env.example .env
php artisan key:generate

# 3. Avvia server
php artisan serve

# 4. In un altro terminale, compila assets
npm run dev
```

**URLs:**
- Home: `http://localhost:8000`
- Gestione Colori: `http://localhost:8000/colors`
- Parallax Demo: `http://localhost:8000/parallax`

---

## 🎨 Sistema Colori

### Come Funziona

**1 colore → 1 palette (50-950) + semantici fissi**

### Gestione Colori

Vai su `/colors` per:
1. Scegliere preset (Sky, Emerald, Orange, Rose, Slate)
2. Personalizzare il colore base
3. Generare palette (11 sfumature con algoritmo CIELab)
4. Applicare al sito

### Palette Principale

Definita in `resources/css/_variables.scss` e `resources/css/app.css`:
```
primary-50  → primary-950 (11 sfumature)
```

Usala per l'identità visiva del sito:
```html
<button class="bg-primary-500">Button</button>
<div class="bg-primary-50">Background chiaro</div>
<h1 class="text-primary-700">Heading</h1>
```

### Colori Semantici (Fissi)

Sempre gli stessi, tipo Tailwind:
```
success: #10b981 (verde)
warning: #f59e0b (arancione)
error: #ef4444 (rosso)
info: #3b82f6 (blu)
```

Usa per messaggi:
```html
<div class="bg-success">✅ Salvato!</div>
<div class="bg-warning">⚠️ Attenzione</div>
<div class="bg-error">❌ Errore</div>
<div class="bg-info">ℹ️ Info</div>
```

---

## ⚙️ Build System (Vite)

### File di Configurazione

**`vite.config.js`**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
```

### File CSS

**`resources/css/app.css`**
- Entry point CSS
- Import Tailwind v4
- Definisce @theme (variabili CSS custom)
- Utility classes custom

### Comandi Build

```bash
# Development (hot reload)
npm run dev

# Production (ottimizzato)
npm run build
```

### Come Funziona il Build

1. **Vite legge** `resources/css/app.css`
2. **Processa Tailwind v4** (genera utility classes)
3. **Applica** variabili custom (@theme)
4. **Compila** in `public/build/assets/app-[hash].css`
5. **Genera** `public/build/manifest.json` (mapping file)

### Hot Reload

Con `npm run dev`:
- Vite server su porta 5173
- Monitora cambiamenti in `resources/`
- Auto-refresh browser quando salvi

### Production Build

Con `npm run build`:
- Minifica CSS/JS
- Tree-shaking (rimuove codice inutilizzato)
- Hash nei nomi file (cache busting)
- Output in `public/build/`

### Includere Assets nelle View

```php
// Nel <head> delle tue view
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

Vite genera automaticamente i tag `<link>` e `<script>` corretti.

---

## 📁 Struttura File

```
resources/
├── css/
│   ├── _variables.scss   # Variabili SCSS (colori, spacing, etc.)
│   ├── _mixins.scss      # Mixins riutilizzabili
│   └── app.css           # Entry point (Tailwind + custom)
│
├── js/
│   ├── app.js            # Entry point JS
│   └── bootstrap.js      # Setup librerie (Alpine, etc.)
│
└── views/
    ├── parallax/
    │   └── index.blade.php      # Pagina principale
    │
    ├── livewire/
    │   └── simple-theme-manager.blade.php  # UI gestione colori
    │
    └── components/
        └── layouts/
            └── parallax.blade.php   # Layout

app/
├── Livewire/
│   └── SimpleThemeManager.php   # Component gestione colori
│
└── Services/
    └── SimpleColorGenerator.php # Generatore palette CIELab

public/
└── build/                # Output compilato (generato da Vite)
    ├── manifest.json
    └── assets/
        ├── app-[hash].css
        └── app-[hash].js

vite.config.js           # Config Vite
package.json             # Dipendenze npm
```

---

## 🛠️ Troubleshooting

### Assets non si aggiornano

```bash
# Ricompila
npm run build

# O riavvia dev server
npm run dev
```

### CSS non applicato

```bash
# Pulisci cache
php artisan view:clear
php artisan cache:clear

# Ricompila
npm run build

# Hard refresh browser
Cmd + Shift + R (Mac)
Ctrl + Shift + R (Windows)
```

### Errori Vite

```bash
# Reinstalla
rm -rf node_modules
npm install

# Rebuild
npm run build
```

---

## 📦 Dipendenze

### PHP/Composer
- Laravel 11
- Livewire 3
- spatie/color (per generazione palette)

### NPM
- Vite 7
- Tailwind CSS v4
- Alpine.js

---

## 🎉 That's It!

Sistema pulito e semplice:
- ✅ 1 palette configurabile
- ✅ Semantici fissi
- ✅ Vite build veloce
- ✅ Zero complessità

**Enjoy!** 🚀
