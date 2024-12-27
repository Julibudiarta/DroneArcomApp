<?php
            use App\Helpers\TranslationHelper;
            $currentTeamId = Auth()->user()->teams()->first()->id;
            //maintenance
            $maintenance_eq = App\Models\maintence_eq::whereHas('teams', function ($query) use ($currentTeamId) {
                $query->where('id', $currentTeamId);
            })
            ->whereNotIn('status', ['completed'])
            ->whereRaw('DATE(date) < ?', [Carbon\Carbon::now()->format('Y-m-d')])
            ->get();


            $maintenance_drone = App\Models\maintence_drone::whereHas('teams', function ($query) use ($currentTeamId){
            $query->where('id', $currentTeamId);
            })->whereNotIn('status', ['completed'])
            ->whereRaw('DATE(date) < ?', [Carbon\Carbon::now()->format('Y-m-d')])
            ->get();

            //end maintenance

            //flight
            $flight = App\Models\fligh::Where('teams_id',$currentTeamId)->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
            //end flight
            //inventory
            $inventory = App\Models\fligh::Where('teams_id',$currentTeamId)
            ->with(['battreis','equidments'])
            ->limit(20)
            ->get();
            //end inventory

            //document
            $document = App\Models\document::whereHas('teams', function ($query) use ($currentTeamId){
            $query->where('teams.id', $currentTeamId)->where('status_visible', '!=', 'archived');
            })->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
            //end document
            //incident
            $incident = App\Models\incident::whereHas('teams', function ($query) use ($currentTeamId){
            $query->where('id', $currentTeamId);
            })->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            //end incident

            //edi inventory data

            $LastBattrei = DB::table('fligh_battrei')
                    ->select('battrei_id')
                    ->orderBy('updated_at', 'desc')
                    ->limit(5)
                    ->get();
                $uniqId = $LastBattrei->pluck('battrei_id')->unique();
                $battreiUsage = App\Models\Battrei::whereHas('teams', function ($query) use ($currentTeamId){
                    $query->where('teams_id', $currentTeamId);
                })->whereIn('id', $uniqId)
                    ->withCount('fligh as usage_count')
                    ->with('fligh')
                    ->get();

            $lastEquipment = DB::table('fligh_equidment')
                    ->select('equidment_id')
                    ->orderBy('updated_at', 'desc')
                    ->limit(5)
                    ->get();
                $uniqIdEquipment = $lastEquipment->pluck('equidment_id')->unique();
                $equipmentUsage = App\Models\Equidment::whereHas('teams', function ($query) use ($currentTeamId){
                    $query->where('teams_id', $currentTeamId);
                })->whereIn('id', $uniqIdEquipment)
                    ->withCount('fligh as usage_count')
                    ->with('fligh')
                    ->get();
            //count
            $flightCount = $flight->count();
            $maintenaceDroneCount =$maintenance_drone->count();
            $maintenaceEqCount = $maintenance_eq->count();
            $battreiCount = $battreiUsage->count();
            $equipmentCount = $equipmentUsage->count();
            $documentCount  = $document->count();
            $incidentCount = $incident->count();

            //end count
                        

                // Debugging output
                // dd($battreiUsage);

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Tab buttons styling */
        /* .tab-button {
            background-color: #e2e8f0;
            color: #333;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        } */
        .tab-button:hover {
            background-color: #cbd5e1;
            color: #000;
        }
        .tab-button.active {
            background-color: #3b82f6;
            color: white;
        }

        /* Tab content styling */
        .tab-content {
            display: none;
            padding: 20px;
            margin-top: 10px;
            animation: fadeIn 0.5s ease;
        }
        .tab-content.active {
            display: block;
        }
        .dark-mode {
            background-color: #1a1a1a; /* Dark background */
            color: white; /* Light text color */
        }
        .light-mode {
            background-color: white; /* Light background */
            color: black; /* Dark text color */
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
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
<div class="container tab-border-warna">
    <!-- Tab headers -->
    <div class="container mx-auto p-5">
        <div class="flex flex-wrap gap-2 border border-gray-300 rounded-lg p-2 bg-black dark:bg-gray-900">
            <button id="tab0" class="tab-button active text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto mb-2 mt-2"><?php echo TranslationHelper::translateIfNeeded('Summary'); ?></button>
            <button id="tab1" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto mb-2 mt-2"><?php echo TranslationHelper::translateIfNeeded('Flights'); ?></button>
            <button id="tab2" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto mb-2 mt-2"><?php echo TranslationHelper::translateIfNeeded('Maintenance'); ?></button>
            <button id="tab3" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto mb-2 mt-2"><?php echo TranslationHelper::translateIfNeeded('Inventory'); ?></button>
            <button id="tab4" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto mb-2 mt-2"><?php echo TranslationHelper::translateIfNeeded('Documents'); ?></button>
            <button id="tab5" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto mb-2 mt-2"><?php echo TranslationHelper::translateIfNeeded('Incidents'); ?></button>
        </div>

    <!-- Tab content -->
        <div class="content">

                <div id="content0" class="tab-content active">
                    <h2 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Your Operations Overview'); ?></h2>
                
                    
                    <div class="space-y-4">
                        <div class="flex flex-wrap justify-center gap-6">
                            <div class="rounded-lg shadow-lg p-4 flex-1 max-w-xs sm:max-w-sm md:max-w-md lg:max-w-full">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\FlightDurationChart::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                            <div class="rounded-lg shadow-lg p-4 flex-1 max-w-xs sm:max-w-sm md:max-w-md lg:max-w-full">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\FlightChart::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                        </div>
                        
                        <div class=""></div>
                        
                    </div>
                    
                    <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-yellow-200 dark:bg-gray-900">
                        <h1 class="text-2xl font-bold mb-4 w-full dark:text-gray-700"><?php echo TranslationHelper::translateIfNeeded('Quick Actions'); ?></h1>
                        <a href="<?php echo e(route('filament.admin.resources.flighs.create',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="mb-2"><button id="" class="text-white bg-primary-500 dark::bg-primary-600 hover:bg-yellow-400 px-4 py-2 rounded text-sm sm:text-base"><?php echo TranslationHelper::translateIfNeeded('Add New'); ?> <br><?php echo TranslationHelper::translateIfNeeded('Flights'); ?></button></a>
                        <a href="<?php echo e(route('filament.admin.resources.users.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="mb-2"><button id="" class="text-white bg-primary-500 dark::bg-primary-600 hover:bg-yellow-400 px-4 py-2 rounded text-sm sm:text-base"><?php echo TranslationHelper::translateIfNeeded('View My'); ?> <br><?php echo TranslationHelper::translateIfNeeded('Personnel Page'); ?></button></a>
                        <a href="<?php echo e(route('filament.admin.resources.incidents.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="mb-2"><button id="" class="text-white bg-primary-500 dark::bg-primary-600 hover:bg-yellow-400 px-4 py-2 rounded text-sm sm:text-base"<?php echo TranslationHelper::translateIfNeeded('Log An'); ?>> <br><?php echo TranslationHelper::translateIfNeeded('Incident'); ?></button></a>
                        <a href="<?php echo e(route('filament.admin.resources.maintences.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="mb-2"><button id="" class="text-white bg-primary-500 dark::bg-primary-600 hover:bg-yellow-400 px-4 py-2 rounded text-sm sm:text-base"><?php echo TranslationHelper::translateIfNeeded('Check'); ?> <br><?php echo TranslationHelper::translateIfNeeded('Maintenance Drone'); ?></button></a>
                        <a href="<?php echo e(route('filament.admin.resources.maintenance-batteries.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="mb-2"><button id="" class="text-white bg-primary-500 dark::bg-primary-600 hover:bg-yellow-400 px-4 py-2 rounded text-sm sm:text-base"><?php echo TranslationHelper::translateIfNeeded('Check'); ?> <br><?php echo TranslationHelper::translateIfNeeded('Maintenance Equipment'); ?></button></a>
                    </div>
                    

                    

                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\Summary::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                    
                </div>

                <div id="content1" class="tab-content">
                    <h2 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Flight Overview'); ?></h2>
                
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="rounded-lg shadow-lg p-2 sm:p-4 flex-1 max-w-xs sm:max-w-[100px] md:max-w-[150px] lg:max-w-[200px] w-full dark:bg-gray-900">
                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabFlight::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                                </div>
                                <div class="rounded-lg shadow-lg p-2 sm:p-4 flex-1 max-w-xs sm:max-w-[100px] md:max-w-[150px] lg:max-w-[200px] w-full dark:bg-gray-900">
                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabFlightDrone::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                                </div>
                            </div>
                            <div class="rounded-lg shadow-lg p-4 flex-1 max-w-xs sm:max-w-sm md:max-w-md lg:max-w-full dark:bg-gray-900">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabFlightChartBar::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-5', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                        </div>
                                
                            <div class="container mx-auto p-4">
                                <h2 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Latest Flights (Last 20)'); ?></h2>
                                <!--[if BLOCK]><![endif]--><?php if($flightCount < 1): ?>
                                    <h3 class="text font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('No Flight History Available.'); ?></h3>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if($flightCount>0): ?>
                                    <div class="mt-4 flex justify-end mb-4">
                                        <a href="<?php echo e(route('filament.admin.resources.flighs.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="inline-block px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"><?php echo TranslationHelper::translateIfNeeded('View All'); ?></a>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($flightCount > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $flight; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto mb-4 shadow-lg"">
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Flight Name'); ?></p>
                                        <a href="<?php echo e(route('filament.admin.resources.flighs.view',
                                            ['tenant' => Auth()->user()->teams()->first()->id,
                                            'record' => $item->id,])); ?>"><p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->name); ?></p>
                                        </a>
                                        <div class="flex justify-between items-center rounded">
                                            <p class="text-sm text-gray-700 dark:text-gray-400 border border-gray-300 dark:border-gray-700"><?php echo e($item->duration ?? null); ?></p>
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->start_date_flight ?? null); ?></p>
                                        </div>
                                        <a href="<?php echo e(route('filament.admin.resources.users.view',
                                            ['tenant' => Auth()->user()->teams()->first()->id,
                                            'record' => $item->users->id ?? 0])); ?>"><p class="text-sm text-gray-700 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Pilot :'); ?> <?php echo e($item->users->name??null); ?></p>
                                        </a>
                                    </div>
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Drone'); ?></p>
                                        <a href="<?php echo e(route('drone.statistik', ['drone_id' => $item->drones->id ?? null])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drones->name?? null); ?></p>
                                        </a>
                                        <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drones->brand?? null); ?> / <?php echo e($item->drones->model??null); ?></p>
                                        
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Flight Type'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->type??null); ?></p>
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Flight Location'); ?></p>
                                        <a href="<?php echo e(route('filament.admin.resources.fligh-locations.edit',
                                        ['tenant' => Auth()->user()->teams()->first()->id,
                                        'record' => $item->fligh_location->id ?? 0])); ?>"><p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->fligh_location->name?? null); ?></p>
                                    </a>
                                    </div>
                            

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                </div>
                
                <div id="content2" class="tab-content">
                    <h1 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Maintenance Overview'); ?></h1>
                    <div class="space-y-4">
                        <div class="flex flex-wrap justify-center gap-6">
                            <div class="rounded-lg shadow-lg p-4 flex-1 max-w-xs sm:max-w-sm md:max-w-md lg:max-w-sm">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabMaintenance::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-6', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                               
                               <div class="container mx-auto p-4">

                                <h2 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Maintenance Overdue'); ?></h2>
                                <!--[if BLOCK]><![endif]--><?php if(($maintenaceDroneCount + $maintenaceEqCount) < 1): ?>
                                    <h3 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('No Maintenance Overdue Available.'); ?></h3>
                                <?php endif; ?>
                                <?php if(($maintenaceDroneCount + $maintenaceEqCount) > 0): ?>
                                    <div class="mt-4 flex justify-end mb-4">
                                        <a href="<?php echo e(route('filament.admin.resources.maintences.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="inline-block px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"><?php echo TranslationHelper::translateIfNeeded('View All'); ?></a>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($maintenaceDroneCount > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $maintenance_drone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto mb-4 shadow-lg">
                                        <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Maintenance Name'); ?></p>
                                            <a href="<?php echo e(route('filament.admin.resources.maintences.edit',
                                                ['tenant' => Auth()->user()->teams()->first()->id,
                                                'record' => $item->id,])); ?>"><p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->name??null); ?></p>
                                            </a>
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->date??null); ?></p>
                                        </div>
                                    
                                        <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Next Scheduled:'); ?> <span class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->date?? null); ?></span></p>
                                            <p class="text-sm text-gray-700 dark:text-gray-400">
                                                <?php
                                                    $now = Carbon\Carbon::now();
                                                    $formatDate = \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                                                    $daysOverdueDiff = $now->diffInDays($item->date, false);
                                                ?>

                                                    <!--[if BLOCK]><![endif]--><?php if($daysOverdueDiff < 0): ?> 
                                                    <?php
                                                        $daysOverdueDiff = abs(intval($daysOverdueDiff));
                                                    ?>
                                                        <span style="
                                                            display: inline-block;
                                                            background-color: red; 
                                                            color: white; 
                                                            padding: 3px 6px;
                                                            border-radius: 5px;
                                                            font-weight: bold;
                                                        ">
                                                            <?php echo TranslationHelper::translateIfNeeded('Overdue:'); ?> <?php echo e($daysOverdueDiff); ?> <?php echo TranslationHelper::translateIfNeeded('days'); ?>

                                                        </span>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="bg-green-600 text-white py-1 px-2 rounded"><?php echo e($formatDate); ?></span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </p>    
                                        </div>
                                    
                                        <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Drone'); ?></p>
                                            <a href="<?php echo e(route('drone.statistik', ['drone_id' => $item->drone->id ?? 0])); ?>">
                                                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drone->name??null); ?></p>
                                            </a>
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drone->brand?? null); ?>/<?php echo e($item->drone->model??null); ?></p>    
                                        </div>
                                    
                                        <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Technician'); ?></p>
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->technician??null); ?></p>
                                        </div>
                                    </div> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($maintenaceEqCount > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $maintenance_eq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto mb-4 shadow-lg">
                                            <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Maintenance Name'); ?></p>
                                                <a href="<?php echo e(route('filament.admin.resources.maintenance-batteries.edit',
                                                ['tenant' => Auth()->user()->teams()->first()->id,
                                                'record' =>$item->id])); ?>">
                                                    <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->name??null); ?></p>
                                                </a>
                                                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->date??null); ?></p>
                                            </div>
                                        
                                            <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Next Scheduled:'); ?> <span class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->date?? null); ?></span></p>
                                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                                    <?php
                                                        $now = Carbon\Carbon::now();
                                                        $formatDate = \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                                                        $daysOverdueDiff = $now->diffInDays($item->date, false);
                                                    ?>
                                                        <!--[if BLOCK]><![endif]--><?php if($daysOverdueDiff < 0): ?> 
                                                        <?php
                                                            $daysOverdueDiff = abs(intval($daysOverdueDiff));
                                                        ?>
                                                            <span style="
                                                                display: inline-block;
                                                                background-color: red; 
                                                                color: white; 
                                                                padding: 3px 6px;
                                                                border-radius: 5px;
                                                                font-weight: bold;
                                                            ">
                                                                <?php echo TranslationHelper::translateIfNeeded('Overdue:'); ?> <?php echo e($daysOverdueDiff); ?> <?php echo TranslationHelper::translateIfNeeded('days'); ?>

                                                            </span>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="bg-green-600 text-white py-1 px-2 rounded"><?php echo e($formatDate); ?></span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </p>    
                                            </div>
                                        

                                            <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Battery / Equipment'); ?></p>
                                                    <!--[if BLOCK]><![endif]--><?php if($item->equidment_id == null): ?>
                                                        <a href="<?php echo e(route('battery.statistik', ['battery_id' => $item->battrei_id])); ?>">
                                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->battrei->name ?? null); ?></p>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('equipment.statistik', ['equipment_id' => $item->equidment_id])); ?>">
                                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->equidment->name ?? null); ?></p>
                                                        </a>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                                    <!--[if BLOCK]><![endif]--><?php if($item->equidment == false): ?>
                                                        <?php echo TranslationHelper::translateIfNeeded('Battery'); ?>

                                                    <?php else: ?>
                                                        <?php echo e($item->equidment->type?? null); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </p>
                                            </div>
                                        
                                            <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Technician'); ?></p>
                                                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->technician??null); ?></p>
                                            </div>
                                        </div> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                
                <div id="content3" class="tab-content">
                    <h1 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Inventory Overview'); ?></h1>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 justify-center">
                            <div class="rounded-lg shadow-lg p-4 max-w-full">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabInventoryDrone::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-7', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                            <div class="rounded-lg shadow-lg p-4 max-w-full">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabInventoryBatteri::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-8', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                            <div class="rounded-lg shadow-lg p-4 max-w-full">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabInventoryEquidment::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-9', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                            <div class="rounded-lg shadow-lg p-4 max-w-full">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(App\Livewire\TabInventoryLocation::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2797861256-10', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                        </div>
                    </div>
                        
                        <div class="container mx-auto p-4">

                        <h2 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Latest Battery / Equipment Used (Last 20)'); ?></h2>
                        <!--[if BLOCK]><![endif]--><?php if(($battreiCount + $equipmentCount) < 1): ?>
                            <h3 class="text font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('No Battery/Equipment Usage History'); ?></h3>
                        <?php endif; ?>
                        <?php if(($battreiCount + $equipmentCount) > 0): ?>
                            <div class="mt-4 flex justify-end mb-4">
                                <a href="<?php echo e(route('filament.admin.resources.battreis.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="inline-block px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"><?php echo TranslationHelper::translateIfNeeded('View All'); ?></a>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($battreiCount > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $battreiUsage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto mb-4 shadow-lg">
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Item:'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">
                                        <a href="<?php echo e(route('battery.statistik', ['battery_id' => $item->id])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->name ?? 'No Battery'); ?> <br> <?php echo TranslationHelper::translateIfNeeded('Batteries'); ?></p>
                                        </a>
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Flight'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400"></p>
                                        <div class="flex justify-between items-center rounded">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->usage_count); ?> <?php echo TranslationHelper::translateIfNeeded('Flight'); ?></p> 
                        
                                            <!--[if BLOCK]><![endif]--><?php if($item->fligh->isNotEmpty()): ?>
                                            
                                            <?php
                                                // Menghitung total durasi dalam detik
                                                $totalDurationInSeconds = $item->fligh->sum(function ($flight) {
                                                    list($hours, $minutes, $seconds) = explode(':', $flight->duration);
                                                    return ($hours * 3600) + ($minutes * 60) + $seconds;
                                                });
                        
                                                // Menghitung total jam, menit, dan detik
                                                $totalHours = floor($totalDurationInSeconds / 3600);
                                                $totalMinutes = floor(($totalDurationInSeconds % 3600) / 60);
                                                $totalSeconds = $totalDurationInSeconds % 60;
                                                // Format total durasi
                                                $formattedTotalDuration = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);
                                            ?>
                        
                                            <p class="text-sm text-gray-700 dark:text-gray-400">
                                            <?php echo TranslationHelper::translateIfNeeded('Total Duration:'); ?> <?php echo e($formattedTotalDuration); ?> <!-- Menampilkan durasi yang diformat -->
                                            </p>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">null</p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>      
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Serial #'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">
                                                <?php echo e($item->serial_I ?? 'N/A'); ?>

                                        </p>
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('For Drone'); ?></p>
                                            <a href="<?php echo e(route('drone.statistik', ['drone_id' => $item->drone->id ?? 0])); ?>">
                                                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drone->name??null); ?></p>
                                            </a>
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drone->brand??null); ?> - <?php echo e($item->drone->model??null); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($equipmentCount > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $equipmentUsage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto mb-4 shadow-lg">
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Item:'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">
                                            <a href="<?php echo e(route('equipment.statistik', ['equipment_id' => $item->id])); ?>">
                                                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->name ?? 'No Equipment'); ?> <br> <?php echo e($item->type ?? 'test'); ?></p>
                                            </a>
                                        </p>
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Flight'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400"></p>
                                        <div class="flex justify-between items-center rounded">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->usage_count); ?> <?php echo TranslationHelper::translateIfNeeded('Flight'); ?></p> 
                        
                                            <!--[if BLOCK]><![endif]--><?php if($item->fligh->isNotEmpty()): ?>
                                            
                                            <?php
                                                // Menghitung total durasi dalam detik
                                                $totalDurationInSeconds = $item->fligh->sum(function ($flight) {
                                                    list($hours, $minutes, $seconds) = explode(':', $flight->duration);
                                                    return ($hours * 3600) + ($minutes * 60) + $seconds;
                                                });
                        
                                                // Menghitung total jam, menit, dan detik
                                                $totalHours = floor($totalDurationInSeconds / 3600);
                                                $totalMinutes = floor(($totalDurationInSeconds % 3600) / 60);
                                                $totalSeconds = $totalDurationInSeconds % 60;
                        
                                                // Format total durasi
                                                $formattedTotalDuration = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);
                                            ?>
                        
                                            <p class="text-sm text-gray-700 dark:text-gray-400">
                                            <?php echo TranslationHelper::translateIfNeeded('Total Duration:'); ?> <?php echo e($formattedTotalDuration); ?> <!-- Menampilkan durasi yang diformat -->
                                            </p>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">null</p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>      
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Serial #'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">
                                                <?php echo e($item->serial ?? 'N/A'); ?>

                                        </p>
                                    </div>
                                
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('For Drone'); ?></p>
                                            <a href="<?php echo e(route('drone.statistik', ['drone_id' => $item->drones->id ?? 0])); ?>">
                                                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drones->name??null); ?></p>
                                            </a>                 
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drones->brand??null); ?> - <?php echo e($item->drones->model??null); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </div>
                          
                </div>

                <div id="content4" class="tab-content">
                    

                    <div class="container mx-auto p-4">
                        <h2 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Document Overview'); ?></h2>
                        <!--[if BLOCK]><![endif]--><?php if($documentCount < 1): ?>
                            <h3 class="text font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('No document found'); ?></h3>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($documentCount > 0): ?>
                            <div class="mt-4 flex justify-end mb-4">
                                <a href="<?php echo e(route('filament.admin.resources.documents.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="inline-block px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"><?php echo TranslationHelper::translateIfNeeded('View All'); ?></a>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($documentCount > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $document; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto mb-4 shadow-lg">
                                    
                                    <!-- Kolom Name -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Name:'); ?></p>
                                        <a href="<?php echo e(route('filament.admin.resources.documents.edit',['tenant' => Auth()->user()->teams()->first()->id , 'record' => $item->id])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->name ?? TranslationHelper::translateIfNeeded('No Name')); ?></p>
                                        </a>
                                    </div>
                            
                                    <!-- Kolom Owner -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Owner:'); ?></p>
                                        <a href="<?php echo e(route('filament.admin.resources.users.view',['tenant' => Auth()->user()->teams()->first()->id, 'record'=>$item->users->id])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->users->name ??  TranslationHelper::translateIfNeeded('No Owner')); ?></p>
                                        </a>
                                    </div>
                            
                                    <!-- Kolom Scope -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Scope:'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->scope ??  TranslationHelper::translateIfNeeded('No Scope')); ?></p>
                                    </div>
                            
                                    <!-- Kolom Type -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Type:'); ?></p>
                                        <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->type ??  TranslationHelper::translateIfNeeded('No Type')); ?></p>
                                    </div>
                            
                                    <!-- Kolom Link -->
                                    <div class="flex-1 min-w-[150px] mb-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Link:'); ?></p>
                                        <a href="/storage/<?php echo e($item->doc); ?>" target="_blank" rel="noopener noreferrer" 
                                        class="inline-block text-sm bg-orange-500 text-white rounded px-3 py-2 hover:bg-orange-600"
                                        style="background-color:#ff8303;">
                                            <?php echo TranslationHelper::translateIfNeeded('Open Document'); ?>

                                        </a>
                                    </div>
                            
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                      
                </div>

                <div id="content5" class="tab-content">
                    
                    <div class="container mx-auto p-4">
                        <h2 class="text-2xl font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('Recent Incidents (Last 10)'); ?></h2>
                        <!--[if BLOCK]><![endif]--><?php if($incidentCount < 1): ?>
                            <h3 class="text font-bold mb-4"><?php echo TranslationHelper::translateIfNeeded('No incidents found'); ?></h3>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($incidentCount > 0): ?>
                            <div class="mt-4 flex justify-end mb-4">
                                <a href="<?php echo e(route('filament.admin.resources.incidents.index',['tenant' => auth()->user()->teams()->first()->id])); ?>" class="inline-block px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700"><?php echo TranslationHelper::translateIfNeeded('View All'); ?></a>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($incidentCount > 0): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $incident; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-4 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto mb-4 shadow-lg">
                                    
                                    <!-- Kolom Cause dan Status -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Cause:'); ?></p>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <a href="<?php echo e(route('filament.admin.resources.incidents.edit',['tenant'=>Auth()->user()->teams()->first()->id,'record'=>$item->id])); ?>">
                                                    <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->cause); ?></p>
                                                </a>
                                                <p class="text-xs text-gray-500 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Date:'); ?> <?php echo e($item->incident_date); ?></p>
                                            </div>
                                            <span class="px-2 py-1 rounded text-white text-xs <?php echo e($item->status == 0 ? 'bg-green-500' : 'bg-red-500'); ?>">
                                                <!--[if BLOCK]><![endif]--><?php if($item->status == 0): ?>
                                                    Closed
                                                <?php else: ?>
                                                    Under Review
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </span>
                                        </div>
                                    </div>
                            
                                    <!-- Kolom Drone Name -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Drone:'); ?></p>
                                        <a href="<?php echo e(route('drone.statistik', ['drone_id' => $item->drone->id ?? 0])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drone->name ??  TranslationHelper::translateIfNeeded('No Drone')); ?></p>
                                        </a>
                                        <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->drone->brand ??  TranslationHelper::translateIfNeeded('No Drone')); ?> / <?php echo e($item->drone->model); ?></p>
                                    </div>
                            
                                    <!-- Kolom Personnel Involved -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Personnel Involved:'); ?></p>
                                        <a href="<?php echo e(route('filament.admin.resources.users.view',['tenant'=>Auth()->user()->teams()->first()->id, 'record'=> $item->users->id ?? 0])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->users->name ??  TranslationHelper::translateIfNeeded('No Personnel')); ?></p>
                                        </a>
                                    </div>
                            
                                    <!-- Kolom Location -->
                                    <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Location:'); ?></p>
                                        <a href="<?php echo e(route('filament.admin.resources.fligh-locations.edit',['tenant' =>Auth()->user()->teams()->first()->id,'record'=>$item->fligh_locations->id ?? 0])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->fligh_locations->name ??  TranslationHelper::translateIfNeeded('No Location')); ?></p>
                                        </a>
                                    </div>
                            
                                    <!-- Kolom Project -->
                                    <div class="flex-1 min-w-[150px] mb-2">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Project:'); ?></p>
                                        <a href="<?php echo e(route('filament.admin.resources.projects.view',['tenant'=>Auth()->user()->teams()->first()->id,'record'=>$item->project->id ?? 0])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->project->case ??  TranslationHelper::translateIfNeeded('No Project')); ?></p>
                                        </a>
                                    </div>
                            
                                </div>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                      
                </div>
        </div>
    </div>
</div>

<script>
    // JavaScript untuk handle content tab aktif dan tidak
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {

            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        
            button.classList.add('active');
            const contentId = `content${button.id.charAt(button.id.length - 1)}`;
            document.getElementById(contentId).classList.add('active');
        });
    });
</script>
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

<?php /**PATH C:\laragon\www\DroneArcomApp\resources\views/filament/tabWidget/tab-widget-overview.blade.php ENDPATH**/ ?>