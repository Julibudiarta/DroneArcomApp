<?php
    use App\Helpers\TranslationHelper;
    //project Document
    $id = $getRecord()->id;

    if (Auth()->user()->roles()->pluck('name')->contains('super_admin') || (Auth()->user()->roles()->pluck('name')->contains('panel_user'))) {
        $queryUsers = App\Models\Document::query()->where('users_id', $id)->where('status_visible', '!=', 'archived')->get();
    }else{
        $queryUsers = App\Models\Document::query()
        ->where('users_id', $id)
        ->where('status_visible', '!=', 'archived')
        ->where(function ($query) {
            $query->where('shared', 1)
                ->orWhere('users_id', auth()->id());
        })->get();
    }

    $documentProjects = $queryUsers;
    //FlightIncident
    $Incident = App\Models\Incident::Where('personel_involved_id',$id)->get();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import at vite('resources/css/app.css') untuk tailwind perlu NPM-->
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
                <p class="text-xl font-bold text-white"><?php echo TranslationHelper::translateIfNeeded('Attachments'); ?></p>
            </div>
        
            <div class="flex flex-wrap gap-2">
                <button id="tab0" class="tab-button active text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto">
                    <?php echo TranslationHelper::translateIfNeeded('Users Document'); ?>

                </button>
                <button id="tab1" class="tab-button text-white bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm sm:text-base w-full sm:w-auto">
                    <?php echo TranslationHelper::translateIfNeeded('Incident'); ?>

                </button>
            </div>
        </div>
        

        <!-- Tab content -->
        <div class="content">

            
            <div id="content0" class="tab-content active">
    
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
                            <?php echo TranslationHelper::translateIfNeeded('Add Document'); ?>

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

                                <!-- Type -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('Ref / Certificate #'); ?></label>
                                    <select id="type" type="text" name="type" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                        <option value="" disabled selected ><?php echo TranslationHelper::translateIfNeeded('Select an type'); ?></option>
                                        <option value="Pilot License">Pilot License</option>
                                        <option value="UAV Training Course">UAV Training Course</option>
                                        <option value="Remote Pilot Certificate">Remote Pilot Certificate</option>
                                        <option value="Currency Certificate">Currency Certificate</option>
                                        <option value="Medical Certificate">Medical Certificate</option>
                                        <option value="Insurance Certificate">Insurance Certificate</option>
                                        <option value="Registration #">Registration #</option>
                                        <option value="Regulatory Certificate">Regulatory Certificate</option>
                                        <option value="Checklist">Checklist</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Other Certificate">Other Certificate</option>
                                        <option value="Site Assessment">Site Assessment</option>
                                        <option value="Safety Instruction">Safety Instruction</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <!-- External Link -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300"><?php echo TranslationHelper::translateIfNeeded('External Link'); ?></label>
                                <input id="externalLink" type="text" name="externalLink" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
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

            
            <div id="content1" class="tab-content">

                
                <div class="mb-2">
                
                    <!--[if BLOCK]><![endif]--><?php if($Incident->count() > 0): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $Incident; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-4 bg-gray-100 dark:bg-gray-800 max-w-[800px] mx-auto shadow-lg">
                                        
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
                            <div class="px-2 mb-4">
                                <div class="flex items-center justify-between py-4 px-6 border-t border-gray-400 bg-gray-300 dark:bg-gray-700  shadow-lg">
                                    <div class="flex-1 min-w-[180px]">
                                        <p class="text-sm text-gray-700 dark:text-gray-400"><strong><?php echo TranslationHelper::translateIfNeeded('Notes:'); ?> </strong><?php echo e($item->description); ?></p>
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
        formData.append('type', $('#type').val());

        $.ajax({
            url: '<?php echo e(route('create.document.personnel')); ?>',
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
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/component/tabViewResorce/personnel-tab.blade.php ENDPATH**/ ?>