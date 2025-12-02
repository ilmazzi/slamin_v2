<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
    
    <div class="polaroid-wall-header py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2"><?php echo e(__('groups.community_title')); ?></h1>
                    <p class="text-neutral-700 dark:text-neutral-300"><?php echo e(__('groups.community_subtitle')); ?></p>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('groups.create')); ?>" wire:navigate
                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <?php echo e(__('groups.create_group')); ?>

                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-2 mb-6">
            <div class="flex gap-2">
                <button wire:click="switchTab('groups')"
                        class="flex-1 px-6 py-3 rounded-xl font-semibold transition-all <?php echo e($activeTab === 'groups' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800'); ?>">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <?php echo e(__('groups.groups_tab')); ?>

                    </span>
                </button>
                <button wire:click="switchTab('users')"
                        class="flex-1 px-6 py-3 rounded-xl font-semibold transition-all <?php echo e($activeTab === 'users' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800'); ?>">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <?php echo e(__('groups.users_tab')); ?>

                    </span>
                </button>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'groups'): ?>
            
            <div>
                
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input type="text" wire:model.live.debounce.300ms="groupSearch"
                                   placeholder="<?php echo e(__('groups.search_groups')); ?>"
                                   class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <select wire:model.live="groupFilter"
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                <option value=""><?php echo e(__('groups.all_groups_filter')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                <option value="my_groups"><?php echo e(__('groups.my_groups_filter')); ?></option>
                                <option value="my_admin_groups"><?php echo e(__('groups.my_admin_groups_filter')); ?></option>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <option value="public"><?php echo e(__('groups.public_filter')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin')): ?>
                                <option value="private"><?php echo e(__('groups.private_filter')); ?></option>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <button wire:click="clearGroupFilters"
                                    class="w-full px-4 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-700 transition-colors font-medium">
                                <?php echo e(__('groups.reset_filters')); ?>

                            </button>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('groups.show', $group)); ?>" wire:navigate
                           class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm hover:shadow-xl transition-all overflow-hidden group">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($group->image): ?>
                                <img src="<?php echo e(Storage::url($group->image)); ?>" alt="<?php echo e($group->name); ?>"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        <?php echo e($group->name); ?>

                                    </h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($group->visibility === 'private'): ?>
                                        <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 text-xs font-semibold rounded-lg">
                                            Privato
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4 line-clamp-2">
                                    <?php echo e($group->description); ?>

                                </p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-neutral-500 dark:text-neutral-500">
                                        <?php echo e($group->members_count); ?> <?php echo e($group->members_count === 1 ? 'membro' : 'membri'); ?>

                                    </span>
                                    <span class="text-primary-600 dark:text-primary-400 font-medium">
                                        <?php echo e(__('groups.view_more')); ?> →
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12">
                            <svg class="w-20 h-20 mx-auto text-neutral-300 dark:text-neutral-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-neutral-500 dark:text-neutral-500 text-lg"><?php echo e(__('groups.no_groups')); ?></p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="mt-8">
                    <?php echo e($groups->links()); ?>

                </div>
            </div>
        <?php else: ?>
            
            <div>
                
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input type="text" wire:model.live.debounce.300ms="userSearch"
                                   placeholder="<?php echo e(__('groups.search_users')); ?>"
                                   class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <select wire:model.live="userFilter"
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                <option value=""><?php echo e(__('groups.all_users_filter')); ?></option>
                                <option value="poets"><?php echo e(__('groups.poets_filter')); ?></option>
                                <option value="organizers"><?php echo e(__('groups.organizers_filter')); ?></option>
                            </select>
                        </div>
                        <div>
                            <button wire:click="clearUserFilters"
                                    class="w-full px-4 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-700 transition-colors font-medium">
                                <?php echo e(__('groups.reset_filters')); ?>

                            </button>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('user.show', $user)); ?>"
                           onclick="window.location.href = this.href; return false;"
                           class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm hover:shadow-xl transition-all p-6 group">
                            <div class="flex items-center gap-4 mb-4">
                                <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($user, 100)); ?>"
                                     alt="<?php echo e($user->name); ?>"
                                     class="w-16 h-16 rounded-full object-cover ring-4 ring-primary-100 dark:ring-primary-900 group-hover:ring-primary-200 dark:group-hover:ring-primary-800 transition-all">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        <?php echo e($user->name); ?>

                                    </h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->nickname): ?>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-500 truncate"><?php echo e($user->nickname); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                                <span><?php echo e($user->poems_count); ?> poesie</span>
                                <span>•</span>
                                <span><?php echo e($user->articles_count); ?> articoli</span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12">
                            <svg class="w-20 h-20 mx-auto text-neutral-300 dark:text-neutral-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <p class="text-neutral-500 dark:text-neutral-500 text-lg"><?php echo e(__('groups.no_users')); ?></p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="mt-8">
                    <?php echo e($users->links()); ?>

                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    
    <style>
        /* Polaroid Wall Header Background - Light & Dark Mode */
        .polaroid-wall-header {
            position: relative;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(180, 150, 120, 0.08) 0%, transparent 40%),
                radial-gradient(ellipse at 80% 70%, rgba(160, 140, 110, 0.06) 0%, transparent 35%),
                radial-gradient(ellipse at 40% 80%, rgba(200, 170, 140, 0.07) 0%, transparent 38%),
                url("data:image/svg+xml,%3Csvg width='280' height='280' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='stucco'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.8' numOctaves='6' seed='28' /%3E%3C/filter%3E%3Crect width='280' height='280' filter='url(%23stucco)' opacity='0.15'/%3E%3C/svg%3E"),
                repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(0, 0, 0, 0.012) 2px, rgba(0, 0, 0, 0.012) 3px),
                linear-gradient(135deg, #f5f1e8 0%, #ebe7de 20%, #e8e4db 40%, #e5e1d8 60%, #ebe7de 80%, #f5f1e8 100%);
            box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.06), inset 0 -1px 4px rgba(0, 0, 0, 0.04);
        }
        
        :is(.dark .polaroid-wall-header) {
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(80, 70, 60, 0.12) 0%, transparent 40%),
                radial-gradient(ellipse at 80% 70%, rgba(70, 60, 50, 0.1) 0%, transparent 35%),
                radial-gradient(ellipse at 40% 80%, rgba(90, 75, 65, 0.11) 0%, transparent 38%),
                url("data:image/svg+xml,%3Csvg width='280' height='280' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='stucco'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.8' numOctaves='6' seed='28' /%3E%3C/filter%3E%3Crect width='280' height='280' filter='url(%23stucco)' opacity='0.18'/%3E%3C/svg%3E"),
                linear-gradient(135deg, #3a3530 0%, #353128 15%, #38342c 30%, #332f26 45%, #36322a 60%, #312d24 75%, #35312b 90%, #3a3530 100%);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.2), inset 0 -2px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/groups/group-index.blade.php ENDPATH**/ ?>