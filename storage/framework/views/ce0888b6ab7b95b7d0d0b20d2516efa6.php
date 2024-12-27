<?php
use App\Helpers\TranslationHelper;
$teams = Auth()->user()->teams()->first()->id;
$locations = session('location_id');
$flights = App\Models\Fligh::where('teams_id', $teams)
    ->where('location_id', $locations)
    ->paginate(5);

$flightCount = App\Models\Fligh::where('teams_id', $teams)
->where('location_id', $locations)
->get();

$count = $flightCount->count('id');

?>
<head>
<style>
    .main-content.active{
        display: block;
    }
</style>
</head>
<!--[if BLOCK]><![endif]--><?php if(request()->routeIs('filament.admin.resources.fligh-locations.view')): ?>
<div class="flex items-center justify-between py-4 px-6 border-b border-gray-300 bg-gray-100 dark:bg-gray-800 mb-4">
    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
        (<?php echo e($count); ?>) <?php echo TranslationHelper::translateIfNeeded('Flights'); ?>

    </h2>
</div>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mb-4">
        <!-- Container utama dengan lebar lebih besar di bagian atas -->
        <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[900px] mx-auto shadow-lg">
            <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-4">
                
                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Name'); ?></p>
                <a href="<?php echo e(route('filament.admin.resources.flighs.view', 
                            ['tenant' => Auth()->user()->teams()->first()->id, 'record' => $item->id])); ?>">
                    <p class="text-sm text-gray-700 dark:text-gray-400" style="color:rgb(0, 85, 255)"><?php echo e($item->name ?? null); ?></p>
                </a>

                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-700 dark:text-gray-400 border-r pr-4">
                        <?php echo e($item->start_date_flight ?? null); ?>

                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        <?php echo e($item->duration ?? null); ?>

                    </p>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Pilot:'); ?> <?php echo e($item->users->name ?? null); ?></p>
            </div>
        
            <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-4 px-4">
                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Drone'); ?></p>
                <a href="<?php echo e(route('filament.admin.resources.drones.view',
                ['tenant' => Auth()->user()->teams()->first()->id,
                'record' => $item->drones->id,])); ?>"><p class="text-sm text-gray-700 dark:text-gray-400" style="color:rgb(0, 85, 255)"><?php echo e($item->drones->name); ?></p></a>  
                <p class="text-sm text-gray-700 dark:text-gray-400" ><?php echo e($item->drones->brand); ?> / <?php echo e($item->drones->model); ?></p>
            </div>
        
            <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-2">
                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Customer'); ?></p>
                <a href="<?php echo e(route('filament.admin.resources.customers.index',
                ['tenant' => Auth()->user()->teams()->first()->id,
                'record' => $item->customers->id,])); ?>"><p class="text-sm text-gray-700 dark:text-gray-400" style="color:rgb(0, 85, 255)"><?php echo e($item->customers->name); ?></p></a>
            </div>
        
            <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-4">
                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Location'); ?></p>
                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->fligh_location->name ?? null); ?></p>
            </div>
            
            <div class="flex-1 min-w-[180px]">
                <button
                class="inline-block text-sm text-white rounded px-4 py-3 transition-all duration-300 ease-in-out bg-gray-400 dark:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white dark:hover:text-white focus:outline-none"
                onclick="showContent(<?php echo e($item->id); ?>)">
                <?php echo TranslationHelper::translateIfNeeded('More Info'); ?>

            </button>
            
            </div>
        </div>
        
        <!-- Bagian konten tambahan yang tersembunyi -->
        <div id="main-content-<?php echo e($item->id); ?>" class="main-content px-2" style="display: none">
            <!-- Container pertama dengan ukuran lebih besar -->
            <div class="flex flex-wrap justify-between py-4 px-6 border-t border-gray-400 bg-gray-300 dark:bg-gray-700  shadow-lg">
                <div class="flex-1 min-w-[180px]">
                    <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Landing'); ?></p>
                    <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->landings ?? null); ?></p>
                </div>
                <div class="flex-1 min-w-[180px">
                    <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Type'); ?></p>
                    <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->type ?? null); ?></p>
                </div>
                <div class="flex-1 min-w-[180px]">
                    <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Operation'); ?></p>
                    <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->ops ?? null); ?></p>
                </div>
            </div>
        
            <!-- Container kedua dengan ukuran lebih kecil -->
            <div class="flex items-center justify-between py-4 px-6 border-t border-gray-400 bg-gray-300 dark:bg-gray-700  shadow-lg">
                <div class="flex-1 min-w-[180px]">
                    <p class="text-sm text-gray-700 dark:text-gray-400"><strong><?php echo TranslationHelper::translateIfNeeded('Personnel:'); ?> </strong><?php echo e($item->users->name); ?> (Pilot) <?php echo e($item->instructor); ?> (Instructor)</p>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <div class="mt-4">
        <?php echo e($flights->links()); ?>

    </div>

<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<?php
    if (!request()->routeIs('filament.admin.resources.fligh-locations.view')) {
        header("Location: " . route('filament.admin.resources.fligh-locations.view', [
            'tenant' => $teams,
            'record' => $locations
        ]));
        exit();
    }
?>
<script>
    <!--[if BLOCK]><![endif]--><?php if(!request()->routeIs('filament.admin.resources.fligh-locations.view')): ?>
        window.location.href = "<?php echo e(route('filament.admin.resources.fligh-locations.view', ['tenant' => $teams, 'record' => $locations])); ?>";
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</script>

<script>
function showContent(id) {
    const contents = document.querySelectorAll('.main-content');
    const contentToShow = document.getElementById(`main-content-${id}`);
    if (contentToShow) {
        if (contentToShow.style.display === 'block') {
            contentToShow.style.display = 'none';
        } 
        else {
            contentToShow.style.display = 'block';
        }
    }
}
</script><?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/component/flight-location.blade.php ENDPATH**/ ?>