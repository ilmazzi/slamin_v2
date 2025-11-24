# Guida ai Link dei Profili

## ⚠️ IMPORTANTE: Come linkare correttamente i profili utente

### ✅ CORRETTO

```blade
<!-- Link al profilo pubblico di un utente -->
<a href="{{ route('user.show', $user) }}">{{ $user->name }}</a>
<a href="{{ route('user.show', ['user' => $user->id]) }}">{{ $user->name }}</a>

<!-- Link al proprio profilo (utente loggato) -->
<a href="{{ route('profile.show') }}">Il mio profilo</a>
```

### ❌ SBAGLIATO

```blade
<!-- NON usare profile.show con parametri -->
<a href="{{ route('profile.show', $user) }}">{{ $user->name }}</a>
<a href="{{ route('profile.show', ['user' => $user->id]) }}">{{ $user->name }}</a>

<!-- NON usare URL diretti con query string -->
<a href="/profile?{{ $user->id }}">{{ $user->name }}</a>
```

## Route Disponibili

### `/profile` - Profilo Personale (Auth Required)
- **Route Name**: `profile.show`
- **Component**: `ProfileShow`
- **Parametri**: Nessuno
- **Uso**: Mostra il profilo dell'utente loggato

### `/user/{user}` - Profilo Pubblico
- **Route Name**: `user.show`
- **Component**: `ProfileShow`
- **Parametri**: `{user}` - ID o nickname dell'utente
- **Uso**: Mostra il profilo pubblico di qualsiasi utente

## Esempi Pratici

### In Blade Templates
```blade
<!-- Lista utenti -->
@foreach($users as $user)
    <a href="{{ route('user.show', $user) }}">
        {{ $user->name }}
    </a>
@endforeach

<!-- Link al proprio profilo -->
<a href="{{ route('profile.show') }}">
    Il mio profilo
</a>
```

### In Livewire Components
```php
// Redirect al profilo pubblico
return $this->redirect(route('user.show', $user));

// Redirect al proprio profilo
return $this->redirect(route('profile.show'));
```

### In Notifiche
```php
public function toArray($notifiable)
{
    return [
        'url' => route('user.show', $this->user),
        // ...
    ];
}
```

## Debugging

Se vedi URL come `/profile?31`, significa che:
1. Stai usando `route('profile.show', $user)` invece di `route('user.show', $user)`
2. O stai costruendo l'URL manualmente in modo errato

**Soluzione**: Usa sempre `route('user.show', $user)` per profili pubblici.

