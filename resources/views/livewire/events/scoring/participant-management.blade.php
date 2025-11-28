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
                        <span><i class="ph ph-users"></i> {{ $participants->count() }} {{ __('events.scoring.participants') }}</span>
                        <span><i class="ph ph-check-circle"></i> {{ $participants->where('status', 'confirmed')->count() }} {{ __('events.scoring.confirmed') }}</span>
                    </div>
                </div>
                @if($isLocked)
                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-lg text-xs font-bold">
                        <i class="ph ph-lock"></i>
                    </span>
                @endif
            </div>
        </div>
        
        {{-- Navigation Tabs --}}
        <div class="flex border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-800">
            <a href="{{ route('events.scoring.scores', $event) }}" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-medium text-[#8b7355] dark:text-neutral-400 hover:bg-[rgba(139,115,85,0.1)]">
                <i class="ph ph-pencil-line"></i>
                <span class="hidden sm:inline ml-1">{{ __('events.scoring.scores') }}</span>
            </a>
            <a href="{{ route('events.scoring.participants', $event) }}" wire:navigate 
               class="flex-1 py-3 text-center text-sm font-bold bg-[#b91c1c] text-white">
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
        
        {{-- Stats Bar --}}
        <div class="grid grid-cols-3 gap-2">
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 text-center shadow-sm border border-[rgba(139,115,85,0.15)]">
                <div class="text-2xl font-bold text-[#b91c1c] dark:text-[#8b7355]">{{ $participants->count() }}</div>
                <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500">{{ __('events.scoring.total') }}</div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 text-center shadow-sm border border-[rgba(139,115,85,0.15)]">
                <div class="text-2xl font-bold text-green-600">{{ $participants->where('status', 'confirmed')->count() }}</div>
                <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500">{{ __('events.scoring.confirmed') }}</div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-3 text-center shadow-sm border border-[rgba(139,115,85,0.15)]">
                <div class="text-2xl font-bold text-blue-600">{{ $participants->where('status', 'performed')->count() }}</div>
                <div class="text-[10px] uppercase font-bold text-[#8b7355] dark:text-neutral-500">{{ __('events.scoring.performed') }}</div>
            </div>
        </div>

        {{-- Add Button --}}
        @if(!$isLocked)
            <button wire:click="openAddModal" 
                    class="w-full py-4 rounded-xl bg-[#b91c1c] text-white font-bold text-lg shadow-lg flex items-center justify-center gap-2">
                <i class="ph ph-plus-circle text-xl"></i>
                {{ __('events.scoring.add_participant') }}
            </button>
        @endif

        {{-- Participants List --}}
        @if($participants->count() > 0)
            <div class="space-y-3">
                @foreach($participants as $participant)
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-[rgba(139,115,85,0.15)] dark:border-neutral-700 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-center gap-3">
                                {{-- Order Number --}}
                                @if($participant->performance_order)
                                    <div class="w-8 h-8 rounded-full bg-[#b91c1c] dark:bg-[#8b7355] text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                                        {{ $participant->performance_order }}
                                    </div>
                                @endif
                                
                                {{-- Avatar --}}
                                @if($participant->user && $participant->user->profile_photo_url)
                                    <img src="{{ $participant->user->profile_photo_url }}" 
                                         class="w-12 h-12 rounded-full object-cover flex-shrink-0 border-2 border-[rgba(139,115,85,0.2)]">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-[rgba(139,115,85,0.1)] flex items-center justify-center flex-shrink-0">
                                        <i class="ph ph-user text-xl text-[#8b7355]"></i>
                                    </div>
                                @endif
                                
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-[#1a1a1a] dark:text-white truncate" style="font-family: 'Crimson Pro', serif;">
                                        {{ $participant->display_name }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($participant->isGuest())
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-bold">
                                                {{ __('events.scoring.guest') }}
                                            </span>
                                        @else
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-bold">
                                                {{ __('events.scoring.registered') }}
                                            </span>
                                        @endif
                                        @if($participant->guest_email)
                                            <span class="text-xs text-[#8b7355] truncate">{{ $participant->guest_email }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Status & Actions --}}
                            <div class="mt-4 flex items-center gap-2">
                                <select wire:change="updateStatus({{ $participant->id }}, $event.target.value)" 
                                        class="flex-1 h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white font-medium">
                                    <option value="confirmed" {{ $participant->status === 'confirmed' ? 'selected' : '' }}>✓ {{ __('events.scoring.confirmed') }}</option>
                                    <option value="performed" {{ $participant->status === 'performed' ? 'selected' : '' }}>🎤 {{ __('events.scoring.performed') }}</option>
                                    <option value="disqualified" {{ $participant->status === 'disqualified' ? 'selected' : '' }}>❌ {{ __('events.scoring.disqualified') }}</option>
                                    <option value="no_show" {{ $participant->status === 'no_show' ? 'selected' : '' }}>👻 {{ __('events.scoring.no_show') }}</option>
                                </select>
                                
                                @if(!$isLocked)
                                    <button wire:click="removeParticipant({{ $participant->id }})" 
                                            onclick="return confirm('{{ __('events.scoring.are_you_sure_you_want_to_remove_this_participant') }}')"
                                            class="h-12 w-12 rounded-xl border-2 border-red-200 text-red-600 flex items-center justify-center hover:bg-red-50">
                                        <i class="ph ph-trash text-xl"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- No Participants --}}
            <div class="text-center py-12">
                <div class="text-6xl mb-4">👥</div>
                <h4 class="text-xl font-bold text-[#1a1a1a] dark:text-white mb-2">{{ __('events.scoring.no_participants') }}</h4>
                <p class="text-[#8b7355] dark:text-neutral-400 mb-4">{{ __('events.scoring.add_first_participant_to_event') }}</p>
            </div>
        @endif
    </div>

    {{-- Add Participant Modal --}}
    @if($showAddModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/50 backdrop-blur-sm"
             x-data="{ show: true }" x-show="show" x-transition>
            <div class="w-full sm:max-w-lg bg-white dark:bg-neutral-800 rounded-t-3xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto"
                 @click.away="$wire.set('showAddModal', false)">
                
                <div class="sticky top-0 bg-white dark:bg-neutral-800 px-4 py-4 border-b border-[rgba(139,115,85,0.1)] dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-[#1a1a1a] dark:text-white">
                            {{ __('events.scoring.add_participant') }}
                        </h3>
                        <button wire:click="$set('showAddModal', false)" class="p-2 text-[#8b7355] hover:bg-[rgba(139,115,85,0.1)] rounded-lg">
                            <i class="ph ph-x text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-4 space-y-4">
                    {{-- Type Selection --}}
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" wire:click="$set('participantType', 'user')"
                                class="p-4 rounded-xl border-2 text-center transition-all
                                       {{ $participantType === 'user' ? 'border-[#b91c1c] bg-[#b91c1c]/5' : 'border-[rgba(139,115,85,0.2)]' }}">
                            <i class="ph ph-user-check text-2xl {{ $participantType === 'user' ? 'text-[#b91c1c]' : 'text-[#8b7355]' }}"></i>
                            <div class="text-sm font-bold mt-1 {{ $participantType === 'user' ? 'text-[#b91c1c]' : 'text-[#1a1a1a] dark:text-white' }}">
                                {{ __('events.scoring.registered_user') }}
                            </div>
                        </button>
                        <button type="button" wire:click="$set('participantType', 'guest')"
                                class="p-4 rounded-xl border-2 text-center transition-all
                                       {{ $participantType === 'guest' ? 'border-[#b91c1c] bg-[#b91c1c]/5' : 'border-[rgba(139,115,85,0.2)]' }}">
                            <i class="ph ph-user-circle text-2xl {{ $participantType === 'guest' ? 'text-[#b91c1c]' : 'text-[#8b7355]' }}"></i>
                            <div class="text-sm font-bold mt-1 {{ $participantType === 'guest' ? 'text-[#b91c1c]' : 'text-[#1a1a1a] dark:text-white' }}">
                                {{ __('events.scoring.guest') }}
                            </div>
                        </button>
                    </div>

                    @if($participantType === 'user')
                        {{-- User Search --}}
                        @if($selectedUser)
                            <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $selectedUser['avatar'] }}" class="w-12 h-12 rounded-full">
                                        <span class="font-bold text-[#1a1a1a] dark:text-white">{{ $selectedUser['display_name'] }}</span>
                                    </div>
                                    <button wire:click="clearSelectedUser" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                        <i class="ph ph-x"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div>
                                <input type="text" wire:model.live.debounce.300ms="userSearch"
                                       class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white"
                                       placeholder="{{ __('events.scoring.name_nickname_email') }}">
                                
                                @if(count($searchResults) > 0)
                                    <div class="mt-2 rounded-xl border border-[rgba(139,115,85,0.2)] overflow-hidden max-h-48 overflow-y-auto">
                                        @foreach($searchResults as $result)
                                            <button wire:click="selectUser({{ $result['id'] }})"
                                                    class="w-full p-3 flex items-center gap-3 hover:bg-[rgba(139,115,85,0.05)] border-b last:border-b-0">
                                                <img src="{{ $result['avatar'] }}" class="w-10 h-10 rounded-full">
                                                <div class="text-left">
                                                    <div class="font-bold text-[#1a1a1a] dark:text-white">{{ $result['display_name'] }}</div>
                                                    <div class="text-xs text-[#8b7355]">{{ $result['email'] }}</div>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @else
                        {{-- Guest Fields --}}
                        <div>
                            <label class="block text-sm font-bold text-[#8b7355] mb-2">{{ __('events.scoring.name') }} *</label>
                            <input type="text" wire:model="guest_name" 
                                   class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-bold text-[#8b7355] mb-2">{{ __('events.scoring.email') }}</label>
                                <input type="email" wire:model="guest_email" 
                                       class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-[#8b7355] mb-2">{{ __('events.scoring.phone') }}</label>
                                <input type="text" wire:model="guest_phone" 
                                       class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white">
                            </div>
                        </div>
                    @endif

                    {{-- Performance Order --}}
                    <div>
                        <label class="block text-sm font-bold text-[#8b7355] mb-2">{{ __('events.scoring.performance_order') }}</label>
                        <input type="number" wire:model="performance_order" min="1"
                               class="w-full h-12 px-4 rounded-xl border-2 border-[rgba(139,115,85,0.3)] bg-[#fefaf3] dark:bg-neutral-900 text-[#1a1a1a] dark:text-white text-center text-xl font-bold"
                               placeholder="#">
                        <p class="text-xs text-[#8b7355] mt-1">{{ __('events.scoring.leave_empty_for_auto_assignment') }}</p>
                    </div>
                </div>
                
                <div class="sticky bottom-0 bg-white dark:bg-neutral-800 p-4 border-t border-[rgba(139,115,85,0.1)] dark:border-neutral-700 flex gap-3">
                    <button wire:click="$set('showAddModal', false)" 
                            class="flex-1 py-3 rounded-xl border-2 border-[rgba(139,115,85,0.3)] text-[#8b7355] font-bold">
                        {{ __('events.scoring.cancel') }}
                    </button>
                    <button wire:click="addParticipant" 
                            class="flex-1 py-3 rounded-xl bg-[#b91c1c] text-white font-bold">
                        <i class="ph ph-plus"></i> {{ __('events.scoring.add') }}
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
                Swal.fire({ icon: 'success', title: data[0].title, text: data[0].text, toast: true, position: 'top', showConfirmButton: false, timer: 2000 });
            });
            Livewire.on('swal:warning', (data) => {
                Swal.fire({ icon: 'warning', title: data[0].title, text: data[0].text, confirmButtonColor: '#b91c1c' });
            });
            Livewire.on('swal:error', (data) => {
                Swal.fire({ icon: 'error', title: data[0].title, text: data[0].text, confirmButtonColor: '#b91c1c' });
            });
        });
    </script>
    @endpush
</div>
