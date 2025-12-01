<div class="min-h-screen">
    
    {{-- HERO con Polaroid Card + Titolo --}}
    <section class="relative pt-16 pb-8 sm:pb-12 md:pb-16 lg:pb-20 overflow-hidden bg-neutral-900 dark:bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-4 sm:gap-6 md:flex-row md:justify-center md:gap-8 lg:gap-12">
                
                <!-- POLAROID CARD -->
                <div class="relative w-64 h-80 sm:w-80 sm:h-96 transform rotate-[-3deg] hover:rotate-0 transition-transform duration-300 shadow-2xl">
                    <div class="absolute inset-0 bg-white rounded-lg p-4 shadow-xl">
                        <div class="w-full h-full bg-gradient-to-br from-neutral-100 to-neutral-200 rounded flex items-center justify-center">
                            @if($photoPreview)
                                <img src="{{ $photoPreview }}" alt="Preview" class="w-full h-full object-cover rounded">
                            @else
                                <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -bottom-2 left-0 right-0 h-8 bg-white rounded-b-lg shadow-lg"></div>
                </div>
                
                <!-- TITOLO A FIANCO -->
                <div class="text-center md:text-left">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight" style="font-family: 'Crimson Pro', serif;">
                        {{ __('media.upload_photo_title') }} <span class="italic text-primary-400">{{ __('media.photo') }}</span>
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/80 mt-2 sm:mt-3 md:mt-4 font-medium">
                        {{ __('media.upload_photo_info') }}
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
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-accent-100 dark:bg-accent-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-1 truncate">{{ __('media.upload_status') }}</h3>
                            <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400">
                                {{ __('media.photos_remaining') }}: <strong class="text-accent-600 dark:text-accent-400">{{ $remainingUploads }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto sm:min-w-[200px]">
                        <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 sm:h-3 mb-2">
                            <div class="bg-accent-600 h-2 sm:h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ min(100, ($currentPhotoCount / max($currentPhotoLimit, 1)) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 text-center font-medium">
                            {{ $currentPhotoCount }} / {{ $currentPhotoLimit }} {{ __('media.photos_used') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Upload Form --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden border border-neutral-200 dark:border-neutral-700">
                <div class="bg-gradient-to-r from-accent-600 to-accent-700 px-4 sm:px-6 py-4 sm:py-5">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white flex items-center gap-2 sm:gap-3" style="font-family: 'Crimson Pro', serif;">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{ __('media.upload_photo_form') }}</span>
                    </h2>
                </div>
                
                <div class="p-4 sm:p-6 md:p-8">
                    <form wire:submit="submitUpload">
                        
                        {{-- Photo File Upload --}}
                        <div class="mb-6 sm:mb-8">
                            <label class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-3 sm:mb-4" style="font-family: 'Crimson Pro', serif;">
                                {{ __('media.photo_file') }} *
                            </label>
                            
                            <div class="relative border-2 border-dashed border-neutral-300 dark:border-neutral-600 rounded-xl p-6 sm:p-8 md:p-10 lg:p-12 text-center transition-all duration-300 hover:border-accent-500 dark:hover:border-accent-500 bg-neutral-50 dark:bg-neutral-900/50" 
                                 x-data="{ 
                                     isDragging: false,
                                     handleDrop(e) {
                                         e.preventDefault();
                                         this.isDragging = false;
                                         if (e.dataTransfer.files.length > 0) {
                                             const input = document.getElementById('photo_file_input');
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
                                 :class="{ 'border-accent-500 bg-accent-50 dark:bg-accent-900/20': isDragging }">
                                
                                @if(!$photo_file)
                                    <svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 text-neutral-400 dark:text-neutral-500 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <h6 class="text-lg sm:text-xl md:text-2xl font-bold text-neutral-700 dark:text-neutral-300 mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">{{ __('media.drag_drop_photo') }}</h6>
                                    <p class="text-sm sm:text-base text-neutral-500 dark:text-neutral-400 mb-3 sm:mb-4 font-medium">{{ __('media.supported_photo_formats') }}</p>
                                    <p class="text-xs sm:text-sm text-neutral-400 dark:text-neutral-500 mb-4 sm:mb-6">{{ __('media.max_size') }}: {{ $maxSizeMB }}MB</p>
                                    <button type="button" 
                                            onclick="document.getElementById('photo_file_input').click()"
                                            class="px-6 sm:px-8 py-3 sm:py-4 bg-accent-600 hover:bg-accent-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 text-sm sm:text-base md:text-lg">
                                        {{ __('media.select_file') }}
                                    </button>
                                    <input type="file" 
                                           id="photo_file_input"
                                           wire:model="photo_file" 
                                           accept="image/*" 
                                           class="hidden">
                                @elseif($photo_file)
                                    {{-- File Selected with Preview --}}
                                    <div class="space-y-4">
                                        @if($photoPreview)
                                            <div class="flex justify-center">
                                                <img src="{{ $photoPreview }}" 
                                                     alt="Preview" 
                                                     class="max-w-full max-h-96 rounded-lg shadow-lg border-2 border-accent-200 dark:border-accent-800">
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-4 sm:gap-6 p-4 sm:p-6 bg-white dark:bg-neutral-800 rounded-lg sm:rounded-xl border-2 border-accent-200 dark:border-accent-800">
                                            <svg class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 text-accent-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <div class="flex-1 text-left min-w-0">
                                                <p class="font-semibold text-sm sm:text-base md:text-lg text-neutral-900 dark:text-white mb-1 truncate" style="font-family: 'Crimson Pro', serif;">
                                                    @if(is_object($photo_file) && method_exists($photo_file, 'getClientOriginalName'))
                                                        {{ $photo_file->getClientOriginalName() }}
                                                    @else
                                                        {{ __('media.photo_selected') }}
                                                    @endif
                                                </p>
                                                <p class="text-xs sm:text-sm md:text-base text-neutral-500 dark:text-neutral-400 font-medium">
                                                    @if(is_object($photo_file) && method_exists($photo_file, 'getSize'))
                                                        {{ number_format($photo_file->getSize() / (1024 * 1024), 2) }} MB
                                                    @endif
                                                </p>
                                            </div>
                                            <button type="button" 
                                                    wire:click="$set('photo_file', null); $set('photoPreview', null)"
                                                    class="p-2 sm:p-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            @error('photo_file') 
                                <p class="mt-3 text-sm font-bold text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Form Fields Grid --}}
                        <div class="space-y-6 sm:space-y-8 mb-6 sm:mb-8">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">
                                    {{ __('media.title') }}
                                </label>
                                <input type="text" 
                                       id="title"
                                       wire:model.live="title" 
                                       class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-transparent dark:bg-neutral-900 dark:text-white font-medium text-sm sm:text-base md:text-lg"
                                       maxlength="255"
                                       placeholder="{{ __('media.title_placeholder') }}">
                                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">{{ __('media.title_photo_help') }}</p>
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
                                          placeholder="{{ __('media.description_placeholder') }}"
                                          class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-transparent dark:bg-neutral-900 dark:text-white resize-none font-medium text-sm sm:text-base"></textarea>
                                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">{{ __('media.description_photo_help') }}</p>
                                @error('description') 
                                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Alt Text --}}
                            <div>
                                <label for="alt_text" class="block text-base sm:text-lg font-semibold text-neutral-900 dark:text-white mb-2 sm:mb-3" style="font-family: 'Crimson Pro', serif;">
                                    {{ __('media.alt_text') }}
                                </label>
                                <input type="text" 
                                       id="alt_text"
                                       wire:model="alt_text" 
                                       placeholder="{{ __('media.alt_text_placeholder') }}"
                                       maxlength="255"
                                       class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-transparent dark:bg-neutral-900 dark:text-white font-medium text-sm sm:text-base">
                                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">{{ __('media.alt_text_help') }}</p>
                                @error('alt_text') 
                                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-end pt-4 sm:pt-6 border-t border-neutral-200 dark:border-neutral-700">
                            <a href="{{ route('media.index') }}" 
                               class="px-6 sm:px-8 py-3 sm:py-4 bg-neutral-600 hover:bg-neutral-700 text-white font-semibold rounded-lg sm:rounded-xl transition-colors text-center text-sm sm:text-base md:text-lg">
                                {{ __('common.cancel') }}
                            </a>
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="px-6 sm:px-8 py-3 sm:py-4 bg-accent-600 hover:bg-accent-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 text-sm sm:text-base md:text-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="submitUpload">
                                    {{ __('media.upload_photo') }}
                                </span>
                                <span wire:loading wire:target="submitUpload" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ __('media.uploading') }}
                                </span>
                            </button>
                        </div>

                        @error('upload') 
                            <p class="mt-4 text-sm font-bold text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

