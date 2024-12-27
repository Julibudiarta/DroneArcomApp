<?php
    use App\Helpers\TranslationHelper;
    $user = Auth()->user()->Teams()->first()->id;
    $maintenance = App\Models\maintence_eq::Where('teams_id',$user)->count('name');
    $inProgres = App\Models\maintence_eq::Where('teams_id',$user)->where('status','in_progress')->count('name');
    $complate = App\Models\maintence_eq::Where('teams_id',$user)->where('status','completed')->count('name');
    $schedule = App\Models\maintence_eq::Where('teams_id', $user)->where('status','Schedule')->count('name');
?>
<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <div class="filament-stats-overview-widget p-6 border-b bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Title and total drones -->
        <div class="flex flex-col space-y-6 sm:flex-row sm:space-y-0 justify-between items-center">
            <!-- Title Section -->
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Maintenance'); ?> <br> <?php echo TranslationHelper::translateIfNeeded('Equipments & Batteries'); ?></h1><br>
                <span class="text-lg font-medium text-gray-500 dark:text-gray-400 p-3"><?php echo e($maintenance); ?> <?php echo TranslationHelper::translateIfNeeded('Total'); ?></span>
            </div>
    
            <!-- Status indicators (Airworthy, Maintenance, Retired) -->
            <div class="flex space-x-12">
                <div class="text-center p-3">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Complete'); ?></h2>
                    <h1 class="text-3xl font-bold text-green-600 dark:text-green-400"><?php echo e($complate); ?></h1>
                </div>
                <br>
                <div class="text-center p-3">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('In Progress'); ?></h2>
                    <h1 class="text-3xl font-bold text-blue-600 dark:text-blue-400"><?php echo e($inProgres); ?></h1>
                </div>
                <br>
                <div class="text-center p-3">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Schedule'); ?></h2>
                    <h1 class="text-3xl font-bold text-red-600 dark:text-red-300"><?php echo e($schedule); ?></h1>
                </div>
            </div>
    
            <!-- Action buttons -->
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can('create', App\Models\maintence_eq::class)): ?> 
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('filament.admin.resources.maintenance-batteries.create', ['tenant' => auth()->user()->teams()->first()->id])); ?>"><button class="filament-button px-6 py-2 text-sm font-semibold text-white bg-primary-600 dark:bg-primary-500 border border-transparent rounded-md hover:bg-primary-700 dark:hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600 dark:focus:ring-offset-gray-800">
                        <?php echo TranslationHelper::translateIfNeeded('Add Maintenance'); ?></button></a> 
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/filament/widgets/header-maintenance-eq.blade.php ENDPATH**/ ?>