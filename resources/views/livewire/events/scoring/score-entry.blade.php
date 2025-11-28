<div class="min-h-screen bg-[#fefaf3] dark:bg-neutral-900">
    
    {{-- Toasts --}}
    @if(session('success'))
        <div class="fixed top-4 left-4 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-green-600 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 left-4 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-red-600 text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2">
                <i class="ph ph-x-circle text-xl"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Compact Header --}}
    <div class="sticky top-0 z-40 bg-[#fefaf3] dark:bg-neutral-900 border-b border-[rgba(139,115,85,0.2)] dark:border-neutral-700 shadow-sm">
        <div class="px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                        {{ $event->title }}
                    </h1>
                    <div class="flex items-center gap-3 text-xs text-[#8b7355] dark:text-neutral-400">
                        <span><i class="ph ph-users"></i> {{ $participants->count() }}</span>
                        <span><i class="ph ph-timer"></i> {{ __('events.scoring.round') }} {{ $selectedRound }}/{{ $rounds->count() }}</span>
                    </div>
                </div>
                @if($isLocked)
                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-lg text-xs font-bold">
                        <i class="ph ph-lock"></i> {{ __('events.scoring.locked') }}
                    </span>
                @endif
            </div>
        </div>
        
        {{-- Navigation Tabs --}}
        <div class="flex border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-800">
            <a href="{{ route('events.scoring.scores', $event) }}" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-bold bg-[#b91c1c] text-white">
                <i class="ph ph-pencil-line"></i>
                <span class="hidden sm:inline ml-1">{{ __('events.scoring.scores') }}</span>
            </a>
            <a href="{{ route('events.scoring.participants', $event) }}" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-medium text-[#8b7355] dark:text-neutral-400 hover:bg-[rgba(139,115,85,0.1)]">
                <i class="ph ph-users"></i>
                <span class="hidden sm:inline ml-1">{{ __('events.scoring.participants') }}</span>
            </a>
            <a href="{{ route('events.scoring.rankings', $event) }}" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-medium text-[#8b7355] dark:text-neutral-400 hover:bg-[rgba(139,115,85,0.1)]">
                <i class="ph ph-trophy"></i>
                <span class="hidden sm:inline ml-1">{{ __('events.scoring.rankings') }}</span>
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="px-4 py-4 space-y-4 pb-24">
        
        @php
            $currentRound = $rounds->where('round_number', $selectedRound)->first();
            $judgesCount = $currentRound ? ($currentRound->judges_count ?? 5) : 5;
            $scoringType = $currentRound ? ($currentRound->scoring_type ?? 'trimmed_mean') : 'trimmed_mean';
            $scoringTypeNames = [
                'trimmed_mean' => __('events.scoring.trimmed_mean'),
                'sum' => __('events.scoring.sum'),
                'average' => __('events.scoring.average'),
                'best_of' => __('events.scoring.best_of'),
            ];
        @endphp

        {{-- Round Selector (Horizontal Scroll) --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 -mx-4 px-4 scrollbar-hide">
            @foreach($rounds as $round)
                <button wire:click="$set('selectedRound', {{ $round->round_number }})" 
                        class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-bold transition-all
                               {{ $selectedRound == $round->round_number 
                                  ? 'bg-[#b91c1c] text-white shadow-lg' 
                                  : 'bg-white dark:bg-neutral-800 text-[#8b7355] dark:text-neutral-300 border border-[rgba(139,115,85,0.3)]' }}">
                    {{ $round->name }}
                </button>
            @endforeach
            @if(!$isLocked)
                <button wire:click="openRoundModal" 
                        class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-bold bg-white dark:bg-neutral-800 text-green-600 border-2 border-dashed border-green-400">
                    <i class="ph ph-plus"></i>
                </button>
            @endif
        </div>

        {{-- Round Info Bar --}}
        <div class="flex items-center justify-between bg-white dark:bg-neutral-800 rounded-xl p-3 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700">
            <div class="flex items-center gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b91c1c] dark:text-[#8b7355]">{{ $judgesCount }}</div>
                    <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500">{{ __('events.scoring.judges') }}</div>
                </div>
                <div class="h-8 w-px bg-[rgba(139,115,85,0.2)]"></div>
                <div>
                    <div class="text-sm font-bold text-[#1a1a1a] dark:text-white">{{ $scoringTypeNames[$scoringType] ?? $scoringType }}</div>
                    <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500">{{ __('events.scoring.mode') }}</div>
                </div>
            </div>
            @if(!$isLocked && $currentRound)
                <button wire:click="editRound({{ $currentRound->id }})" class="p-2 text-[#8b7355] hover:bg-[rgba(139,115,85,0.1)] rounded-lg">
                    <i class="ph ph-gear text-xl"></i>
                </button>
            @endif
        </div>

        {{-- Participants List --}}
        @if($participants->count() > 0)
            <div class="space-y-3">
                @foreach($participants as $index => $participant)
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 overflow-hidden"
                         x-data="{ expanded: {{ isset($savedScores[$participant->id]) && $savedScores[$participant->id] ? 'false' : 'true' }} }">
                        
                        {{-- Participant Header (always visible) --}}
                        <div class="p-4 flex items-center gap-3 cursor-pointer" @click="expanded = !expanded">
                            {{-- Order Number --}}
                            <div class="w-8 h-8 rounded-full bg-[#b91c1c] dark:bg-[#8b7355] text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                                {{ $participant->performance_order ?? ($index + 1) }}
                            </div>
                            
                            {{-- Avatar --}}
                            @if($participant->user && $participant->user->profile_photo_url)
                                <img src="{{ $participant->user->profile_photo_url }}" 
                                     class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-[rgba(139,115,85,0.1)] flex items-center justify-center flex-shrink-0">
                                    <i class="ph ph-user text-[#8b7355]"></i>
                                </div>
                            @endif
                            
                            {{-- Name & Score --}}
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                                    {{ $participant->display_name }}
                                </div>
                                @if(isset($participantScores[$participant->id]) && $participantScores[$participant->id]->count() > 0)
                                    @php
                                        $scoresArray = collect($participantScores[$participant->id])->pluck('score')->map(fn($s) => (float)$s)->filter(fn($s) => $s > 0);
                                        $pSum = $scoresArray->sum();
                                        $pMin = $scoresArray->min() ?? 0;
                                        $pMax = $scoresArray->max() ?? 0;
                                        $pAvg = $scoresArray->count() > 0 ? $scoresArray->avg() : 0;
                                        $pTrimmed = $scoresArray->count() >= 3 ? $pSum - $pMin - $pMax : $pSum;
                                        $pFinal = match($scoringType) {
                                            'sum' => $pSum,
                                            'trimmed_mean' => $pTrimmed,
                                            'best_of' => $pMax,
                                            default => $pAvg,
                                        };
                                    @endphp
                                    <div class="text-xs text-[#8b7355] dark:text-neutral-400">
                                        {{ __('events.scoring.score') }}: <span class="font-bold text-[#b91c1c] dark:text-[#8b7355]">{{ number_format($pFinal, 1) }}</span>
                                        <span class="text-[10px]">({{ $scoresArray->count() }}/{{ $judgesCount }} {{ __('events.scoring.votes') }})</span>
                                    </div>
                                @else
                                    <div class="text-xs text-neutral-400">{{ __('events.scoring.no_scores') }}</div>
                                @endif
                            </div>
                            
                            {{-- Status & Expand --}}
                            <div class="flex items-center gap-2">
                                @if(isset($savedScores[$participant->id]) && $savedScores[$participant->id])
                                    <span class="text-green-500"><i class="ph ph-check-circle text-xl"></i></span>
                                @endif
                                <i class="ph text-[#8b7355] transition-transform" :class="expanded ? 'ph-caret-up' : 'ph-caret-down'"></i>
                            </div>
                        </div>
                        
                        {{-- Score Entry (expandable) --}}
                        <div x-show="expanded" x-collapse class="border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-700">
                            <div class="p-4 space-y-4">
                                {{-- Score Inputs Grid --}}
                                <div class="grid grid-cols-5 gap-2">
                                    @for($i = 1; $i <= $judgesCount; $i++)
                                        <div class="text-center">
                                            <label class="block text-[10px] font-bold text-[#8b7355] dark:text-neutral-500 mb-1">G{{ $i }}</label>
                                            <input type="number" 
                                                   wire:model.live="scores.{{ $participant->id }}.{{ $i }}"
                                                   class="w-full h-12 text-center text-lg font-bold rounded-xl border-2 
                                                          border-[rgba(139,115,85,0.3)] dark:border-neutral-600
                                                          bg-[#fefaf3] dark:bg-neutral-900
                                                          text-[#1a1a1a] dark:text-white
                                                          focus:border-[#b91c1c] focus:ring-2 focus:ring-[#b91c1c]/20
                                                          transition-all"
                                                   step="0.1" 
                                                   min="0"
                                                   placeholder="0"
                                                   inputmode="decimal">
                                        </div>
                                    @endfor
                                </div>
                                
                                {{-- Save Button --}}
                                @if(!$isLocked)
                                    <button wire:click="saveScores({{ $participant->id }})" 
                                            wire:loading.attr="disabled"
                                            type="button"
                                            class="w-full py-4 rounded-xl text-white font-bold text-lg transition-all active:scale-[0.98]
                                                   {{ isset($savedScores[$participant->id]) && $savedScores[$participant->id] 
                                                      ? 'bg-green-600 hover:bg-green-700' 
                                                      : 'bg-[#b91c1c] hover:bg-[#991b1b]' }}">
                                        <span wire:loading.remove wire:target="saveScores({{ $participant->id }})">
                                            <i class="ph ph-check-circle"></i>
                                            {{ isset($savedScores[$participant->id]) && $savedScores[$participant->id] ? __('events.scoring.saved') : __('events.scoring.save') }}
                                        </span>
                                        <span wire:loading wire:target="saveScores({{ $participant->id }})">
                                            <i class="ph ph-spinner animate-spin"></i>
                                            {{ __('events.scoring.saving') }}...
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Progress Summary --}}
            @php
                $completedCount = count(array_filter($savedScores ?? []));
                $totalCount = $participants->count();
                $progressPercent = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
            @endphp
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold text-[#8b7355] dark:text-neutral-400">{{ __('events.scoring.progress') }}</span>
                    <span class="text-sm font-bold text-[#1a1a1a] dark:text-white">{{ $completedCount }}/{{ $totalCount }}</span>
                </div>
                <div class="h-3 bg-[rgba(139,115,85,0.1)] dark:bg-neutral-700 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#b91c1c] to-[#dc2626] rounded-full transition-all duration-500" 
                         style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>
            
            {{-- Finalize Button --}}
            @php
                $allParticipantsHaveScores = $completedCount === $totalCount && $totalCount > 0;
                $hasMultipleRounds = $rounds->count() >= 2;
            @endphp
            @if(!$isLocked && $hasMultipleRounds && $allParticipantsHaveScores)
                <button wire:click="finalizeEvent" 
                        onclick="return confirm('{{ __('events.scoring.confirm_finalize_event') }}')"
                        class="w-full py-4 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold text-lg shadow-lg">
                    <i class="ph ph-trophy"></i>
                    {{ __('events.scoring.finalize_event') }}
                </button>
            @endif
            
        @else
            {{-- No Participants --}}
            <div class="text-center py-12">
                <div class="text-6xl mb-4">👥</div>
                <h4 class="text-xl font-bold text-[#1a1a1a] dark:text-white mb-2">{{ __('events.scoring.no_participants') }}</h4>
                <p class="text-[#8b7355] dark:text-neutral-400 mb-4">{{ __('events.scoring.add_participants_first') }}</p>
                <a href="{{ route('events.scoring.participants', $event) }}" wire:navigate
                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#b91c1c] text-white rounded-xl font-bold">
                    <i class="ph ph-plus"></i>
                    {{ __('events.scoring.add_participants') }}
                </a>
            </div>
        @endif
    </div>

    {{-- Round Modal --}}
    @if($showRoundModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/50 backdrop-blur-sm"
             x-data="{ show: true }" x-show="show" x-transition>
            <div class="w-full sm:max-w-lg bg-white dark:bg-neutral-800 rounded-t-3xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto"
                 @click.away="$wire.set('showRoundModal', false)">
                
                <div class="sticky top-0 bg-white dark:bg-neutral-800 px-4 py-4 border-b border-[rgba(139,115,85,0.1)] dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-[#1a1a1a] dark:text-white">
                            {{ $editingRound ? __('events.scoring.edit_round') : __('events.scoring.new_round') }}
                        </h3>
                        <button wire:click="$set('showRoundModal', false)" class="p-2 text-[#8b7355] hover:bg-[rgba(139,115,85,0.1)] rounded-lg">
                            <i class="ph ph-x text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-4 space-y-4">
                    {{-- Round Name --}}
                    <div>
                        <label class="block text-sm font-bold text-[#8b7355] dark:text-neutral-400 mb-2">{{ __('events.scoring.round_name') }}</label>
                        <input type="text" wire:model="round_name" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-[rgba(139,115,85,0.3)] dark:border-neutral-600 bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white"
                               placeholder="{{ __('events.scoring.round') }} {{ $rounds->count() + 1 }}">
                    </div>
                    
                    {{-- Judges Count --}}
                    <div>
                        <label class="block text-sm font-bold text-[#8b7355] dark:text-neutral-400 mb-2">{{ __('events.scoring.judges_count') }}</label>
                        <div class="flex items-center gap-3">
                            <button type="button" wire:click="$set('judges_count', max(1, $judges_count - 1))"
                                    class="w-12 h-12 rounded-xl bg-[rgba(139,115,85,0.1)] text-[#8b7355] text-2xl font-bold">-</button>
                            <input type="number" wire:model="judges_count" 
                                   class="flex-1 h-12 text-center text-xl font-bold rounded-xl border-2 border-[rgba(139,115,85,0.3)] dark:border-neutral-600 bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white"
                                   min="1" max="20">
                            <button type="button" wire:click="$set('judges_count', min(20, $judges_count + 1))"
                                    class="w-12 h-12 rounded-xl bg-[rgba(139,115,85,0.1)] text-[#8b7355] text-2xl font-bold">+</button>
                        </div>
                    </div>
                    
                    {{-- Scoring Type --}}
                    <div>
                        <label class="block text-sm font-bold text-[#8b7355] dark:text-neutral-400 mb-2">{{ __('events.scoring.scoring_type') }}</label>
                        
                        {{-- Primary Option: Somma senza estremi (trimmed_mean) --}}
                        <button type="button" wire:click="$set('scoring_type', 'trimmed_mean')"
                                class="w-full p-4 rounded-xl border-2 text-left transition-all mb-3
                                       {{ $scoring_type === 'trimmed_mean' 
                                          ? 'border-[#b91c1c] bg-[#b91c1c]/10 shadow-md' 
                                          : 'border-[rgba(139,115,85,0.3)] hover:border-[rgba(139,115,85,0.5)]' }}">
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0
                                            {{ $scoring_type === 'trimmed_mean' ? 'bg-[#b91c1c] text-white' : 'bg-[rgba(139,115,85,0.1)] text-[#8b7355]' }}">
                                    <i class="ph ph-scissors text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base font-bold {{ $scoring_type === 'trimmed_mean' ? 'text-[#b91c1c]' : 'text-[#1a1a1a] dark:text-white' }}">
                                            {{ __('events.scoring.trimmed_mean') }}
                                        </span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-blue-100 text-blue-700">
                                            {{ __('events.scoring.automatic') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-[#8b7355] dark:text-neutral-400 mt-1">
                                        {{ __('events.scoring.trimmed_mean_tip') }}
                                    </p>
                                </div>
                            </div>
                        </button>
                        
                        {{-- Secondary Options --}}
                        <div class="grid grid-cols-3 gap-2">
                            @foreach([
                                'sum' => ['icon' => 'ph-plus-circle', 'label' => __('events.scoring.sum')],
                                'average' => ['icon' => 'ph-chart-line', 'label' => __('events.scoring.average')],
                                'best_of' => ['icon' => 'ph-trophy', 'label' => __('events.scoring.best_of')],
                            ] as $type => $data)
                                <button type="button" wire:click="$set('scoring_type', '{{ $type }}')"
                                        class="p-3 rounded-xl border-2 text-center transition-all
                                               {{ $scoring_type === $type 
                                                  ? 'border-[#b91c1c] bg-[#b91c1c]/5' 
                                                  : 'border-[rgba(139,115,85,0.2)] hover:border-[rgba(139,115,85,0.4)]' }}">
                                    <i class="ph {{ $data['icon'] }} text-xl {{ $scoring_type === $type ? 'text-[#b91c1c]' : 'text-[#8b7355]' }}"></i>
                                    <div class="text-xs font-bold mt-1 {{ $scoring_type === $type ? 'text-[#b91c1c]' : 'text-[#1a1a1a] dark:text-white' }}">
                                        {{ $data['label'] }}
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="sticky bottom-0 bg-white dark:bg-neutral-800 p-4 border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-700 flex gap-3">
                    <button wire:click="$set('showRoundModal', false)" 
                            class="flex-1 py-3 rounded-xl border-2 border-[rgba(139,115,85,0.3)] text-[#8b7355] font-bold">
                        {{ __('events.scoring.cancel') }}
                    </button>
                    <button wire:click="saveRound" 
                            class="flex-1 py-3 rounded-xl bg-[#b91c1c] text-white font-bold">
                        {{ __('events.scoring.save') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Participant Selection Modal --}}
    @if($showParticipantSelectionModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/50 backdrop-blur-sm">
            <div class="w-full sm:max-w-lg bg-white dark:bg-neutral-800 rounded-t-3xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto">
                
                <div class="sticky top-0 bg-white dark:bg-neutral-800 px-4 py-4 border-b border-[rgba(139,115,85,0.1)] dark:border-neutral-700">
                    <h3 class="text-lg font-bold text-[#1a1a1a] dark:text-white">
                        {{ __('events.scoring.select_participants_for_next_round') }}
                    </h3>
                </div>
                
                <div class="p-4 space-y-2 max-h-96 overflow-y-auto">
                    @foreach($participantsWithScores ?? [] as $participantData)
                        <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-[rgba(139,115,85,0.05)] cursor-pointer">
                            <input type="checkbox" wire:model="selectedParticipants" value="{{ $participantData['id'] }}"
                                   class="w-5 h-5 rounded border-[#8b7355] text-[#b91c1c] focus:ring-[#b91c1c]">
                            <span class="flex-1 font-medium text-[#1a1a1a] dark:text-white">{{ $participantData['name'] }}</span>
                            <span class="text-sm font-bold text-[#b91c1c]">{{ number_format($participantData['score'], 1) }}</span>
                        </label>
                    @endforeach
                </div>
                
                <div class="sticky bottom-0 bg-white dark:bg-neutral-800 p-4 border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-700 flex gap-3">
                    <button wire:click="$set('showParticipantSelectionModal', false)" 
                            class="flex-1 py-3 rounded-xl border-2 border-[rgba(139,115,85,0.3)] text-[#8b7355] font-bold">
                        {{ __('events.scoring.cancel') }}
                    </button>
                    <button wire:click="saveRound" 
                            class="flex-1 py-3 rounded-xl bg-[#b91c1c] text-white font-bold">
                        {{ __('events.scoring.confirm') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (data) => {
                Swal.fire({
                    icon: 'success',
                    title: data[0].title || 'Salvato!',
                    text: data[0].text || '',
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            });

            Livewire.on('swal:warning', (data) => {
                Swal.fire({
                    icon: 'warning',
                    title: data[0].title || 'Attenzione',
                    text: data[0].text || '',
                    confirmButtonColor: '#b91c1c',
                });
            });

            Livewire.on('swal:error', (data) => {
                Swal.fire({
                    icon: 'error',
                    title: data[0].title || 'Errore',
                    text: data[0].text || '',
                    confirmButtonColor: '#b91c1c',
                });
            });
        });
    </script>
    @endpush
</div>
