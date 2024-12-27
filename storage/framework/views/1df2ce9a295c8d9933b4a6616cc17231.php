<?php
use App\Helpers\TranslationHelper;

$currentTeamId = auth()->user()->teams()->first()->id;
    
    $drones = App\Models\drone::where('teams_id', $currentTeamId)
        ->where('status', 'airworthy')
        ->pluck('name', 'id');
    // dd($drones);
        
    $projects = App\Models\Projects::where('teams_id', $currentTeamId)->pluck('case', 'id');
    
    $batteriesEquipment = App\Models\battrei::where('teams_id', $currentTeamId)
        ->where('status', 'airworthy')
        ->whereDoesntHave('kits')
        ->pluck('name', 'id')
        ->merge(
        App\Models\equidment::where('teams_id', $currentTeamId)
            ->where('status', 'airworthy')
            ->whereDoesntHave('kits')
            ->pluck('name', 'id')
    );
    // dd($batteriesEquipment);
    
        
    // $equipments = App\Models\equidment::where('teams_id', $currentTeamId)
    //     ->where('status', 'airworthy')
    //     ->whereDoesntHave('kits')
    //     ->pluck('name', 'id');
    
    $pilots = App\Models\User::whereHas('teams', function ($query) use ($currentTeamId) {
        $query->where('team_id', $currentTeamId);
    })->whereHas('roles', function ($query) {
        $query->where('roles.name', 'Pilot');
    })->pluck('name', 'id');
?>
<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .main-content {
    display: none; /* Initially hidden */
    padding: 20px;
    border-radius: 8px;
    animation: fadeIn 0.5s ease;
    }
    .main-content.active {
        display: block; /* Displayed when active */
    }
    button.active{
        background-color: #ecefef;
    }
    .active{
        display: none;
    }
    .tob-bar, .tob-bar-login {
    display: none;
}

