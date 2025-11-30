<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                🛡️ <?php echo e(__('report.moderation_title')); ?>

            </h1>
            <p class="text-neutral-600 dark:text-neutral-400">
                <?php echo e(__('report.moderation_subtitle')); ?>

            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <!-- Total -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 shadow-sm border border-neutral-200 dark:border-neutral-800">
                <div class="text-2xl font-bold text-neutral-900 dark:text-white"><?php echo e($stats['total']); ?></div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('report.all_reports')); ?></div>
            </div>
            
            <!-- Pending -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 shadow-sm border border-yellow-200 dark:border-yellow-800">
                <div class="text-2xl font-bold text-yellow-900 dark:text-yellow-300"><?php echo e($stats['pending']); ?></div>
                <div class="text-sm text-yellow-700 dark:text-yellow-400"><?php echo e(__('report.pending_reports')); ?></div>
            </div>
            
            <!-- Investigating -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 shadow-sm border border-blue-200 dark:border-blue-800">
                <div class="text-2xl font-bold text-blue-900 dark:text-blue-300"><?php echo e($stats['investigating']); ?></div>
                <div class="text-sm text-blue-700 dark:text-blue-400"><?php echo e(__('report.active_reports')); ?></div>
            </div>
            
            <!-- Resolved -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 shadow-sm border border-green-200 dark:border-green-800">
                <div class="text-2xl font-bold text-green-900 dark:text-green-300"><?php echo e($stats['resolved']); ?></div>
                <div class="text-sm text-green-700 dark:text-green-400"><?php echo e(__('report.resolved_reports')); ?></div>
            </div>
            
            <!-- Dismissed -->
            <div class="bg-neutral-100 dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-neutral-300 dark:border-neutral-700">
                <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-300"><?php echo e($stats['dismissed']); ?></div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400"><?php echo e(__('report.dismissed_reports')); ?></div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-800 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        <?php echo e(__('common.search')); ?>

                    </label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchTerm"
                           placeholder="<?php echo e(__('report.search_placeholder')); ?>"
                           class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        <?php echo e(__('report.filter_by_status')); ?>

                    </label>
                    <select wire:model.live="statusFilter"
                            class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                        <option value="all"><?php echo e(__('report.all_statuses')); ?></option>
                        <option value="<?php echo e(\App\Models\Report::STATUS_PENDING); ?>"><?php echo e(__('report.status_pending')); ?></option>
                        <option value="<?php echo e(\App\Models\Report::STATUS_INVESTIGATING); ?>"><?php echo e(__('report.status_investigating')); ?></option>
                        <option value="<?php echo e(\App\Models\Report::STATUS_RESOLVED); ?>"><?php echo e(__('report.status_resolved')); ?></option>
                        <option value="<?php echo e(\App\Models\Report::STATUS_DISMISSED); ?>"><?php echo e(__('report.status_dismissed')); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Reports List -->
        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <!-- Reporter Info -->
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <img src="<?php echo e($report->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($report->user->name)); ?>" 
                                 alt="<?php echo e($report->user->name); ?>"
                                 class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <div class="font-medium text-neutral-900 dark:text-white">
                                    <?php echo e($report->user->name); ?>

                                </div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                    <?php echo e($report->created_at->diffForHumans()); ?>

                                </div>
                            </div>
                        </div>

                        <!-- Report Details -->
                        <div class="flex-1 min-w-0">
                            <!-- Status Badge -->
                            <div class="flex items-center gap-2 mb-2">
                                <?php
                                $statusColors = [
                                    \App\Models\Report::STATUS_PENDING => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    \App\Models\Report::STATUS_INVESTIGATING => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                    \App\Models\Report::STATUS_RESOLVED => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    \App\Models\Report::STATUS_DISMISSED => 'bg-neutral-100 text-neutral-800 dark:bg-neutral-800 dark:text-neutral-300',
                                ];
                                ?>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($statusColors[$report->status] ?? ''); ?>">
                                    <?php echo e(__('report.status_' . $report->status)); ?>

                                </span>
                                
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    <?php echo e(__('report.reasons.' . $report->reason)); ?>

                                </span>
                                
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                    <?php echo e(class_basename($report->reportable_type)); ?> #<?php echo e($report->reportable_id); ?>

                                </span>
                            </div>

                            <!-- Description -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->description): ?>
                            <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-3">
                                <?php echo e($report->description); ?>

                            </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <!-- Content Preview -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->reportable): ?>
                            <div class="mt-3 p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                <div class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1">
                                    <?php echo e(__('report.reported_content')); ?>:
                                </div>
                                <div class="text-sm text-neutral-900 dark:text-white line-clamp-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($report->reportable, 'getContentPreviewAttribute')): ?>
                                        <?php echo e($report->reportable->content_preview); ?>

                                    <?php elseif(isset($report->reportable->title)): ?>
                                        <strong><?php echo e($report->reportable->title); ?></strong>
                                    <?php elseif(isset($report->reportable->content)): ?>
                                        <?php echo e(\Str::limit($report->reportable->content, 100)); ?>

                                    <?php elseif(isset($report->reportable->body)): ?>
                                        <?php echo e(\Str::limit($report->reportable->body, 100)); ?>

                                    <?php else: ?>
                                        <?php echo e(class_basename($report->reportable_type)); ?> #<?php echo e($report->reportable_id); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                <div class="text-xs text-red-700 dark:text-red-300">
                                    ⚠️ <?php echo e(__('report.content_deleted_or_unavailable')); ?>

                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <!-- Resolution Notes -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->resolution_notes && in_array($report->status, [\App\Models\Report::STATUS_RESOLVED, \App\Models\Report::STATUS_DISMISSED])): ?>
                            <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="text-xs font-semibold text-blue-700 dark:text-blue-300 mb-1">
                                    <?php echo e(__('report.resolution_notes')); ?>:
                                </div>
                                <div class="text-sm text-blue-900 dark:text-blue-200">
                                    <?php echo e($report->resolution_notes); ?>

                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->resolver): ?>
                                <div class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                    — <?php echo e($report->resolver->name); ?>, <?php echo e($report->resolved_at->diffForHumans()); ?>

                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($report->status, [\App\Models\Report::STATUS_PENDING, \App\Models\Report::STATUS_INVESTIGATING])): ?>
                        <div class="flex flex-col gap-2 flex-shrink-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->status === \App\Models\Report::STATUS_PENDING): ?>
                            <button wire:click="markInvestigating(<?php echo e($report->id); ?>)"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                🔍 <?php echo e(__('report.mark_investigating')); ?>

                            </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <button wire:click="openResolveModal(<?php echo e($report->id); ?>)"
                                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                ✅ <?php echo e(__('report.mark_resolved')); ?>

                            </button>
                            
                            <button wire:click="dismissReport(<?php echo e($report->id); ?>)"
                                    wire:confirm="<?php echo e(__('report.confirm_dismiss')); ?>"
                                    class="px-4 py-2 bg-neutral-600 text-white text-sm font-medium rounded-lg hover:bg-neutral-700 transition-colors">
                                ❌ <?php echo e(__('report.mark_dismissed')); ?>

                            </button>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->reportable): ?>
                            <button wire:click="deleteContent(<?php echo e($report->id); ?>)"
                                    wire:confirm="<?php echo e(__('report.confirm_delete_content')); ?>"
                                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                🗑️ <?php echo e(__('report.delete_content')); ?>

                            </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->reportable): ?>
                                <?php
                                    // Normalizza il tipo - può essere 'poem' o 'Poem' o 'App\Models\Poem'
                                    $rawType = $report->reportable_type;
                                    $contentType = class_basename($rawType);
                                    $contentTypeLower = strtolower($contentType);
                                    $contentUrl = null;
                                    
                                    // Genera URL per contenuti che hanno pagine dedicate
                                    if ($contentTypeLower === 'event') {
                                        $contentUrl = route('events.show', $report->reportable_id);
                                    } elseif ($contentTypeLower === 'poem') {
                                        $contentUrl = route('poems.show', $report->reportable->slug ?? $report->reportable_id);
                                    } elseif ($contentTypeLower === 'article') {
                                        $contentUrl = route('articles.show', $report->reportable_id);
                                    }
                                ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contentUrl): ?>
                                    
                                    <a href="<?php echo e($contentUrl); ?>" 
                                       target="_blank"
                                       class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors inline-flex items-center gap-2">
                                        👁️ <?php echo e(__('report.view_content')); ?>

                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    
                                    <button wire:click="viewContent(<?php echo e($report->id); ?>)"
                                            class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                                        👁️ <?php echo e(__('report.view_content')); ?>

                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-800 p-12 text-center">
                <div class="text-6xl mb-4">🎉</div>
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                    <?php echo e(__('report.no_reports')); ?>

                </h3>
                <p class="text-neutral-600 dark:text-neutral-400">
                    <?php echo e(__('report.no_reports_message')); ?>

                </p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <?php echo e($reports->links()); ?>

        </div>
    </div>

    <!-- Resolve Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showResolveModal && $selectedReport): ?>
    <div class="fixed inset-0 z-[9999] overflow-y-auto" 
         x-data="{ show: <?php if ((object) ('showResolveModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showResolveModal'->value()); ?>')<?php echo e('showResolveModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showResolveModal'); ?>')<?php endif; ?> }"
         x-show="show"
         x-cloak
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
             @click="$wire.closeResolveModal()">
        </div>

        <!-- Modal -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-lg w-full p-6"
                 @click.stop>
                
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                    <?php echo e(__('report.resolve_report')); ?>

                </h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        <?php echo e(__('report.resolution_notes')); ?>

                        <span class="text-neutral-500 font-normal">(<?php echo e(__('common.optional')); ?>)</span>
                    </label>
                    <textarea wire:model="resolutionNotes"
                              rows="3"
                              placeholder="<?php echo e(__('report.resolution_notes_placeholder')); ?>"
                              class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all"></textarea>
                </div>

                <div class="flex gap-3">
                    <button @click="$wire.closeResolveModal()"
                            class="flex-1 px-6 py-3 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-semibold rounded-xl hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                        <?php echo e(__('common.cancel')); ?>

                    </button>
                    <button wire:click="resolveReport"
                            class="flex-1 px-6 py-3 bg-gradient-to-br from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                        <?php echo e(__('report.resolve')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Content Preview Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showContentModal && $selectedContent): ?>
    <div class="fixed inset-0 z-[9999] overflow-y-auto" 
         x-data="{ show: <?php if ((object) ('showContentModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showContentModal'->value()); ?>')<?php echo e('showContentModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showContentModal'); ?>')<?php endif; ?> }"
         x-show="show"
         x-cloak
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity"
             @click="$wire.closeContentModal()">
        </div>

        <!-- Modal -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                 @click.stop>
                
                <!-- Header -->
                <div class="sticky top-0 bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-800 px-6 py-4 flex items-center justify-between z-10">
                    <div>
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white">
                            <?php echo e(__('report.reported_content')); ?>

                        </h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                            <?php echo e(ucfirst($selectedContent['type'])); ?> #<?php echo e($selectedContent['report']->reportable_id); ?>

                        </p>
                    </div>
                    <button @click="$wire.closeContentModal()"
                            class="p-2 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <?php
                        $content = $selectedContent['data'];
                        $type = $selectedContent['type'];
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'Video'): ?>
                        <!-- Video Content -->
                        <div>
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e($content->title); ?></h2>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($content->thumbnail_url): ?>
                            <img src="<?php echo e($content->thumbnail_url); ?>" 
                                 alt="<?php echo e($content->title); ?>"
                                 class="w-full h-64 object-cover rounded-lg mb-4">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($content->description): ?>
                            <p class="text-neutral-700 dark:text-neutral-300 mb-4"><?php echo e($content->description); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <div class="flex items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                                <span>👁️ <?php echo e(number_format($content->view_count ?? 0)); ?> <?php echo e(__('common.views')); ?></span>
                                <span>❤️ <?php echo e(number_format($content->like_count ?? 0)); ?> <?php echo e(__('common.likes')); ?></span>
                            </div>
                        </div>

                    <?php elseif($type === 'Photo'): ?>
                        <!-- Photo Content -->
                        <div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($content->title): ?>
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4"><?php echo e($content->title); ?></h2>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <img src="<?php echo e($content->url ?? $content->image_url); ?>" 
                                 alt="<?php echo e($content->title ?? 'Photo'); ?>"
                                 class="w-full rounded-lg mb-4">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($content->description): ?>
                            <p class="text-neutral-700 dark:text-neutral-300 mb-4"><?php echo e($content->description); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <div class="flex items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                                <span>❤️ <?php echo e(number_format($content->like_count ?? 0)); ?> <?php echo e(__('common.likes')); ?></span>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Fallback -->
                        <div class="text-center py-12">
                            <p class="text-neutral-600 dark:text-neutral-400">
                                <?php echo e(__('report.content_type_not_supported')); ?>

                            </p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Report Info -->
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-800">
                        <h4 class="font-semibold text-neutral-900 dark:text-white mb-3">
                            <?php echo e(__('report.report_details')); ?>

                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400"><?php echo e(__('report.reason')); ?>:</span>
                                <span class="font-medium text-neutral-900 dark:text-white">
                                    <?php echo e(__('report.reasons.' . $selectedContent['report']->reason)); ?>

                                </span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedContent['report']->description): ?>
                            <div class="mt-3">
                                <span class="text-neutral-600 dark:text-neutral-400"><?php echo e(__('report.description')); ?>:</span>
                                <p class="mt-1 text-neutral-900 dark:text-white"><?php echo e($selectedContent['report']->description); ?></p>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Footer with Actions -->
                <div class="sticky bottom-0 bg-white dark:bg-neutral-900 border-t border-neutral-200 dark:border-neutral-800 px-6 py-4 flex justify-end gap-3">
                    <button @click="$wire.closeContentModal()"
                            class="px-6 py-2 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-medium rounded-lg hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                        <?php echo e(__('common.close')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php /**PATH /Users/mazzi/slamin_v2/resources/views/livewire/moderation/reports-dashboard.blade.php ENDPATH**/ ?>