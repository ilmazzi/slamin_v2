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
                        <div class="text-xs font-black tracking-widest uppercase text-[#b91c1c] dark:text-[#8b7355]" style="letter-spacing: 0.1em;">{{ strtoupper(__('events.scoring.participant_management')) }}</div>
                        <div class="text-xs font-bold text-[#8b7355] dark:text-[#a3a3a3]" style="font-family: 'Courier New', monospace;">#{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold mb-3 text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $event->title }}</h1>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.participants') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $participants->count() }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.confirmed') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $participants->where('status', 'confirmed')->count() }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase mb-1 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.performed') }}</div>
                            <div class="text-sm font-semibold text-[#b91c1c] dark:text-[#8b7355]" style="font-family: 'Crimson Pro', serif;">{{ $participants->where('status', 'performed')->count() }}</div>
                        </div>
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
                <a href="{{ route('events.scoring.scores', $event) }}" wire:navigate class="scoring-nav-button">
                    <i class="ph ph-pencil-line"></i>
                    {{ __('events.scoring.scores') }}
                </a>
                <a href="{{ route('events.scoring.participants', $event) }}" wire:navigate class="scoring-nav-button scoring-nav-active">
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
                        <p class="text-[#92400e] dark:text-[#fbbf24]">{{ __('events.scoring.rankings_generated') }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Participants List --}}
            <div class="scoring-card">
                <div class="scoring-card-header">
                    <div>
                        <h3 class="scoring-card-title mb-1">
                            <i class="ph-duotone ph-users"></i>
                            {{ __('events.scoring.participants') }} ({{ $participants->count() }})
                        </h3>
                        <p class="text-xs text-[#8b7355] dark:text-[#a3a3a3]">
                            <i class="ph ph-info me-1"></i>
                            {{ __('events.scoring.users_added_automatically') }}
                        </p>
                    </div>
                    @if(!$isLocked)
                    <button wire:click="openAddModal" class="scoring-button-primary">
                        <i class="ph ph-plus"></i>
                        {{ __('events.scoring.add') }}
                    </button>
                    @endif
                </div>
                <div class="scoring-card-content">
                    @if($participants->count() > 0)
                        {{-- Mobile View --}}
                        <div class="block lg:hidden space-y-4">
                            @foreach($participants as $participant)
                                <div class="scoring-participant-card">
                                    <div class="flex items-start gap-3 mb-4">
                                        @if($participant->user)
                                            <img src="{{ $participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                                 alt="{{ $participant->display_name }}"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] flex-shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] flex items-center justify-center flex-shrink-0">
                                                <i class="ph ph-user text-2xl text-[#8b7355] dark:text-[#a3a3a3]"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                @if($participant->performance_order)
                                                    <span class="scoring-badge bg-gradient-to-r from-[#b91c1c] to-[#dc2626] dark:from-[#8b7355] dark:to-[#a68b5b] border-[#b91c1c] dark:border-[#8b7355] text-white">#{{ $participant->performance_order }}</span>
                                                @endif
                                                <h6 class="font-bold text-[#1a1a1a] dark:text-[#e5e5e5] truncate" style="font-family: 'Crimson Pro', serif;">{{ $participant->display_name }}</h6>
                                            </div>
                                            @if($participant->isGuest())
                                                <span class="scoring-badge scoring-badge-pending mb-2 inline-block">
                                                    <i class="ph ph-user-circle me-1"></i>{{ __('events.scoring.guest') }}
                                                </span>
                                            @endif
                                            @if($participant->guest_email)
                                                <p class="text-sm text-[#8b7355] dark:text-[#a3a3a3]">{{ $participant->guest_email }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-bold text-[#8b7355] dark:text-[#a3a3a3] mb-2" style="letter-spacing: 0.05em;">{{ __('events.scoring.status') }}</label>
                                        <select wire:change="updateStatus({{ $participant->id }}, $event.target.value)" 
                                                class="scoring-input w-full">
                                            <option value="confirmed" {{ $participant->status === 'confirmed' ? 'selected' : '' }}>{{ __('events.scoring.confirmed') }}</option>
                                            <option value="performed" {{ $participant->status === 'performed' ? 'selected' : '' }}>{{ __('events.scoring.performed') }}</option>
                                            <option value="disqualified" {{ $participant->status === 'disqualified' ? 'selected' : '' }}>{{ __('events.scoring.disqualified') }}</option>
                                            <option value="no_show" {{ $participant->status === 'no_show' ? 'selected' : '' }}>{{ __('events.scoring.no_show') }}</option>
                                        </select>
                                    </div>

                                    @if(!$isLocked)
                                    <button wire:click="removeParticipant({{ $participant->id }})" 
                                            class="scoring-button-secondary w-full"
                                            onclick="return confirm('{{ __('events.scoring.are_you_sure_you_want_to_remove_this_participant') }}')">
                                        <i class="ph ph-trash"></i>{{ __('events.scoring.remove') }}
                                    </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Desktop Table --}}
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="scoring-table">
                                <thead>
                                    <tr>
                                        <th class="w-20">#</th>
                                        <th>{{ __('events.scoring.name') }}</th>
                                        <th>{{ __('events.scoring.type') }}</th>
                                        <th>{{ __('events.scoring.status') }}</th>
                                        <th>{{ __('events.scoring.score') }}</th>
                                        @if(!$isLocked)
                                        <th class="w-32">{{ __('events.scoring.actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                        <tr class="border-b border-[rgba(139,115,85,0.2)] dark:border-[rgba(139,115,85,0.3)] hover:bg-gradient-to-r hover:from-[rgba(254,250,243,0.3)] hover:to-[rgba(253,248,240,0.3)] dark:hover:from-[rgba(26,26,26,0.5)] dark:hover:to-[rgba(45,45,45,0.5)] transition-colors">
                                            <td class="py-4 px-6">
                                                @if($participant->performance_order)
                                                    <span class="scoring-badge bg-gradient-to-r from-[#b91c1c] to-[#dc2626] dark:from-[#8b7355] dark:to-[#a68b5b] border-[#b91c1c] dark:border-[#8b7355] text-white">#{{ $participant->performance_order }}</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-3">
                                                    @if($participant->user)
                                                        <img src="{{ $participant->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                                             alt="{{ $participant->display_name }}"
                                                             class="w-10 h-10 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                    @else
                                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[rgba(254,250,243,0.5)] to-[rgba(253,248,240,0.5)] dark:from-[rgba(26,26,26,0.5)] dark:to-[rgba(45,45,45,0.5)] border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)] flex items-center justify-center">
                                                            <i class="ph ph-user text-[#8b7355] dark:text-[#a3a3a3]"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="font-bold text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $participant->display_name }}</div>
                                                        @if($participant->guest_email)
                                                            <small class="text-[#8b7355] dark:text-[#a3a3a3] text-xs">{{ $participant->guest_email }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                @if($participant->isGuest())
                                                    <span class="scoring-badge scoring-badge-pending">
                                                        <i class="ph ph-user-circle me-1"></i>{{ __('events.scoring.guest') }}
                                                    </span>
                                                @else
                                                    <span class="scoring-badge scoring-badge-confirmed">
                                                        <i class="ph ph-user-check me-1"></i>{{ __('events.scoring.registered') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <select wire:change="updateStatus({{ $participant->id }}, $event.target.value)" 
                                                        class="scoring-input text-sm">
                                                    <option value="confirmed" {{ $participant->status === 'confirmed' ? 'selected' : '' }}>{{ __('events.scoring.confirmed') }}</option>
                                                    <option value="performed" {{ $participant->status === 'performed' ? 'selected' : '' }}>{{ __('events.scoring.performed') }}</option>
                                                    <option value="disqualified" {{ $participant->status === 'disqualified' ? 'selected' : '' }}>{{ __('events.scoring.disqualified') }}</option>
                                                    <option value="no_show" {{ $participant->status === 'no_show' ? 'selected' : '' }}>{{ __('events.scoring.no_show') }}</option>
                                                </select>
                                            </td>
                                            <td class="py-4 px-6">
                                                @if($participant->ranking)
                                                    <span class="scoring-badge bg-gradient-to-r from-[#eab308] to-[#ca8a04] dark:from-[#8b7355] dark:to-[#a68b5b] border-[#eab308] dark:border-[#8b7355] text-white font-bold">
                                                        {{ number_format($participant->ranking->total_score, 1) }}
                                                    </span>
                                                @else
                                                    <span class="text-[#8b7355] dark:text-[#a3a3a3]">-</span>
                                                @endif
                                            </td>
                                            @if(!$isLocked)
                                            <td>
                                                <button wire:click="removeParticipant({{ $participant->id }})" 
                                                        class="scoring-button-secondary"
                                                        onclick="return confirm('{{ __('events.scoring.are_you_sure_you_want_to_remove_this_participant') }}')">
                                                    <i class="ph ph-trash"></i>
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">👥</div>
                            <h4 class="text-xl font-bold text-[#1a1a1a] dark:text-[#e5e5e5] mb-2" style="font-family: 'Crimson Pro', serif;">{{ __('events.scoring.no_participants') }}</h4>
                            <p class="text-[#8b7355] dark:text-[#a3a3a3] mb-6">{{ __('events.scoring.add_first_participant_to_event') }}</p>
                            @if(!$isLocked)
                            <button wire:click="openAddModal" class="scoring-button-primary">
                                <i class="ph ph-plus"></i>
                                {{ __('events.scoring.add_participant') }}
                            </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Add Participant Modal --}}
    @if($showAddModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="scoring-modal max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                 @click.away="$wire.set('showAddModal', false)">
                <div class="scoring-modal-header">
                    <h3 class="scoring-modal-title">
                        {{ __('events.scoring.add_participant') }}
                    </h3>
                    <button wire:click="$set('showAddModal', false)" class="text-[#8b7355] dark:text-[#a3a3a3]">
                        <i class="ph ph-x text-2xl"></i>
                    </button>
                </div>
                <div class="scoring-modal-content">
                
                    {{-- Type Selection --}}
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase mb-3 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.participant_type') }}</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" 
                                    wire:click="$set('participantType', 'user')"
                                    class="{{ $participantType === 'user' ? 'scoring-button-primary' : 'scoring-button-secondary' }}">
                                <i class="ph ph-user-check"></i>{{ __('events.scoring.registered_user') }}
                            </button>
                            <button type="button" 
                                    wire:click="$set('participantType', 'guest')"
                                    class="{{ $participantType === 'guest' ? 'scoring-button-primary' : 'scoring-button-secondary' }}">
                                <i class="ph ph-user-circle"></i>{{ __('events.scoring.guest') }}
                            </button>
                        </div>
                    </div>

                    @if($participantType === 'user')
                        {{-- User Search --}}
                        <div class="mb-6">
                            <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.search_user') }} *</label>
                            @if($selectedUser)
                                <div class="scoring-participant-card">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $selectedUser['avatar'] }}" 
                                                 alt="{{ $selectedUser['display_name'] }}"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                            <span class="font-bold text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $selectedUser['display_name'] }}</span>
                                        </div>
                                        <button type="button" wire:click="clearSelectedUser" class="scoring-button-secondary">
                                            <i class="ph ph-x"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <input type="text" 
                                       wire:model.live.debounce.300ms="userSearch"
                                       class="scoring-input w-full" 
                                       placeholder="{{ __('events.scoring.name_nickname_email') }}">
                                
                                @if(count($searchResults) > 0)
                                    <div class="mt-3 scoring-card max-h-64 overflow-y-auto">
                                        <div class="scoring-card-content">
                                            @foreach($searchResults as $result)
                                                <button type="button" 
                                                        wire:click="selectUser({{ $result['id'] }})"
                                                        class="w-full px-4 py-3 hover:bg-opacity-50 transition-colors text-left border-b border-dashed last:border-b-0 border-[rgba(139,115,85,0.2)] dark:border-[rgba(139,115,85,0.3)]">
                                                    <div class="flex items-center gap-3">
                                                        <img src="{{ $result['avatar'] }}" 
                                                             alt="{{ $result['display_name'] }}"
                                                             class="w-10 h-10 rounded-full object-cover border-2 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                                                        <div>
                                                            <div class="font-bold text-[#1a1a1a] dark:text-[#e5e5e5]" style="font-family: 'Crimson Pro', serif;">{{ $result['display_name'] }}</div>
                                                            <small class="text-xs text-[#8b7355] dark:text-[#a3a3a3]">{{ $result['email'] }}</small>
                                                        </div>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        {{-- Guest Fields --}}
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.name') }} *</label>
                                <input type="text" wire:model="guest_name" class="scoring-input w-full" required>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.email') }}</label>
                                    <input type="email" wire:model="guest_email" class="scoring-input w-full">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.phone') }}</label>
                                    <input type="text" wire:model="guest_phone" class="scoring-input w-full">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.bio') }}</label>
                                <textarea wire:model="guest_bio" class="scoring-input w-full" rows="3"></textarea>
                            </div>
                        </div>
                    @endif

                    {{-- Common Fields --}}
                    <div class="space-y-4 mb-6 border-t border-dashed pt-6 border-[rgba(139,115,85,0.3)] dark:border-[rgba(139,115,85,0.4)]">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.performance_order') }}</label>
                                <input type="number" wire:model="performance_order" class="scoring-input w-full" min="1">
                                <small class="text-xs mt-1 block text-[#8b7355] dark:text-[#a3a3a3] opacity-60">{{ __('events.scoring.leave_empty_for_auto_assignment') }}</small>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase mb-2 text-[#8b7355] dark:text-[#a3a3a3]" style="letter-spacing: 0.05em;">{{ __('events.scoring.notes') }}</label>
                            <textarea wire:model="notes" class="scoring-input w-full" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="scoring-modal-footer">
                    <button wire:click="$set('showAddModal', false)" class="scoring-button-secondary">
                        {{ __('events.scoring.cancel') }}
                    </button>
                    <button wire:click="addParticipant" class="scoring-button-primary">
                        <i class="ph ph-check"></i>{{ __('events.scoring.add_participant') }}
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

