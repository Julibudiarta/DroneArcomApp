<?php
    use App\Helpers\TranslationHelper;
    $teams = Auth()->user()->teams()->first()->id;
    $customer = App\Models\customer::where('teams_id',$teams)->get();
    $project = App\Models\projects::where('teams_id',$teams)->get();
    $default = App\Models\team::where('id',$teams)->get();
    $defaultCountCustomer = App\Models\team::where('id',$teams)->count('id_customers');
    $defaultCountProject = App\Models\team::where('id',$teams)->count('id_projects');
    $defaultCountType = App\Models\team::where('id',$teams)->count('flight_type');
    $team = App\Models\Team::where('id', $teams)->first();
    $defaultPilot = $team ? $team->set_pilot : false;
    $isChecked = $defaultPilot;
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
            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <!-- Include CSS for Select2 -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
            <!-- Include jQuery (required for Select2) -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <!-- Include Select2 JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <!--tailwind-->
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


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
        .tab-button.active {
            background-color: #2563eb;
        }

            /* Container for tabs and content */
            .tab-container {
                display: grid;
                grid-template-columns: 1fr 3fr; /* Left column 1/4, right column 3/4 */
                gap: 20px;
                padding: 20px;
                border-radius: 8px;
            }
            /* Styling for the tab buttons container */
            .tab-buttons {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
    
            /* Tab buttons styling */
            .tab-button {
                background-color: #3b82f6;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
    
            .tab-button.active {
                background-color: #2563eb;
            }
    
            /* Tab content styling */
            .tab-content {
                display: none;
                padding: 20px;
                border-radius: 8px;
                animation: fadeIn 0.5s ease;
            }
            .tab-content.active {
                display: block;
            }
    
            /* Responsive design */
            @media (max-width: 768px) {
                .tab-container {
                    grid-template-columns: 1fr; /* Stack on small screens */
                }
            }
    
            /* Animation */
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
    </style>
    </head>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Menu 1 -->
        <div class="main-button bg-white dark:bg-gray-800 shadow dark:shadow-lg rounded-lg p-4 text-center hover:shadow-lg dark:hover:shadow-xl transition-shadow" onclick="showContent(0)">
            <div class="text-blue-500 dark:text-blue-400 mb-2">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-globe-alt'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 mx-auto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('General Settings'); ?></h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1"><?php echo TranslationHelper::translateIfNeeded('Set your website here'); ?></p>
        </div>
    
        <!-- Menu 2 -->
        <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles()->pluck('name')->contains('super_admin') || (Auth::user()->roles()->pluck('name')->contains('panel_user'))): ?>
        <div class="main-button bg-white dark:bg-gray-800 shadow dark:shadow-lg rounded-lg p-4 text-center hover:shadow-lg dark:hover:shadow-xl transition-shadow cursor-pointer" onclick="showContent(1)">
            <div class="mb-2 text-gray-800 dark:text-gray-200">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-currency-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 mx-auto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('Currency'); ?></h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1"><?php echo TranslationHelper::translateIfNeeded('Manage your currency here'); ?></p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!-- Menu 3 -->
        <div class="main-button bg-white dark:bg-gray-800 shadow dark:shadow-lg rounded-lg p-4 text-center hover:shadow-lg dark:hover:shadow-xl transition-shadow" onclick="showContent(2)">
            <div class="text-yellow-500 dark:text-yellow-400 mb-2">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-c-language'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 mx-auto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('Language'); ?></h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1"><?php echo TranslationHelper::translateIfNeeded('Manage your Language'); ?></p>
        </div>
    </div>
    
    
<div class="main-contents">
    
    <div id="maincontent0" class="container tab-border-warna main-content">
        <!-- Main tab container -->
        <div class="tab-container grid grid-cols-1 md:grid-cols-4 gap-5 p-5 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
            <!-- Tab buttons on the left -->
            <div class="tab-buttons flex flex-col border-r border-gray-300 dark:border-gray-700 p-4 space-y-2">

                <h1 class="text-lg font-bold border-b border-gray-500 pb-2"><?php echo TranslationHelper::translateIfNeeded('Setting'); ?></h1>
                <button id="tab0" data-index="0" class="tab-button active border border-gray-300 dark:border-gray-700 rounded-lg py-2 px-4 text-gray-800 dark:text-gray-200" onclick="showContentTab(0)"><?php echo TranslationHelper::translateIfNeeded('Profile'); ?></button>
                <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles()->pluck('name')->contains('super_admin') || (Auth::user()->roles()->pluck('name')->contains('panel_user'))): ?>
                    <button id="tab1" data-index="1" class="tab-button border border-gray-300 dark:border-gray-700 rounded-lg py-2 px-4 text-gray-800 dark:text-gray-200" onclick="showContentTab(1)"><?php echo TranslationHelper::translateIfNeeded('Organization'); ?></button>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <button id="tab2" data-index="2" class="tab-button border border-gray-300 dark:border-gray-700 rounded-lg py-2 px-4 text-gray-800 dark:text-gray-200" onclick="showContentTab(2)"><?php echo TranslationHelper::translateIfNeeded('Import Rules'); ?></button>
                <button id="tab3" data-index="3" class="tab-button border border-gray-300 dark:border-gray-700 rounded-lg py-2 px-4 text-gray-800 dark:text-gray-200" onclick="showContentTab(3)"><?php echo TranslationHelper::translateIfNeeded('API'); ?></button>
                <button id="tab4" data-index="4" class="tab-button border border-gray-300 dark:border-gray-700 rounded-lg py-2 px-4 text-gray-800 dark:text-gray-200" onclick="showContentTab(4)"><?php echo TranslationHelper::translateIfNeeded('Billing'); ?></button>
            </div>
    
            <!-- Tab content on the right -->
            <div class="tab-contents">
                
                <div id="content0" class="tab-content active">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('personal-info');

