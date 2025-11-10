<div>
    <!-- Toggle Button -->
    <button wire:click="toggleNegotiation" 
            class="relative px-4 py-2 rounded-xl bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-900 dark:text-blue-100 font-medium transition-colors">
        💬 {{ __('negotiations.negotiate') }}
        
        @if($unreadCount > 0)
            <span class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Negotiation Modal/Panel -->
    @if($showNegotiation)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-neutral-900/75 backdrop-blur-sm" 
                     wire:click="toggleNegotiation"></div>

                <!-- Modal panel -->
                <div class="inline-block w-full max-w-3xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-neutral-800 shadow-2xl rounded-3xl">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-neutral-200 dark:border-neutral-700">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                            💬 {{ __('negotiations.title') }}
                        </h2>
                        <button wire:click="toggleNegotiation" 
                                class="text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Gig Info Summary -->
                    <div class="p-4 bg-neutral-50 dark:bg-neutral-900/50 border-b border-neutral-200 dark:border-neutral-700">
                        <div class="text-sm">
                            <span class="font-semibold text-neutral-700 dark:text-neutral-300">{{ __('negotiations.gig') }}:</span>
                            <span class="text-neutral-600 dark:text-neutral-400 ml-2">{{ $application->gig->title }}</span>
                        </div>
                        <div class="text-sm mt-1">
                            <span class="font-semibold text-neutral-700 dark:text-neutral-300">{{ __('negotiations.applicant') }}:</span>
                            <span class="text-neutral-600 dark:text-neutral-400 ml-2">{{ $application->user->name }}</span>
                        </div>
                        @if($application->compensation_expectation)
                            <div class="text-sm mt-1">
                                <span class="font-semibold text-neutral-700 dark:text-neutral-300">{{ __('negotiations.original_offer') }}:</span>
                                <span class="text-neutral-600 dark:text-neutral-400 ml-2">{{ $application->compensation_expectation }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Messages -->
                    <div class="p-6 space-y-4 max-h-96 overflow-y-auto" id="negotiation-messages">
                        @forelse($negotiations as $negotiation)
                            <div class="flex {{ $negotiation->user_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-md">
                                    <!-- User info -->
                                    <div class="flex items-center gap-2 mb-1 {{ $negotiation->user_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                            {{ $negotiation->user->name }}
                                        </span>
                                        <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                            {{ $negotiation->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <!-- Message bubble -->
                                    <div class="rounded-2xl p-4 {{ $negotiation->user_id === Auth::id() 
                                        ? 'bg-primary-600 text-white' 
                                        : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white' }}">
                                        
                                        <!-- Message Type Badge -->
                                        @if($negotiation->message_type !== 'info')
                                            <div class="mb-2">
                                                @if($negotiation->message_type === 'proposal')
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                        💰 {{ __('negotiations.types.proposal') }}
                                                    </span>
                                                @elseif($negotiation->message_type === 'counter')
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                                        🔄 {{ __('negotiations.types.counter') }}
                                                    </span>
                                                @elseif($negotiation->message_type === 'accept')
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                        ✓ {{ __('negotiations.types.accept') }}
                                                    </span>
                                                @elseif($negotiation->message_type === 'reject')
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                        ✗ {{ __('negotiations.types.reject') }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Message text -->
                                        <p class="text-sm">{{ $negotiation->message }}</p>

                                        <!-- Proposed values -->
                                        @if($negotiation->proposed_compensation || $negotiation->proposed_deadline)
                                            <div class="mt-3 pt-3 border-t {{ $negotiation->user_id === Auth::id() ? 'border-primary-500' : 'border-neutral-200 dark:border-neutral-600' }}">
                                                @if($negotiation->proposed_compensation)
                                                    <div class="text-sm font-semibold">
                                                        {{ __('negotiations.proposed_compensation') }}: €{{ number_format($negotiation->proposed_compensation, 2) }}
                                                    </div>
                                                @endif
                                                @if($negotiation->proposed_deadline)
                                                    <div class="text-sm">
                                                        {{ __('negotiations.proposed_deadline') }}: {{ $negotiation->proposed_deadline->format('d M Y') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                                <p>{{ __('negotiations.no_messages') }}</p>
                                <p class="text-sm mt-2">{{ __('negotiations.start_negotiation') }}</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Message Input Form -->
                    <div class="p-6 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/50">
                        
                        <!-- Message Type Selector -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button type="button" 
                                    wire:click="setMessageType('info')"
                                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors {{ $messageType === 'info' ? 'bg-neutral-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}">
                                💬 {{ __('negotiations.types.info') }}
                            </button>

                            <button type="button" 
                                    wire:click="setMessageType('proposal')"
                                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors {{ $messageType === 'proposal' ? 'bg-blue-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}">
                                💰 {{ __('negotiations.types.proposal') }}
                            </button>

                            <button type="button" 
                                    wire:click="setMessageType('counter')"
                                    class="px-3 py-1 rounded-lg text-sm font-medium transition-colors {{ $messageType === 'counter' ? 'bg-orange-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}">
                                🔄 {{ __('negotiations.types.counter') }}
                            </button>

                            @if($isRequester)
                                <button type="button" 
                                        wire:click="setMessageType('accept')"
                                        class="px-3 py-1 rounded-lg text-sm font-medium transition-colors {{ $messageType === 'accept' ? 'bg-green-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}">
                                    ✓ {{ __('negotiations.types.accept') }}
                                </button>

                                <button type="button" 
                                        wire:click="setMessageType('reject')"
                                        class="px-3 py-1 rounded-lg text-sm font-medium transition-colors {{ $messageType === 'reject' ? 'bg-red-600 text-white' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}">
                                    ✗ {{ __('negotiations.types.reject') }}
                                </button>
                            @endif
                        </div>

                        <!-- Form -->
                        <form wire:submit.prevent="sendMessage" class="space-y-4">
                            
                            <!-- Message -->
                            <div>
                                <textarea wire:model="message" 
                                          rows="3"
                                          placeholder="{{ __('negotiations.message_placeholder') }}"
                                          class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 resize-none"></textarea>
                                @error('message') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Optional: Proposed Compensation & Deadline -->
                            @if(in_array($messageType, ['proposal', 'counter', 'accept']))
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700">
                                    <div>
                                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                            {{ __('negotiations.proposed_compensation') }}
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-3 text-neutral-500">€</span>
                                            <input type="number" 
                                                   wire:model="proposedCompensation"
                                                   step="0.01"
                                                   min="0"
                                                   placeholder="50.00"
                                                   class="w-full pl-8 pr-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        </div>
                                        @error('proposedCompensation') 
                                            <span class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                            {{ __('negotiations.proposed_deadline') }}
                                        </label>
                                        <input type="date" 
                                               wire:model="proposedDeadline"
                                               class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        @error('proposedDeadline') 
                                            <span class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="flex gap-3">
                                <button type="submit" 
                                        class="flex-1 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition-colors">
                                    {{ __('negotiations.send_message') }}
                                </button>
                                
                                <button type="button" 
                                        wire:click="toggleNegotiation"
                                        class="px-6 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold transition-colors">
                                    {{ __('common.cancel') }}
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    @endif
</div>

<script>
    // Auto-scroll to bottom when new messages arrive
    document.addEventListener('livewire:update', () => {
        const messagesContainer = document.getElementById('negotiation-messages');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });
</script>
