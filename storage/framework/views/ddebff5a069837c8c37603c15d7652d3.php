<?php
    use App\Helpers\TranslationHelper;
    $user = Auth()->user()->Teams()->first()->id;
    $sumbattery = App\Models\battrei::Where('teams_id',$user)->count('name');
    $airworthy = App\Models\battrei::Where('teams_id',$user)->where('status','airworthy')->count('name');
    $maintenance = App\Models\battrei::Where('teams_id',$user)->where('status','maintenance')->count('name');
    $retired = App\Models\battrei::Where('teams_id', $user)->where('status','retired')->count('name');
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

    <div class="filament-stats-overview-widget p-6 border-b bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Title and total drones -->
        <div class="flex flex-col space-y-6 sm:flex-row sm:space-y-0 justify-between items-center">
            <!-- Title Section -->
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white p-4"><?php echo TranslationHelper::translateIfNeeded('Batteries'); ?></h1><br>
                <span class="text-lg font-medium text-gray-500 dark:text-gray-400"><?php echo e($sumbattery); ?> <?php echo TranslationHelper::translateIfNeeded('Total'); ?></span>
            </div>
    
            <!-- Status indicators (Airworthy, Maintenance, Retired) -->
            <div class="flex space-x-12">
                <div class="text-center p-3">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Airworthy'); ?></h2>
                    <h1 class="text-3xl font-bold text-green-600 dark:text-green-400"><?php echo e($airworthy); ?></h1>
                </div>
                <br>
                <div class="text-center p-3">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Maintenance'); ?></h2>
                    <h1 class="text-3xl font-bold text-red-600 dark:text-red-400"><?php echo e($maintenance); ?></h1>
                </div>
                <br>
                <div class="text-center p-3">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Retired'); ?></h2>
                    <h1 class="text-3xl font-bold text-gray-600 dark:text-gray-300"><?php echo e($retired); ?></h1>
                </div>
            </div>
    
            <!-- Action buttons -->
            
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can('create', App\Models\battrei::class)): ?> 
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('filament.admin.resources.battreis.create', ['tenant' => auth()->user()->teams()->first()->id])); ?>"><button class="filament-button px-6 py-2 text-sm font-semibold text-white bg-primary-600 dark:bg-primary-500 border border-transparent rounded-md hover:bg-primary-700 dark:hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600 dark:focus:ring-offset-gray-800">
                        <?php echo TranslationHelper::translateIfNeeded('Add Batteries'); ?></button></a> 
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
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/filament/widgets/header-battery.blade.php ENDPATH**/ ?>