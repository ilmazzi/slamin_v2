# 🎨 SLAMIN Design System

## Palette Colori

### Colori Principali

Il design system usa una **palette minimalista e non troppo accesa** per creare un'esperienza elegante e professionale.

#### Primary (Slate/Blue tenue)
Colore principale per elementi neutri e professionali.

```scss
$primary-500: #64748b  // Uso primario
$primary-600: #475569  // Hover states
$primary-700: #334155  // Active states
```

#### Accent (Warm terracotta/rose)
Colore d'accento per CTA e elementi importanti.

```scss
$accent-500: #e06155  // Uso primario
$accent-600: #cc4237  // Hover states
$accent-700: #ab352c  // Active states
```

#### Secondary (Sage/Green soft)
Colore secondario per elementi di supporto.

```scss
$secondary-500: #637063  // Uso primario
$secondary-600: #4e5a4e  // Hover states
$secondary-700: #414941  // Active states
```

#### Neutral (Warm gray)
Grigi caldi per testi e backgrounds.

```scss
$neutral-50: #fafaf9   // Bg chiaro
$neutral-100: #f5f5f4  // Bg card
$neutral-500: #78716c  // Testo secondario
$neutral-900: #1c1917  // Testo primario
```

---

## Typography

### Font Families

```scss
$font-primary: 'Inter'      // Corpo testo
$font-secondary: 'Georgia'  // Titoli eleganti (opzionale)
$font-mono: 'Fira Code'     // Codice
$font-display: 'Inter'      // Display/Hero
```

### Font Sizes

```scss
$font-size-xs: 0.75rem     // 12px - Caption
$font-size-sm: 0.875rem    // 14px - Small text
$font-size-base: 1rem      // 16px - Body
$font-size-lg: 1.125rem    // 18px - Large body
$font-size-xl: 1.25rem     // 20px - H6
$font-size-2xl: 1.5rem     // 24px - H5
$font-size-3xl: 1.875rem   // 30px - H4
$font-size-4xl: 2.25rem    // 36px - H3
$font-size-5xl: 3rem       // 48px - H2
$font-size-6xl: 3.75rem    // 60px - H1
```

### Font Weights

```scss
$font-weight-light: 300      // Testo leggero
$font-weight-normal: 400     // Testo normale
$font-weight-medium: 500     // Testo medio
$font-weight-semibold: 600   // Titoli
$font-weight-bold: 700       // Bold
```

---

## Spacing

Sistema di spacing basato su multipli di 4px:

```scss
$spacing-1: 0.25rem   // 4px
$spacing-2: 0.5rem    // 8px
$spacing-3: 0.75rem   // 12px
$spacing-4: 1rem      // 16px
$spacing-6: 1.5rem    // 24px
$spacing-8: 2rem      // 32px
$spacing-12: 3rem     // 48px
$spacing-16: 4rem     // 64px
```

---

## Borders

### Border Radius

```scss
$border-radius-sm: 0.125rem   // 2px - Subtle
$border-radius-base: 0.25rem  // 4px - Base
$border-radius-md: 0.375rem   // 6px - Medium
$border-radius-lg: 0.5rem     // 8px - Large (bottoni)
$border-radius-xl: 0.75rem    // 12px - Cards
$border-radius-2xl: 1rem      // 16px - Hero elements
$border-radius-full: 9999px   // Circular
```

---

## Shadows

```scss
$shadow-sm: ...    // Subtle shadow
$shadow-base: ...  // Default shadow
$shadow-md: ...    // Medium shadow (cards)
$shadow-lg: ...    // Large shadow (modals)
$shadow-xl: ...    // Extra large
```

---

## Icons

### Icon Sizes

```scss
$icon-size-xs: 1rem      // 16px
$icon-size-sm: 1.25rem   // 20px
$icon-size-base: 1.5rem  // 24px
$icon-size-lg: 2rem      // 32px
$icon-size-xl: 2.5rem    // 40px
```

---

## Mixins Disponibili

### Responsive

```scss
@include sm { ... }   // ≥640px
@include md { ... }   // ≥768px
@include lg { ... }   // ≥1024px
@include xl { ... }   // ≥1280px
```

### Dark Mode

```scss
@include dark { ... }
```

### Typography

```scss
@include heading-1;
@include heading-2;
@include body-base;
@include caption;
```

### Layout

```scss
@include flex-center;
@include flex-between;
@include card;
@include card-hover;
```

### Utilities

```scss
@include transition-all;
@include truncate;
@include line-clamp(2);
```

---

## Esempi d'Uso

### Button Custom

```scss
.btn-custom {
  @include button-base;
  @include button-md;
  background-color: $accent-500;
  color: white;

  &:hover {
    background-color: $accent-600;
  }

  @include dark {
    background-color: $accent-600;
  }
}
```

### Card Personalizzata

```scss
.custom-card {
  @include card;
  @include card-hover;
  padding: $spacing-6;
  
  h3 {
    @include heading-4;
    margin-bottom: $spacing-4;
  }
}
```

### Responsive Typography

```scss
.hero-title {
  @include heading-2;
  
  @include md {
    @include heading-1;
  }
}
```

---

## Tailwind + SCSS

Puoi combinare le utility di Tailwind con le tue variabili SCSS:

```html
<!-- Usando Tailwind con i tuoi colori custom -->
<div class="bg-primary-500 text-white">...</div>
<div class="bg-accent-500 hover:bg-accent-600">...</div>

<!-- Oppure usando classi SCSS custom -->
<div class="card-interactive">...</div>
```

---

## Best Practices

1. **Usa le variabili** invece di valori hardcoded
2. **Sfrutta i mixins** per codice riutilizzabile
3. **Mantieni consistenza** usando il design system
4. **Dark mode first** - pensa sempre alla modalità scura
5. **Mobile first** - usa i breakpoint progressivamente

---

## Struttura File

```
resources/css/
├── _variables.scss    # Tutte le variabili del design system
├── _mixins.scss       # Mixins riutilizzabili
├── app.scss           # File principale (importa tutto)
└── README.md          # Questa documentazione
```

---

**Design System creato per SLAMIN** 🎨

