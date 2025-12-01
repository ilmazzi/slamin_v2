<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
    <!-- Navigation Header -->
    <x-layouts.navigation-modern />
    
    <!-- Main Content -->
    <div class="pt-16 md:pt-20">
        <div class="min-h-[calc(100vh-4rem)] md:min-h-[calc(100vh-5rem)] flex flex-col lg:flex-row max-w-7xl mx-auto">
            <!-- Left Side - Features -->
            <div class="hidden lg:flex lg:flex-1 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 items-start justify-center p-6 xl:p-8 relative overflow-visible lg:min-h-[calc(100vh-5rem)]">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
                <div class="absolute w-96 h-96 bg-white rounded-full blur-3xl -bottom-48 -right-48 animate-pulse" style="animation-delay: 1s;"></div>
            </div>

            <div class="max-w-full w-full relative z-10 text-white px-4 py-6">
                <h3 class="text-2xl xl:text-3xl font-bold mb-4 text-center" style="font-family: 'Crimson Pro', serif;">
                    {{ __('register.home_for_poetry') }}
                </h3>
                <p class="text-base xl:text-lg text-white/90 mb-6 text-center px-4">
                    {{ __('register.platform_description') }}
                </p>
                
                {{-- Categories Grid - Hero Cards from Homepage - Horizontal Layout --}}
                <div class="flex flex-wrap justify-center gap-3 max-w-full mx-auto px-4 pt-6 pb-4"
                     style="-webkit-overflow-scrolling: touch;">
                    
                    {{-- Poetry - Mini Paper Sheet --}}
                    <?php $paperRotation = rand(-2, 2); ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-paper-wrapper cursor-pointer"
                             style="transform: rotate({{ $paperRotation }}deg);">
                            <div class="hero-paper-sheet">
                                <div class="flex items-center justify-center h-full">
                                    <h3 class="hero-paper-title">
                                        "{{ __('home.hero_category_poems') }}"
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.poetry_section_title')) }}</div>
                    </div>
                    
                    {{-- Articles - Mini Magazine --}}
                    <?php 
                        $rotation = rand(-3, 3);
                        $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
                        $pinRotation = rand(-15, 15);
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-magazine-wrapper cursor-pointer">
                            <div class="hero-thumbtack" 
                                 style="background: {{ $pinColor }}; transform: rotate({{ $pinRotation }}deg);">
                                <div class="hero-thumbtack-needle"></div>
                            </div>
                            <div class="hero-magazine-cover" style="transform: rotate({{ $rotation }}deg);">
                                <div class="hero-magazine-inner">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="text-xs font-bold text-neutral-900">SLAMIN</div>
                                        <div class="text-[8px] text-neutral-600">Vol. {{ date('Y') }} · N.{{ rand(10, 99) }}</div>
                                    </div>
                                    <div class="hero-magazine-image-area" style="background: url('<?php echo [
                                        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                                        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400',
                                        'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400',
                                        'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400'
                                    ][rand(0, 3)]; ?>') center/cover;">
                                    </div>
                                    <h3 class="hero-magazine-title mt-2">
                                        {{ __('home.hero_category_articles') }}
                                    </h3>
                                    <div class="h-[1px] bg-neutral-300 my-1"></div>
                                    <p class="text-[7px] text-neutral-500 leading-[0.6rem]">
                                        Prtn b nsnt st ps dlrs dcms vntr
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.articles_section_title')) }}</div>
                    </div>
                    
                    {{-- Gigs - Mini Notice Board --}}
                    <?php
                        $tapeWidth = rand(80, 100);
                        $tapeRotation = rand(-4, 4);
                        $paperRotation = rand(-2, 2);
                        $tapeBottomRotation = rand(-4, 4);
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-notice-wrapper cursor-pointer">
                            <div class="hero-washi-tape hero-washi-top" 
                                 style="width: {{ $tapeWidth }}px; 
                                        transform: translate(calc(-50%), 0) rotate({{ $tapeRotation }}deg);"></div>
                            <div class="hero-notice-paper" style="transform: rotate({{ $paperRotation }}deg);">
                                <div class="flex items-center justify-center h-full">
                                    <div class="hero-notice-badge">{{ strtoupper(__('home.hero_category_gigs')) }}</div>
                                </div>
                            </div>
                            <div class="hero-washi-tape hero-washi-bottom" 
                                 style="width: {{ $tapeWidth }}px; 
                                        transform: translate(calc(-50%), 0) rotate({{ $tapeBottomRotation }}deg);"></div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.gigs_section_title')) }}</div>
                    </div>
                    
                    {{-- Events - Mini Cinema Ticket --}}
                    <?php 
                        $tilt = rand(-3, 3);
                        $selectedColors = [
                            ['#fefaf3', '#fdf8f0', '#faf5ec'],
                            ['#fef9f1', '#fdf7ef', '#faf4ea'],
                            ['#fffbf5', '#fef9f3', '#fdf7f1']
                        ][rand(0, 2)];
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-ticket-wrapper cursor-pointer"
                             style="transform: rotate({{ $tilt }}deg);">
                            <div class="hero-cinema-ticket"
                                 style="background: linear-gradient(135deg, {{ $selectedColors[0] }} 0%, {{ $selectedColors[1] }} 50%, {{ $selectedColors[2] }} 100%);">
                                <div class="hero-ticket-perforation"></div>
                                <div class="hero-ticket-content">
                                    <div class="ticket-mini-header">
                                        <div class="text-[8px] font-black tracking-wider text-red-700">TICKET</div>
                                        <div class="text-[7px] font-bold text-amber-700">#0{{ rand(1, 9) }}{{ rand(0, 9) }}{{ rand(0, 9) }}</div>
                                    </div>
                                    <div class="flex-1 flex items-center justify-center">
                                        <div class="hero-ticket-stamp">{{ strtoupper(__('home.hero_category_events')) }}</div>
                                    </div>
                                    <div class="ticket-mini-barcode">
                                        <div class="flex justify-center gap-[1px]">
                                            @for($j = 0; $j < 20; $j++)
                                            <div style="width: {{ rand(1, 2) }}px; height: {{ rand(12, 18) }}px; background: #2d2520;"></div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.events_section_title')) }}</div>
                    </div>
                    
                    {{-- Videos - Mini Film Strip --}}
                    <?php $tilt = rand(-2, 2); ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-film-wrapper cursor-pointer"
                             style="transform: rotate({{ $tilt }}deg);">
                            <div class="hero-film-strip">
                                <!-- Film codes -->
                                <div class="hero-film-code-top">SLAMIN</div>
                                <div class="hero-film-code-bottom">ISO 400</div>
                                
                                <!-- Film frame with thumbnail -->
                                <div class="hero-film-frame">
                                    <!-- Left perforation -->
                                    <div class="hero-film-perf-left">
                                        @for($h = 0; $h < 8; $h++)
                                        <div class="hero-perf-hole"></div>
                                        @endfor
                                    </div>
                                    
                                    <!-- Right perforation -->
                                    <div class="hero-film-perf-right">
                                        @for($h = 0; $h < 8; $h++)
                                        <div class="hero-perf-hole"></div>
                                        @endfor
                                    </div>
                                    
                                    <div class="hero-frame-number-tl">///01</div>
                                    <div class="hero-frame-number-tr">01A</div>
                                    <div class="hero-frame-number-bl">35MM</div>
                                    <div class="hero-frame-number-br">{{ rand(1, 9) }}</div>
                                    
                                    <!-- Thumbnail background with random image -->
                                    <div class="hero-film-thumbnail" style="background: url('<?php echo [
                                        'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=400',
                                        'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=400',
                                        'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=400',
                                        'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=400',
                                        'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400',
                                        'https://images.unsplash.com/photo-1501612780327-45045538702b?w=400'
                                    ][rand(0, 5)]; ?>') center/cover;">
                                    </div>
                                    
                                    <!-- Media text overlay -->
                                    <div class="hero-film-text">
                                        {{ __('home.hero_category_videos') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.videos_section_title')) }}</div>
                    </div>
                    
                    {{-- New Users - Mini Polaroid --}}
                    <?php 
                        $rotation = rand(-3, 3);
                        $tapeRotation = rand(-8, 8);
                        $tapeWidth = rand(60, 80);
                        $tapeColors = [
                            ['rgba(255, 220, 0, 0.95)', 'rgba(255, 230, 50, 0.93)', 'rgba(255, 240, 100, 0.95)'],
                            ['rgba(255, 105, 180, 0.92)', 'rgba(255, 130, 200, 0.90)', 'rgba(255, 150, 215, 0.92)'],
                            ['rgba(0, 150, 255, 0.90)', 'rgba(50, 170, 255, 0.88)', 'rgba(100, 190, 255, 0.90)'],
                            ['rgba(50, 255, 50, 0.88)', 'rgba(80, 255, 80, 0.86)', 'rgba(110, 255, 110, 0.88)'],
                        ];
                        $selectedTape = $tapeColors[array_rand($tapeColors)];
                    ?>
                    <div class="hero-card-container flex-shrink-0">
                        <div class="hero-polaroid-wrapper cursor-pointer"
                             style="transform: rotate({{ $rotation }}deg);">
                            <!-- Tape -->
                            <div class="hero-polaroid-tape" 
                                 style="width: {{ $tapeWidth }}px; 
                                        transform: rotate({{ $tapeRotation }}deg);
                                        background: linear-gradient(135deg, {{ $selectedTape[0] }}, {{ $selectedTape[1] }}, {{ $selectedTape[2] }});"></div>
                            
                            <!-- Polaroid Card -->
                            <div class="hero-polaroid-card">
                                <div class="hero-polaroid-photo" style="background: linear-gradient(135deg, <?php echo [
                                    '#4a7c59 0%, #2d5a3f 100%',
                                    '#0369a1 0%, #0284c7 100%',
                                    '#d97706 0%, #ea580c 100%',
                                    '#7c3aed 0%, #5b21b6 100%'
                                ][rand(0, 3)]; ?>);">
                                    <svg class="w-12 h-12 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="hero-polaroid-caption">
                                    {{ __('home.hero_category_users') }}
                                </div>
                            </div>
                        </div>
                        <div class="hero-card-label">{{ strip_tags(__('home.new_users_title')) }}</div>
                    </div>
                    
                </div>
            </div>
        </div>

            <!-- Right Side - Form -->
            <div class="flex-1 flex items-center justify-center px-4 py-6 sm:px-6 lg:px-8 bg-neutral-50 dark:bg-neutral-950 lg:min-h-[calc(100vh-5rem)] overflow-x-hidden">
            <div class="max-w-md w-full mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                        {{ __('register.create_account') }}
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        {{ __('register.complete_profile') }}
                    </p>
                </div>

                <!-- Error Message -->
                @error('error')
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    </div>
                @enderror

                <!-- Register Form -->
                <form wire:submit="register" class="space-y-5">
                    <!-- Selezione Lingua -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <strong>🌐 {{ __('register.preferred_language') }}</strong>
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-2">
                            {{ __('register.language_tip') }}
                        </p>
                        <select wire:model.live="language" 
                                class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                            @foreach($this->languages as $code => $language)
                                <option value="{{ $code }}">{{ $language['flag'] }} {{ $language['name'] }}</option>
                            @endforeach
                        </select>
                        @error('language')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nome e Cognome -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nome -->
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('register.first_name') }} *
                            </label>
                            <input id="first_name" 
                                   wire:model="first_name"
                                   type="text" 
                                   required 
                                   placeholder="{{ __('register.first_name_placeholder') }}"
                                   class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                            @error('first_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cognome -->
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('register.last_name') }} *
                            </label>
                            <input id="last_name" 
                                   wire:model="last_name"
                                   type="text" 
                                   required 
                                   placeholder="{{ __('register.last_name_placeholder') }}"
                                   class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                            @error('last_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nickname (Opzionale) -->
                    <div>
                        <label for="nickname" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.nickname') }} 
                            <span class="text-xs text-neutral-500">({{ __('register.optional') }})</span>
                        </label>
                        <input id="nickname" 
                               wire:model="nickname"
                               type="text" 
                               placeholder="{{ __('register.nickname_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        @error('nickname')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.email') }} *
                        </label>
                        <input id="email" 
                               wire:model="email"
                               type="email" 
                               required 
                               placeholder="{{ __('register.email_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.password') }} *
                        </label>
                        <input id="password" 
                               wire:model="password"
                               type="password" 
                               required 
                               placeholder="{{ __('auth.password_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                        <p class="mt-1 text-xs text-neutral-500">{{ __('register.password_min_characters') }}</p>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('register.confirm_password') }} *
                        </label>
                        <input id="password_confirmation" 
                               wire:model="password_confirmation"
                               type="password" 
                               required 
                               placeholder="{{ __('auth.confirm_password_placeholder') }}"
                               class="w-full px-4 py-3 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 dark:bg-neutral-800 dark:text-white transition-all">
                    </div>

                    <!-- Selezione Ruoli -->
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <strong>🎭 {{ __('register.choose_role') }}</strong>
                        </label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-3">
                            {{ __('register.choose_role_description') }}
                        </p>

                        <div class="grid grid-cols-1 gap-3">
                            @foreach($this->roles as $role)
                                <div class="border-2 rounded-xl p-3 transition-all cursor-pointer
                                    @if(in_array($role['name'], $selectedRoles))
                                        border-primary-500 bg-primary-50 dark:bg-primary-900/20
                                    @else
                                        border-neutral-200 dark:border-neutral-700 hover:border-primary-300 dark:hover:border-primary-700
                                    @endif">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="checkbox"
                                               wire:click="toggleRole('{{ $role['name'] }}')"
                                               @checked(in_array($role['name'], $selectedRoles))
                                               class="mt-1 w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500 flex-shrink-0">
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xl flex-shrink-0">{{ $role['icon'] }}</span>
                                                <strong class="text-neutral-900 dark:text-white text-sm sm:text-base">{{ $role['display_name'] }}</strong>
                                            </div>
                                            <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-1 break-words">{{ $role['description'] }}</p>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('selectedRoles')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Privacy Acceptance -->
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input 
                                    id="acceptTerms" 
                                    wire:model="acceptTerms" 
                                    type="checkbox" 
                                    class="w-4 h-4 border-neutral-300 rounded text-primary-600 focus:ring-primary-500 dark:border-neutral-600 dark:bg-neutral-700"
                                    required
                                >
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="acceptTerms" class="text-neutral-700 dark:text-neutral-300">
                                    {{ __('register.accept_terms') }}
                                    <a href="{{ route('terms') }}" target="_blank" class="font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                                        {{ __('register.terms_of_service') }}
                                    </a>
                                    {{ __('register.and') }}
                                    <a href="{{ route('privacy') }}" target="_blank" class="font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                                        {{ __('register.privacy_policy') }}
                                    </a>
                                </label>
                            </div>
                        </div>
                        @error('acceptTerms')
                            <p class="ml-7 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                        {{ __('register.join_slam_in') }}
                    </button>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('register.already_have_account') }}
                            <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700">
                                {{ __('register.login') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <x-layouts.footer-modern />
    
    <style>
    /* Scrollbar Hide */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    /* Hero Card Container with Label - Horizontal Layout (Smaller for sidebar) */
    .hero-card-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        width: 100px;
        min-width: 100px;
        max-width: 100px;
        padding-top: 12px; /* Spazio per elementi che escono in alto (puntina, nastro) */
        margin-bottom: 12px; /* Spazio in basso per le label */
    }
    
    .hero-card-container:hover > div:first-child {
        transform: scale(1.12) translateY(-8px) !important;
        z-index: 10;
    }
    
    /* Hero Card Label - Appears below on hover - Smaller */
    .hero-card-label {
        font-family: 'Crimson Pro', serif;
        font-size: 0.875rem;
        font-weight: 700;
        color: white;
        text-align: center;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        text-shadow: 
            0 0 20px rgba(16, 185, 129, 0.8),
            0 0 40px rgba(16, 185, 129, 0.6),
            0 2px 4px rgba(0, 0, 0, 0.9);
        white-space: nowrap;
        pointer-events: none;
    }
    
    .hero-card-container:hover .hero-card-label {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Poetry - Mini Paper Sheet - Smaller */
    .hero-paper-wrapper {
        display: block;
        width: 100px;
        transition: all 0.3s ease;
    }
    
    .hero-paper-wrapper:hover {
        transform: translateY(-6px) scale(1.05);
    }
    
    .hero-paper-sheet {
        background: 
            linear-gradient(135deg, 
                rgba(255,253,245,0) 0%, 
                rgba(250,240,220,0.4) 25%, 
                rgba(245,235,215,0.3) 50%, 
                rgba(240,230,210,0.4) 75%, 
                rgba(255,250,240,0) 100%),
            radial-gradient(circle at 20% 30%, rgba(210,180,140,0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(205,175,135,0.12) 0%, transparent 50%),
            #faf6ed;
        padding: 1rem 0.75rem;
        height: 115px;
        border-radius: 3px;
        box-shadow: 
            inset 0 0 0 3px rgba(180, 120, 70, 0.85),
            inset 0 0 18px 7px rgba(160, 100, 60, 0.55),
            inset 0 0 28px 11px rgba(140, 90, 50, 0.35),
            0 5px 8px rgba(0, 0, 0, 0.25),
            0 10px 15px rgba(0, 0, 0, 0.2),
            0 15px 22px rgba(0, 0, 0, 0.15),
            0 20px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-paper-wrapper:hover .hero-paper-sheet {
        box-shadow: 
            inset 0 0 0 3px rgba(180, 120, 70, 0.85),
            inset 0 0 18px 7px rgba(160, 100, 60, 0.55),
            inset 0 0 28px 11px rgba(140, 90, 50, 0.35),
            0 10px 16px rgba(0, 0, 0, 0.3),
            0 20px 30px rgba(0, 0, 0, 0.25),
            0 30px 45px rgba(0, 0, 0, 0.2);
    }
    
    .hero-paper-title {
        font-family: 'Crimson Pro', serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: #2d2520;
        line-height: 1.3;
        text-align: center;
        transition: color 0.3s ease;
    }
    
    .hero-paper-wrapper:hover .hero-paper-title {
        color: #4a7c59;
    }
    
    /* Articles - Mini Magazine - Smaller */
    .hero-magazine-wrapper {
        display: block;
        width: 100px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .hero-magazine-wrapper:hover {
        transform: translateY(-6px);
    }
    
    .hero-thumbtack {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        box-shadow: 
            0 3px 6px rgba(0, 0, 0, 0.35),
            inset 0 1px 3px rgba(255, 255, 255, 0.4),
            inset 0 -1px 2px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }
    
    .hero-thumbtack-needle {
        position: absolute;
        top: 16px;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 6px;
        background: linear-gradient(to bottom, 
            rgba(0, 0, 0, 0.4),
            rgba(0, 0, 0, 0.2),
            transparent
        );
    }
    
    .hero-magazine-cover {
        background: linear-gradient(135deg, 
            #fefefe 0%,
            #fcfcfc 25%,
            #fafafa 50%,
            #f8f8f8 75%,
            #f6f6f6 100%
        );
        border: 2px solid #2d2d2d;
        border-radius: 4px;
        box-shadow: 
            0 6px 10px rgba(0, 0, 0, 0.25),
            0 12px 20px rgba(0, 0, 0, 0.2),
            0 18px 30px rgba(0, 0, 0, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.6),
            inset 0 2px 4px rgba(255, 255, 255, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-magazine-inner {
        padding: 0.75rem 0.5rem;
        height: 115px;
        display: flex;
        flex-direction: column;
    }
    
    .hero-magazine-wrapper:hover .hero-magazine-cover {
        box-shadow: 
            0 10px 16px rgba(0, 0, 0, 0.3),
            0 20px 32px rgba(0, 0, 0, 0.25),
            0 30px 48px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.6),
            inset 0 2px 4px rgba(255, 255, 255, 0.3);
    }
    
    .hero-magazine-title {
        font-family: 'Crimson Pro', serif;
        font-size: 0.7rem;
        font-weight: 700;
        line-height: 1.2;
        color: #1a1a1a;
        text-align: left;
        transition: color 0.3s ease;
    }
    
    .hero-magazine-wrapper:hover .hero-magazine-title {
        color: #10b981;
    }
    
    .hero-magazine-image-area {
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 3px;
        overflow: hidden;
    }
    
    /* Gigs - Mini Notice Board - Smaller */
    .hero-notice-wrapper {
        display: block;
        width: 100px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .hero-notice-wrapper:hover {
        transform: translateY(-6px);
    }
    
    .hero-washi-tape {
        position: absolute;
        left: 50%;
        height: 24px;
        border-radius: 1px;
        background: 
            linear-gradient(
                105deg,
                rgba(255, 255, 255, 0.25) 0%,
                transparent 30%,
                transparent 70%,
                rgba(255, 255, 255, 0.25) 100%
            ),
            linear-gradient(180deg, 
                rgba(240, 210, 100, 0.92) 0%, 
                rgba(245, 220, 120, 0.90) 50%, 
                rgba(250, 230, 140, 0.92) 100%
            );
        box-shadow: 
            0 3px 8px rgba(0, 0, 0, 0.35),
            0 1px 4px rgba(0, 0, 0, 0.25),
            inset 0 2px 5px rgba(255, 255, 255, 0.9),
            inset 0 -1px 3px rgba(0, 0, 0, 0.2);
        z-index: 10;
        border-top: 1px solid rgba(255, 255, 255, 0.8);
        border-bottom: 1px solid rgba(200, 180, 100, 0.4);
        clip-path: polygon(
            0% 0%, 2% 5%, 0% 10%, 2% 15%, 0% 20%, 2% 25%, 0% 30%, 2% 35%, 0% 40%, 2% 45%, 0% 50%, 2% 55%, 0% 60%, 2% 65%, 0% 70%, 2% 75%, 0% 80%, 2% 85%, 0% 90%, 2% 95%, 0% 100%,
            100% 100%,
            98% 95%, 100% 90%, 98% 85%, 100% 80%, 98% 75%, 100% 70%, 98% 65%, 100% 60%, 98% 55%, 100% 50%, 98% 45%, 100% 40%, 98% 35%, 100% 30%, 98% 25%, 100% 20%, 98% 15%, 100% 10%, 98% 5%, 100% 0%
        );
    }
    
    .hero-washi-top {
        top: -12px;
    }
    
    .hero-washi-bottom {
        bottom: -12px;
    }
    
    .hero-notice-paper {
        background: linear-gradient(135deg, 
            #fffef5 0%,
            #fffdf2 25%,
            #fefce8 50%,
            #fefbe5 75%,
            #fdfae3 100%
        );
        padding: 1rem 0.75rem;
        height: 115px;
        border-radius: 4px;
        box-shadow: 
            0 5px 8px rgba(0, 0, 0, 0.2),
            0 10px 15px rgba(0, 0, 0, 0.15),
            0 15px 22px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8),
            inset 0 2px 4px rgba(255, 255, 255, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hero-notice-wrapper:hover .hero-notice-paper {
        box-shadow: 
            0 8px 14px rgba(0, 0, 0, 0.25),
            0 16px 28px rgba(0, 0, 0, 0.2),
            0 24px 40px rgba(0, 0, 0, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.8),
            inset 0 2px 4px rgba(255, 255, 255, 0.4);
    }
    
    .hero-notice-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: white;
        background: linear-gradient(135deg, #0369a1 0%, #0284c7 100%);
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        box-shadow: 
            0 3px 6px rgba(0, 0, 0, 0.25),
            inset 0 1px 2px rgba(255, 255, 255, 0.3);
    }
    
    /* Events - Mini Cinema Ticket - Smaller */
    .hero-ticket-wrapper {
        display: block;
        width: 100px;
        transition: all 0.3s ease;
    }
    
    .hero-ticket-wrapper:hover {
        transform: translateY(-6px) scale(1.02);
    }
    
    .hero-cinema-ticket {
        display: flex;
        background: #fef7e6;
        border-radius: 6px;
        height: 115px;
        box-shadow: 
            0 6px 16px rgba(0, 0, 0, 0.4),
            0 12px 32px rgba(0, 0, 0, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .hero-ticket-wrapper:hover .hero-cinema-ticket {
        box-shadow: 
            0 10px 20px rgba(0, 0, 0, 0.5),
            0 16px 40px rgba(0, 0, 0, 0.4),
            0 0 0 2px rgba(218, 165, 32, 0.4);
    }
    
    .hero-ticket-perforation {
        width: 16px;
        background: linear-gradient(135deg, 
            rgba(139, 115, 85, 0.15) 0%,
            rgba(160, 140, 110, 0.1) 100%
        );
        position: relative;
        flex-shrink: 0;
    }
    
    .hero-ticket-perforation::before {
        content: '';
        position: absolute;
        top: -5px;
        bottom: -5px;
        right: 0;
        width: 8px;
        background: 
            radial-gradient(circle at 0 6px, transparent 3px, currentColor 3px) 0 0 / 8px 12px repeat-y;
        color: inherit;
    }
    
    .hero-ticket-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 0.75rem 0.5rem;
    }
    
    .ticket-mini-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.25rem;
        border-bottom: 1px dashed rgba(139, 115, 85, 0.3);
        margin-bottom: 0.5rem;
    }
    
    .ticket-mini-barcode {
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px dashed rgba(139, 115, 85, 0.3);
    }
    
    .hero-ticket-stamp {
        font-family: 'Special Elite', 'Courier New', monospace;
        text-align: center;
        font-size: 0.7rem;
        font-weight: 400;
        color: #b91c1c;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.375rem 0.75rem;
        border: 2px solid #b91c1c;
        border-radius: 3px;
        opacity: 0.7;
        position: relative;
        box-shadow: 
            0 2px 4px rgba(185, 28, 28, 0.2),
            inset 0 1px 2px rgba(185, 28, 28, 0.1);
    }
    
    .hero-ticket-stamp::before {
        content: '';
        position: absolute;
        inset: -1px;
        border: 1px solid rgba(185, 28, 28, 0.12);
        border-radius: 2px;
        pointer-events: none;
    }
    
    /* Videos - Mini Film Strip - Smaller */
    .hero-film-wrapper {
        display: block;
        width: 100px;
        transition: all 0.3s ease;
    }
    
    .hero-film-wrapper:hover {
        transform: translateY(-6px) scale(1.02);
    }
    
    .hero-film-strip {
        position: relative;
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0.08) 0%,
            transparent 30%
        ),
        linear-gradient(180deg, 
            rgba(80, 55, 35, 0.95) 0%,
            rgba(70, 48, 30, 0.97) 50%,
            rgba(80, 55, 35, 0.95) 100%
        );
        padding: 0.75rem 0.375rem;
        height: 115px;
        border-radius: 4px;
        box-shadow: 
            0 4px 8px rgba(0, 0, 0, 0.3),
            0 8px 16px rgba(0, 0, 0, 0.25),
            inset 0 2px 4px rgba(255, 255, 255, 0.1);
    }
    
    .hero-film-code-top,
    .hero-film-code-bottom {
        position: absolute;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 0.5rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        letter-spacing: 0.1em;
        z-index: 2;
    }
    
    .hero-film-code-top { top: 0.25rem; }
    .hero-film-code-bottom { bottom: 0.25rem; }
    
    .hero-film-frame {
        position: relative;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 2px;
        overflow: hidden;
    }
    
    .hero-film-perf-left,
    .hero-film-perf-right {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 0.85rem;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
        background: linear-gradient(180deg, 
            rgba(80, 55, 35, 0.98) 0%,
            rgba(70, 48, 30, 1) 50%,
            rgba(80, 55, 35, 0.98) 100%
        );
        z-index: 3;
    }
    
    .hero-film-perf-left { left: 0; }
    .hero-film-perf-right { right: 0; }
    
    .hero-perf-hole {
        width: 10px;
        height: 8px;
        background: rgba(240, 235, 228, 0.95);
        border-radius: 1px;
        box-shadow: 
            inset 0 2px 3px rgba(0, 0, 0, 0.4),
            inset 0 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    .hero-film-thumbnail {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    
    .hero-film-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-family: 'Crimson Pro', serif;
        font-size: 1.125rem;
        font-weight: 900;
        color: white;
        text-shadow: 
            0 0 20px rgba(16, 185, 129, 0.8),
            0 0 40px rgba(16, 185, 129, 0.6),
            0 0 60px rgba(16, 185, 129, 0.4),
            0 4px 8px rgba(0, 0, 0, 0.9),
            0 2px 4px rgba(0, 0, 0, 0.8);
        z-index: 10;
        white-space: nowrap;
        letter-spacing: 0.05em;
        animation: hero-film-glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes hero-film-glow {
        0% {
            text-shadow: 
                0 0 20px rgba(16, 185, 129, 0.8),
                0 0 40px rgba(16, 185, 129, 0.6),
                0 0 60px rgba(16, 185, 129, 0.4),
                0 4px 8px rgba(0, 0, 0, 0.9),
                0 2px 4px rgba(0, 0, 0, 0.8);
        }
        100% {
            text-shadow: 
                0 0 30px rgba(16, 185, 129, 1),
                0 0 50px rgba(16, 185, 129, 0.8),
                0 0 80px rgba(16, 185, 129, 0.6),
                0 6px 12px rgba(0, 0, 0, 0.9),
                0 3px 6px rgba(0, 0, 0, 0.8);
        }
    }
    
    .hero-film-wrapper:hover .hero-film-text {
        transform: translate(-50%, -50%) scale(1.1);
        transition: transform 0.3s ease;
    }
    
    .hero-frame-number-tl,
    .hero-frame-number-tr,
    .hero-frame-number-bl,
    .hero-frame-number-br {
        position: absolute;
        font-size: 0.5rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        z-index: 4;
    }
    
    .hero-frame-number-tl { top: 0.25rem; left: 1.1rem; }
    .hero-frame-number-tr { top: 0.25rem; right: 1.1rem; }
    .hero-frame-number-bl { bottom: 0.25rem; left: 1.1rem; }
    .hero-frame-number-br { bottom: 0.25rem; right: 1.1rem; }
    
    /* New Users - Mini Polaroid - Smaller */
    .hero-polaroid-wrapper {
        display: block;
        width: 100px;
        position: relative;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
    }
    
    .hero-polaroid-tape {
        position: absolute;
        top: -8px;
        left: 50%;
        transform-origin: center;
        height: 20px;
        border-radius: 2px;
        box-shadow: 
            0 2px 4px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        z-index: 2;
    }
    
    .hero-polaroid-card {
        background: linear-gradient(135deg, 
            #ffffff 0%,
            #fafafa 50%,
            #f5f5f5 100%
        );
        padding: 0.5rem 0.5rem 0.75rem 0.5rem;
        border-radius: 4px;
        box-shadow: 
            0 4px 8px rgba(0, 0, 0, 0.15),
            0 8px 16px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    
    .hero-polaroid-photo {
        width: 100%;
        height: 85px;
        background-color: #e5e5e5;
        border-radius: 2px;
        margin-bottom: 0.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hero-polaroid-photo svg {
        width: 2rem;
        height: 2rem;
    }
    
    .hero-polaroid-caption {
        font-family: 'Crimson Pro', serif;
        font-size: 0.65rem;
        font-weight: 600;
        color: #2d2d2d;
        text-align: center;
        line-height: 1.2;
    }
    
    /* Enhanced hover for all card wrappers */
    .hero-paper-wrapper,
    .hero-magazine-wrapper,
    .hero-notice-wrapper,
    .hero-ticket-wrapper,
    .hero-film-wrapper,
    .hero-polaroid-wrapper {
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));
    }
    
    .hero-card-container:hover .hero-paper-wrapper,
    .hero-card-container:hover .hero-magazine-wrapper,
    .hero-card-container:hover .hero-notice-wrapper,
    .hero-card-container:hover .hero-ticket-wrapper,
    .hero-card-container:hover .hero-film-wrapper,
    .hero-card-container:hover .hero-polaroid-wrapper {
        filter: drop-shadow(0 20px 40px rgba(16, 185, 129, 0.4)) 
                drop-shadow(0 0 30px rgba(16, 185, 129, 0.3));
    }
</style>
</div>
