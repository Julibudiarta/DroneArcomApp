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

    $countMaintenanceEq = $maintenance_eq->count();
    $countMaintenanceDrone = $maintenance_drone->count();
    $countMaintenance = $countMaintenanceEq + $countMaintenanceDrone;

    //end maintenance
    
    //planned Flight
    $flightSummary = App\Models\fligh::where('teams_id', $currentTeamId)
            ->whereDate('start_date_flight', Carbon\Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();
    $flightSummaryMonth = App\Models\fligh::where('teams_id', $currentTeamId)
            ->whereDate('start_date_flight', '>=', Carbon\Carbon::now()->startOfMonth())
            ->orderBy('created_at', 'desc')
            ->get();

?>
<style>
    .hide-mission{
        display: none;
    }
    /* Styles for active buttons */ 
    .active-button-day { 
        background-color: #fff;
        color: #f19022;
    } 
</style>
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
    <div class="container mx-auto p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Today's Missions Section -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-300 dark:from-primary-700 dark:bg-gray-800 p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 flex flex-col">
                
                <div class="content-mission flex-grow overflow-y-auto">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex-shrink-0"><?php echo TranslationHelper::translateIfNeeded('Today Organization Missions'); ?></h2>
                    <!--[if BLOCK]><![endif]--><?php if($flightSummary->count() < 1): ?>
                        <div class="mb-2 flex justify-between items-center">
                            <span class="font-semibold text-gray-900 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('No Flight Today.'); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class=" text-gray-800 dark:text-gray-200 overflow-y-auto flex-grow" style="max-height: 300px;"> 
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $flightSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex flex-col border-b border-gray-200 dark:border-gray-600 pb-2">
                                <div class="mb-2 flex justify-between items-center">
                                    <a href="<?php echo e(route('filament.admin.resources.flighs.view',['tenant'=>Auth()->user()->teams()->first()->id, 'record'=>$item->id ?? 0])); ?>">
                                        <span class="font-semibold text-gray-900 dark:text-gray-200"><?php echo e($item->name ?? null); ?></span>
                                    </a>
                                    <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Missions Date:'); ?> <?php echo e($item->start_date_flight ?? null); ?></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Project name:'); ?> 
                                        <a href="<?php echo e(route('flight-peroject',['project_id' => $item->projects->id ?? 0])); ?>">
                                            <?php echo e($item->projects->case ?? null); ?>

                                        </a>
                                    </div>
                                    <div class="text-red-900 dark:text-red-300"><?php echo TranslationHelper::translateIfNeeded('Pilot:'); ?> 
                                        <a href="<?php echo e(route('flight-personnel',['personnel_id'=>$item->users->id])); ?>">
                                            <?php echo e($item->users->name ?? null); ?>

                                        </a>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Customers:'); ?> 
                                        <a href="<?php echo e(route('filament.admin.resources.customers.edit',['tenant'=>Auth()->user()->teams()->first()->id, 'record'=>$item->customers->id ?? 0])); ?>">
                                            <?php echo e($item->customers->name ?? null); ?>

                                        </a>
                                    </span>
                                    <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Locations:'); ?> 
                                        <a href="<?php echo e(route('filament.admin.resources.fligh-locations.edit',['tenant'=> Auth()->user()->teams()->first()->id, 'record' => $item->fligh_location->id])); ?>">
                                            <?php echo e($item->fligh_location->name ?? null); ?>

                                        </a>    
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                 
                 <div class="hide-mission content-mission2 flex-grow overflow-y-auto">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex-shrink-0"><?php echo TranslationHelper::translateIfNeeded('Month Organization Missions'); ?></h2>
                    <!--[if BLOCK]><![endif]--><?php if($flightSummaryMonth->count() < 1): ?>
                        <div class="mb-2 flex justify-between items-center">
                            <span class="font-semibold text-gray-900 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('No Flight Monthly.'); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="text-gray-800 dark:text-gray-200 overflow-y-auto flex-grow" style="max-height: 300px;"> 
                       <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $flightSummaryMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <div class="flex flex-col border-b border-gray-200 dark:border-gray-600 pb-2">
                        <div class="mb-2 flex justify-between items-center">
                            <a href="<?php echo e(route('filament.admin.resources.flighs.view',['tenant'=>Auth()->user()->teams()->first()->id, 'record'=>$item->id ?? 0])); ?>">
                                <span class="font-semibold text-gray-900 dark:text-gray-200"><?php echo e($item->name ?? null); ?></span>
                            </a>
                            <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Missions Date:'); ?> <?php echo e($item->start_date_flight ?? null); ?></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Project name:'); ?> 
                                <a href="<?php echo e(route('flight-peroject',['project_id' => $item->projects->id ?? 0])); ?>">
                                    <?php echo e($item->projects->case ?? null); ?>

                                </a>
                            </div>
                            <div class="text-red-900 dark:text-red-300"><?php echo TranslationHelper::translateIfNeeded('Pilot:'); ?> 
                                <a href="<?php echo e(route('flight-personnel',['personnel_id'=>$item->users->id])); ?>">
                                    <?php echo e($item->users->name ?? null); ?>

                                </a>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Customers:'); ?> 
                                <a href="<?php echo e(route('filament.admin.resources.customers.edit',['tenant'=>Auth()->user()->teams()->first()->id, 'record'=>$item->customers->id ?? 0])); ?>">
                                    <?php echo e($item->customers->name ?? null); ?>

                                </a>
                            </span>
                            <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Locations:'); ?> 
                                <a href="<?php echo e(route('filament.admin.resources.fligh-locations.edit',['tenant'=> Auth()->user()->teams()->first()->id, 'record' => $item->fligh_location->id])); ?>">
                                    <?php echo e($item->fligh_location->name ?? null); ?>

                                </a>    
                            </div>
                        </div>
                    </div>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                 </div>      
                 <!-- Tombol --> 
                 <div class="mt-4 flex space-x-2 flex-wrap flex-shrink-0 justify-center">
                    <button id="dayButton" class="active-button-day bg-primary-600 text-white font-semibold rounded-full px-4 py-2 shadow-md hover:bg-primary-100" onclick="missionDayActive()">
                        <?php echo TranslationHelper::translateIfNeeded('Day Missions'); ?>

                    </button>
                    <button id="monthButton" class="bg-primary-600 text-white font-semibold rounded-full px-4 py-2 shadow-md hover:bg-primary-700" onclick="missionMonthActive()">
                       <?php echo TranslationHelper::translateIfNeeded('This Month'); ?>

                    </button>
                </div>
                
            </div>
            <!-- Maintenance Overdue Section -->
            <div class="bg-gradient-to-r from-primary-500 t-primary-300 dark:from-primary-700 dark:bg-gray-800 p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 flex flex-col">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex-shrink-0"><?php echo TranslationHelper::translateIfNeeded('Maintenance Overdue'); ?> (<?php echo e($countMaintenance); ?>)</h2>
                <div class="text-gray-800 dark:text-gray-200 overflow-y-auto flex-grow" style="max-height: 300px;">
                
                    <!--[if BLOCK]><![endif]--><?php if($countMaintenance < 1): ?>
                    <div class="mb-2 flex justify-between items-center">
                        <span class="font-semibold text-gray-900 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('No Maintenance Overdue'); ?></span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--maintenance overdue drones -->
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $maintenance_drone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col border-b border-gray-200 dark:border-gray-600 pb-2">
                            <div class="mb-2 flex justify-between items-center">
                                <a href="<?php echo e(route('filament.admin.resources.maintences.edit',['tenant'=>Auth()->user()->teams()->first()->id, 'record'=>$item->id])); ?>">
                                    <span class="font-semibold text-gray-900 dark:text-gray-200"><?php echo e($item->name??null); ?></span>
                                </a>
                                <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Maintenance Date:'); ?> <?php echo e($item->date??null); ?></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Next Scheduled:'); ?> <?php echo e($item->date?? null); ?></div>
                                <?php
                                    $now = Carbon\Carbon::now();
                                    $formatDate = \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                                    $daysOverdueDiff = $now->diffInDays($item->date, false);
                                    $daysOverdueDiff = abs(intval($daysOverdueDiff));
                                ?>
                                <div class="text-red-900 font dark:text-red-300"><?php echo TranslationHelper::translateIfNeeded('Overdue:'); ?> <?php echo e($daysOverdueDiff); ?></div>     
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($item->drones->brand?? null); ?></span>
                                <a href="<?php echo e(route('drone.statistik',['drone_id'=>$item->drone->id ?? 0])); ?>">
                                    <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($item->drones->name??null); ?></div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <!-- maintenance overdue Eequipments -->
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $maintenance_eq; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col border-b border-gray-200 dark:border-gray-600 pb-2">
                            <div class="mb-2 flex justify-between items-center">
                                <a href="<?php echo e(route('filament.admin.resources.maintenance-batteries.edit',['tenant'=>Auth()->user()->teams()->first()->id,'record'=>$item->id])); ?>">
                                    <span class="font-semibold text-gray-900 dark:text-gray-200"><?php echo e($item->name??null); ?></span>
                                </a>
                               
                                <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Maintenance Date:'); ?> <?php echo e($item->date??null); ?></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Next Scheduled:'); ?> <?php echo e($item->date?? null); ?></div>
                                <?php
                                    $now = Carbon\Carbon::now();
                                    $formatDate = \Carbon\Carbon::parse($item->date)->format('Y-m-d');
                                    $daysOverdueDiff = $now->diffInDays($item->date, false);
                                    $daysOverdueDiff = abs(intval($daysOverdueDiff));
                                ?>
                                <div class="text-red-900 font dark:text-red-300"><?php echo TranslationHelper::translateIfNeeded('Overdue:'); ?> <?php echo e($daysOverdueDiff); ?></div>     
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($item->equidment == true): ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($item->equidment->type?? null); ?></span>
                                    <a href="<?php echo e(route('equipment.statistik',['equipment_id'=>$item->equidment->id ?? 0])); ?>">
                                        <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($item->equidment->name??null); ?></div>
                                    </a>  
                                </div>
                            <?php elseif($item->battrei == true): ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Batteries:'); ?></span>
                                    <a href="<?php echo e(route('battery.statistik',['battery_id'=>$item->battrei->id ?? 0])); ?>">
                                        <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($item->battrei->name??null); ?></div>
                                    </a>  
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <!--end-->
                </div>
            </div>
        </div>
    </div>
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
    function missionDayActive() {
        const content = document.querySelector('.content-mission');
        const content2  = document.querySelector('.content-mission2');
        content2.classList.add('hide-mission');
        content.classList.remove('hide-mission');
        document.getElementById('dayButton').classList.add('active-button-day');
        document.getElementById('monthButton').classList.remove('active-button-day');
    }
    function missionMonthActive() {
        const content = document.querySelector('.content-mission');
        const content2 = document.querySelector('.content-mission2');
        content.classList.add('hide-mission');
        content2.classList.remove('hide-mission');
        document.getElementById('monthButton').classList.add('active-button-day');
        document.getElementById('dayButton').classList.remove('active-button-day');
    }
</script>

<?php /**PATH C:\laragon\www\DroneArcomApp\resources\views/filament/tabWidget/summary.blade.php ENDPATH**/ ?>