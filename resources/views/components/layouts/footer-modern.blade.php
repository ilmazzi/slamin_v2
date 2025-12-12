<footer class="bg-neutral-900 dark:bg-black text-neutral-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 md:gap-12 mb-12">
            <!-- Brand -->
            <div>
                <a href="{{ route('home') }}" class="flex items-center mb-4 group">
                    <img src="{{ asset('assets/images/Logo_orizzontale_bianco.png') }}" 
                         alt="{{ config('app.name') }}" 
                         class="h-10 w-auto group-hover:scale-105 transition-transform">
                </a>
                <p class="text-sm text-neutral-400 leading-relaxed">
                    {{ __('footer.description') }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-bold mb-4">{{ __('footer.discover') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('events.index') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.events') }}</a></li>
                    <li><a href="{{ route('poems.index') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.poems') }}</a></li>
                    <li><a href="{{ route('articles.index') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.articles') }}</a></li>
                    <li><a href="{{ route('media.index') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.media') }}</a></li>
                </ul>
            </div>

            <!-- Community -->
            <div>
                <h3 class="text-white font-bold mb-4">{{ __('footer.community') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('faq') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.faq') }}</a></li>
                    <li><a href="{{ route('help') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.help') }}</a></li>
                    <li><a href="{{ route('support') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.support') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.contact') }}</a></li>
                    @auth
                    <li>
                        <button onclick="Livewire.dispatch('openTutorial')" 
                                class="hover:text-primary-400 transition-colors flex items-center gap-2 text-left">
                            <span>📚</span>
                            <span>{{ __('footer.tutorial') }}</span>
                        </button>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Info -->
            <div>
                <h3 class="text-white font-bold mb-4">{{ __('footer.info') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.about') }}</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.terms') }}</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-primary-400 transition-colors">{{ __('footer.privacy') }}</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-white font-bold mb-4">{{ __('footer.newsletter') }}</h3>
                <p class="text-sm text-neutral-400 mb-4">
                    {{ __('footer.newsletter_description') }}
                </p>
                <livewire:components.newsletter-subscribe />
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-neutral-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center flex-wrap gap-3 text-sm text-neutral-500">
                <span>{{ __('footer.license_text') }}</span>
                <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" class="text-primary-400 hover:text-primary-300 transition-colors" target="_blank" rel="noopener noreferrer">CC BY-NC-SA 4.0</a>
                <span class="inline-flex items-center gap-1 ml-1">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/cc.svg" alt="CC" class="w-4 h-4 inline-block">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/by.svg" alt="BY" class="w-4 h-4 inline-block">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/nc.svg" alt="NC" class="w-4 h-4 inline-block">
                    <img src="https://mirrors.creativecommons.org/presskit/icons/sa.svg" alt="SA" class="w-4 h-4 inline-block">
                </span>
            </div>
            <div class="flex items-center flex-wrap gap-6 text-sm">
                <a href="{{ route('about') }}" class="text-neutral-400 hover:text-primary-400 transition-colors">{{ __('footer.about') }}</a>
                <a href="{{ route('terms') }}" class="text-neutral-400 hover:text-primary-400 transition-colors">{{ __('footer.terms') }}</a>
                <a href="{{ route('privacy') }}" class="text-neutral-400 hover:text-primary-400 transition-colors">{{ __('footer.privacy') }}</a>
            </div>
        </div>
    </div>
</footer>