.tob-bar.active, .tob-bar-login.active {
    display: block;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
</head>

    <div class="fixed active inset-0 flex justify-center z-50" style="max-height: 80%">
        <div class="relative space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[80%] overflow-y-auto mx-4 md:mx-auto">
            <!-- Tombol Close -->
            <button type="button"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-500 text-2xl font-bold p-2"
                onclick="closeModal()">
                &times;
            </button>

            <!-- Judul Modal -->
            <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-white">
                <?php echo TranslationHelper::translateIfNeeded('Add Data to Import'); ?>

            </h2>
            <hr class="border-t border-gray-300 dark:border-gray-600 w-24 mx-auto">

            <!-- Form -->
            <div class="p-4">
                <?php echo csrf_field(); ?>
                    <!-- Drone -->
                <div class="mb-2">
                    <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Drone'); ?></label>
                    <Select id="drone" name="drone" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 bg-white border-gray-300 text-gray-900"> 
                        <option value="" disabled selected>Select an drone</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $drones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </Select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">

                    <!-- Flight Type -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Flight Type'); ?></label> 
                        <Select id="flight_type" name="flight_type" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 bg-white border-gray-300 text-gray-900"> 
                            <option value="" disabled selected>Select an Type Flight</option>
                            <option value="commercial-agriculture">Commercial-Agriculture</option>
                            <option value="commercial-inspection">Commercial-Inspection</option>
                            <option value="commercial-mapping/survey">Commercial-Mapping/Survey</option>
                            <option value="commercial-other">Commercial-Other</option>
                            <option value="commercial-photo/video">Commercial-Photo/Video</option>
                            <option value="emergency">Emergency</option>
                            <option value="hobby-entertainment">Hobby-Entertainment</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="mapping_hr">Mapping HR</option>
                            <option value="mapping_uhr">Mapping UHR</option>
                            <option value="photogrammetry">Photogrammetry</option>
                            <option value="science">Science</option>
                            <option value="search_rescue">Search and Rescue</option>
                            <option value="simulator">Simulator</option>
                            <option value="situational_awareness">Situational Awareness</option>
                            <option value="spreading">Spreading</option>
                            <option value="surveillance/patrol">Surveillance or Patrol</option>
                            <option value="survey">Survey</option>
                            <option value="test_flight">Test Flight</option>
                            <option value="training_flight">Training Flight</option>

                            
                        </Select>
                    </div>

                    <!-- Project -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Projects'); ?></label>
                        <select id="project" name="project" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 bg-white border-gray-300 text-gray-900">
                            <option value="" disabled selected>Select an project</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>"><?php echo e($case); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                </div>
                <!-- Battery & Equipment On-Board -->
                <div class="mb-2">
                    <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Battery & Equipment On-Board'); ?></label>
                    <?php if (isset($component)) { $__componentOriginal505efd9768415fdb4543e8c564dad437 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal505efd9768415fdb4543e8c564dad437 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.wrapper','data' => ['class' => 'dark:bg-gray-900 dark:border-gray-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'dark:bg-gray-900 dark:border-gray-700']); ?>
                        <?php if (isset($component)) { $__componentOriginal97dc683fe4ff7acce9e296503563dd85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97dc683fe4ff7acce9e296503563dd85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.input.select','data' => ['wire:model' => 'status','id' => 'EquipmentBattrei','name' => 'status','class' => ' chosen-select w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500','multiple' => true,'ariaPlaceholder' => 'Select Equipment Or Battrei']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'status','id' => 'EquipmentBattrei','name' => 'status','class' => ' chosen-select w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500','multiple' => true,'aria-placeholder' => 'Select Equipment Or Battrei']); ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $batteriesEquipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97dc683fe4ff7acce9e296503563dd85)): ?>
<?php $attributes = $__attributesOriginal97dc683fe4ff7acce9e296503563dd85; ?>
<?php unset($__attributesOriginal97dc683fe4ff7acce9e296503563dd85); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97dc683fe4ff7acce9e296503563dd85)): ?>
<?php $component = $__componentOriginal97dc683fe4ff7acce9e296503563dd85; ?>
<?php unset($__componentOriginal97dc683fe4ff7acce9e296503563dd85); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $attributes = $__attributesOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__attributesOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal505efd9768415fdb4543e8c564dad437)): ?>
<?php $component = $__componentOriginal505efd9768415fdb4543e8c564dad437; ?>
<?php unset($__componentOriginal505efd9768415fdb4543e8c564dad437); ?>
<?php endif; ?>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-4">
                    <button id="triggerButton" type="button" 
                        class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg 
                    hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                    focus:ring-gray-500 dark:focus:ring-gray-300" onclick="closeModal()">
                        <?php echo TranslationHelper::translateIfNeeded('Submit'); ?>

                    </button>
                </div>
                
            </div>
        </div>
    </div>

