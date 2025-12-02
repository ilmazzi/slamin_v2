<div>
    <button wire:click="toggleNegotiation" 
            class="relative px-4 py-2 rounded-xl bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-900 dark:text-blue-100 font-medium transition-colors">
        💬 {{ __('negotiations.negotiate') }}
        
        @if($unreadCount > 0)
            <span class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    @if($showNegotiation)
        <div class="fixed inset-0 z-[9999] overflow-y-auto flex items-center justify-center p-4"
             style="margin: 0 !important;">
            
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-neutral-900/75 backdrop-blur-sm" 
                 wire:click="toggleNegotiation"></div>

            <!-- Modal panel -->
            <div class="relative w-full max-w-4xl max-h-[90vh] bg-white dark:bg-neutral-800 shadow-2xl rounded-3xl overflow-hidden flex flex-col"
                 @click.stop>
                    
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

                <!-- Info Bar -->
                <div class="px-6 py-4 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-blue-800 dark:text-blue-300">
                            {{ __('negotiations.info_text') }}
                        </p>
                    </div>
                </div>

                <!-- Current Offer -->
                <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-900/50 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('negotiations.current_compensation') }}:</span>
                            <p class="text-lg font-bold text-neutral-900 dark:text-white">
                                {{ $application->negotiated_compensation ?? $application->compensation_expectation ?? $application->gig->compensation ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('negotiations.status') }}:</span>
                            <p class="text-lg font-bold text-neutral-900 dark:text-white">
                                {{ __('gigs.applications.status_' . $application->status) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 p-6 space-y-4 overflow-y-auto" 
                     id="negotiation-messages-{{ $application->id }}" 
                     style="min-height: 200px; max-height: 400px;">
                    @forelse($negotiations as $negotiation)
                        <div class="flex {{ $negotiation->user_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-md">
                                <div class="flex items-start gap-2 {{ $negotiation->user_id === Auth::id() ? 'flex-row-reverse' : '' }}">
                                    <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($negotiation->user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                                            {{ $negotiation->user->name }} • {{ $negotiation->created_at->diffForHumans() }}
                                        </div>
                                        <div class="rounded-2xl p-4 {{ $negotiation->user_id === Auth::id() ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white' }}">
                                            <p class="text-sm whitespace-pre-wrap">{{ $negotiation->message }}</p>
                                            
                                            @if($negotiation->proposed_compensation)
                                                <div class="mt-3 pt-3 border-t {{ $negotiation->user_id === Auth::id() ? 'border-primary-500' : 'border-neutral-200 dark:border-neutral-600' }}">
                                                    <div class="text-xs font-semibold mb-1">{{ __('negotiations.proposed_compensation') }}:</div>
                                                    <div class="text-lg font-bold">€{{ number_format($negotiation->proposed_compensation, 2) }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-neutral-500 dark:text-neutral-400 py-8">
                            {{ __('negotiations.no_messages') }}
                        </div>
                    @endforelse
                </div>

                <!-- Message Form -->
                <div class="p-6 border-t border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/50">
                    <form wire:submit="sendMessage">
                        <div class="space-y-4">
                            <!-- Message Type -->
                            <div class="flex gap-2">
                                <button type="button"
                                        wire:click="$set('messageType', 'message')"
                                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $messageType === 'message' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300' }}">
                                    💬 {{ __('negotiations.message') }}
                                </button>
                                <button type="button"
                                        wire:click="$set('messageType', 'offer')"
                                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $messageType === 'offer' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300' }}">
                                    💰 {{ __('negotiations.make_offer') }}
                                </button>
                            </div>

                            <!-- Message Input -->
                            <textarea wire:model="message"
                                      rows="3"
                                      class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-xl bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                      placeholder="{{ __('negotiations.message_placeholder') }}"></textarea>

                            <!-- Compensation Input (if offer) -->
                            @if($messageType === 'offer')
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('negotiations.proposed_compensation') }}:
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-neutral-500">€</span>
                                        <input type="number"
                                               wire:model="proposedCompensation"
                                               step="0.01"
                                               min="0"
                                               class="w-full pl-8 pr-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-xl bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                               placeholder="0.00">
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        class="flex-1 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors disabled:opacity-50">
                                    <span wire:loading.remove>{{ __('negotiations.send') }}</span>
                                    <span wire:loading>{{ __('negotiations.sending') }}...</span>
                                </button>
                                
                                @if($messageType === 'offer' && $application->status === 'pending')
                                    <button type="button"
                                            wire:click="acceptOffer"
                                            wire:loading.attr="disabled"
                                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors">
                                        ✓ {{ __('negotiations.accept_and_close') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif
</div>
