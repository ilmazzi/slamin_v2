<div class="-mt-16">
<?php
    $primaryRole = optional($user->roles->first())->display_name ?? optional($user->roles->first())->name ?? null;
?>

<div class="profile-cinematic" 
     x-data="{ scrollY: 0, scrollProgress: 0 }" 
     x-init="
         window.addEventListener('scroll', () => {
             scrollY = window.scrollY;
             scrollProgress = Math.min(scrollY / 1000, 1);
         }, { passive: true });
     ">
    
    
    <section class="hero-immersive">
        
        <div class="parallax-bg">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->banner_image_url): ?>
                <img src="<?php echo e($user->banner_image_url); ?>" alt="" class="banner-blur">
            <?php else: ?>
                <div class="banner-gradient"></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <canvas id="particles-canvas" class="particles-layer"></canvas>

        
        <div class="hero-content-wrap">
            <div class="hero-inner">
                
                <div class="avatar-3d">
                    <div class="avatar-ring-outer"></div>
                    <div class="avatar-ring-middle"></div>
                    <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($user, 500)); ?>"
                         alt="<?php echo e(\App\Helpers\AvatarHelper::getDisplayName($user)); ?>"
                         class="avatar-img"
                         style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; object-position: center; display: block;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->verified_at ?? false): ?>
                        <div class="verified-seal">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="hero-info">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($primaryRole): ?>
                        <div class="role-tag"><?php echo e($primaryRole); ?></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <h1 class="name-title"><?php echo e($user->name); ?></h1>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->nickname): ?>
                        <p class="handle"><?php echo e($user->nickname); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->bio): ?>
                        <p class="bio-text"><?php echo e($user->bio); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="profile-info-compact">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->location): ?>
                            <div class="info-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span><?php echo e($user->location); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->website): ?>
                            <div class="info-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <a href="<?php echo e($user->website); ?>" target="_blank" rel="noopener" class="hover:underline"><?php echo e(Str::limit($user->website, 30)); ?></a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->phone && ($isOwnProfile ? true : $user->show_phone)): ?>
                            <div class="info-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span><?php echo e($user->phone); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->email && ($isOwnProfile ? true : $user->show_email)): ?>
                            <div class="info-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:<?php echo e($user->email); ?>" class="hover:underline"><?php echo e($user->email); ?></a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->birth_date && ($isOwnProfile ? true : $user->show_birth_date)): ?>
                            <div class="info-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->birth_date instanceof \Carbon\Carbon): ?>
                                        <?php echo e($user->birth_date->format('d/m/Y')); ?>

                                    <?php elseif($user->birth_date): ?>
                                        <?php echo e(\Carbon\Carbon::parse($user->birth_date)->format('d/m/Y')); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->languages && $user->languages->count() > 0): ?>
                        <div class="languages-compact">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $user->languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="language-flag-tag <?php echo e($language->type); ?>">
                                    <span class="flag-emoji"><?php echo e($language->language_code === 'it' ? '🇮🇹' : ($language->language_code === 'en' ? '🇬🇧' : ($language->language_code === 'fr' ? '🇫🇷' : ($language->language_code === 'es' ? '🇪🇸' : ($language->language_code === 'de' ? '🇩🇪' : '🌐'))))); ?></span>
                                    <span class="language-name"><?php echo e($language->language_name); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($language->type === 'native'): ?>
                                        <span class="language-badge-inline native"><?php echo e(__('profile.native')); ?></span>
                                    <?php else: ?>
                                        <span class="language-type-badge <?php echo e($language->type); ?>">
                                            <?php echo e($language->type === 'spoken' ? '🗣️' : '✍️'); ?>

                                            <?php echo e(__('languages.' . $language->type)); ?>

                                        </span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($language->level): ?>
                                            <span class="language-level-inline"><?php echo e(__('profile.' . $language->level)); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topBadges && $topBadges->count() > 0): ?>
                        <div class="user-badges-large">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topBadges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userBadge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="badge-item-large" title="<?php echo e($userBadge->badge->name); ?>">
                                    <img src="<?php echo e($userBadge->badge->icon_url); ?>"
                                         alt="<?php echo e($userBadge->badge->name); ?>"
                                         class="badge-icon-large">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="stats-inline">
                        <div class="stat-item">
                            <span class="stat-num"><?php echo e($stats['poems']); ?></span>
                            <span class="stat-lbl"><?php echo e(__('profile.stats.poems')); ?></span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num"><?php echo e($stats['articles']); ?></span>
                            <span class="stat-lbl"><?php echo e(__('profile.stats.articles')); ?></span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num"><?php echo e($stats['videos']); ?></span>
                            <span class="stat-lbl"><?php echo e(__('profile.stats.videos')); ?></span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num"><?php echo e(number_format($stats['total_views'])); ?></span>
                            <span class="stat-lbl"><?php echo e(__('profile.stats.views')); ?></span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-num"><?php echo e($user->level ?? 1); ?></span>
                            <span class="stat-lbl">Livello</span>
                        </div>
                        <div class="stat-divider"></div>
                        <a href="<?php echo e(route('user.followers', $user)); ?>" class="stat-item hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                            <span class="stat-num"><?php echo e($stats['followers']); ?></span>
                            <span class="stat-lbl"><?php echo e(__('follow.followers')); ?></span>
                        </a>
                        <div class="stat-divider"></div>
                        <a href="<?php echo e(route('user.following', $user)); ?>" class="stat-item hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                            <span class="stat-num"><?php echo e($stats['following']); ?></span>
                            <span class="stat-lbl"><?php echo e(__('follow.following_users')); ?></span>
                        </a>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isOwnProfile): ?>
                        <div class="mt-4 flex justify-center">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.follow-button', ['userId' => $user->id,'size' => 'md','variant' => 'default']);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1602318323-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->social_facebook || $user->social_instagram || $user->social_twitter || $user->social_youtube || $user->social_linkedin): ?>
                        <div class="social-links">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->social_facebook): ?>
                                <a href="<?php echo e($user->social_facebook); ?>" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->social_instagram): ?>
                                <a href="<?php echo e($user->social_instagram); ?>" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->social_twitter): ?>
                                <a href="<?php echo e($user->social_twitter); ?>" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->social_youtube): ?>
                                <a href="<?php echo e($user->social_youtube); ?>" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->social_linkedin): ?>
                                <a href="<?php echo e($user->social_linkedin); ?>" target="_blank" class="social-link">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="scroll-indicator" :style="`opacity: ${1 - scrollProgress}`">
            <div class="scroll-line"></div>
            <span><?php echo e(__('profile.scroll_to_explore')); ?></span>
        </div>
    </section>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOwnProfile): ?>
        <div class="sticky top-16 z-40 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <?php echo e(__('profile.edit_profile')); ?>

                    </a>
                    <a href="<?php echo e(route('profile.my-media')); ?>" class="inline-flex items-center gap-2 px-6 py-2.5 bg-neutral-700 hover:bg-neutral-800 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <?php echo e(__('profile.manage_media')); ?>

                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="content-sections">
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($poems->count() > 0): ?>
        <section class="section-horizontal poems-section" data-section="poems">
            <div class="section-title-vertical">
                <h2><?php echo e(__('profile.poems.title')); ?></h2>
                <a href="<?php echo e(route('poems.index')); ?>" class="view-all-link"><?php echo e(__('common.view_all')); ?></a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $poems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="poem-paper" onclick="Livewire.dispatch('openPoemModal', { poemId: <?php echo e($poem->id); ?> })">
                        <div class="paper-texture"></div>
                        <div class="paper-content">
                            <div class="author-stamp">
                                <img src="<?php echo e(\App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 60)); ?>" alt="">
                                <a href="<?php echo e(\App\Helpers\AvatarHelper::getUserProfileUrl($poem->user)); ?>" onclick="event.stopPropagation();">
                                    <?php echo e(\App\Helpers\AvatarHelper::getDisplayName($poem->user)); ?>

                                </a>
                            </div>
                            <h3>"<?php echo e($poem->title ?: __('poems.untitled')); ?>"</h3>
                            <p><?php echo e(\App\Helpers\PlaceholderHelper::cleanHtmlContent($poem->content, 150)); ?></p>
                            <div class="paper-footer" @click.stop>
                                <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $poem->id,'itemType' => 'poem','isLiked' => $poem->is_liked ?? false,'likesCount' => $poem->like_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($poem->id),'itemType' => 'poem','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($poem->is_liked ?? false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($poem->like_count ?? 0),'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $attributes = $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $component = $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $poem->id,'itemType' => 'poem','commentsCount' => $poem->comment_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($poem->id),'itemType' => 'poem','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($poem->comment_count ?? 0),'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $attributes = $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $component = $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articles->count() > 0): ?>
        <section class="section-horizontal articles-section" data-section="articles">
            <div class="section-title-vertical">
                <h2><?php echo e(__('profile.articles.title')); ?></h2>
                <a href="<?php echo e(route('articles.index')); ?>" class="view-all-link"><?php echo e(__('common.view_all')); ?></a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="article-magazine" onclick="Livewire.dispatch('openArticleModal', { articleId: <?php echo e($article->id); ?> })">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->featured_image_url): ?>
                        <div class="magazine-cover" style="background-image: url('<?php echo e($article->featured_image_url); ?>');"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="magazine-info">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article->category): ?>
                            <span class="magazine-category"><?php echo e($article->category->name); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h3><?php echo e($article->title); ?></h3>
                            <p><?php echo e(Str::limit($article->excerpt ?? strip_tags($article->content), 100)); ?></p>
                            <div class="magazine-footer" @click.stop>
                                <?php if (isset($component)) { $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.like-button','data' => ['itemId' => $article->id,'itemType' => 'article','isLiked' => $article->is_liked ?? false,'likesCount' => $article->like_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('like-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','isLiked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->is_liked ?? false),'likesCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->like_count ?? 0),'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $attributes = $__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__attributesOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2)): ?>
