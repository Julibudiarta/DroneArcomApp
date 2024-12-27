<?php
    use App\Helpers\TranslationHelper;
    //project Document
    $id = $getRecord()->id;

    $teams = Auth()->user()->teams()->first()->id;

    if (Auth()->user()->roles()->pluck('name')->contains('super_admin') || (Auth()->user()->roles()->pluck('name')->contains('panel_user'))) {
        $queryDocument = App\Models\Document::query()->where('equidment_id', $id)->get();
    }else{
        $queryDocument = App\Models\Document::query()
        ->where('equidment_id', $id)
        ->where(function ($query) {
            $query->where('shared', 1)
                ->orWhere('users_id', auth()->id());
        })->get();
    }


    $documentProjects = $queryDocument;
    //FlightIncident
    $maintenance = App\Models\maintence_eq::Where('equidment_id',$id)->get();
    $flights = App\Models\Fligh::where('teams_id', $teams)
    ->whereHas('equidments', function ($query) use ($id) {
        $query->where('equidment_id', $id);
    })
    ->get();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import at vite('resources/css/app.css') untuk tailwind perlu NPM-->
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .main-content.active{
            display: block;
        }
        .active-modal{
            display: none;
        }
        .hidden-notif
        {
            display: none;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 50;
            display: block;
        }
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

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<div class="container bg-gray-200 flex flex-wrap space-x-4 border border-gray-300 rounded-lg dark:bg-gray-800">
    <!-- Tab headers -->
    <div class="container mx-auto p-5">

        <div class="flex flex-wrap items-center justify-between border border-gray-300 rounded-lg p-2 bg-black dark:bg-gray-900">
          
            <div class="flex items-center">
                <p class="text-xl font-bold text-white"><?php echo TranslationHelper::translateIfNeeded('Other Project Resources'); ?></p>
            </div>
        
            <div class="flex flex-wrap gap-2">
                <button id="tab0" class="tab-button active text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto">
                    <?php echo TranslationHelper::translateIfNeeded('Flight'); ?> (<?php echo e($flights->count()); ?>)
                </button>
                <button id="tab1" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto">
                    <?php echo TranslationHelper::translateIfNeeded('Equipment Document'); ?>

                </button>
                <button id="tab2" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto">
                    <?php echo TranslationHelper::translateIfNeeded('Maintenence'); ?>

                </button>
            </div>
        </div>
        

        <!-- Tab content -->
        <div class="content">
            <div id="content0" class="tab-content active">
                <!--[if BLOCK]><![endif]--><?php if($flights->count() > 0): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4">
                            <!-- Container utama dengan lebar lebih besar di bagian atas -->
                            <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[900px] mx-auto shadow-lg">
                                <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-4">
                                    <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Name'); ?></p>
                                    <a href="<?php echo e(route('filament.admin.resources.flighs.view',
                                            ['tenant' => Auth()->user()->teams()->first()->id,
                                            'record' => $item->id,])); ?>">
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
                                    <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->customers->name ?? null); ?></p>
                                </div>
                            
                                <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-4">
                                    <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Location'); ?></p>
                                    <a href="<?php echo e(route('filament.admin.resources.flighs.view',
                                            ['tenant' => Auth()->user()->teams()->first()->id,
                                            'record' => $item->fligh_location->id,])); ?>">
                                            <p class="text-sm text-gray-700 dark:text-gray-400" style="color:rgb(0, 85, 255)"><?php echo e($item->fligh_location->name ?? null); ?></p>
                                            </a>
                                
                                </div>
                                
                                <div class="flex-1 min-w-[180px] mt-4 justify-end">
                                    <button
                                        class="px-4 py-2 bg-gray-700 text-white font-semibold rounded-lg 
                                                hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                                                focus:ring-gray-500 dark:focus:ring-gray-300"
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
                <?php else: ?>
                    <p class="text-center text-gray-600 dark:text-gray-300 mt-4">No Data Found</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


            </div>

            
            <div id="content1" class="tab-content">
    
                <!-- Modal -->
                <div class="fixed active-modal inset-0 flex justify-center z-50" style="max-height: 80%">
                    <div class="relative space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[80%] overflow-y-auto mx-4 md:mx-auto">
                        <!-- Tombol Close -->
                        <button type="button"
                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-500 text-2xl font-bold p-2"
                            onclick="closeModal()">
                                &times;
                        </button>

                        <!-- Judul Modal -->
                        <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-white">
                            <?php echo TranslationHelper::translateIfNeeded('Add Equipment Document'); ?>

                        </h2>
                        <hr class="border-t border-gray-300 dark:border-gray-600 w-24 mx-auto">

                        <!-- Form -->
                        <form id="documentForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input id="owner" type="hidden" name="teams_id" value="<?php echo e(auth()->user()->first()->id); ?>">
                            <input id="relation" type="hidden" name="recordID" value="<?php echo e($id); ?>">
                        
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name Input -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Name'); ?></label>
                                    <input id="name" type="text" name="name" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                </div>
                        
                                <!-- Expired Input -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Expiration Date'); ?></label>
                                    <input id="expiredDate" type="date" name="expiredDate" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                </div>
                        
                                <!-- RefNumber Input -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Ref / Certificate #'); ?></label>
                                    <input id="refnumber" type="text" name="refnumber" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                </div>
                        
                                <!-- External Link -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('External Link'); ?></label>
                                    <input id="externalLink" type="text" name="externalLink" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                </div>
                            </div>
                        
                            <!-- Document -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('File Document'); ?></label>
                                <input id="dock" type="file" name="dock" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            </div>
                        
                            <!-- Notes -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Notes'); ?></label>
                                <textarea id="description" name="description" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500"></textarea>
                            </div>
                        
                            <!-- Submit Button -->
                            <div class="flex justify-end mt-4">
                                <button id="triggerButton" type="button" class="button" style="font-size: 16px; background-color: #4A5568; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;">
                                    <span class="button__text"><?php echo TranslationHelper::translateIfNeeded('Submit'); ?></span>
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>

                
                <div class="mb-2">
                    
                    <div class="mt-4 flex justify-end mb-4">
                        <button type="button" onclick="openModal()" class="px-4 py-2 bg-gray-700 text-white font-semibold rounded-lg 
                    hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                    focus:ring-gray-500 dark:focus:ring-gray-300"><?php echo TranslationHelper::translateIfNeeded('Upload Document'); ?></button>
                    </div>
                
                    <!--[if BLOCK]><![endif]--><?php if($documentProjects->count() > 0): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $documentProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg bg-gray-100 dark:bg-gray-800 mx-auto mb-4 shadow-lg p-4">
                                
                                <!-- column Name -->
                                <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2 overflow-hidden">
                                    <p class="text-l text-gray-800 dark:text-gray-200 font-semibold truncate"><?php echo TranslationHelper::translateIfNeeded('Name : '); ?></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-150 font-semibold truncate"><?php echo e($item->name); ?></p>
                                </div>
                        
                                <!-- Column Number Ref-->
                                <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                    <p class="text-l text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Number :'); ?></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-150 font-semibold truncate"><?php echo e($item->refnumber); ?></p></p>
                                </div>

                                <!-- Column Expiration-->
                                <div class="flex-1 min-w-[150px] mb-2 border-r border-gray-300 pr-2">
                                    <p class="text-l text-gray-800 dark:text-gray-200 font-semibold"><?php echo TranslationHelper::translateIfNeeded('Expiration : '); ?> <span class="text-sm text-gray-500 dark:text-gray-150 font-semibold truncate"><?php echo e($item->expired_date); ?></span></p>
                                    
                                    <?php
                                        $now = Carbon\Carbon::now();
                                        $Expired = Carbon\Carbon::createFromFormat('Y-m-d',$item->expired_date);
                                        $daysRemaining = $now->diffInDays($Expired, false);
                                        $daysRemaining = intval($daysRemaining);
                                    ?>

                                    <!--[if BLOCK]><![endif]--><?php if($daysRemaining > 0): ?>
                                        <p class="text-sm text-gray-500 dark:text-gray-150 font-semibold truncate">
                                            <?php echo TranslationHelper::translateIfNeeded('Expired In '); ?><?php echo e($daysRemaining); ?><?php echo TranslationHelper::translateIfNeeded(' Days'); ?>

                                        </p>
                                    
                                    <?php elseif($daysRemaining === 0): ?> 
                                        <p class="text-sm text-gray-500 dark:text-gray-150 font-semibold truncate">
                                            <?php echo TranslationHelper::translateIfNeeded('Hari ini adalah hari terakhir sebelum expired.'); ?>

                                        </p>
                                    
                                    <?php else: ?>
                                        <p class="text-sm text-gray-500 dark:text-gray-150 font-semibold truncate">
                                            <?php echo TranslationHelper::translateIfNeeded('Tanggal expired telah lewat '); ?><?php echo e($daysRemaining); ?><?php echo TranslationHelper::translateIfNeeded(' hari yang lalu'); ?>

                                        </p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    

                                </div>

                                <!-- Column Modified-->
                                <div class="flex justify-end items-center mb-2 min-w-[150px] border-gray-300 pr-2">
                                    <a href="<?php echo e(route('filament.admin.resources.documents.edit',['tenant' => Auth()->user()->teams()->first()->id, 'record' => $item->id])); ?>" class="px-4 py-2 bg-gray-700 text-white font-semibold rounded-lg 
                                       hover:bg-gray-600 dark:hover:bg-gray-400 focus:outline-none focus:ring-2 
                                       focus:ring-gray-500 dark:focus:ring-gray-300">
                                        <?php echo TranslationHelper::translateIfNeeded('Edit'); ?>

                                    </a>
                                </div>
                        
                            
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                        <p class="text-center text-gray-600 dark:text-gray-300 mt-4">No Data Found</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </div>
                 

            </div>

            
            <div id="content2" class="tab-content">

                
                <div class="mb-2">
                
                    <!--[if BLOCK]><![endif]--><?php if($maintenance->count() > 0): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $maintenance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto shadow-lg">
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
                                            <!--[if BLOCK]><![endif]--><?php if($daysOverdueDiff < 0 && $item->status != 'completed'): ?> 
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
                            <div class="px-2 mb-4">
                                <div class="flex items-center justify-between py-4 px-6 border-t border-gray-400 bg-gray-300 dark:bg-gray-700  shadow-lg">
                                    <div class="flex-1 min-w-[180px]">
                                        <p class="text-sm text-gray-700 dark:text-gray-400"><strong><?php echo TranslationHelper::translateIfNeeded('Notes:'); ?> </strong><?php echo e($item->notes); ?></p>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                        <p class="text-center text-gray-600 dark:text-gray-300 mt-4">No Data Found</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </div>
                 

            </div>

        </div>
    </div>
</div>

<script>
    function closeModal() {
        const contents = document.querySelector('.fixed');
        contents.classList.add('active-modal');
    }
    function openModal() {
        const contents = document.querySelector('.fixed');
        contents.classList.remove('active-modal');     
    }
</script>

<script>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(document).ready(function() {
        $('#triggerButton').click(function() {
            const formData = new FormData();
            formData.append('_token', '<?php echo e(csrf_token()); ?>'); // CSRF token
            formData.append('name', $('#name').val());
            formData.append('expired', $('#expiredDate').val());
            formData.append('refNumber', $('#refnumber').val());
            formData.append('link', $('#externalLink').val());
            formData.append('notes', $('#description').val());
            formData.append('dock', $('#dock')[0].files[0]); // File input
            formData.append('owner', $('#owner').val());
            formData.append('relation', $('#relation').val());

            $.ajax({
                url: '<?php echo e(route('create.document.equipment')); ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });


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
</script>
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/component/tabViewResorce/equipment-tab.blade.php ENDPATH**/ ?>