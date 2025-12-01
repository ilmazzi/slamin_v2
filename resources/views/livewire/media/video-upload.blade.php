<div class="min-h-screen">
    
    {{-- HERO con Film Card + Titolo --}}
    <section class="relative pt-16 pb-8 sm:pb-12 md:pb-16 lg:pb-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-4 sm:gap-6 md:flex-row md:justify-center md:gap-8 lg:gap-12">
                
                <!-- FILM CARD -->
                <div class="media-page-film-card">
                    <!-- Film codes -->
                    <div class="media-page-film-code-top">SLAMIN</div>
                    <div class="media-page-film-code-bottom">ISO 400</div>
                    
                    <!-- Film frame -->
                    <div class="media-page-film-frame">
                        <!-- Perforations -->
                        <div class="media-page-film-perf-left">
                            @for($h = 0; $h < 10; $h++)
                            <div class="media-page-perf-hole"></div>
                            @endfor
                        </div>
                        
                        <div class="media-page-film-perf-right">
                            @for($h = 0; $h < 10; $h++)
                            <div class="media-page-perf-hole"></div>
                            @endfor
                        </div>
                        
                        <!-- Frame numbers -->
                        <div class="media-page-frame-number-tl">///01</div>
                        <div class="media-page-frame-number-tr">01A</div>
                        <div class="media-page-frame-number-bl">35MM</div>
                        <div class="media-page-frame-number-br">1</div>
                        
                        <!-- Thumbnail -->
                        <div class="media-page-film-thumbnail" style="background: url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=600') center/cover;"></div>
                        
                        <!-- Upload text overlay -->
                        <div class="media-page-film-text">
                            Upload
                        </div>
                    </div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                        {{ __('media.upload_video_title') }} <span class="italic text-primary-400">{{ __('media.video') }}</span>
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/80 mt-2 sm:mt-3 md:mt-4 font-medium">
                        {{ __('media.upload_info') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- UPLOAD FORM SECTION --}}
    <section class="relative py-8 md:py-12 lg:py-16 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Upload Status Card --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 sm:p-6 mb-6 md:mb-8 border border-neutral-200 dark:border-neutral-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-1 truncate">{{ __('media.upload_status') }}</h3>
                            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">
                                {{ __('media.videos_remaining') }}: <strong class="text-primary-600 dark:text-primary-400">{{ $remainingUploads }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto sm:min-w-[200px]">
                        <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 sm:h-3 mb-2">
                            <div class="bg-primary-600 h-2 sm:h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ min(100, ($currentVideoCount / max($currentVideoLimit, 1)) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 text-center font-medium">
                            {{ $currentVideoCount }} / {{ $currentVideoLimit }} {{ __('media.videos_used') }}
                        </p>
                    </div>
                </div>
            </div>


            {{-- Upload Form --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden border border-neutral-200 dark:border-neutral-700">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-4 sm:px-6 py-4 sm:py-5">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white flex items-center gap-2 sm:gap-3" style="font-family: 'Crimson Pro', serif;">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{ __('media.upload_form') }}</span>
                    </h2>
                </div>
                
                <div class="p-4 sm:p-6 md:p-8 relative">
                    {{-- Loading State quando isUploading è true --}}
                    @if($isUploading)
                        <div class="absolute inset-0 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm z-50 flex items-center justify-center rounded-xl">
                            <div class="text-center p-6 sm:p-8 md:p-12 max-w-sm w-full mx-4">
                                <div class="animate-spin rounded-full h-16 w-16 sm:h-20 sm:w-20 md:h-24 md:w-24 border-b-4 border-primary-600 mx-auto mb-6"></div>
                                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white mb-3 sm:mb-4" style="font-family: 'Crimson Pro', serif;">
                                    {{ __('media.loading') }}
                                </h3>
                                <p class="text-base sm:text-lg md:text-xl text-neutral-600 dark:text-neutral-400 font-semibold mb-4 sm:mb-6">{{ $uploadPhase ?: __('media.preparing_file') }}</p>
                                <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-3 sm:h-4 mb-3 sm:mb-4">
                                    <div class="bg-gradient-to-r from-primary-600 via-primary-500 to-primary-400 h-3 sm:h-4 rounded-full transition-all duration-500" 
                                         style="width: {{ max($uploadProgress, 1) }}%"></div>
                                </div>
                                <p class="text-lg sm:text-xl md:text-2xl font-bold text-primary-600 dark:text-primary-400">{{ max($uploadProgress, 1) }}%</p>
                            </div>
                        </div>
                    @endif
                    
                    <form wire:submit="submitUpload" class="{{ $isUploading ? 'pointer-events-none opacity-30' : '' }}">
                        
                        {{-- Video File Upload --}}
                        <div class="mb-6 sm:mb-8">
                            <label class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-3 sm:mb-4" style="font-family: 'Crimson Pro', serif;">
                                {{ __('media.video_file') }} *
                            </label>
                            
                            <div class="relative border-2 border-dashed border-neutral-300 dark:border-neutral-600 rounded-xl p-6 sm:p-8 md:p-10 lg:p-12 text-center transition-all duration-300 hover:border-primary-500 dark:hover:border-primary-500 bg-neutral-50 dark:bg-neutral-900/50" 
                                 x-data="{ 
                                     isDragging: false,
                                     handleDrop(e) {
                                         e.preventDefault();
                                         this.isDragging = false;
                                         if (e.dataTransfer.files.length > 0) {
                                             const input = document.getElementById('video_file_input');
                                             const dataTransfer = new DataTransfer();
                                             dataTransfer.items.add(e.dataTransfer.files[0]);
                                             input.files = dataTransfer.files;
                                             input.dispatchEvent(new Event('change', { bubbles: true }));
                                         }
                                     },
                                     handleDragover(e) {
                                         e.preventDefault();
                                         this.isDragging = true;
                                     },
                                     handleDragleave() {
                                         this.isDragging = false;
                                     }
                                 }"
                                 @drop="handleDrop"
                                 @dragover="handleDragover"
                                 @dragleave="handleDragleave"
                                 :class="{ 'border-primary-500 bg-primary-50 dark:bg-primary-900/20': isDragging }">
                                
                                @if(!$video_file && !$isUploading)
                                    <svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 text-neutral-400 dark:text-neutral-500 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <h6 class="text-lg sm:text-xl md:text-2xl font-bold text-neutral-700 dark:text-neutral-300 mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">{{ __('media.drag_drop_video') }}</h6>
                                    <p class="text-sm sm:text-base text-neutral-500 dark:text-neutral-400 mb-3 sm:mb-4 font-medium">{{ __('media.supported_formats') }}</p>
                                    <p class="text-xs sm:text-sm text-neutral-400 dark:text-neutral-500 mb-4 sm:mb-6">{{ __('media.max_size') }}</p>
                                    <button type="button" 
                                            onclick="document.getElementById('video_file_input').click()"
                                            class="px-6 sm:px-8 py-3 sm:py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 text-sm sm:text-base md:text-lg">
                                        {{ __('media.select_file') }}
                                    </button>
                                    <input type="file" 
                                           id="video_file_input"
                                           wire:model="video_file" 
                                           accept="video/*" 
                                           class="hidden">
                                @elseif($video_file)
                                    {{-- File Selected --}}
                                    <div class="flex items-center gap-4 sm:gap-6 p-4 sm:p-6 bg-white dark:bg-neutral-800 rounded-lg sm:rounded-xl border-2 border-primary-200 dark:border-primary-800">
                                        <svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        <div class="flex-1 text-left min-w-0">
                                            <p class="font-semibold text-sm sm:text-base md:text-lg text-neutral-900 dark:text-white mb-1 truncate" style="font-family: 'Crimson Pro', serif;">
                                                @if(is_object($video_file) && method_exists($video_file, 'getClientOriginalName'))
                                                    {{ $video_file->getClientOriginalName() }}
                                                @else
                                                    {{ __('media.video_selected') }}
                                                @endif
                                            </p>
                                            <p class="text-xs sm:text-sm md:text-base text-neutral-500 dark:text-neutral-400 font-medium">
                                                @if(is_object($video_file) && method_exists($video_file, 'getSize'))
                                                    {{ number_format($video_file->getSize() / (1024 * 1024), 2) }} MB
                                                @endif
                                            </p>
                                        </div>
                                        <button type="button" 
                                                wire:click="$set('video_file', null)"
                                                class="p-2 sm:p-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            
                            @error('video_file') 
                                <p class="mt-3 text-sm font-bold text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Form Fields Grid --}}
                        <div class="space-y-6 sm:space-y-8 mb-6 sm:mb-8">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">
                                    {{ __('media.title') }} *
                                </label>
                                <input type="text" 
                                       id="title"
                                       wire:model.live="title" 
                                       class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white font-medium text-sm sm:text-base md:text-lg"
                                       maxlength="255"
                                       required>
                                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">{{ __('media.title_help') }}</p>
                                @error('title') 
                                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">
                                    {{ __('media.description') }}
                                </label>
                                <textarea id="description"
                                          wire:model="description" 
                                          rows="4"
                                          maxlength="1000"
                                          class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white resize-none font-medium text-sm sm:text-base"></textarea>
                                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">{{ __('media.description_help') }}</p>
                                @error('description') 
                                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Tags --}}
                            <div>
                                <label for="tags" class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">
                                    {{ __('media.tags') }}
                                </label>
                                <input type="text" 
                                       id="tags"
                                       wire:model="tags" 
                                       placeholder="{{ __('media.tags_placeholder') }}"
                                       maxlength="255"
                                       class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white font-medium text-sm sm:text-base">
                                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">{{ __('media.tags_help') }}</p>
                                @error('tags') 
                                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        {{-- Thumbnail --}}
                        <div class="mb-6 sm:mb-8">
                            <label class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">
                                {{ __('media.thumbnail') }}
                            </label>
                            <div class="border-2 border-dashed border-neutral-300 dark:border-neutral-600 rounded-lg sm:rounded-xl p-6 sm:p-8 text-center bg-neutral-50 dark:bg-neutral-900/50">
                                @if(!$thumbnail)
                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-neutral-400 dark:text-neutral-500 mx-auto mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm sm:text-base text-neutral-500 dark:text-neutral-400 mb-3 sm:mb-4 font-medium">{{ __('media.thumbnail_help') }}</p>
                                    <button type="button" 
                                            onclick="document.getElementById('thumbnail_input').click()"
                                            class="px-5 sm:px-6 py-2 sm:py-3 bg-neutral-600 hover:bg-neutral-700 text-white font-semibold rounded-lg sm:rounded-xl transition-colors text-sm sm:text-base">
                                        {{ __('media.select_thumbnail') }}
                                    </button>
                                    <input type="file" 
                                           id="thumbnail_input"
                                           wire:model="thumbnail" 
                                           accept="image/*" 
                                           class="hidden">
                                @else
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                                        <img src="{{ $thumbnail->temporaryUrl() }}" 
                                             alt="{{ __('media.thumbnail') }}" 
                                             class="max-w-full sm:max-w-xs max-h-40 sm:max-h-48 rounded-lg sm:rounded-xl object-cover shadow-md border-2 border-neutral-200 dark:border-neutral-700">
                                        <button type="button" 
                                                wire:click="$set('thumbnail', null)"
                                                class="p-2 sm:p-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            @error('thumbnail') 
                                <p class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Privacy --}}
                        <div class="mb-6 sm:mb-8">
                            <label class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-3 sm:mb-4" style="font-family: 'Crimson Pro', serif;">
                                {{ __('media.privacy') }}
                            </label>
                            <div class="grid sm:grid-cols-2 gap-3 sm:gap-4">
                                <label class="flex items-center gap-3 sm:gap-4 p-4 sm:p-5 border-2 rounded-lg sm:rounded-xl cursor-pointer transition-all duration-300 {{ $is_public ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 shadow-md' : 'border-neutral-300 dark:border-neutral-600 hover:border-primary-300 dark:hover:border-primary-700' }}">
                                    <input type="radio" 
                                           wire:model="is_public" 
                                           value="1" 
                                           class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 focus:ring-primary-500">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-neutral-600 dark:text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <span class="font-semibold text-sm sm:text-base md:text-lg text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">{{ __('media.public') }}</span>
                                </label>
                                
                                <label class="flex items-center gap-3 sm:gap-4 p-4 sm:p-5 border-2 rounded-lg sm:rounded-xl cursor-pointer transition-all duration-300 {{ !$is_public ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 shadow-md' : 'border-neutral-300 dark:border-neutral-600 hover:border-primary-300 dark:hover:border-primary-700' }}">
                                    <input type="radio" 
                                           wire:model="is_public" 
                                           value="0" 
                                           class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600 focus:ring-primary-500">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-neutral-600 dark:text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span class="font-semibold text-sm sm:text-base md:text-lg text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">{{ __('media.private') }}</span>
                                </label>
                            </div>
                            @error('is_public') 
                                <p class="mt-2 sm:mt-3 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Error Messages --}}
                        @if($errors->has('limit'))
                            <div class="mb-4 sm:mb-6 p-4 sm:p-5 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg sm:rounded-xl">
                                <p class="text-sm sm:text-base font-semibold text-red-600 dark:text-red-400">{{ $errors->first('limit') }}</p>
                            </div>
                        @endif
                        
                        @if($errors->has('upload'))
                            <div class="mb-4 sm:mb-6 p-4 sm:p-5 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg sm:rounded-xl">
                                <p class="text-sm sm:text-base font-semibold text-red-600 dark:text-red-400">{{ $errors->first('upload') }}</p>
                            </div>
                        @endif


                        {{-- Submit Buttons --}}
                        <div class="flex flex-col-reverse sm:flex-row justify-between gap-3 sm:gap-4 pt-6 sm:pt-8 border-t-2 border-neutral-200 dark:border-neutral-700">
                            <a href="{{ route('media.index') }}" 
                               class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold transition-colors text-sm sm:text-base md:text-lg">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span>{{ __('common.cancel') }}</span>
                            </a>
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    wire:target="submitUpload"
                                    @if(!$video_file || empty($title) || $isUploading) disabled @endif
                                    class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-400 disabled:cursor-not-allowed disabled:hover:translate-y-0 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 text-sm sm:text-base md:text-lg relative w-full sm:w-auto">
                                <span wire:loading.remove wire:target="submitUpload" class="inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <span>{{ __('media.upload_video') }}</span>
                                </span>
                                <span wire:loading wire:target="submitUpload" class="inline-flex items-center gap-2">
                                    <div class="animate-spin rounded-full h-4 w-4 sm:h-5 sm:w-5 border-b-2 border-white"></div>
                                    <span>{{ __('media.loading') }}</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Include media page styles --}}
    <style>
        /* Media Page Film Card Styles (from media-index.blade.php) */
        .media-page-film-card {
            position: relative;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0.08) 0%,
                transparent 30%
            ),
            linear-gradient(180deg, 
                rgba(80, 55, 35, 0.95) 0%,
                rgba(70, 48, 30, 0.97) 50%,
                rgba(80, 55, 35, 0.95) 100%
            );
            padding: 1.75rem 0.75rem;
            height: 250px;
            width: 200px;
            border-radius: 6px;
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.35),
                0 16px 32px rgba(0, 0, 0, 0.3),
                inset 0 2px 4px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .media-page-film-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 
                0 12px 24px rgba(0, 0, 0, 0.4),
                0 20px 40px rgba(0, 0, 0, 0.35);
        }
        
        .media-page-film-code-top,
        .media-page-film-code-bottom {
            position: absolute;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            letter-spacing: 0.1em;
            z-index: 2;
        }
        
        .media-page-film-code-top { top: 0.4rem; }
        .media-page-film-code-bottom { bottom: 0.4rem; }
        
        .media-page-film-frame {
            position: relative;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 2px;
            overflow: hidden;
        }
        
        .media-page-film-perf-left,
        .media-page-film-perf-right {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            background: linear-gradient(180deg, 
                rgba(80, 55, 35, 0.98) 0%,
                rgba(70, 48, 30, 1) 50%,
                rgba(80, 55, 35, 0.98) 100%
            );
            z-index: 3;
        }
        
        .media-page-film-perf-left { left: 0; }
        .media-page-film-perf-right { right: 0; }
        
        .media-page-perf-hole {
            width: 14px;
            height: 12px;
            background: rgba(240, 235, 228, 0.95);
            border-radius: 1px;
            box-shadow: 
                inset 0 2px 3px rgba(0, 0, 0, 0.4),
                inset 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .dark .media-page-perf-hole {
            background: #1a1a1a;
        }
        
        .media-page-film-thumbnail {
            position: absolute;
            inset: 0;
            z-index: 1;
        }
        
        .media-page-film-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Crimson Pro', serif;
            font-size: 2rem;
            font-weight: 900;
            color: white;
            text-shadow: 
                0 0 25px rgba(16, 185, 129, 0.9),
                0 0 50px rgba(16, 185, 129, 0.7),
                0 0 75px rgba(16, 185, 129, 0.5),
                0 4px 8px rgba(0, 0, 0, 0.9);
            z-index: 10;
            white-space: nowrap;
            letter-spacing: 0.05em;
            animation: media-glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes media-glow {
            0% {
                text-shadow: 
                    0 0 25px rgba(16, 185, 129, 0.9),
                    0 0 50px rgba(16, 185, 129, 0.7),
                    0 0 75px rgba(16, 185, 129, 0.5),
                    0 4px 8px rgba(0, 0, 0, 0.9);
            }
            100% {
                text-shadow: 
                    0 0 35px rgba(16, 185, 129, 1),
                    0 0 60px rgba(16, 185, 129, 0.9),
                    0 0 95px rgba(16, 185, 129, 0.7),
                    0 6px 12px rgba(0, 0, 0, 0.9);
            }
        }
        
        .media-page-frame-number-tl,
        .media-page-frame-number-tr,
        .media-page-frame-number-bl,
        .media-page-frame-number-br {
            position: absolute;
            font-size: 0.65rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            z-index: 4;
        }
        
        .media-page-frame-number-tl { top: 0.4rem; left: 1.5rem; }
        .media-page-frame-number-tr { top: 0.4rem; right: 1.5rem; }
        .media-page-frame-number-bl { bottom: 0.4rem; left: 1.5rem; }
        .media-page-frame-number-br { bottom: 0.4rem; right: 1.5rem; }
        
        @media (max-width: 768px) {
            .media-page-film-card {
                width: 180px;
                height: 220px;
                padding: 1.5rem 0.7rem;
            }
            
            .media-page-film-perf-left,
            .media-page-film-perf-right {
                width: 1.1rem;
            }
            
            .media-page-perf-hole {
                width: 12px;
                height: 10px;
            }
            
            .media-page-film-text {
                font-size: 1.75rem;
            }
        }
        
    </style>
</div>
