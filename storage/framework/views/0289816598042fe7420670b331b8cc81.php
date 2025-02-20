<?php
    use App\Helpers\TranslationHelper;
    //year
    $year = Carbon\Carbon::now()->year;

    //name
    $userName = Auth()->user()->first()->name;
    $team = Auth()->user()->Teams()->first()->name;

    $userId = Auth()->user()->first()->id;
    $user = Auth()->user()->Teams()->first()->id;

    //current year flight data Team
    $sumFlightYear = App\Models\fligh::Where('teams_id',$user)
    ->whereYear('start_date_flight',$year)
    ->count('name');

    $flightsYear = App\Models\fligh::Where('teams_id',$user)
    ->whereYear('start_date_flight',$year)
    ->get();
    $totalDurationInSecondsYear = $flightsYear->sum(function ($flightYear) {
                list($hoursYear, $minutesYear, $secondsYear) = explode(':', $flightYear->duration);
                return ($hoursYear * 3600) + ($minutesYear * 60) + $secondsYear;
            });
            $totalHoursYear = floor($totalDurationInSecondsYear / 3600);
            $totalMinutesYear = floor(($totalDurationInSecondsYear % 3600) / 60);
            $totalSecondsYear = $totalDurationInSecondsYear % 60;
            // Format total durasi
            $formattedTotalDurationYear = sprintf('%02d:%02d:%02d', $totalHoursYear, $totalMinutesYear, $totalSecondsYear);

    //current year flight data Individual
    $sumFlightYearIndividu = App\Models\fligh::Where('users_id',$userId)
    ->whereYear('start_date_flight',$year)
    ->count('name');

    $flightsYearIndividu = App\Models\fligh::Where('users_id',$userId)
    ->whereYear('start_date_flight',$year)
    ->get();
    $totalDurationInSecondsYearIndividu = $flightsYearIndividu->sum(function ($flightYearIndividu) {
                list($hoursYearIndividu, $minutesYearIndividu, $secondsYearIndividu) = explode(':', $flightYearIndividu->duration);
                return ($hoursYearIndividu * 3600) + ($minutesYearIndividu * 60) + $secondsYearIndividu;
            });
            $totalHoursYearIndividu = floor($totalDurationInSecondsYearIndividu / 3600);
            $totalMinutesYearIndividu = floor(($totalDurationInSecondsYearIndividu % 3600) / 60);
            $totalSecondsYearIndividu = $totalDurationInSecondsYearIndividu % 60;
            // Format total durasi
            $formattedTotalDurationYearIndividu = sprintf('%02d:%02d:%02d', $totalHoursYearIndividu, $totalMinutesYearIndividu, $totalSecondsYearIndividu);


    //all flight data Team
    $sumFlight = App\Models\fligh::Where('teams_id',$user)->count('name');
    
    $flights = App\Models\fligh::Where('teams_id',$user)->get();
    $totalDurationInSeconds = $flights->sum(function ($flight) {
                list($hours, $minutes, $seconds) = explode(':', $flight->duration);
                return ($hours * 3600) + ($minutes * 60) + $seconds;
            });
            $totalHours = floor($totalDurationInSeconds / 3600);
            $totalMinutes = floor(($totalDurationInSeconds % 3600) / 60);
            $totalSeconds = $totalDurationInSeconds % 60;
            // Format total durasi
            $formattedTotalDuration = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);

      //all flight data Individu
    $sumFlightIndividu = App\Models\fligh::Where('users_id',$userId)->count('name');

    $flightsIndividu = App\Models\fligh::Where('users_id',$userId)->get();
    $totalDurationInSecondsIndividu = $flightsIndividu->sum(function ($flightIndividu) {
                list($hoursIndividu, $minutesIndividu, $secondsIndividu) = explode(':', $flightIndividu->duration);
                return ($hoursIndividu * 3600) + ($minutesIndividu * 60) + $secondsIndividu;
            });
            $totalHoursIndividu = floor($totalDurationInSecondsIndividu / 3600);
            $totalMinutesIndividu = floor(($totalDurationInSecondsIndividu % 3600) / 60);
            $totalSecondsIndividu = $totalDurationInSecondsIndividu % 60;
            // Format total durasi
            $formattedTotalDurationIndividu = sprintf('%02d:%02d:%02d', $totalHoursIndividu, $totalMinutesIndividu, $totalSecondsIndividu);
    
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
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
            <div class="flex flex-col items-start space-y-4">
                <h1 id="titleHeader" class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($team); ?></h1>
            
                <div class="flex space-x-4">
                    <button id="individualStats" onclick="openIndividualStats()" class="border-2 border-gray-500 text-gray-500 rounded-full px-4 py-2 hover:bg-gray-500 hover:text-white dark:border-gray-300 dark:text-gray-300 dark:hover:bg-gray-400 dark:hover:text-gray-900">
                        <?php echo TranslationHelper::translateIfNeeded('View Individual Stats'); ?>

                    </button>
            
                    <button id="teamStats" onclick="openTeamStats()" style="display: none;" class="border-2 border-gray-500 text-gray-500 rounded-full px-4 py-2 hover:bg-gray-500 hover:text-white dark:border-gray-300 dark:text-gray-300 dark:hover:bg-gray-400 dark:hover:text-gray-900">
                        <?php echo TranslationHelper::translateIfNeeded('View Organization Stats'); ?>

                    </button>
            
                    <button id="viewYearTeam" onclick="openYearTeam()" class="border-2 border-gray-500 text-gray-500 rounded-full px-4 py-2 hover:bg-gray-500 hover:text-white dark:border-gray-300 dark:text-gray-300 dark:hover:bg-gray-400 dark:hover:text-gray-900">
                        <?php echo TranslationHelper::translateIfNeeded('Current Year'); ?>

                    </button>
            
                    <button id="viewAllYearTeam" onclick="openAllYearTeam()" style="display: none;" class="border-2 border-gray-500 text-gray-500 rounded-full px-4 py-2 hover:bg-gray-500 hover:text-white dark:border-gray-300 dark:text-gray-300 dark:hover:bg-gray-400 dark:hover:text-gray-900">
                        <?php echo TranslationHelper::translateIfNeeded('View Total'); ?>

                    </button>
            
                    <button id="viewYearIndividual" onclick="openYearIndividual()" style="display: none;" class="border-2 border-gray-500 text-gray-500 rounded-full px-4 py-2 hover:bg-gray-500 hover:text-white dark:border-gray-300 dark:text-gray-300 dark:hover:bg-gray-400 dark:hover:text-gray-900">
                        <?php echo TranslationHelper::translateIfNeeded('Current Year'); ?>

                    </button>
            
                    <button id="viewAllYearIndividual" onclick="openAllYearIndividual()" style="display: none;" class="border-2 border-gray-500 text-gray-500 rounded-full px-4 py-2 hover:bg-gray-500 hover:text-white dark:border-gray-300 dark:text-gray-300 dark:hover:bg-gray-400 dark:hover:text-gray-900">
                        <?php echo TranslationHelper::translateIfNeeded('View Total'); ?>

                    </button>
                </div>
            </div>
                  
    
            <!-- Status indicators (Airworthy, Maintenance, Retired) -->
            <div class="flex space-x-12">
                <div class="text-center">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Flying Time'); ?></h2>
                    <h1 id="flightDuration" class="text-3xl font-bold text-gray-600 dark:text-gray-300"><?php echo e($formattedTotalDuration); ?></h1>
                </div>
                <br>
                <div class="text-center">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Flights'); ?></h2>
                    <h1 id="flightCount" class="text-3xl font-bold text-gray-600 dark:text-gray-300"><?php echo e($sumFlightYear); ?></h1>
                </div>
                <br>
                <div id="isYear" class="text-center" style="display: none;">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Year'); ?></h2>
                    <h1 id="flightCount" class="text-3xl font-bold text-gray-600 dark:text-gray-300"><?php echo e($year); ?></h1>
                </div>
            </div>
    
            <!-- Action buttons -->
            
            <!--[if BLOCK]><![endif]--><?php if(Auth::user()->can('create', App\Models\fligh::class)): ?> 
                <div class="flex space-x-4">
                    
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
    function openIndividualStats() {
        var title = <?php echo json_encode($userName); ?>;
        var flightDuration = <?php echo json_encode($formattedTotalDurationIndividu); ?>;
        var flightCount = <?php echo json_encode($sumFlightIndividu);?>;

        document.getElementById('isYear').style.display = 'none';


        document.getElementById('viewAllYearIndividual').style.display = 'none';
        document.getElementById('viewAllYearTeam').style.display = 'none';

        document.getElementById('viewYearIndividual').style.display = 'block';
        document.getElementById('viewYearTeam').style.display = 'none';


        document.getElementById("individualStats").style.display = "none";
        document.getElementById("teamStats").style.display = "block";


        document.getElementById("titleHeader").innerHTML = title;
        document.getElementById("flightDuration").innerHTML = flightDuration;
        document.getElementById("flightCount").innerHTML = flightCount;
    }

    function openTeamStats() {
        var title = <?php echo json_encode($team); ?>;
        var flightDuration = <?php echo json_encode($formattedTotalDuration); ?>;
        var flightCount = <?php echo json_encode($sumFlight);?>;

        document.getElementById('isYear').style.display = 'none';


        document.getElementById('viewAllYearIndividual').style.display = 'none';
        document.getElementById('viewAllYearTeam').style.display = 'none';

        document.getElementById('viewYearIndividual').style.display = 'none';
        document.getElementById('viewYearTeam').style.display = 'block';


        document.getElementById("individualStats").style.display = "block";
        document.getElementById("teamStats").style.display = "none";

        document.getElementById("titleHeader").innerHTML = title;
        document.getElementById("flightDuration").innerHTML = flightDuration;
        document.getElementById("flightCount").innerHTML = flightCount;
    }

    function openAllYearTeam() {
        var title = <?php echo json_encode($team); ?>;
        var flightDuration = <?php echo json_encode($formattedTotalDuration); ?>;
        var flightCount = <?php echo json_encode($sumFlight);?>;

        document.getElementById('isYear').style.display = 'none';


        document.getElementById('viewAllYearIndividual').style.display = 'none';
        document.getElementById('viewAllYearTeam').style.display = 'none';

        document.getElementById('viewYearIndividual').style.display = 'none';
        document.getElementById('viewYearTeam').style.display = 'block';


        document.getElementById("individualStats").style.display = "block";
        document.getElementById("teamStats").style.display = "none";


        document.getElementById("titleHeader").innerHTML = title;
        document.getElementById("flightDuration").innerHTML = flightDuration;
        document.getElementById("flightCount").innerHTML = flightCount;
    }

    function openYearTeam() {
        var title = <?php echo json_encode($team); ?>;
        var flightDuration = <?php echo json_encode($formattedTotalDurationYear); ?>;
        var flightCount = <?php echo json_encode($sumFlightYear);?>;

        document.getElementById('isYear').style.display = 'block';


        document.getElementById('viewAllYearIndividual').style.display = 'none';
        document.getElementById('viewAllYearTeam').style.display = 'block';

        document.getElementById('viewYearIndividual').style.display = 'none';
        document.getElementById('viewYearTeam').style.display = 'none';


        document.getElementById("individualStats").style.display = "block";
        document.getElementById("teamStats").style.display = "none";


        document.getElementById("titleHeader").innerHTML = title;
        document.getElementById("flightDuration").innerHTML = flightDuration;
        document.getElementById("flightCount").innerHTML = flightCount;
    }

    function openAllYearIndividual(){
        var title = <?php echo json_encode($userName); ?>;
        var flightDuration = <?php echo json_encode($sumFlightIndividu); ?>;
        var flightCount = <?php echo json_encode($formattedTotalDurationIndividu);?>;

        document.getElementById('isYear').style.display = 'none';


        document.getElementById('viewAllYearIndividual').style.display = 'none';
        document.getElementById('viewAllYearTeam').style.display = 'none';

        document.getElementById('viewYearIndividual').style.display = 'block';
        document.getElementById('viewYearTeam').style.display = 'none';


        document.getElementById("individualStats").style.display = "none";
        document.getElementById("teamStats").style.display = "block";


        document.getElementById("titleHeader").innerHTML = title;
        document.getElementById("flightDuration").innerHTML = flightDuration;
        document.getElementById("flightCount").innerHTML = flightCount;
    }

    function openYearIndividual(){
        var title = <?php echo json_encode($userName); ?>;
        var flightDuration = <?php echo json_encode($sumFlightYearIndividu); ?>;
        var flightCount = <?php echo json_encode($formattedTotalDurationYearIndividu);?>;

        document.getElementById('isYear').style.display = 'block';


        document.getElementById('viewAllYearIndividual').style.display = 'block';
        document.getElementById('viewAllYearTeam').style.display = 'none';

        document.getElementById('viewYearIndividual').style.display = 'none';
        document.getElementById('viewYearTeam').style.display = 'none';


        document.getElementById("individualStats").style.display = "none";
        document.getElementById("teamStats").style.display = "block";


        document.getElementById("titleHeader").innerHTML = title;
        document.getElementById("flightDuration").innerHTML = flightDuration;
        document.getElementById("flightCount").innerHTML = flightCount;
    }

  
</script>
<?php /**PATH C:\laragon\www\DroneArcomApp\resources\views/filament/widgets/header-dasboard.blade.php ENDPATH**/ ?>