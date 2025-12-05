<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Gestione Articoli</h2>
            <p class="text-neutral-600 dark:text-neutral-400 mt-1">Gestisci tutti gli articoli della piattaforma</p>
        </div>
        <button wire:click="create" 
                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Crea Articolo
        </button>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="lg:col-span-2">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Cerca articolo..." 
                       class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            
            <div>
                <select wire:model.live="category" 
                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">Tutte le categorie</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            
            <div>
                <select wire:model.live="status" 
                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">Tutti gli stati</option>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            
            <div>
                <select wire:model.live="moderationStatus" 
                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">Tutti gli stati moderazione</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            
            <div class="flex gap-2">
                <select wire:model.live="sortBy" 
                        class="flex-1 px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="created_at">Data creazione</option>
                    <option value="title">Titolo</option>
                    <option value="status">Stato</option>
                </select>
                <button wire:click="sortByColumn('<?php echo e($sortBy); ?>')" 
                        class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600 border border-neutral-300 dark:border-neutral-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortDirection === 'asc'): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-800" 
                        wire:click="sortByColumn('title')">
                        <div class="flex items-center gap-2">
                            Titolo
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'title'): ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortDirection === 'asc'): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    <?php else: ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Categoria</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Autore</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Stato</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Moderazione</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Azioni</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                <?php echo e($article->title['it'] ?? $article->title['en'] ?? 'N/A'); ?>

                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->excerpt): ?>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                    <?php echo e(Str::limit($article->excerpt['it'] ?? $article->excerpt['en'] ?? '', 60)); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                <?php echo e($article->category->name ?? 'N/A'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-400">
                            <?php echo e($article->user->name ?? 'N/A'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo e($article->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ''); ?>

                                <?php echo e($article->status === 'draft' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : ''); ?>

                                <?php echo e($article->status === 'archived' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : ''); ?>">
                                <?php echo e(ucfirst($article->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo e($article->moderation_status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ''); ?>

                                <?php echo e($article->moderation_status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : ''); ?>

                                <?php echo e($article->moderation_status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : ''); ?>">
                                <?php echo e(ucfirst($article->moderation_status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="edit(<?php echo e($article->id); ?>)" 
                                        class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->moderation_status === 'pending'): ?>
                                    <button wire:click="approve(<?php echo e($article->id); ?>)" 
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                    <button wire:click="reject(<?php echo e($article->id); ?>)" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <button wire:click="delete(<?php echo e($article->id); ?>)" 
                                        wire:confirm="Sei sicuro di voler eliminare questo articolo?"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                            Nessun articolo trovato
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="flex justify-center">
        <?php echo e($articles->links()); ?>

    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModal): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white">
                        <?php echo e($isEditing ? 'Modifica' : 'Crea'); ?> Articolo
                    </h3>
                    <button wire:click="closeModal" class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Titolo (IT) *</label>
                            <input type="text" 
                                   wire:model="title.it" 
                                   class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Titolo (EN)</label>
                            <input type="text" 
                                   wire:model="title.en" 
                                   class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Excerpt (IT)</label>
                        <textarea wire:model="excerpt.it" 
                                  rows="2"
                                  class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Contenuto (IT) *</label>
                        <textarea wire:model="content.it" 
                                  rows="8"
                                  class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                  required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Categoria</label>
                            <select wire:model="category_id" 
                                    class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Nessuna</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Stato</label>
                            <select wire:model="articleStatus" 
                                    class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Immagine Featured</label>
                        <input type="file" 
                               wire:model="featured_image" 
                               accept="image/*"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_featured_image): ?>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-2">
                                Immagine attuale: <a href="<?php echo e(Storage::url($existing_featured_image)); ?>" target="_blank" class="text-primary-600 hover:underline"><?php echo e($existing_featured_image); ?></a>
                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" 
                                   wire:model="featured" 
                                   class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Featured</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <button type="button" 
                                wire:click="closeModal" 
                                class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600">
                            Annulla
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold disabled:opacity-50">
                            <span wire:loading.remove>Salva</span>
                            <span wire:loading>Salvataggio...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/admin/articles/article-list.blade.php ENDPATH**/ ?>