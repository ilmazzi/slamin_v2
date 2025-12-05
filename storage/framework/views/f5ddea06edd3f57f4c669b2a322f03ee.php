<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Gestione Newsletter</h2>
            <p class="text-neutral-600 dark:text-neutral-400 mt-1">Gestisci gli iscritti e invia newsletter</p>
        </div>
        <button wire:click="openSendModal" 
                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Invia Newsletter
        </button>
    </div>

    
    <div class="border-b border-neutral-200 dark:border-neutral-700">
        <nav class="flex space-x-8">
            <button wire:click="$set('activeTab', 'subscribers')" 
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors
                           <?php echo e($activeTab === 'subscribers' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300 dark:text-neutral-400 dark:hover:text-neutral-300'); ?>">
                Iscritti (<?php echo e($stats['total'] ?? 0); ?>)
            </button>
            <button wire:click="$set('activeTab', 'statistics')" 
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors
                           <?php echo e($activeTab === 'statistics' ? 'border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:border-neutral-300 dark:text-neutral-400 dark:hover:text-neutral-300'); ?>">
                Statistiche
            </button>
        </nav>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
        <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'subscribers'): ?>
        <div class="space-y-4">
            
            <div class="flex gap-4 items-center">
                <div class="flex-1">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cerca per email o nome..." 
                           class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                </div>
                <select wire:model.live="statusFilter" 
                        class="px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                    <option value="all">Tutti</option>
                    <option value="active">Attivi</option>
                    <option value="unsubscribed">Disiscritti</option>
                </select>
                <button wire:click="openAddModal" 
                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Aggiungi Iscritto
                </button>
            </div>

            
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead class="bg-neutral-50 dark:bg-neutral-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Stato</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Iscritto il</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscriber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-white"><?php echo e($subscriber->email); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-400"><?php echo e($subscriber->name ?? '-'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        <?php echo e($subscriber->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ''); ?>

                                        <?php echo e($subscriber->status === 'unsubscribed' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : ''); ?>

                                        <?php echo e($subscriber->status === 'bounced' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : ''); ?>">
                                        <?php echo e(ucfirst($subscriber->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-400">
                                    <?php echo e($subscriber->subscribed_at->format('d/m/Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="toggleStatus(<?php echo e($subscriber->id); ?>)" 
                                            class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                        <?php echo e($subscriber->status === 'active' ? 'Disattiva' : 'Riattiva'); ?>

                                    </button>
                                    <button wire:click="deleteSubscriber(<?php echo e($subscriber->id); ?>)" 
                                            wire:confirm="Sei sicuro di voler eliminare questo iscritto?"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Elimina
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                    Nessun iscritto trovato
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($subscribers->links()); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'statistics'): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 shadow">
                <div class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">Totale Iscritti</div>
                <div class="text-3xl font-bold text-neutral-900 dark:text-white"><?php echo e($stats['total'] ?? 0); ?></div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 shadow">
                <div class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">Attivi</div>
                <div class="text-3xl font-bold text-green-600 dark:text-green-400"><?php echo e($stats['active'] ?? 0); ?></div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 shadow">
                <div class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">Disiscritti</div>
                <div class="text-3xl font-bold text-red-600 dark:text-red-400"><?php echo e($stats['unsubscribed'] ?? 0); ?></div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 shadow">
                <div class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">Bounced</div>
                <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400"><?php echo e($stats['bounced'] ?? 0); ?></div>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 shadow">
                <div class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">Questo Mese</div>
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400"><?php echo e($stats['this_month'] ?? 0); ?></div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showSendModal): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeSendModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white">Invia Newsletter</h3>
                    <button wire:click="closeSendModal" class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="sendNewsletter" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Destinatari</label>
                        <select wire:model="sendTo" class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                            <option value="all">Tutti gli iscritti attivi alla newsletter</option>
                            <option value="custom">Email personalizzate (separate da virgola)</option>
                        </select>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            <strong>"Tutti gli iscritti attivi":</strong> Invia a tutti gli utenti che si sono iscritti alla newsletter e sono attualmente attivi.<br>
                            <strong>"Email personalizzate":</strong> Invia a indirizzi email specifici che inserisci manualmente (anche se non sono iscritti alla newsletter).
                        </p>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sendTo === 'custom'): ?>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Email</label>
                            <textarea wire:model="customEmails" 
                                      placeholder="email1@example.com, email2@example.com" 
                                      class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white"
                                      rows="3"></textarea>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Oggetto *</label>
                        <input type="text" 
                               wire:model="subject" 
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Contenuto *</label>
                        <textarea wire:model="content" 
                                  class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white"
                                  rows="10"
                                  required></textarea>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Puoi usare HTML per formattare il contenuto</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" 
                                wire:click="closeSendModal" 
                                class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600">
                            Annulla
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold disabled:opacity-50">
                            <span wire:loading.remove>Invia Newsletter</span>
                            <span wire:loading>Invio in corso...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showAddModal): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeAddModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 max-w-md w-full mx-4" wire:click.stop>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white">Aggiungi Iscritto</h3>
                    <button wire:click="closeAddModal" class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="addSubscriber" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Email *</label>
                        <input type="email" 
                               wire:model="newEmail" 
                               placeholder="email@example.com"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white"
                               required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Nome (opzionale)</label>
                        <input type="text" 
                               wire:model="newName" 
                               placeholder="Nome completo"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" 
                                wire:click="closeAddModal" 
                                class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600">
                            Annulla
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold">
                            Aggiungi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/admin/newsletter/newsletter-management.blade.php ENDPATH**/ ?>