<?php
//convert $record to int
    $teams = Auth()->user()->teams()->first()->id;
    $id= $record->id;
    $customers = App\Models\Customer::where('teams_id', $teams)->where('id',$id)->get();
    // $customers = App\Models\Customer::where('teams_id', $teams)->get();
?>
<head>
<style>
    .main-content.active{
        display: block;
    }
</style>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['record']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['record']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>


<!--[if BLOCK]><![endif]--><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mb-4" style="min-width: 120dvh">
        <!-- Container utama dengan lebar lebih besar di bagian atas -->
        <div class="flex flex-wrap space-x-4 border border-gray-300 rounded-lg p-2 bg-gray-100 dark:bg-gray-800 max-w-[900px] mx-auto shadow-lg">
            <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-4">
                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">Name</p>
                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->name ?? null); ?></p>
            </div>
        
            <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-4 px-4">
                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">Contact</p>
                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->phone); ?></p>
                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->email); ?></p>
            </div>
        
            <div class="flex-1 min-w-[180px] border-r border-gray-300 pr-2">
                <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">Address</p>
                <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->address); ?></p>
            </div>
            <div class="flex-1 min-w-[180px]">
            <button
                class="inline-block text-sm text-white rounded px-4 py-3 transition-all duration-300 ease-in-out bg-gray-400 dark:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white dark:hover:text-white focus:outline-none"
                onclick="showContent(<?php echo e($item->id); ?>)">
                More Info
            </button> 
            </div>
        </div>
        
        <!-- Bagian konten tambahan yang tersembunyi -->
        <div id="main-content-<?php echo e($item->id); ?>" class="main-content px-2" style="display: none">
            <!-- Container pertama dengan ukuran lebih besar -->
            <div class="flex flex-wrap justify-between py-4 px-6 border-t border-gray-400 bg-gray-300 dark:bg-gray-700  shadow-lg">
                <div class="flex-1 min-w-[180px]">
                    <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold">Description : </p>
                    <p class="text-sm text-gray-700 dark:text-gray-400"><?php echo e($item->description ?? null); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
</script><?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/component/table/table-customer.blade.php ENDPATH**/ ?>