# 🎭 SLAMIN - Poetry Social Network

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)

> **La community poetica più innovativa d'Italia** - Un social network elegante e moderno dedicato ai poeti, con design minimalista e funzionalità avanzate.

---

## ✨ Features

### 🎬 Hero Slider
- **4 slide dinamiche** con auto-play (7s)
- **Parallax effect** su immagini di sfondo
- **Progress bar animata** per ogni slide
- **Navigation arrows** con hover effects
- **Pause on hover** e ripresa automatica
- Immagini da Unsplash in HD

### 📰 Feed Interattivo
- Post con **immagini reali** e poesie
- **Avatar dinamici** (Pravatar)
- Layout **senza bordi** - solo shadow e blur
- Actions: Like, Commenti, Condividi, Salva
- **Sidebar sticky** con Trending e Suggeriti
- Filtri: Tutti, Seguiti, Trending

### 🌟 Discover Section
- Grid responsive di **8 poeti emergenti**
- **Foto reali** con overlay gradient
- Hover: scale + translate effects
- Button "Segui" con backdrop blur

### 🎭 Eventi
- **3 eventi** con immagini Unsplash
- Date badge floating
- Category tags
- Info complete + CTA
- Hover: scale image effect

### 🎨 Design System
- **Palette custom**: Accent (coral), Primary (slate), Secondary (sage)
- **Tipografia**: Crimson Pro (serif), Inter (sans)
- **Spacing armonioso**: 8px base grid
- **Rounded-3xl**: 28px border radius
- **Backdrop blur**: effetto vetro
- **No borders**: solo shadow e transparenze

---

## 🚀 Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Livewire 3.x
- **Styling**: Tailwind CSS 4.x + SCSS
- **JavaScript**: Alpine.js 3.x
- **Build Tool**: Vite
- **Images**: Unsplash API + Pravatar

---

## 📦 Installazione

### Prerequisiti
- PHP 8.2+
- Composer
- Node.js 20.19+ / 22.12+
- MySQL/PostgreSQL

### Setup

```bash
# Clone repository
git clone https://github.com/YOUR-USERNAME/slamin_v2.git
cd slamin_v2

# Install PHP dependencies
composer install

# Install NPM dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Build assets
npm run build

# Start development server
php artisan serve
```

### Development Mode

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev
```

Apri: `http://localhost:8000/parallax`

---

## 🎨 Routes Disponibili

| Route | Descrizione |
|-------|-------------|
| `/` | Homepage |
| `/parallax` | **Main Layout** - Hero slider + Feed + Discover + Eventi |
| `/verse` | Layout masonry innovativo |
| `/fluid` | Layout editoriale fluido |
| `/feed` | Social feed layout |
| `/test-styles` | Test colori e stili |

---

## 🎯 Funzionalità Principali

### Hero Slider
```javascript
// Auto-play configurabile
autoplayInterval: 7000ms
// Pause on hover
// Navigation: arrows + indicators
// Smooth transitions: 1000ms
```

### Parallax Effect
```javascript
// Background: 0.5x scroll speed
// Content: 0.3x scroll speed
// Smooth e fluido
```

### Animazioni
- **Scroll animations**: Fade in up con stagger
- **Hover effects**: Scale, translate, shadow
- **Transitions**: 300-700ms ease-out
- **Progress bar**: Linear 7s animation

---

## 🎨 Color Palette

```css
/* Accent - Coral/Terracotta */
--color-accent-500: #e06155;
--color-accent-600: #cc4237;

/* Primary - Slate Blue */
--color-primary-500: #64748b;
--color-primary-600: #475569;

/* Secondary - Sage Green */
--color-secondary-500: #637063;
--color-secondary-600: #4e5a4e;

/* Neutral - Warm Gray */
--color-neutral-50: #fafaf9;
--color-neutral-900: #1c1917;
```

---

## 📁 Struttura Progetto

```
slamin_v2/
├── app/
│   ├── Livewire/          # Componenti Livewire
│   └── Models/            # Eloquent models
├── resources/
│   ├── css/
│   │   ├── app.css        # Main CSS (Tailwind + custom)
│   │   ├── _variables.scss # Design tokens
│   │   └── _mixins.scss   # SCSS mixins
│   ├── js/
│   │   └── app.js         # Alpine.js + components
│   └── views/
│       ├── components/layouts/
│       │   ├── parallax.blade.php  # Main layout ⭐
│       │   ├── verse.blade.php
│       │   └── fluid.blade.php
│       └── parallax/
│           └── index.blade.php      # Homepage ⭐
├── routes/
│   └── web.php            # Routes
└── vite.config.js         # Vite configuration
```

---

## 🎭 Layouts Disponibili

### 1. **Parallax Layout** ⭐ (Consigliato)
- Hero slider full-screen
- Feed con sidebar
- Discover poeti
- Eventi
- CTA finale
- **Route**: `/parallax`

### 2. **Verse Layout**
- Masonry grid asimmetrica
- Floating navigation orb
- FAB verticali
- Particelle animate
- **Route**: `/verse`

### 3. **Fluid Layout**
- Design editoriale
- Tipografia grande
- Layout libero
- Cursor personalizzato
- **Route**: `/fluid`

---

## 🛠️ Personalizzazione

### Modificare Colori

Edita `resources/css/_variables.scss`:

```scss
$accent-500: #e06155;    // Tuo colore
$primary-500: #64748b;
$secondary-500: #637063;
```

Poi rebuilda:
```bash
npm run build
```

### Modificare Slider

Edita `resources/views/parallax/index.blade.php`:

```javascript
slides: [
    {
        image: 'URL_TUA_IMMAGINE',
        title: 'Tuo Titolo',
        subtitle: 'Tuo Sottotitolo',
        gradient: 'from-accent-900/80 ...'
    },
    // ... altre slide
]
```

### Modificare Auto-Play Speed

```javascript
// Cambia 7000 con i millisecondi desiderati
setInterval(() => {
    currentSlide = (currentSlide + 1) % slides.length;
}, 7000);  // ← Modifica qui
```

---

## 📸 Screenshots

### Hero Slider
![Hero Slider](docs/hero-slider.png)

### Feed Section
![Feed](docs/feed-section.png)

### Discover Poeti
![Discover](docs/discover-poets.png)

### Eventi
![Eventi](docs/events-section.png)

---

## 🚀 Deploy

### Vercel/Netlify (Frontend)
```bash
npm run build
# Upload della cartella public/build
```

### Laravel Forge/Vapor
```bash
# Push su GitHub
git push origin main

# Configura Forge con:
# - Build Command: npm run build
# - Deploy Script: standard Laravel
```

---

## 🤝 Contributing

Contributi benvenuti! Per favore:

1. Fork il progetto
2. Crea un branch (`git checkout -b feature/AmazingFeature`)
3. Commit le modifiche (`git commit -m 'Add AmazingFeature'`)
4. Push al branch (`git push origin feature/AmazingFeature`)
5. Apri una Pull Request

---

## 📝 License

Questo progetto è sotto licenza MIT - vedi il file [LICENSE](LICENSE) per dettagli.

---

## 👨‍💻 Author

**Mazzi** - [GitHub](https://github.com/YOUR-USERNAME)

---

## 🙏 Ringraziamenti

- **Unsplash** per le immagini
- **Pravatar** per gli avatar
- **Tailwind CSS** per il framework
- **Laravel** per il backend
- **Alpine.js** per la reattività

---

## 📞 Support

Per domande o supporto, apri una [Issue](https://github.com/YOUR-USERNAME/slamin_v2/issues).

---

**Made with ❤️ for the Poetry Community**
