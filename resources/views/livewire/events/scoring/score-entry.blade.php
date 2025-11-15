<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900">
    
    {{-- Success Toast --}}
    @if(session('success'))
        <div class="fixed top-24 right-6 z-50"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0 translate-x-full">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-3 shadow-xl flex items-center gap-3 rounded-xl">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-bold text-white">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-24 right-6 z-50"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="opacity-0 translate-x-full">
            <div class="bg-gradient-to-r from-red-600 to-amber-600 px-6 py-3 shadow-xl flex items-center gap-3 rounded-xl">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="font-bold text-white">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Elegant Header with Ticket Styles --}}
    <?php 
        $selectedColors = [
            ['#fefaf3', '#fdf8f0', '#faf5ec'],
            ['#fef9f1', '#fdf7ef', '#faf4ea'],
            ['#fffbf5', '#fef9f3', '#fdf7f1']
        ][rand(0, 2)];
        $selectedColorsDark = [
            ['#1a1a1a', '#2d2d2d', '#1f1f1f'],
            ['#1f1f1f', '#2d2d2d', '#262626'],
            ['#1a1a1a', '#262626', '#1f1f1f']
        ][rand(0, 2)];
    ?>
    <div class="relative py-4 overflow-hidden bg-gradient-to-br from-[#fefaf3] via-[#fdf8f0] to-[#faf5ec] dark:from-[#1a1a1a] dark:via-[#2d2d2d] dark:to-[#1f1f1f]"
         x-data="{ 
             lightColors: {{ json_encode($selectedColors) }},
             darkColors: {{ json_encode($selectedColorsDark) }},
             get bgStyle() { 
                 return document.documentElement.classList.contains('dark') 
                     ? `linear-gradient(135deg, ${this.darkColors[0]} 0%, ${this.darkColors[1]} 50%, ${this.darkColors[2]} 100%)`
                     : `linear-gradient(135deg, ${this.lightColors[0]} 0%, ${this.lightColors[1]} 50%, ${this.lightColors[2]} 100%)`;
             }
         }"
         x-bind:style="{ background: bgStyle }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center justify-between mb-2 pb-2 border-b-2 border-dashed border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                        <div class="text-xs font-black tracking-widest uppercase text-[#b91c1c] dark:text-[#8b7355]" style="letter-spacing: 0.1em;">{{ strtoupper(__('events.scoring.score_entry')) }}</div>
                        <div class="text-xs font-bold text-[#8b7355] dark:text-[#a3a3a3]" style="font-family: 'Courier New', monospace;">#{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold mb-3 text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $event->title }}</h1>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.rounds') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $rounds->count() }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.participants') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $participants->count() }}</div>
                        </div>
                        @if($selectedRound)
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.current_round') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ __('events.scoring.round') }} {{ $selectedRound }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="relative py-8">
        <div class="max-w-6xl mx-auto px-6">
            
            {{-- Navigation --}}
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="{{ route('events.scoring.scores', $event) }}" wire:navigate class="scoring-nav-button scoring-nav-active">
                    <i class="ph ph-pencil-line"></i>
                    {{ __('events.scoring.scores') }}
                </a>
                <a href="{{ route('events.scoring.participants', $event) }}" wire:navigate class="scoring-nav-button">
                    <i class="ph ph-users"></i>
                    {{ __('events.scoring.participants') }}
                </a>
                <a href="{{ route('events.scoring.rankings', $event) }}" wire:navigate class="scoring-nav-button">
                    <i class="ph ph-ranking"></i>
                    {{ __('events.scoring.rankings') }}
                </a>
            </div>

            {{-- Lock Alert --}}
            @if($isLocked)
            <div class="mb-6 scoring-alert scoring-alert-warning">
                <div class="flex items-center gap-4">
                    <div class="text-4xl">🔒</div>
                    <div>
                        <h4 class="font-bold mb-1 text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ __('events.scoring.event_completed') }}</h4>
                        <p class="text-[#92400e] dark:text-[#fbbf24]">{{ __('events.scoring.the_rankings_have_been_generated') }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Round Management --}}
            <div class="mb-6 scoring-card">
                <div class="scoring-card-header">
                    <h3 class="scoring-card-title">
                        <i class="ph-duotone ph-timer"></i>
                        {{ __('events.scoring.rounds') }} ({{ $rounds->count() }})
                    </h3>
                    @if(!$isLocked)
                    <button wire:click="openRoundModal" class="scoring-button-primary">
                        <i class="ph ph-plus"></i>
                        {{ __('events.scoring.add_round') }}
                    </button>
                    @endif
                </div>
                <div class="scoring-card-content">
                    @if($rounds->count() > 0)
                        <div class="flex flex-wrap gap-3 mb-4">
                            @foreach($rounds as $round)
                                <button wire:click="$set('selectedRound', {{ $round->round_number }})" 
                                        class="{{ $selectedRound == $round->round_number ? 'scoring-button-primary' : 'scoring-button-secondary' }}">
                                    {{ $round->name }}
                                </button>
                            @endforeach
                        </div>

                        @if(!$isLocked)
                        <div class="flex gap-3">
                            @foreach($rounds as $round)
                                @if($selectedRound == $round->round_number)
                                    <button wire:click="editRound({{ $round->id }})" class="scoring-button-secondary">
                                        <i class="ph ph-pencil"></i>{{ __('events.scoring.edit') }}
                                    </button>
                                    <button wire:click="deleteRound({{ $round->id }})" 
                                            class="scoring-button-secondary"
                                            onclick="return confirm('{{ __('events.scoring.confirm_delete_round') }}')">
                                        <i class="ph ph-trash"></i>{{ __('events.scoring.delete') }}
                                    </button>
                                @endif
                            @endforeach
                        </div>
                        @endif
                    @else
                        <p class="text-neutral-600 dark:text-neutral-400">{{ __('events.scoring.no_rounds_configured') }}</p>
                    @endif
                </div>
            </div>

            {{-- Score Entry --}}
            <div class="scoring-card">
                <div class="scoring-card-header">
                    <h3 class="scoring-card-title">
                        <i class="ph-duotone ph-pencil-line"></i>
                        {{ __('events.scoring.scores') }} - {{ __('events.scoring.round') }} {{ $selectedRound }}
                    </h3>
                </div>
                <div class="scoring-card-content">
                    @if($participants->count() > 0)
                        {{-- Mobile View --}}
                        <div class="block lg:hidden space-y-4">
                            @foreach($participants as $participant)
                                <div class="scoring-participant-card">
                                    <div class="flex items-center gap-3 mb-4">
                                        @if($participant->user)
                                            <img src="{{ $participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                                 alt="{{ $participant->display_name }}"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                        @else
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                <i class="ph ph-user text-2xl text-[#8b7355] dark:text-[#a3a3a3]"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                @if($participant->performance_order)
                                                    <span class="scoring-badge bg-gradient-to-r from-[#b91c1c] to-[#dc2626] dark:from-[#8b7355] dark:to-[#a68b5b] border-[#b91c1c] dark:border-[#8b7355] text-white">#{{ $participant->performance_order }}</span>
                                                @endif
                                                <h6 class="font-bold text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $participant->display_name }}</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.score') }} (0.0 - 10.0)</label>
                                        <div class="flex gap-2">
                                            <input type="number" 
                                                   wire:model="scores.{{ $participant->id }}"
                                                   class="scoring-input flex-1" 
                                                   step="0.1" 
                                                   min="0" 
                                                   max="10"
                                                   placeholder="{{ __('events.scoring.example') }}: 9.5">
                                            <button wire:click="saveScore({{ $participant->id }})" 
                                                    class="scoring-button-primary">
                                                <i class="ph ph-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Desktop Table --}}
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="scoring-table">
                                <thead>
                                    <tr>
                                        <th class="w-20">#</th>
                                        <th>{{ __('events.scoring.participant') }}</th>
                                        <th class="w-64">{{ __('events.scoring.score') }} (0.0 - 10.0)</th>
                                        <th class="w-32">{{ __('events.scoring.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td>
                                                @if($participant->performance_order)
                                                    <span class="scoring-badge bg-gradient-to-r from-[#b91c1c] to-[#dc2626] dark:from-[#8b7355] dark:to-[#a68b5b] border-[#b91c1c] dark:border-[#8b7355] text-white">#{{ $participant->performance_order }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    @if($participant->user)
                                                        <img src="{{ $participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                                             alt="{{ $participant->display_name }}"
                                                             class="w-10 h-10 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                    @else
                                                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                            <i class="ph ph-user text-[#8b7355] dark:text-[#a3a3a3]"></i>
                                                        </div>
                                                    @endif
                                                    <span class="font-bold text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $participant->display_name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       wire:model="scores.{{ $participant->id }}"
                                                       class="scoring-input" 
                                                       step="0.1" 
                                                       min="0" 
                                                       max="10"
                                                       placeholder="{{ __('events.scoring.example') }}: 9.5">
                                            </td>
                                            <td>
                                                <button wire:click="saveScore({{ $participant->id }})" 
                                                        class="scoring-button-primary">
                                                    <i class="ph ph-check"></i>{{ __('events.scoring.save') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 scoring-alert scoring-alert-info">
                            <p class="text-sm flex items-center gap-2" style="font-family: 'Crimson Pro', serif;">
                                <i class="ph ph-info text-lg"></i>
                                <strong>{{ __('events.scoring.note') }}:</strong> {{ __('events.scoring.scores_are_saved_automatically') }}. {{ __('events.scoring.scale_0_0_10_0_with_one_decimal') }}.
                            </p>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">👥</div>
                            <h4 class="text-xl font-black text-neutral-900 dark:text-white mb-2">{{ __('events.scoring.no_participants') }}</h4>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('events.scoring.add_participants_before_inserting_scores') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Round Modal --}}
    @if($showRoundModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="scoring-modal max-w-2xl w-full"
                 @click.away="$wire.set('showRoundModal', false)">
                <div class="scoring-modal-header">
                    <h3 class="scoring-modal-title">
                        {{ $editingRound ? __('events.scoring.edit_round') : __('events.scoring.add_round') }}
                    </h3>
                    <button wire:click="$set('showRoundModal', false)" class="text-[#8b7355] dark:text-[#a3a3a3]">
                        <i class="ph ph-x text-2xl"></i>
                    </button>
                </div>
                <div class="scoring-modal-content">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.round_number') }} *</label>
                                <input type="number" wire:model="round_number" class="scoring-input" min="1" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.round_name') }} *</label>
                                <input type="text" wire:model="round_name" class="scoring-input" required>
                                <small class="text-xs mt-1 block text-[#8b7355] dark:text-[#a3a3a3] opacity-60">{{ __('events.scoring.example') }}: "{{ __('events.scoring.first_round') }}", "{{ __('events.scoring.semi_final') }}", "{{ __('events.scoring.final') }}"</small>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.scoring_type') }} *</label>
                            <select wire:model="scoring_type" class="scoring-input">
                                <option value="average">{{ __('events.scoring.average') }} ({{ __('events.scoring.recommended') }})</option>
                                <option value="sum">{{ __('events.scoring.sum') }}</option>
                                <option value="best_of">{{ __('events.scoring.best_of') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scoring-modal-footer">
                    <button wire:click="$set('showRoundModal', false)" class="scoring-button-secondary">
                        {{ __('events.scoring.cancel') }}
                    </button>
                    <button wire:click="saveRound" class="scoring-button-primary">
                        <i class="ph ph-check"></i>{{ $editingRound ? __('events.scoring.update') : __('events.scoring.create') }} {{ __('events.scoring.round') }}
                    </button>
                </div>
            </div>
        </div>
    @endif


    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (data) => {
                Swal.fire({
                    icon: 'success',
                    title: data[0].title || '{{ __('events.scoring.success') }}!',
                    text: data[0].text || '',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn bg-red-600 hover:bg-red-700 text-white',
                    },
                    buttonsStyling: false,
                    timer: 2000
                });
            });

            Livewire.on('swal:warning', (data) => {
                Swal.fire({
                    icon: 'warning',
                    title: data[0].title || '{{ __('events.scoring.warning') }}',
                    text: data[0].text || '',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn bg-red-600 hover:bg-red-700 text-white',
                    },
                    buttonsStyling: false,
                });
            });

            Livewire.on('swal:error', (data) => {
                Swal.fire({
                    icon: 'error',
                    title: data[0].title || '{{ __('events.scoring.error') }}',
                    text: data[0].text || '',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn bg-red-600 hover:bg-red-700 text-white',
                    },
                    buttonsStyling: false,
                });
            });
        });
    </script>
    @endpush
</div>

