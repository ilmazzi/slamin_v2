<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900">
    
    {{-- HERO SECTION with Image/Gradient --}}
    <div class="relative h-[60vh] min-h-[500px] flex items-center justify-center overflow-hidden"
         x-data="{ scrollY: 0 }"
         @scroll.window="scrollY = window.pageYOffset">
        
        {{-- Background with Parallax --}}
        <div class="absolute inset-0" 
             :style="`transform: translateY(${scrollY * 0.5}px)`">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-accent-600 to-primary-700"></div>
        </div>

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-neutral-900/30 to-neutral-900/80"></div>

        {{-- Geometric Pattern --}}
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        {{-- Content with reverse Parallax --}}
        <div class="relative z-10 max-w-6xl mx-auto px-6 text-center"
             :style="`transform: translateY(${scrollY * -0.2}px)`">
            
            {{-- Back Button --}}
            <div class="mb-8">
                <a href="{{ route('gigs.index') }}" 
                   class="inline-flex items-center gap-3 px-6 py-3 backdrop-blur-xl bg-white/10 hover:bg-white/20 border-2 border-white/20 hover:border-white/40 transition-all group">
                    <svg class="w-5 h-5 text-white group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="text-white font-black uppercase tracking-wider text-sm">{{ __('gigs.back_to_list') }}</span>
                </a>
            </div>

            {{-- Status Badges --}}
            <div class="flex flex-wrap justify-center gap-4 mb-8">
                @if($gig->is_featured)
                    <div class="group relative px-6 py-3 backdrop-blur-xl bg-blue-500/90 border-2 border-white/30 overflow-hidden hover:scale-105 transition-all animate-pulse">
                        <span class="relative text-white text-sm font-black uppercase tracking-[0.2em] flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ __('gigs.status.featured') }}
                        </span>
                    </div>
                @endif
                
                @if($gig->is_urgent)
                    <div class="group relative px-6 py-3 backdrop-blur-xl bg-gradient-to-r from-orange-500 to-red-600 border-2 border-white/30 overflow-hidden hover:scale-105 transition-all animate-pulse">
                        <span class="relative text-white text-sm font-black uppercase tracking-[0.2em] flex items-center gap-2">
                            <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('gigs.status.urgent') }}
                        </span>
                    </div>
                @endif

                @if($gig->is_remote)
                    <div class="group relative px-6 py-3 backdrop-blur-xl bg-green-500/90 border-2 border-white/30 overflow-hidden hover:scale-105 transition-all">
                        <span class="relative text-white text-sm font-black uppercase tracking-[0.2em] flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('gigs.remote') }}
                        </span>
                    </div>
                @endif

                @if($gig->is_closed)
                    <div class="group relative px-6 py-3 backdrop-blur-xl bg-red-600/90 border-2 border-white/30 overflow-hidden">
                        <span class="relative text-white text-sm font-black uppercase tracking-[0.2em] flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('gigs.status.closed') }}
                        </span>
                    </div>
                @endif

                {{-- Category Badge --}}
                <div class="group relative px-6 py-3 backdrop-blur-xl bg-white/10 border-2 border-white/20 overflow-hidden hover:border-white/40 transition-all">
                    <span class="relative text-white text-sm font-black uppercase tracking-[0.2em]">
                        {{ __('gigs.categories.' . $gig->category) }}
                    </span>
                </div>

                {{-- Type Badge --}}
                <div class="group relative px-6 py-3 backdrop-blur-xl {{ $gig->type === 'paid' ? 'bg-accent-500/90' : 'bg-primary-500/90' }} border-2 border-white/20 overflow-hidden hover:scale-105 transition-all">
                    <span class="relative text-white text-sm font-black uppercase tracking-[0.2em]">
                        {{ __('gigs.types.' . $gig->type) }}
                    </span>
                </div>
            </div>

            {{-- Title with Shadow --}}
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white mb-6 leading-[1.1] tracking-tight" 
                style="text-shadow: 0 10px 40px rgba(0,0,0,0.8)">
                {{ $gig->title }}
            </h1>

            {{-- Meta Info --}}
            <div class="flex flex-wrap justify-center items-center gap-8 text-white/90">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="font-bold text-lg">{{ $gig->user ? $gig->user->name : ($gig->requester ? $gig->requester->name : __('gigs.anonymous')) }}</span>
                </div>

                @if($gig->location)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="font-bold text-lg">{{ $gig->location }}</span>
                    </div>
                @endif

                @if($gig->deadline)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="font-bold text-lg">{{ $gig->deadline->format('d M Y H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 z-20 animate-bounce">
            <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="relative py-16 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-6xl mx-auto px-6">
            
            {{-- Grid Layout --}}
            <div class="grid lg:grid-cols-3 gap-8">
                
                {{-- Left Column - Content --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Poem Card (if translation request) --}}
                    @if($gig->poem_id && $gig->poem)
                        <div class="group relative bg-gradient-to-br from-accent-50 to-primary-50 dark:from-accent-950/30 dark:to-primary-950/30 overflow-hidden border-l-4 border-accent-500 shadow-2xl hover:shadow-[0_20px_50px_rgba(74,124,89,0.3)] transition-all duration-500">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-accent-500/10 rounded-full -mr-16 -mt-16"></div>
                            <div class="relative p-8">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-14 h-14 bg-gradient-to-br from-accent-500 to-accent-600 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-3xl font-black text-neutral-900 dark:text-neutral-100 uppercase tracking-tight">
                                        Poesia da Tradurre
                                    </h2>
                                </div>
                                <div class="space-y-4">
                                    <div class="bg-white/80 dark:bg-neutral-900/50 rounded-lg p-6 backdrop-blur-sm">
                                        <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2 font-poem">
                                            "{{ $gig->poem->title }}"
                                        </h3>
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                                            di {{ $gig->poem->user->name }}
                                        </p>
                                        <button onclick="Livewire.dispatch('openPoemModal', { poemId: {{ $gig->poem->id }} })" 
                                                class="inline-flex items-center gap-2 px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white font-bold rounded-lg transition-all hover:shadow-lg hover:-translate-y-0.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Leggi la Poesia
                                        </button>
                                    </div>
                                    @if($gig->target_language)
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="font-semibold text-neutral-700 dark:text-neutral-300">Lingua richiesta:</span>
                                            <span class="px-3 py-1 bg-accent-100 dark:bg-accent-900/30 text-accent-700 dark:text-accent-300 rounded-full font-bold">
                                                {{ strtoupper($gig->target_language) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Description Card --}}
                    <div class="group relative bg-white dark:bg-neutral-800 overflow-hidden border-l-4 border-primary-500 shadow-2xl hover:shadow-[0_20px_50px_rgba(0,0,0,0.2)] transition-all duration-500">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/5 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-accent-600 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h2 class="text-3xl font-black text-neutral-900 dark:text-white uppercase tracking-tight">
                                    {{ __('gigs.fields.description') }}
                                </h2>
                            </div>
                            <div class="prose prose-lg prose-neutral dark:prose-invert max-w-none">
                                {!! nl2br(e($gig->description)) !!}
                            </div>
                        </div>
                    </div>

                    {{-- Requirements Card --}}
                    @if($gig->requirements)
                        <div class="group relative bg-white dark:bg-neutral-800 overflow-hidden border-l-4 border-blue-500 shadow-2xl hover:shadow-[0_20px_50px_rgba(0,0,0,0.2)] transition-all duration-500">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16"></div>
                            <div class="relative p-8">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-3xl font-black text-neutral-900 dark:text-white uppercase tracking-tight">
                                        {{ __('gigs.fields.requirements') }}
                                    </h2>
                                </div>
                                <div class="prose prose-lg prose-neutral dark:prose-invert max-w-none">
                                    {!! nl2br(e($gig->requirements)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Compensation Card --}}
                    @if($gig->compensation)
                        <div class="group relative bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-950/30 dark:to-emerald-950/30 overflow-hidden border-l-4 border-accent-500 shadow-2xl hover:shadow-[0_20px_50px_rgba(34,197,94,0.2)] transition-all duration-500">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-accent-500/10 rounded-full -mr-16 -mt-16"></div>
                            <div class="relative p-8">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-14 h-14 bg-gradient-to-br from-accent-500 to-accent-600 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-3xl font-black text-neutral-900 dark:text-neutral-100 uppercase tracking-tight">
                                        {{ __('gigs.fields.compensation') }}
                                    </h2>
                                </div>
                                <div class="text-2xl font-black text-accent-700 dark:text-accent-400">
                                    {{ $gig->compensation }}
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Right Column - Sidebar --}}
                <div class="space-y-6">
                    
                    {{-- Stats Card --}}
                    <div class="bg-white dark:bg-neutral-800 shadow-2xl overflow-hidden border-t-4 border-primary-500">
                        <div class="p-6">
                            <h3 class="text-xl font-black text-neutral-900 dark:text-white uppercase tracking-tight mb-6">Info Rapide</h3>
                            
                            <div class="space-y-4">
                                {{-- Applications Counter --}}
                                <div class="flex items-center justify-between p-4 bg-primary-50 dark:bg-primary-950/30 border-l-4 border-primary-500">
                                    <span class="font-bold text-neutral-700 dark:text-neutral-300">Candidature</span>
                                    <span class="text-2xl font-black text-primary-600 dark:text-primary-400">
                                        {{ $gig->application_count }}@if($gig->max_applications)<span class="text-base text-neutral-500">/{{ $gig->max_applications }}</span>@endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Card (Sticky) --}}
                    <div class="sticky top-6 bg-white dark:bg-neutral-800 shadow-2xl overflow-hidden border-t-4 border-accent-500">
                        <div class="p-6">
                            
                            @if($userApplication)
                                {{-- Already Applied --}}
                                <div class="space-y-4">
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 border-l-4 border-blue-500 p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-black text-blue-900 dark:text-blue-100 mb-1 uppercase text-sm tracking-wider">
                                                    {{ __('gigs.applications.already_applied') }}
                                                </h4>
                                                <p class="text-sm text-blue-700 dark:text-blue-300 font-bold">
                                                    {{ __('gigs.applications.status') }}: {{ __('gigs.applications.status_' . $userApplication->status) }}
                                                </p>
                                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                                    {{ $userApplication->created_at->format('d M Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($userApplication->status === 'pending')
                                        <livewire:gigs.negotiation-chat :application="$userApplication" :key="'negotiation-'.$userApplication->id" />
                                    @elseif($userApplication->status === 'accepted')
                                        {{-- Workspace Access for Accepted Applications --}}
                                        <a href="{{ route('gigs.workspace', $userApplication) }}" 
                                           class="block w-full px-6 py-4 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-accent-700 hover:to-accent-800 text-white font-black text-center uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105 rounded-lg">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                🚀 Apri Workspace Collaborativo
                                            </div>
                                        </a>
                                    @endif
                                </div>

                            @elseif($isOwner)
                                {{-- Owner Actions --}}
                                <div class="space-y-3">
                                    <a href="{{ route('gigs.edit', $gig) }}" 
                                       class="block w-full px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-black text-center uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
                                        {{ __('gigs.edit') }}
                                    </a>

                                    <a href="{{ route('gigs.applications', $gig) }}" 
                                       class="block w-full px-6 py-4 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-black text-center uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
                                        {{ __('gigs.applications.manage_applications') }} ({{ $gig->application_count }})
                                    </a>

                                    @if($gig->is_closed)
                                        <button wire:click="reopenGig" 
                                                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-black uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
                                            {{ __('gigs.actions.reopen_gig') }}
                                        </button>
                                    @else
                                        <button wire:click="closeGig" 
                                                class="w-full px-6 py-4 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-black uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
                                            {{ __('gigs.actions.close_gig') }}
                                        </button>
                                    @endif
                                </div>

                            @elseif($canApply && !$showApplicationForm)
                                {{-- Apply Button --}}
                                <button wire:click="toggleApplicationForm" 
                                        class="group w-full relative px-8 py-6 bg-gradient-to-r from-accent-500 via-accent-600 to-accent-700 hover:from-accent-600 hover:via-accent-700 hover:to-accent-800 text-white font-black text-xl uppercase tracking-wider transition-all overflow-hidden hover:shadow-[0_20px_50px_rgba(34,197,94,0.5)] hover:scale-105">
                                    <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                                    <span class="relative">{{ __('gigs.applications.apply') }}</span>
                                </button>

                            @elseif(!$canApply && !auth()->check())
                                {{-- Login Required --}}
                                <a href="{{ route('login') }}" 
                                   class="block w-full px-8 py-6 bg-neutral-300 dark:bg-neutral-700 hover:bg-neutral-400 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-black text-xl text-center uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
                                    {{ __('gigs.messages.login_to_interact') }}
                                </a>

                            @elseif(!$canApply)
                                {{-- Cannot Apply --}}
                                <div class="bg-neutral-100 dark:bg-neutral-800 p-4 text-center text-neutral-600 dark:text-neutral-400 font-bold">
                                    {{ __('gigs.applications.cannot_apply') }}
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

            {{-- Application Form (Full Width) --}}
            @if($showApplicationForm)
                <div class="mt-12">
                    <div class="bg-white dark:bg-neutral-800 shadow-2xl overflow-hidden border-t-4 border-accent-500">
                        <div class="p-8 md:p-12">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-16 h-16 bg-gradient-to-br from-accent-500 to-accent-600 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <h3 class="text-3xl md:text-4xl font-black text-neutral-900 dark:text-white uppercase tracking-tight">
                                    {{ __('gigs.applications.submit_application') }}
                                </h3>
                            </div>

                            <form wire:submit.prevent="submitApplication" class="space-y-6">
                                
                                {{-- Message (Required) --}}
                                <div>
                                    <label class="block text-sm font-black text-neutral-900 dark:text-white uppercase tracking-wider mb-3">
                                        {{ __('gigs.applications.message') }} <span class="text-red-500">*</span>
                                    </label>
                                    <textarea wire:model="applicationMessage" 
                                              rows="5" 
                                              class="w-full px-5 py-4 border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:border-accent-500 dark:focus:border-accent-400 focus:ring-4 focus:ring-accent-500/10 transition-all"
                                              placeholder="{{ __('gigs.applications.message_placeholder') }}"></textarea>
                                    @error('applicationMessage') 
                                        <span class="text-sm text-red-600 dark:text-red-400 mt-1 font-bold flex items-center gap-1">
                                            ⚠️ {{ $message }}
                                        </span> 
                                    @enderror
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    
                                    {{-- Experience --}}
                                    <div>
                                        <label class="block text-sm font-black text-neutral-900 dark:text-white uppercase tracking-wider mb-3">
                                            {{ __('gigs.applications.experience') }}
                                        </label>
                                        <textarea wire:model="applicationExperience" 
                                                  rows="4" 
                                                  class="w-full px-5 py-4 border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all"
                                                  placeholder="{{ __('gigs.applications.experience_placeholder') }}"></textarea>
                                    </div>

                                    {{-- Availability --}}
                                    <div>
                                        <label class="block text-sm font-black text-neutral-900 dark:text-white uppercase tracking-wider mb-3">
                                            {{ __('gigs.applications.availability') }}
                                        </label>
                                        <textarea wire:model="applicationAvailability" 
                                                  rows="4" 
                                                  class="w-full px-5 py-4 border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all"
                                                  placeholder="{{ __('gigs.applications.availability_placeholder') }}"></textarea>
                                    </div>

                                </div>

                                <div class="grid md:grid-cols-2 gap-6">

                                    {{-- Portfolio URL --}}
                                    <div>
                                        <label class="block text-sm font-black text-neutral-900 dark:text-white uppercase tracking-wider mb-3">
                                            {{ __('gigs.applications.portfolio_url') }}
                                        </label>
                                        <input type="url" 
                                               wire:model="applicationPortfolioUrl" 
                                               class="w-full px-5 py-4 border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all"
                                               placeholder="https://...">
                                    </div>

                                    {{-- Compensation Expectation --}}
                                    <div>
                                        <label class="block text-sm font-black text-neutral-900 dark:text-white uppercase tracking-wider mb-3">
                                            {{ __('gigs.applications.compensation_expectation') }}
                                        </label>
                                        <input type="text" 
                                               wire:model="applicationCompensationExpectation" 
                                               class="w-full px-5 py-4 border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white focus:border-primary-500 dark:focus:border-primary-400 focus:ring-4 focus:ring-primary-500/10 transition-all"
                                               placeholder="{{ __('gigs.applications.compensation_expectation_placeholder') }}">
                                    </div>

                                </div>

                                {{-- Buttons --}}
                                <div class="flex flex-col md:flex-row gap-4 pt-6">
                                    <button type="submit" 
                                            class="group flex-1 relative px-8 py-5 bg-gradient-to-r from-accent-500 via-accent-600 to-accent-700 hover:from-accent-600 hover:via-accent-700 hover:to-accent-800 text-white font-black text-lg uppercase tracking-wider transition-all overflow-hidden hover:shadow-[0_20px_50px_rgba(34,197,94,0.5)] hover:scale-105">
                                        <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></span>
                                        <span class="relative">{{ __('gigs.applications.submit_application') }}</span>
                                    </button>

                                    <button type="button" 
                                            wire:click="toggleApplicationForm" 
                                            class="px-8 py-5 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-black text-lg uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
                                        {{ __('gigs.cancel') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    
    {{-- Poem Modal --}}
    <livewire:poems.poem-modal />
</div>
