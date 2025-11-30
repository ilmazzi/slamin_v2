<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(!$submitted)
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
                    {{ __('support.page_title') }}
                </h1>
                <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                    {{ __('support.page_description') }}
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                <form wire:submit.prevent="submit" class="p-6 md:p-8 space-y-6">
                    
                    <!-- Personal Info -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                                {{ __('support.name') }} *
                            </label>
                            <input 
                                type="text" 
                                id="name"
                                wire:model="name"
                                @if(Auth::check()) readonly @endif
                                class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white @if(Auth::check()) opacity-75 cursor-not-allowed @endif"
                                placeholder="{{ __('support.name_placeholder') }}"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                                {{ __('support.email') }} *
                            </label>
                            <input 
                                type="email" 
                                id="email"
                                wire:model="email"
                                @if(Auth::check()) readonly @endif
                                class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white @if(Auth::check()) opacity-75 cursor-not-allowed @endif"
                                placeholder="{{ __('support.email_placeholder') }}"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('support.category') }} *
                        </label>
                        <select 
                            id="category"
                            wire:model="category"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white"
                        >
                            <option value="">{{ __('support.select_category') }}</option>
                            <option value="technical">🔧 {{ __('support.category_technical') }}</option>
                            <option value="account">👤 {{ __('support.category_account') }}</option>
                            <option value="content">📝 {{ __('support.category_content') }}</option>
                            <option value="other">💬 {{ __('support.category_other') }}</option>
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('support.subject') }} *
                        </label>
                        <input 
                            type="text" 
                            id="subject"
                            wire:model="subject"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white"
                            placeholder="{{ __('support.subject_placeholder') }}"
                        >
                        @error('subject')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('support.message') }} *
                        </label>
                        <textarea 
                            id="message"
                            wire:model="message"
                            rows="8"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white resize-none"
                            placeholder="{{ __('support.message_placeholder') }}"
                        ></textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ __('support.message_help') }}
                        </p>
                    </div>

                    <!-- Attachments -->
                    <div>
                        <label for="attachments" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('support.attachments') }}
                            <span class="text-neutral-500 dark:text-neutral-400 font-normal">
                                ({{ __('support.optional') }})
                            </span>
                        </label>
                        <input 
                            type="file" 
                            id="attachments"
                            wire:model="attachments"
                            multiple
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-neutral-900 dark:text-white"
                        >
                        @error('attachments.*')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ __('support.attachments_help') }}
                        </p>
                        
                        <!-- Loading indicator for uploads -->
                        <div wire:loading wire:target="attachments" class="mt-3">
                            <div class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-primary-600 dark:border-primary-400"></div>
                                <span>{{ __('support.uploading') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <a 
                            href="{{ route('home') }}" 
                            class="flex-1 px-6 py-3 text-center bg-neutral-200 dark:bg-neutral-800 hover:bg-neutral-300 dark:hover:bg-neutral-700 text-neutral-900 dark:text-white font-semibold rounded-lg transition-colors"
                        >
                            {{ __('support.cancel') }}
                        </a>
                        
                        <button 
                            type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 px-6 py-3 bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition-colors shadow-lg inline-flex items-center justify-center gap-2"
                        >
                            <span wire:loading.remove>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </span>
                            <span wire:loading>
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                            </span>
                            <span wire:loading.remove>{{ __('support.submit') }}</span>
                            <span wire:loading>{{ __('support.submitting') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-sm text-blue-800 dark:text-blue-200">
                        <p class="font-semibold mb-1">{{ __('support.response_time_title') }}</p>
                        <p>{{ __('support.response_time_description') }}</p>
                    </div>
                </div>
            </div>
        @else
            <!-- Success Message -->
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 mb-6">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-3">
                    {{ __('support.success_title') }}
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                    {{ __('support.success_message') }}
                </p>
                <p class="text-sm text-neutral-500 dark:text-neutral-500 mb-8">
                    {{ __('support.ticket_number') }}: <strong>#{{ $ticketId }}</strong>
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a 
                        href="{{ route('home') }}" 
                        class="px-6 py-3 bg-neutral-200 dark:bg-neutral-800 hover:bg-neutral-300 dark:hover:bg-neutral-700 text-neutral-900 dark:text-white font-semibold rounded-lg transition-colors"
                    >
                        {{ __('support.back_home') }}
                    </a>
                    
                    <button 
                        wire:click="$set('submitted', false)"
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors"
                    >
                        {{ __('support.submit_another') }}
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