<?php $component = $__componentOriginal332a28e2e55aa3574ada95b4497eb0b2; ?>
<?php unset($__componentOriginal332a28e2e55aa3574ada95b4497eb0b2); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-button','data' => ['itemId' => $article->id,'itemType' => 'article','commentsCount' => $article->comment_count ?? 0,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['itemId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->id),'itemType' => 'article','commentsCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->comment_count ?? 0),'size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $attributes = $__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__attributesOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd)): ?>
<?php $component = $__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd; ?>
<?php unset($__componentOriginale34ce5ad0385b05e8d24b4bea6ec4cfd); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videos->count() > 0 || $photos->count() > 0): ?>
        <section class="section-horizontal media-section" data-section="media">
            <div class="section-title-vertical">
                <h2><?php echo e(__('profile.media.title')); ?></h2>
                <a href="<?php echo e(route('media.index')); ?>" class="view-all-link"><?php echo e(__('common.view_all')); ?></a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('media.video.show', $video->uuid)); ?>" class="media-filmstrip">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($video->thumbnail_url): ?>
                        <img src="<?php echo e($video->thumbnail_url); ?>" alt="<?php echo e($video->title); ?>">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="film-overlay">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                        </div>
                        <div class="film-title"><?php echo e($video->title); ?></div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="#" onclick="Livewire.dispatch('openPhotoModal', { photoId: <?php echo e($photo->id); ?> }); return false;" class="media-polaroid">
                        <img src="<?php echo e($photo->image_url ?? $photo->thumbnail_url); ?>" alt="<?php echo e($photo->title ?? __('media.untitled')); ?>">
                        <div class="polaroid-caption"><?php echo e($photo->title ?? __('media.untitled')); ?></div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($events->count() > 0): ?>
        <section class="section-horizontal events-section" data-section="events">
            <div class="section-title-vertical">
                <h2><?php echo e(__('profile.events.title')); ?></h2>
                <a href="<?php echo e(route('events.index')); ?>" class="view-all-link"><?php echo e(__('common.view_all')); ?></a>
            </div>
            <div class="horizontal-scroll-container">
                <div class="scroll-track">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="event-ticket-wrapper">
                        <?php if (isset($component)) { $__componentOriginal38bd807ab82c98cab835bf194286bfe9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38bd807ab82c98cab835bf194286bfe9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.event-ticket','data' => ['event' => $event]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('event-ticket'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['event' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38bd807ab82c98cab835bf194286bfe9)): ?>
<?php $attributes = $__attributesOriginal38bd807ab82c98cab835bf194286bfe9; ?>
<?php unset($__attributesOriginal38bd807ab82c98cab835bf194286bfe9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38bd807ab82c98cab835bf194286bfe9)): ?>
<?php $component = $__componentOriginal38bd807ab82c98cab835bf194286bfe9; ?>
<?php unset($__componentOriginal38bd807ab82c98cab835bf194286bfe9); ?>
<?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('livewire:init', () => {
    // Particles animation
    const canvas = document.getElementById('particles-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const particleCount = 50;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 3 + 1;
                this.speedX = Math.random() * 0.5 - 0.25;
                this.speedY = Math.random() * 0.5 - 0.25;
                this.opacity = Math.random() * 0.5 + 0.2;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width) this.x = 0;
                if (this.x < 0) this.x = canvas.width;
                if (this.y > canvas.height) this.y = 0;
                if (this.y < 0) this.y = canvas.height;
            }

            draw() {
                ctx.fillStyle = `rgba(74, 124, 89, ${this.opacity})`;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            requestAnimationFrame(animate);
        }

        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    }

    // Horizontal scroll with mouse wheel (only when scrolling horizontally or holding Shift)
    document.querySelectorAll('.horizontal-scroll-container').forEach(container => {
        container.addEventListener('wheel', (e) => {
            const isHorizontalScroll = Math.abs(e.deltaX) > Math.abs(e.deltaY);
            const isShiftPressed = e.shiftKey;
            const canScrollHorizontally = container.scrollWidth > container.clientWidth;
            
            // Solo converti in scroll orizzontale se:
            // 1. Si scrolla orizzontalmente (deltaX > deltaY) O si tiene premuto Shift
            // 2. E il container può ancora scrollare orizzontalmente
            // 3. Altrimenti, lascia che lo scroll verticale normale continui
            if ((isHorizontalScroll || isShiftPressed) && canScrollHorizontally) {
                e.preventDefault();
                container.scrollLeft += e.deltaX || e.deltaY;
            }
            // Se non si scrolla orizzontalmente e non si tiene Shift, non fare nulla
            // così lo scroll verticale normale può continuare
        }, { passive: false });
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('media.photo-modal');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1602318323-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/profile.css', 'resources/js/profile.js']); ?>
<style>
    .profile-info-compact {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
        margin-bottom: 1rem;
        justify-content: center;
        align-items: center;
    }

    .profile-info-compact .info-item {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 0.75rem;
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }

    .profile-info-compact .info-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .profile-info-compact .info-item svg {
        flex-shrink: 0;
        opacity: 0.8;
    }

    .profile-info-compact .info-item a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
    }

    .profile-info-compact .info-item a:hover {
        color: white;
        text-decoration: underline;
    }

    @media (max-width: 640px) {
        .profile-info-compact {
            flex-direction: column;
            gap: 0.75rem;
        }

        .profile-info-compact .info-item {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>

</div>
<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/profile/profile-show.blade.php ENDPATH**/ ?>