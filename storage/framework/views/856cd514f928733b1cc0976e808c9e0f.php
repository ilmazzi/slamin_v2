<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8 md:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                        <?php echo e(__('profile.edit.title')); ?>

                    </h1>
                    <p class="text-neutral-600 dark:text-neutral-400"><?php echo e(__('profile.edit.subtitle')); ?></p>
                </div>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('profile.languages')); ?>" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        <span class="hidden sm:inline"><?php echo e(__('profile.languages')); ?></span>
                    </a>
                    <a href="<?php echo e(route('profile.badges')); ?>" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <span class="hidden sm:inline"><?php echo e(__('profile.badges')); ?></span>
                    </a>
                </div>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl">
                <p class="text-green-800 dark:text-green-400 font-semibold"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(session()->has('error')): ?>
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl">
                <p class="text-red-800 dark:text-red-400 font-semibold"><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-white dark:bg-neutral-800 rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-700 shadow-sm mb-6">
            <div class="relative h-32 sm:h-40 overflow-hidden bg-gradient-to-br from-primary-600 via-accent-600 to-primary-800">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner): ?>
                    <img src="<?php echo e($banner->temporaryUrl()); ?>" alt="Banner" class="w-full h-full object-cover opacity-90">
                <?php elseif($user->banner_image_url): ?>
                    <img src="<?php echo e($user->banner_image_url); ?>" alt="Banner" class="w-full h-full object-cover opacity-90">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                
                
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avatar): ?>
                        <img src="<?php echo e($avatar->temporaryUrl()); ?>" alt="Avatar" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white dark:border-neutral-900 shadow-xl object-cover">
                    <?php else: ?>
                        <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($user, 200)); ?>" alt="Avatar" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white dark:border-neutral-900 shadow-xl object-cover">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            
            <div class="pt-16 sm:pt-20 pb-6 text-center">
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white"><?php echo e($user->name); ?></h2>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->nickname): ?>
                    <p class="text-primary-600 dark:text-primary-400"><?php echo e($user->nickname); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <form wire:submit="save" class="space-y-6">
            
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e(__('profile.edit.images')); ?></h3>
                
                <div class="grid sm:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.avatar')); ?>

                        </label>
                        <input type="file" 
                               wire:model="avatar" 
                               accept="image/*"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white text-sm">
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400"><?php echo e(__('profile.edit.avatar_help')); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avatar || $user->profile_photo): ?>
                            <button type="button" 
                                    wire:click="removeAvatar"
                                    class="mt-2 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                <?php echo e(__('profile.edit.remove_avatar')); ?>

                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.banner')); ?>

                        </label>
                        <input type="file" 
                               wire:model="banner" 
                               accept="image/*"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white text-sm">
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400"><?php echo e(__('profile.edit.banner_help')); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['banner'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banner || $user->banner_image): ?>
                            <button type="button" 
                                    wire:click="removeBanner"
                                    class="mt-2 px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                <?php echo e(__('profile.edit.remove_banner')); ?>

                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e(__('profile.edit.basic_info')); ?></h3>
                
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.name')); ?> *
                        </label>
                        <input type="text" 
                               id="name"
                               wire:model="name" 
                               required
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="nickname" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.nickname')); ?> *
                        </label>
                        <input type="text" 
                               id="nickname"
                               wire:model="nickname" 
                               required
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nickname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.email')); ?> *
                        </label>
                        <input type="email" 
                               id="email"
                               wire:model="email" 
                               required
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.phone')); ?>

                        </label>
                        <input type="tel" 
                               id="phone"
                               wire:model="phone" 
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.location')); ?>

                        </label>
                        <input type="text" 
                               id="location"
                               wire:model="location" 
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="birth_date" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.birth_date')); ?>

                        </label>
                        <input type="date" 
                               id="birth_date"
                               wire:model="birth_date" 
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="website" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.website')); ?>

                        </label>
                        <input type="text" 
                               id="website"
                               wire:model.blur="website" 
                               placeholder="www.example.com"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400"><?php echo e(__('profile.edit.website_hint')); ?></p>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="bio" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            <?php echo e(__('profile.edit.bio')); ?>

                        </label>
                        <textarea id="bio"
                                  wire:model="bio" 
                                  rows="4"
                                  maxlength="1000"
                                  class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white resize-none"></textarea>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400"><?php echo e(__('profile.edit.bio_help')); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e(__('profile.edit.social_links')); ?></h3>
                
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="social_facebook" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Facebook
                        </label>
                        <input type="text" 
                               id="social_facebook"
                               wire:model.blur="social_facebook" 
                               placeholder="facebook.com/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['social_facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="social_instagram" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Instagram
                        </label>
                        <input type="text" 
                               id="social_instagram"
                               wire:model.blur="social_instagram" 
                               placeholder="instagram.com/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['social_instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="social_twitter" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Twitter
                        </label>
                        <input type="text" 
                               id="social_twitter"
                               wire:model.blur="social_twitter" 
                               placeholder="twitter.com/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['social_twitter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="social_youtube" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            YouTube
                        </label>
                        <input type="text" 
                               id="social_youtube"
                               wire:model.blur="social_youtube" 
                               placeholder="youtube.com/channel/..."
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['social_youtube'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label for="social_linkedin" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            LinkedIn
                        </label>
                        <input type="text" 
                               id="social_linkedin"
                               wire:model.blur="social_linkedin" 
                               placeholder="linkedin.com/in/username"
                               class="w-full px-4 py-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent dark:bg-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['social_linkedin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="bg-gradient-to-br from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-xl p-6 border-2 border-primary-200 dark:border-primary-800 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <?php echo e(__('profile.edit.roles')); ?>

                </h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4"><?php echo e(__('profile.edit.roles_description')); ?></p>
                
                <div class="grid sm:grid-cols-3 gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->availableRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div wire:key="role-<?php echo e($role['name']); ?>"
                             wire:click="toggleRole('<?php echo e($role['name']); ?>')"
                             class="relative group cursor-pointer">
                            <div class="bg-white dark:bg-neutral-800 rounded-xl p-4 border-2 transition-all duration-300
                                <?php echo e(in_array($role['name'], $selectedRoles) 
                                    ? 'border-green-500 shadow-lg shadow-green-500/20' 
                                    : 'border-neutral-200 dark:border-neutral-700 hover:border-green-300'); ?>">
                                
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($role['name'], $selectedRoles)): ?>
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <div class="flex items-start gap-3">
                                    <div class="text-3xl"><?php echo e($role['icon']); ?></div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-neutral-900 dark:text-white truncate"><?php echo e($role['display_name']); ?></h4>
                                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-1"><?php echo e($role['description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <p class="mt-4 text-xs text-neutral-600 dark:text-neutral-400 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e(__('profile.edit.roles_help')); ?>

                </p>
            </div>

            
            <div class="bg-white dark:bg-neutral-800 rounded-xl p-6 border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e(__('profile.edit.privacy')); ?></h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4"><?php echo e(__('profile.edit.privacy_description')); ?></p>
                
                <div class="space-y-4">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" 
                               wire:model.live="show_email" 
                               class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 cursor-pointer">
                        <div>
                            <div class="font-semibold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"><?php echo e(__('profile.edit.show_email')); ?></div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('profile.edit.show_email_help')); ?></div>
                        </div>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" 
                               wire:model.live="show_phone" 
                               class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 cursor-pointer">
                        <div>
                            <div class="font-semibold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"><?php echo e(__('profile.edit.show_phone')); ?></div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('profile.edit.show_phone_help')); ?></div>
                        </div>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" 
                               wire:model.live="show_birth_date" 
                               class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 cursor-pointer">
                        <div>
                            <div class="font-semibold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"><?php echo e(__('profile.edit.show_birth_date')); ?></div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('profile.edit.show_birth_date_help')); ?></div>
                        </div>
                    </label>
                </div>
            </div>

            
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border-2 border-blue-200 dark:border-blue-800 shadow-sm">
                <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100 mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <?php echo e(__('profile.edit.data_privacy')); ?>

                </h3>
                <p class="text-blue-800 dark:text-blue-200 mb-4">
                    <?php echo e(__('profile.edit.data_privacy_description')); ?>

                </p>
                <a href="<?php echo e(route('profile.export')); ?>" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <?php echo e(__('profile.edit.export_data')); ?>

                </a>
            </div>

            
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-6 border-2 border-red-200 dark:border-red-800 shadow-sm">
                <h3 class="text-xl font-bold text-red-900 dark:text-red-100 mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <?php echo e(__('profile.edit.danger_zone')); ?>

                </h3>
                <p class="text-red-800 dark:text-red-200 mb-4">
                    <?php echo e(__('profile.edit.danger_zone_description')); ?>

                </p>
                <a href="<?php echo e(route('profile.delete')); ?>" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <?php echo e(__('profile.edit.delete_account')); ?>

                </a>
            </div>

            
            <div class="flex flex-col sm:flex-row justify-between gap-4">
                <a href="<?php echo e(route('profile.show')); ?>" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <?php echo e(__('profile.edit.cancel')); ?>

                </a>
                <button type="submit" 
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-primary-600 hover:bg-primary-700 disabled:bg-neutral-400 disabled:cursor-not-allowed text-white font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <?php echo e(__('profile.edit.save')); ?>

                    </span>
                    <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                        <?php echo e(__('profile.edit.saving')); ?>

                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/profile/profile-edit.blade.php ENDPATH**/ ?>