<div class="snap-timeline relative mt-4">
    
    <!-- Progress Bar Container -->
    <div class="relative h-2 bg-neutral-200 dark:bg-neutral-700 rounded-full overflow-hidden">
        <!-- Progress (updates with video time) -->
        <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-primary-500 to-primary-600 transition-all duration-200"
             style="width: {{ $duration > 0 ? ($currentTime / $duration * 100) : 0 }}%">
        </div>
    </div>
    
    <!-- Snap Markers -->
    @foreach($snaps as $snap)
        <div class="absolute -top-1 transform -translate-x-1/2 cursor-pointer group z-10" 
             style="left: {{ ($snap->timestamp / ($duration ?: 1)) * 100 }}%"
             wire:click="seekToTime({{ $snap->timestamp }})"
             x-data="{ showTooltip: false }"
             @mouseenter="showTooltip = true"
             @mouseleave="showTooltip = false">
            
            <!-- Marker Icon -->
            <div class="w-6 h-6 bg-primary-600 border-2 border-white dark:border-neutral-900 rounded-full flex items-center justify-center shadow-lg group-hover:scale-125 transition-all duration-300">
                <img src="{{ asset('assets/icon/new/like.svg') }}" 
                     alt="Snap" 
                     class="w-3 h-3"
                     style="filter: brightness(0) saturate(100%) invert(100%) sepia(0%) saturate(7500%) hue-rotate(0deg) brightness(100%) contrast(100%);">
            </div>
            
            <!-- Tooltip -->
            <div x-show="showTooltip"
                 x-transition
                 class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-neutral-900 dark:bg-neutral-800 text-white rounded-lg p-3 shadow-2xl min-w-[200px] pointer-events-none"
                 style="display: none;">
                <div class="font-bold text-sm mb-1">{{ $snap->title }}</div>
                @if($snap->description)
                <div class="text-xs text-neutral-300">{{ $snap->description }}</div>
                @endif
                <div class="text-xs text-primary-400 mt-1">{{ $snap->formatted_timestamp }}</div>
                
                <!-- Arrow -->
                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                    <div class="w-2 h-2 bg-neutral-900 dark:bg-neutral-800 rotate-45"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
