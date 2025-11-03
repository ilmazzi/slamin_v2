<div>
    {{-- Hero Carousel --}}
    <livewire:home.hero-carousel />

    {{-- Events Slider --}}
    <livewire:home.events-slider />

    {{-- Statistics Section --}}
    <livewire:home.statistics-section />

    {{-- Videos Section --}}
    <livewire:home.videos-section />

    {{-- New Users Section --}}
    <livewire:home.new-users-section />

    {{-- Poetry & Articles Grid --}}
    <section class="py-12 md:py-20 bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 md:gap-12">
                {{-- Poetry Section --}}
                <div>
                    <livewire:home.poetry-section />
                </div>
                
                {{-- Articles Section --}}
                <div>
                    <livewire:home.articles-section />
                </div>
            </div>
        </div>
    </section>
</div>
