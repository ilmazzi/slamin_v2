@props([
    'user',
    'size' => 'md', // xs, sm, md, lg, xl
    'link' => true,
    'showName' => false,
    'showNickname' => false,
    'showStatus' => false,
    'status' => null
])

@php
$sizes = [
    'xs' => 'w-8 h-8 text-sm',
    'sm' => 'w-10 h-10 text-base',
    'md' => 'w-12 h-12 text-lg',
    'lg' => 'w-16 h-16 text-2xl',
    'xl' => 'w-20 h-20 text-3xl'
];
$sizeClasses = $sizes[$size] ?? $sizes['md'];

// Avatar URL or fallback
$avatarUrl = $user->profile_photo_url ?? null;
$initial = strtoupper(substr($user->name ?? 'U', 0, 1));

// Profile route (da implementare)
$profileUrl = '#'; // TODO: route('profile.show', $user->id) quando sarà pronto
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    @if($link)
        <a href="{{ $profileUrl }}" class="group">
    @endif
    
    {{-- Avatar --}}
    @if($avatarUrl)
        <img src="{{ $avatarUrl }}" 
             alt="{{ $user->name }}" 
             class="{{ $sizeClasses }} rounded-full object-cover shadow-lg group-hover:scale-110 transition-transform">
    @else
        <div class="{{ $sizeClasses }} rounded-full bg-gradient-to-br from-primary-500 to-accent-600 flex items-center justify-center text-white font-black shadow-lg group-hover:scale-110 transition-transform">
            {{ $initial }}
        </div>
    @endif

    @if($link)
        </a>
    @endif

    {{-- Info (optional) --}}
    @if($showName || $showNickname || $showStatus)
        <div class="flex-1 min-w-0">
            @if($showName)
                <div class="text-neutral-900 dark:text-white font-bold truncate">
                    @if($link)
                        <a href="{{ $profileUrl }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            {{ $user->name }}
                        </a>
                    @else
                        {{ $user->name }}
                    @endif
                </div>
            @endif
            
            @if($showNickname && $user->nickname)
                <div class="text-primary-600 dark:text-primary-400 text-sm font-medium">{{ '@' . $user->nickname }}</div>
            @endif
            
            @if($showStatus && $status)
                <div class="text-xs text-neutral-600 dark:text-neutral-400 uppercase font-semibold">{{ $status }}</div>
            @endif
        </div>
    @endif
</div>