$__html = app('livewire')->mount($__name, $__params, 'lw-4195144844-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('my-custom-component');

$__html = app('livewire')->mount($__name, $__params, 'lw-4195144844-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('update-password');

$__html = app('livewire')->mount($__name, $__params, 'lw-4195144844-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
                
                
                <div id="content1" class="tab-content">
                    <!--[if BLOCK]><![endif]--><?php if(Auth::user()->roles()->pluck('name')->contains('super_admin') || (Auth::user()->roles()->pluck('name')->contains('panel_user'))): ?>
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(\app\filament\Pages\Tenancy\EditTeamProfil::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-4195144844-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                
                <div id="content2" class="tab-content p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                    <h1 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('Import Rules'); ?></h1>
                    <p class="mb-3 text-gray-600 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('These rules will be automatically set for all logs on new imported flights.'); ?><br><?php echo TranslationHelper::translateIfNeeded('Rules will be applied in these flight log importers:'); ?></p>
                    
                    <ul class="list-disc pl-5 mb-6">
                        <li><a href="<?php echo e(route('filament.admin.resources.manual-imports.index',[Auth()->user()->teams()->first()->id])); ?>" class="text-blue-600 dark:text-blue-400 hover:underline"><?php echo TranslationHelper::translateIfNeeded('Manual Multiple Importer'); ?></a></li>
                        <li ><a href="<?php echo e(route('filament.admin.resources.importers.index',[Auth()->user()->teams()->first()->id])); ?>" class="text-blue-600 dark:text-blue-400 hover:underline"><?php echo TranslationHelper::translateIfNeeded('Dji Cloud Importer'); ?></a></li>
                    </ul>
                    <h1 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('Default Value'); ?></h1>
                    <form class="space-y-4" action="<?php echo e(route('default-value')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="customer" class="font-medium text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Default Customer'); ?></label>
                            <select name="customer" id="customer" class="border border-gray-300 dark:border-gray-600 rounded-lg w-full p-2 mt-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400">
                                <!--[if BLOCK]><![endif]--><?php if($defaultCountCustomer > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $default; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id_customers); ?>">-- <?php echo e($key->getNameCustomer->name); ?> --</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->  
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <option value="">-- None --</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>
                
                        <div class="form-group">
                            <label for="projects" class="font-medium text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Default Project/Job'); ?></label>
                            <select name="projects" id="projects" class="border border-gray-300 dark:border-gray-600 rounded-lg w-full p-2 mt-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400">
                                <!--[if BLOCK]><![endif]--><?php if($defaultCountProject > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $default; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id_projects); ?>">-- <?php echo e($key->getNameProject->case); ?> --</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->  
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <option value="">-- None --</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $project; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->case); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>
                
                        <div class="form-group">
                            <label for="Sflight_type" class="font-medium text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Default Flight Type'); ?></label>
                            <select name="flight_type" id="flight_type" class="border border-gray-300 dark:border-gray-600 rounded-lg w-full p-2 mt-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400">
                                <!--[if BLOCK]><![endif]--><?php if($defaultCountType > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $default; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->flight_type); ?>">-- <?php echo e($key->flight_type); ?> --</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->  
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <option value="">-- None --</option>
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
                            </select>
                        </div>
                
                        <div class="form-group flex items-center space-x-2">
                            <input name="pilot" type="checkbox"  id="pilot" class="form-checkbox h-5 w-5 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400"<?php echo e($isChecked ? 'checked' : ''); ?>>
                            <label for="pilot" class="font-medium text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('If Pilot not set upfront, set Auto-detected Drone Owner As Pilot'); ?></label>
                        </div>  
                        <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-all duration-200 ease-in-out">
                            <?php echo TranslationHelper::translateIfNeeded('Submit'); ?>

                        </button>
                    </form>
                </div> 
                
                <div id="content3" class="tab-content p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4"><?php echo TranslationHelper::translateIfNeeded('DJi Sync'); ?></h1>
                    <form class="space-y-4">
                        <div class="form-group">
                            <label for="email" class="font-medium text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Email'); ?></label>
                            <input type="email" id="email" class="border border-gray-300 dark:border-gray-600 rounded-lg w-full p-2 mt-1 focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="font-medium text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Password'); ?></label>
                            <input type="password" id="password" class="border border-gray-300 dark:border-gray-600 rounded-lg w-full p-2 mt-1 focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="since_sync" class="font-medium text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Sync Flights Since'); ?></label>
                            <input type="datetime-local" id="since_sync" class="border border-gray-300 dark:border-gray-600 rounded-lg w-full p-2 mt-1 focus:outline-none focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200 ease-in-out">
                            <?php echo TranslationHelper::translateIfNeeded('Sync'); ?>

                        </button>
                    </form>
                </div>
                
                <div id="content4" class="tab-content  p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('billing');

$__html = app('livewire')->mount($__name, $__params, 'lw-4195144844-4', $__slots ?? [], get_defined_vars());

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
    </div>
 
    
    <div id="maincontent1" class="main-content flex justify-center bg-gray-50 dark:bg-gray-900 ">
        <div class="max-w-lg w-full p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('Currency Settings'); ?></h1>
           
            <form action="<?php echo e(route('currency-store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="mb-4">
                    
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Choose your ssacurrency:'); ?></label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="search-box" 
                            placeholder="Search currency..." 
                            class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2" 
                            oninput="filterAndSelect(this.value)"
                        >
                        <select 
                            name="currency_id" 
                            id="currency" 
                            required 
                            class="block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php
                                $currencies = App\Models\currencie::all();
                                $currentTeam = auth()->user()->teams()->first();
                                $selectedCurrencyId = $currentTeam ? $currentTeam->currencies_id : null;
                            ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option 
                                    value="<?php echo e($currency->id); ?>" 
                                    <?php echo e($currency->id == $selectedCurrencyId ? 'selected' : ''); ?>>
                                    <?php echo e($currency->name); ?> (<?php echo e($currency->iso); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                    
                    
                </div>
    
                
    
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 font-semibold bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400 shadow">
                        <?php echo TranslationHelper::translateIfNeeded('Save Changes'); ?> 
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    
<div id="maincontent2" class="main-content flex justify-center bg-gray-50 dark:bg-gray-900 mt-6">
    <div class="max-w-lg w-full p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200"><?php echo TranslationHelper::translateIfNeeded('Language Settings'); ?></h1>
        
        <form action="<?php echo e(route('change.language')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="mb-4">
                <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?php echo TranslationHelper::translateIfNeeded('Choose your language:'); ?></label>
                <select name="language" id="language" required class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="en" <?php echo e(request()->cookie('locale') == 'en' ? 'selected' : ''); ?>>English</option>
                    <option value="es" <?php echo e(request()->cookie('locale') == 'es' ? 'selected' : ''); ?>>Spanish</option>
                    <option value="fr" <?php echo e(request()->cookie('locale') == 'fr' ? 'selected' : ''); ?>>French</option>
                    <option value="id" <?php echo e(request()->cookie('locale') == 'id' ? 'selected' : ''); ?>>Indonesian</option>
                    <option value="ko" <?php echo e(request()->cookie('locale') == 'ko' ? 'selected' : ''); ?>>Korean</option>
                    <option value="ja" <?php echo e(request()->cookie('locale') == 'ja' ? 'selected' : ''); ?>>Japan</option>
                </select>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 font-semibold bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400 shadow">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>




</div>
    
    <script>
        function showContentTab(index) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach((content, i) => {
                content.classList.remove('active');
                if (i === index) {
                    content.classList.add('active');
                }
            });
            const contentss = document.querySelectorAll('.tab-button');
            contentss.forEach((contentsss) => {
                contentsss.classList.remove('active');
            });
            const target = document.querySelector(`.tab-button[data-index="${index}"]`);
            if (target) {
                target.classList.add('active');
            }
        }
        function showContent(index) {
            const contents = document.querySelectorAll('.main-content');
            contents.forEach((content, i) => {
                content.classList.remove('active');
                if (i === index) {
                    content.classList.add('active');
                }
            });
        }
    </script>
    
    <script>
        function filterAndSelect(searchValue) {
            const select = document.getElementById('currency');
            const options = select.querySelectorAll('option');

            // search value
            const query = searchValue.toLowerCase();
            let foundAndSelected = false;
            options.forEach(option => {
                const text = option.textContent.toLowerCase();

                // Show/hide options
                if (text.includes(query)) {
                    option.style.display = '';
                    if (!foundAndSelected) {
                        select.value = option.value;
                        foundAndSelected = true;
                    }
                } else {
                    option.style.display = 'none';
                }
            });

            if (!foundAndSelected) {
                select.value = '';
            }
        }


    </script>
    
    
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
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/filament/pages/settings.blade.php ENDPATH**/ ?>