<div>
    <section class="py-12 md:py-20 bg-white dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <!-- Total Users -->
                <x-ui.stats.counter 
                    :number="$stats['total_users'] ?? 0" 
                    label="Poeti"
                    icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />

                <!-- Total Videos -->
                <x-ui.stats.counter 
                    :number="$stats['total_videos'] ?? 0" 
                    label="Video"
                    icon="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />

                <!-- Total Events -->
                <x-ui.stats.counter 
                    :number="$stats['total_events'] ?? 0" 
                    label="Eventi"
                    icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                <!-- Total Views -->
                <x-ui.stats.counter 
                    :number="$stats['total_views'] ?? 0" 
                    label="Visualizzazioni"
                    icon="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </div>
        </div>
    </section>
</div>
