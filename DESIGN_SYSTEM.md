# 🎨 SLAMIN Design System - Quick Reference

## ✅ Completato

Sistema di design completo con palette minimalista e variabili SCSS.

### 📁 File Creati

```
resources/css/
├── _variables.scss   ✅ Tutte le variabili (colori, typography, spacing)
├── _mixins.scss      ✅ Mixins riutilizzabili
├── app.scss          ✅ File principale SCSS + Tailwind
└── README.md         ✅ Documentazione completa
```

### 🎨 Palette Colori (Non Troppo Accesa)

**Primary** - Slate/Blue tenue (neutro e professionale)
- `$primary-500: #64748b` 
- `$primary-600: #475569`
- `$primary-700: #334155`

**Accent** - Warm terracotta/rose (elegante)
- `$accent-500: #e06155`
- `$accent-600: #cc4237` 
- `$accent-700: #ab352c`

**Secondary** - Sage/Green soft (naturale)
- `$secondary-500: #637063`
- `$secondary-600: #4e5a4e`
- `$secondary-700: #414941`

**Neutral** - Warm gray (caldo)
- `$neutral-100: #f5f5f4` - Backgrounds
- `$neutral-500: #78716c` - Testo secondario
- `$neutral-900: #1c1917` - Testo primario

### 📝 Typography

**Fonts:**
- Primary: `Inter` (clean, moderno)
- Secondary: `Georgia` (elegante per titoli)
- Mono: `Fira Code` (codice)

**Sizes:** Da `$font-size-xs` (12px) a `$font-size-8xl` (96px)

**Weights:** Da `$font-weight-light` (300) a `$font-weight-black` (900)

### 📏 Spacing

Sistema basato su 4px:
- `$spacing-1`: 4px
- `$spacing-2`: 8px
- `$spacing-4`: 16px
- `$spacing-8`: 32px
- `$spacing-12`: 48px

### 🔘 Borders & Radius

- `$border-radius-sm`: 2px
- `$border-radius-lg`: 8px (bottoni)
- `$border-radius-xl`: 12px (cards)
- `$border-radius-2xl`: 16px
- `$border-radius-full`: circular

### 🎯 Icons

Da `$icon-size-xs` (16px) a `$icon-size-2xl` (48px)

### ✨ Mixins Principali

**Responsive:**
```scss
@include sm { ... }  // ≥640px
@include md { ... }  // ≥768px
@include lg { ... }  // ≥1024px
```

**Dark Mode:**
```scss
@include dark { ... }
```

**Typography:**
```scss
@include heading-1;
@include body-base;
@include caption;
```

**Components:**
```scss
@include card;
@include button-base;
@include input-base;
```

**Utilities:**
```scss
@include flex-center;
@include transition-all;
@include truncate;
```

## 🚀 Uso

### In SCSS:
```scss
.my-button {
  background: $accent-500;
  padding: $spacing-4;
  border-radius: $border-radius-lg;
  @include transition-all;

  &:hover {
    background: $accent-600;
  }
}
```

### In Tailwind (con custom theme):
```html
<div class="bg-primary-500 text-accent-500">
  <button class="bg-accent-500 hover:bg-accent-600">
    Click me
  </button>
</div>
```

### Con Mixins:
```scss
.card {
  @include card;
  @include card-hover;

  h3 {
    @include heading-3;
  }
}
```

## 📖 Documentazione

Vedi `resources/css/README.md` per la documentazione completa con tutti i dettagli e esempi.

## ✅ Next Steps

1. Usa le variabili SCSS invece di valori hardcoded
2. Applica i mixins per componenti consistenti
3. Mantieni la palette minimalista
4. Testa dark mode su tutti i componenti
5. Documenta nuovi componenti custom

---

**Design System pronto all'uso!** 🎨

Per compilare: `npm run dev`

