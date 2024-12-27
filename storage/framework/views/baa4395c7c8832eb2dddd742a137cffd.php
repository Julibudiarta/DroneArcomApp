<?php
    // $user = Auth()->user()->Teams()->first()->id;
    // $sumFlight = App\Models\fligh::Where('teams_id',$user)->count('name');
    // $flights = App\Models\fligh::Where('teams_id',$user)->get();
    // $totalDurationInSeconds = $flights->sum(function ($flight) {
    //             list($hours, $minutes, $seconds) = explode(':', $flight->duration);
    //             return ($hours * 3600) + ($minutes * 60) + $seconds;
    //         });
    //         $totalHours = floor($totalDurationInSeconds / 3600);
    //         $totalMinutes = floor(($totalDurationInSeconds % 3600) / 60);
    //         $totalSeconds = $totalDurationInSeconds % 60;
    //         // Format total durasi
    //         $formattedTotalDuration = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);;
    use App\Helpers\TranslationHelper;
    $filter = request()->input('tableFilters.individual.isActive');
    if ($filter) {
        $userId = auth()->id();
        $flights = App\Models\Fligh::where('users_id', $userId)->get();
    } else {
        $teamId = auth()->user()->teams()->first()->id;
        $flights = App\Models\Fligh::where('teams_id', $teamId)->get();
    }

    $sumFlight = $flights->count('name');

    $totalDurationInSeconds = $flights->sum(function ($flight) {
        list($hours, $minutes, $seconds) = explode(':', $flight->duration);
        return ($hours * 3600) + ($minutes * 60) + ($seconds);
    });
    $totalHours = floor($totalDurationInSeconds / 3600);
    $totalMinutes = floor(($totalDurationInSeconds % 3600) / 60);
    $totalSeconds = $totalDurationInSeconds % 60;
    $formattedTotalDuration = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);
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
            <div class="flex flex-col space-y-4">
                <!-- Title Section -->
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        <?php echo TranslationHelper::translateIfNeeded('Your Flights'); ?>

                    </h1>
                </div>
            
                <!-- Button Section -->
                <div class="mt-4">
                    <button id="organization" onclick="viewTeamFlight()" class="filament-button px-6 py-2 text-sm font-semibold text-primary-600 border border-primary-600 rounded-full bg-white duration-300 dark:bg-gray-800">
                        <?php echo TranslationHelper::translateIfNeeded('View Organization Flights'); ?>

                    </button>
                    <button id="individual" onclick="viewUserFlight()"  class="filament-button px-6 py-2 text-sm font-semibold text-primary-600 border border-primary-600 rounded-full bg-white duration-300 dark:bg-gray-800">
                        <?php echo TranslationHelper::translateIfNeeded('View Individual Flights'); ?>

                    </button>
                </div>  
            </div>
    
            <!-- Status indicators (Airworthy, Maintenance, Retired) -->
            <div class="flex space-x-12">
                <div class="text-center p-4">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Flying Time'); ?></h2>
                    <h1 class="text-3xl font-bold text-gray-600 dark:text-gray-300"><?php echo e($formattedTotalDuration); ?></h1>
                </div>
                <br>
                <div class="text-center p-4">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Flights'); ?></h2>
                    <h1 class="text-3xl font-bold text-gray-600 dark:text-gray-300"><?php echo e($sumFlight); ?></h1>
                </div>
                <br>
            </div>
    
            <!-- Action buttons -->
            
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can('create', App\Models\fligh::class)): ?> 
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('filament.admin.resources.flighs.create', ['tenant' => auth()->user()->teams()->first()->id])); ?>"><button class="filament-button px-6 py-2 text-sm font-semibold text-white bg-primary-600 dark:bg-primary-500 border border-transparent rounded-md hover:bg-primary-700 dark:hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600 dark:focus:ring-offset-gray-800">
                        <?php echo TranslationHelper::translateIfNeeded('Add Flight'); ?></button></a> 
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

<script>
    function viewUserFlight(){
        localStorage.setItem('button', 'user');
        document.getElementById('organization').style.display='block';
        document.getElementById('individual').style.display='none';
        const baseUrl = "<?php echo e(route('filament.admin.resources.flighs.index',['tenant'=>Auth()->user()->teams()->first()->id])); ?>";
        const params = new URLSearchParams({
        'tableFilters[individual][isActive]': true
        }); 
        window.location.href = `${baseUrl}?${params.toString()}`;
    }

    function viewTeamFlight(){
        localStorage.setItem('button', 'team');
        document.getElementById('organization').style.display='none';
        document.getElementById('individual').style.display='block';
        const baseUrl = "<?php echo e(route('filament.admin.resources.flighs.index',['tenant'=>Auth()->user()->teams()->first()->id])); ?>"; 
        window.location.href = `${baseUrl}`;
    }

    window.addEventListener("DOMContentLoaded", function() {
        const button = localStorage.getItem('button');
        console.log(button);
        if(button === 'user'){
            document.getElementById('individual').style.display = 'none';
            document.getElementById('organization').style.display='block';
            localStorage.removeItem('button');
        }else{
            document.getElementById('individual').style.display = 'block';
            document.getElementById('organization').style.display='none';
        }
        
    })
</script> 
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/filament/widgets/header-flight.blade.php ENDPATH**/ ?>