<div class="block min-h-screen w-full">
    <div class="w-full p-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <!-- Top Bar -->
        <div id="tob-bar" class="tob-bar active bg-gray-700 dark:bg-gray-900 text-white p-4 rounded-t-lg">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <!-- Email-->
                <div class="flex items-center space-x-2">
                    <label for="email" class="font-semibold text-sm">
                        <?php echo TranslationHelper::translateIfNeeded('Your DJI Account Email: '); ?>

                    </label>
                    <input type="email" name="email" id="email" 
                           class="bg-gray-200 text-black dark:bg-gray-700 dark:text-white
                                  border-none rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <!-- Password-->
                <div class="flex items-center space-x-2">
                    <label for="password" class="font-semibold text-sm">
                        <?php echo TranslationHelper::translateIfNeeded('Password: '); ?>

                    </label>
                    <input type="password" name="password" id="password" 
                           class="bg-gray-200 text-black dark:bg-gray-700 dark:text-white
                                  border-none rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <!-- Login Button -->
                <div>
                    <button class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg 
                                   hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                                   focus:ring-gray-500 dark:focus:ring-gray-300" onclick="closeLogin()">
                        <?php echo TranslationHelper::translateIfNeeded('Login'); ?>

                    </button>
                </div>
            </div>
        </div>
        <!--Top Bar if Login-->
        <div id="tob-bar-login" class="tob-bar-login bg-gray-700 dark:bg-gray-900 text-white p-4 rounded-t-lg">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <!-- Account-->
                <div class="flex items-center space-x-2">
                    <p class="font-semibold text-sm">
                        <?php echo TranslationHelper::translateIfNeeded('Your DJI Account: Name Account'); ?>

                    </p>
                    <button class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg 
                    hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                    focus:ring-gray-500 dark:focus:ring-gray-300" onclick="openLogin()">
                        <?php echo TranslationHelper::translateIfNeeded('Disconnect'); ?>

                    </button>

                </div>
                <!--Date Sncy-->
                <div class="flex items-center space-x-2">
                    <label for="password" class="font-semibold text-sm">
                        <?php echo TranslationHelper::translateIfNeeded('Sync Flight Since: '); ?>

                    </label>
                    <input type="date" name="date" id="date" 
                           class="bg-gray-200 text-black dark:bg-gray-700 dark:text-white
                                  border-none rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    
                    <button class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg 
                    hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                    focus:ring-gray-500 dark:focus:ring-gray-300">
                       <?php echo TranslationHelper::translateIfNeeded('Get Flight List'); ?>

                   </button>
                   
                   <button class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg 
                   hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                   focus:ring-gray-500 dark:focus:ring-gray-300" onclick="openModal()">
                      <?php echo TranslationHelper::translateIfNeeded('Add Data To Import'); ?>

                  </button>

                </div>
            </div>
        </div>
        
        <div class="mb-2">
            
                    <div class="mt-4 flex justify-end mb-4">
                        <a href="#" class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg 
                    hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                    focus:ring-gray-500 dark:focus:ring-gray-300"><?php echo TranslationHelper::translateIfNeeded('Import All'); ?></a>
                    </div>
                
                    <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 mx-auto mb-4 shadow-lg p-4">
                        
                        <!-- Kolom Name -->
                        <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2 overflow-hidden">
                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold truncate"><?php echo TranslationHelper::translateIfNeeded('DJIFLightRecord_2024_09_10_[02:50:43].txt'); ?></p>
                        </div>
                
                        <!-- Date time-->
                        <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                            <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('2024-09-10 02:50:43'); ?></p>
                        </div>
                
                        <!-- Import -->
                        <div class="flex justify-center items-center min-w-[150px] mb-2">
                            <a href="#" target="_blank" rel="noopener noreferrer" 
                               class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-lg 
                                      hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                                      focus:ring-gray-500 dark:focus:ring-gray-300">
                                <?php echo TranslationHelper::translateIfNeeded('Import'); ?>

                            </a>
                        </div>
                    </div>
        </div>
         

        

        
        
        
        
        
    </div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>


<script>
function closeLogin() {
    const topBar = document.querySelector('#tob-bar');
    const tobBarlogin = document.querySelector('#tob-bar-login');
    topBar.classList.remove('active');
    tobBarlogin.classList.add('active');
}

function openLogin() {
    const topBar = document.querySelector('#tob-bar');
    const tobBarlogin = document.querySelector('#tob-bar-login');
    topBar.classList.add('active');
    tobBarlogin.classList.remove('active');
}
</script>

<script>
    function closeModal() {
        const contents = document.querySelector('.fixed');
        contents.classList.add('active');
    }
    function openModal() {
        const contents = document.querySelector('.fixed');
        contents.classList.remove('active');     
    }
</script>

<script>
    $(document).ready(function(){
        var multipleCancelButton = new Choices('#EquipmentBattrei', {
            removeItemButton: true,
            maxItemCount: 10,          
            searchResultLimit: 10,
            renderChoiceLimit: 10
            
        }); 
    });
</script><?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/filament/pages/dji-importer.blade.php ENDPATH**/ ?>