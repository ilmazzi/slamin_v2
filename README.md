# SLAMIN - Portale per Poeti

Un portale moderno e minimalista per poeti dove puoi condividere poesie, partecipare ad eventi, scrivere articoli, postare foto e video e connetterti con la community letteraria.

## 🚀 Tecnologie

- **Laravel 12** - Framework PHP moderno
- **Livewire 3** - Componenti interattivi senza JavaScript
- **Tailwind CSS 4** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **Vite** - Next generation frontend tooling

## 📋 Caratteristiche

- ✨ Design pulito, elegante e minimalista
- 🌗 Dark mode support
- 📱 Fully responsive
- ⚡ Livewire components interattivi
- 🎨 Tailwind CSS v4 con configurazione personalizzata
- 🔄 Alpine.js per interattività lato client
- 📝 Layout e componenti riutilizzabili

## 🛠️ Installazione

### Prerequisiti

- PHP >= 8.2
- Composer
- Node.js >= 20.x
- SQLite (o altro database supportato da Laravel)

### Setup

1. **Clona il repository**
   ```bash
   git clone <repository-url>
   cd slamin_v2
   ```

2. **Installa dipendenze PHP**
   ```bash
   composer install
   ```

3. **Installa dipendenze JavaScript**
   ```bash
   npm install
   ```

4. **Configura l'ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Esegui le migrazioni**
   ```bash
   php artisan migrate
   ```

6. **Avvia il server di sviluppo**
   ```bash
   php artisan serve
   ```

7. **In un altro terminale, avvia Vite**
   ```bash
   npm run dev
   ```

8. **Apri nel browser**
   ```
   http://localhost:8000
   ```

## 📁 Struttura del Progetto

```
slamin_v2/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Livewire/
│   │   ├── Button.php          # Componente bottone riutilizzabile
│   │   └── Card.php            # Componente card riutilizzabile
│   └── Models/
├── resources/
│   ├── css/
│   │   └── app.css            # Stili personalizzati con Tailwind
│   ├── js/
│   │   ├── app.js             # Alpine.js e configurazione
│   │   └── bootstrap.js       # Setup axios
│   └── views/
│       ├── components/        # Blade components
│       ├── layouts/
│       │   ├── app.blade.php  # Layout principale
│       │   ├── navigation.blade.php
│       │   └── footer.blade.php
│       ├── livewire/          # Views Livewire components
│       └── home.blade.php     # Homepage
├── routes/
│   └── web.php                # Route dell'applicazione
├── config/                    # File di configurazione
└── public/                    # File pubblici
```

## 🎨 Componenti

### Button Livewire

Componente bottone riutilizzabile con varianti e dimensioni.

```blade
@livewire('button', ['variant' => 'primary', 'size' => 'md'])
```

**Varianti disponibili:**
- `primary` (default)
- `secondary`
- `success`
- `danger`
- `outline`

**Dimensioni:**
- `sm` - Small
- `md` - Medium (default)
- `lg` - Large

### Card Livewire

Componente card con header e footer opzionali.

```blade
@livewire('card')
```

**Nota:** I componenti Livewire sono disponibili ma la homepage usa HTML puro per semplicità.

## 🎯 Funzionalità Principali

- **Home** - Landing page con hero section, features e CTA
- **Navigation** - Header responsivo con menu mobile e dark mode toggle
- **Footer** - Footer informativo con link utili
- **Dark Mode** - Toggle automatico con persistenza locale

## 🌈 Personalizzazione

### Tema e Colori

Il tema è definito in `resources/css/app.css` con Tailwind CSS v4:

```css
@theme {
    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
}
```

### Font

Il progetto usa **Inter** come font principale. Puoi cambiarlo importando un altro font da Google Fonts e aggiornando la configurazione.

## 📝 Sviluppo

### Creare un nuovo componente Livewire

```bash
php artisan make:livewire NomeComponente
```

### Build per produzione

```bash
npm run build
```

### Ottimizzazione

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🤝 Contribuire

1. Fork il progetto
2. Crea un branch per la tua feature (`git checkout -b feature/AmazingFeature`)
3. Commit le tue modifiche (`git commit -m 'Add some AmazingFeature'`)
4. Push al branch (`git push origin feature/AmazingFeature`)
5. Apri una Pull Request

## 📄 Licenza

Questo progetto è open source e disponibile sotto licenza MIT.

## 👨‍💻 Autore

Creato per SLAMIN - Portale per Poeti

## 🙏 Ringraziamenti

- Laravel per il fantastic framework
- Livewire per i componenti reattivi
- Tailwind CSS per il sistema di design
- Alpine.js per la leggerezza
- Vite per la velocità di sviluppo

---

**Buon coding! 🚀**
