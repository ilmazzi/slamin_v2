<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/20 to-neutral-50 dark:from-neutral-950 dark:via-primary-950/10 dark:to-neutral-950 relative overflow-hidden">
    
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <!-- Floating blur circles -->
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-400/20 dark:bg-primary-600/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-float-delayed"></div>
        <div class="absolute -bottom-40 right-1/3 w-72 h-72 bg-pink-400/20 dark:bg-pink-600/10 rounded-full blur-3xl animate-float-slow"></div>
        
        <!-- Subtle particles -->
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-primary-400/40 dark:bg-primary-500/20 rounded-full animate-pulse"></div>
        <div class="absolute top-1/3 right-1/4 w-1.5 h-1.5 bg-purple-400/40 dark:bg-purple-500/20 rounded-full animate-pulse delay-700"></div>
        <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-pink-400/40 dark:bg-pink-500/20 rounded-full animate-pulse delay-1000"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <!-- Back Button -->
        <div class="mb-6 sm:mb-8 animate-fade-in-up">
            <a href="{{ route('gigs.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl backdrop-blur-xl bg-white/60 dark:bg-neutral-800/60 hover:bg-white/80 dark:hover:bg-neutral-800/80 text-neutral-700 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white border border-neutral-200/50 dark:border-neutral-700/50 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">{{ __('gigs.back_to_list') }}</span>
            </a>
        </div>

        <!-- Hero Section with Gradient -->
        <div class="mb-8 sm:mb-12 animate-fade-in-up delay-100">
            <div class="relative backdrop-blur-xl bg-gradient-to-br from-white/80 via-white/60 to-white/80 dark:from-neutral-800/80 dark:via-neutral-800/60 dark:to-neutral-800/80 rounded-3xl border border-white/50 dark:border-neutral-700/50 shadow-2xl overflow-hidden">
                
                <!-- Gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 via-transparent to-purple-500/5 pointer-events-none"></div>
                
                <div class="relative p-8 sm:p-12">
                    <!-- Status Badges -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        @if($gig->is_featured)
                            <span class="group relative px-4 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500/20 to-blue-600/20 dark:from-blue-500/30 dark:to-blue-600/30 text-blue-700 dark:text-blue-300 border border-blue-500/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20">
                                <span class="relative z-10 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ __('gigs.status.featured') }}
                                </span>
                            </span>
                        @endif
                        
                        @if($gig->is_urgent)
                            <span class="group relative px-4 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-orange-500/20 to-red-500/20 dark:from-orange-500/30 dark:to-red-600/30 text-orange-700 dark:text-orange-300 border border-orange-500/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-orange-500/20 animate-pulse">
                                <span class="relative z-10 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('gigs.status.urgent') }}
                                </span>
                            </span>
                        @endif

                        @if($gig->is_remote)
                            <span class="group relative px-4 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-green-500/20 to-emerald-500/20 dark:from-green-500/30 dark:to-emerald-600/30 text-green-700 dark:text-green-300 border border-green-500/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-green-500/20">
                                <span class="relative z-10 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('gigs.remote') }}
                                </span>
                            </span>
                        @endif

                        @if($gig->is_closed)
                            <span class="group relative px-4 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-red-500/20 to-pink-500/20 dark:from-red-500/30 dark:to-pink-600/30 text-red-700 dark:text-red-300 border border-red-500/30 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-red-500/20">
                                <span class="relative z-10 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('gigs.status.closed') }}
                                </span>
                            </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-700 dark:from-white dark:via-neutral-100 dark:to-neutral-300 bg-clip-text text-transparent mb-6 sm:mb-8 leading-tight">
                        {{ $gig->title }}
                    </h1>

                    <!-- Meta Information -->
                    <div class="flex flex-wrap items-center gap-6 text-sm text-neutral-600 dark:text-neutral-400">
                        <div class="flex items-center gap-2 group">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-primary-500/20 to-purple-500/20 dark:from-primary-500/30 dark:to-purple-500/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-medium">{{ $gig->user ? $gig->user->name : ($gig->requester ? $gig->requester->name : __('gigs.anonymous')) }}</span>
                        </div>

                        @if($gig->location)
                            <div class="flex items-center gap-2 group">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 dark:from-green-500/30 dark:to-emerald-500/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $gig->location }}</span>
                            </div>
                        @endif

                        @if($gig->deadline)
                            <div class="flex items-center gap-2 group">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-orange-500/20 to-red-500/20 dark:from-orange-500/30 dark:to-red-500/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $gig->deadline->format('d M Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-3 gap-8 animate-fade-in-up delay-200">
            
            <!-- Left Column - Details -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Description Card -->
                <div class="group backdrop-blur-xl bg-white/70 dark:bg-neutral-800/70 rounded-2xl border border-neutral-200/50 dark:border-neutral-700/50 p-6 sm:p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500/20 to-purple-500/20 dark:from-primary-500/30 dark:to-purple-500/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 dark:text-white">
                            {{ __('gigs.fields.description') }}
                        </h2>
                    </div>
                    <div class="prose prose-neutral dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300 leading-relaxed">
                        {!! nl2br(e($gig->description)) !!}
                    </div>
                </div>

                <!-- Requirements Card -->
                @if($gig->requirements)
                    <div class="group backdrop-blur-xl bg-white/70 dark:bg-neutral-800/70 rounded-2xl border border-neutral-200/50 dark:border-neutral-700/50 p-6 sm:p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500/20 to-indigo-500/20 dark:from-blue-500/30 dark:to-indigo-500/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 dark:text-white">
                                {{ __('gigs.fields.requirements') }}
                            </h2>
                        </div>
                        <div class="prose prose-neutral dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300 leading-relaxed">
                            {!! nl2br(e($gig->requirements)) !!}
                        </div>
                    </div>
                @endif

                <!-- Compensation Card -->
                @if($gig->compensation)
                    <div class="group backdrop-blur-xl bg-gradient-to-br from-green-50/80 to-emerald-50/80 dark:from-green-950/30 dark:to-emerald-950/30 rounded-2xl border border-green-200/50 dark:border-green-700/50 p-6 sm:p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500/30 to-emerald-500/30 dark:from-green-500/40 dark:to-emerald-500/40 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 dark:text-white">
                                {{ __('gigs.fields.compensation') }}
                            </h2>
                        </div>
                        <div class="text-lg sm:text-xl font-bold text-green-700 dark:text-green-300">
                            {{ $gig->compensation }}
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                
                <!-- Quick Info Card -->
                <div class="backdrop-blur-xl bg-white/70 dark:bg-neutral-800/70 rounded-2xl border border-neutral-200/50 dark:border-neutral-700/50 p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Informazioni</h3>
                    
                    <div class="space-y-3">
                        <!-- Category -->
                        <div class="flex items-center justify-between py-2 border-b border-neutral-200 dark:border-neutral-700">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Categoria</span>
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200">
                                {{ __('gigs.categories.' . $gig->category) }}
                            </span>
                        </div>

                        <!-- Type -->
                        <div class="flex items-center justify-between py-2 border-b border-neutral-200 dark:border-neutral-700">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Tipo</span>
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200">
                                {{ __('gigs.types.' . $gig->type) }}
                            </span>
                        </div>

                        <!-- Applications -->
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Candidature</span>
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300">
                                {{ $gig->application_count }}@if($gig->max_applications) / {{ $gig->max_applications }}@endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="sticky top-6 backdrop-blur-xl bg-white/70 dark:bg-neutral-800/70 rounded-2xl border border-neutral-200/50 dark:border-neutral-700/50 p-6 shadow-xl">
                    
                    @if($userApplication)
                        <!-- Already Applied -->
                        <div class="space-y-4">
                            <div class="bg-gradient-to-br from-blue-50/80 to-indigo-50/80 dark:from-blue-950/30 dark:to-indigo-950/30 border border-blue-200/50 dark:border-blue-800/50 rounded-xl p-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-500/20 dark:bg-blue-500/30 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-blue-900 dark:text-blue-100 mb-1">
                                            {{ __('gigs.applications.already_applied') }}
                                        </h4>
                                        <p class="text-sm text-blue-700 dark:text-blue-300">
                                            {{ __('gigs.applications.status') }}: 
                                            <span class="font-semibold">{{ __('gigs.applications.status_' . $userApplication->status) }}</span>
                                        </p>
                                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                            {{ $userApplication->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($userApplication->status === 'pending')
                                <livewire:gigs.negotiation-chat :application="$userApplication" :key="'negotiation-'.$userApplication->id" />
                            @endif
                        </div>

                    @elseif($isOwner)
                        <!-- Owner Actions -->
                        <div class="space-y-3">
                            <a href="{{ route('gigs.edit', $gig) }}" 
                               class="block w-full px-6 py-3 rounded-xl bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold text-center transition-all duration-300 hover:shadow-lg hover:shadow-primary-500/30 hover:-translate-y-0.5">
                                {{ __('gigs.edit') }}
                            </a>

                            <a href="{{ route('gigs.applications', $gig) }}" 
                               class="block w-full px-6 py-3 rounded-xl bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-bold text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                                {{ __('gigs.applications.manage_applications') }} ({{ $gig->application_count }})
                            </a>

                            @if($gig->is_closed)
                                <button wire:click="reopenGig" 
                                        class="w-full px-6 py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold transition-all duration-300 hover:shadow-lg hover:shadow-green-500/30 hover:-translate-y-0.5">
                                    {{ __('gigs.actions.reopen_gig') }}
                                </button>
                            @else
                                <button wire:click="closeGig" 
                                        class="w-full px-6 py-3 rounded-xl bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-bold transition-all duration-300 hover:shadow-lg hover:shadow-orange-500/30 hover:-translate-y-0.5">
                                    {{ __('gigs.actions.close_gig') }}
                                </button>
                            @endif
                        </div>

                    @elseif($canApply && !$showApplicationForm)
                        <!-- Apply Button -->
                        <button wire:click="toggleApplicationForm" 
                                class="group w-full relative px-8 py-4 rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-purple-600 hover:from-primary-700 hover:via-primary-800 hover:to-purple-700 text-white font-bold text-lg transition-all duration-500 hover:shadow-2xl hover:shadow-primary-500/50 hover:-translate-y-1 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                            <span class="relative">{{ __('gigs.applications.apply') }}</span>
                        </button>

                    @elseif(!$canApply && !auth()->check())
                        <!-- Login Required -->
                        <a href="{{ route('login') }}" 
                           class="block w-full px-8 py-4 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-bold text-lg text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                            {{ __('gigs.messages.login_to_interact') }}
                        </a>

                    @elseif(!$canApply)
                        <!-- Cannot Apply -->
                        <div class="bg-neutral-100 dark:bg-neutral-800 rounded-xl p-4 text-center text-neutral-600 dark:text-neutral-400 text-sm">
                            {{ __('gigs.applications.cannot_apply') }}
                        </div>
                    @endif

                </div>

            </div>
        </div>

        <!-- Application Form (Full Width Below) -->
        @if($showApplicationForm)
            <div class="mt-8 animate-fade-in-up">
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-3xl border border-neutral-200/50 dark:border-neutral-700/50 p-8 sm:p-12 shadow-2xl">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500/20 to-purple-500/20 dark:from-primary-500/30 dark:to-purple-500/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-neutral-900 dark:text-white">
                            {{ __('gigs.applications.submit_application') }}
                        </h3>
                    </div>

                    <form wire:submit.prevent="submitApplication" class="space-y-6">
                        
                        <!-- Message (Required) -->
                        <div class="group">
                            <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('gigs.applications.message') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="applicationMessage" 
                                      rows="5" 
                                      class="w-full px-5 py-4 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white/50 dark:bg-neutral-900/50 text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all duration-300"
                                      placeholder="{{ __('gigs.applications.message_placeholder') }}"></textarea>
                            @error('applicationMessage') 
                                <span class="text-sm text-red-600 dark:text-red-400 mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">
                            
                            <!-- Experience -->
                            <div class="group">
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.experience') }}
                                </label>
                                <textarea wire:model="applicationExperience" 
                                          rows="4" 
                                          class="w-full px-5 py-4 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white/50 dark:bg-neutral-900/50 text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all duration-300"
                                          placeholder="{{ __('gigs.applications.experience_placeholder') }}"></textarea>
                                @error('applicationExperience') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Availability -->
                            <div class="group">
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.availability') }}
                                </label>
                                <textarea wire:model="applicationAvailability" 
                                          rows="4" 
                                          class="w-full px-5 py-4 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white/50 dark:bg-neutral-900/50 text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all duration-300"
                                          placeholder="{{ __('gigs.applications.availability_placeholder') }}"></textarea>
                                @error('applicationAvailability') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">

                            <!-- Portfolio URL -->
                            <div class="group">
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.portfolio_url') }}
                                </label>
                                <input type="url" 
                                       wire:model="applicationPortfolioUrl" 
                                       class="w-full px-5 py-4 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white/50 dark:bg-neutral-900/50 text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all duration-300"
                                       placeholder="https://...">
                                @error('applicationPortfolioUrl') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Compensation Expectation -->
                            <div class="group">
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.compensation_expectation') }}
                                </label>
                                <input type="text" 
                                       wire:model="applicationCompensationExpectation" 
                                       class="w-full px-5 py-4 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white/50 dark:bg-neutral-900/50 text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-500 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all duration-300"
                                       placeholder="{{ __('gigs.applications.compensation_expectation_placeholder') }}">
                                @error('applicationCompensationExpectation') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit" 
                                    class="group flex-1 relative px-8 py-4 rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-purple-600 hover:from-primary-700 hover:via-primary-800 hover:to-purple-700 text-white font-bold text-lg transition-all duration-500 hover:shadow-2xl hover:shadow-primary-500/50 hover:-translate-y-1 overflow-hidden">
                                <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                                <span class="relative">{{ __('gigs.applications.submit_application') }}</span>
                            </button>

                            <button type="button" 
                                    wire:click="toggleApplicationForm" 
                                    class="px-8 py-4 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-bold text-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                                {{ __('gigs.cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>

@push('styles')
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(-3deg); }
}

@keyframes float-slow {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-25px) rotate(7deg); }
}

.animate-float {
    animation: float 20s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 25s ease-in-out infinite;
    animation-delay: 5s;
}

.animate-float-slow {
    animation: float-slow 30s ease-in-out infinite;
    animation-delay: 10s;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out;
}

.delay-100 {
    animation-delay: 100ms;
}

.delay-200 {
    animation-delay: 200ms;
}

.delay-700 {
    animation-delay: 700ms;
}

.delay-1000 {
    animation-delay: 1000ms;
}
</style>
@endpush
