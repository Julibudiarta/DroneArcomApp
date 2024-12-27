<?php
use App\Helpers\TranslationHelper;
$userID = Auth()->user()->id;
$emailUser = App\Models\User::where('id', $userID)->get()->pluck('email')->first();
$phoneUser = App\Models\User::where('id', $userID)->get()->pluck('phone')->first();

?>
<?php if (isset($component)) { $__componentOriginalbe23554f7bded3778895289146189db7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe23554f7bded3778895289146189db7 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\Page::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Filament\View\LegacyComponents\Page::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Example</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 50;
                display: none;
            }
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center h-screen">
        <div class="container mx-auto p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Form -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h1 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Contact Us'); ?></h1>
                    <p class="mt-2 text-lg leading-8 text-gray-600 dark:text-white text-center"><?php echo TranslationHelper::translateIfNeeded('Leave us feedback or feature requests!'); ?></p>
             <!-- Success Notification -->
                    <!--[if BLOCK]><![endif]--><?php if(session('success')): ?>
                    <div id="success-notification" class="notification bg-green-500 text-white p-4 rounded-lg shadow-lg flex items-center justify-between">
                        <span><?php echo e(session('success')); ?></span>
                        <button id="close-notification" class="ml-4 text-white hover:text-gray-200 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <form action="<?php echo e(route('sendEmail')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Email'); ?></label>
                            <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100" 
                            required
                            value="<?php echo e($emailUser); ?>">
                        </div>
                        <div class="mb-4">
                            <label for="number" class="block text-gray-700 dark:text-gray-300 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Number'); ?></label>
                            <input 
                            type="number" 
                            id="number" 
                            name="number" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100" 
                            required
                            value="<?php echo e($phoneUser); ?>">
                        </div>
                                <!--category-->
                        <div class="mb-4">
                            <label for="category" class="block text-gray-700 dark:text-gray-300 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Category'); ?></label>
                            <div class="mt-2.5">
                                <select name="category" id="category" autocomplete="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100" required>
                                    <option value="" disabled selected><?php echo TranslationHelper::translateIfNeeded('Select a category'); ?></option>
                                    <option value="Web Application"><?php echo TranslationHelper::translateIfNeeded('Web Application'); ?></option>
                                    <option value="Mobile Application"><?php echo TranslationHelper::translateIfNeeded('Mobile Application'); ?></option>
                                    <option value="Subscription"><?php echo TranslationHelper::translateIfNeeded('Subscription'); ?></option>
                                    <option value="Schedule a demo"><?php echo TranslationHelper::translateIfNeeded('Schedule a demo'); ?></option>
                                    <option value="Flight Log Importing"><?php echo TranslationHelper::translateIfNeeded('Flight Log Importing'); ?></option>
                                    <option value="Login - Registration"><?php echo TranslationHelper::translateIfNeeded('Login - Registration'); ?></option>
                                    <option value="Technical Issue"><?php echo TranslationHelper::translateIfNeeded('Technical Issue'); ?></option>
                                    <option value="Partnership"><?php echo TranslationHelper::translateIfNeeded('Partnership'); ?></option>
                                    <option value="Knowledge Base Suggestion"><?php echo TranslationHelper::translateIfNeeded('Knowledge Base Suggestion'); ?></option>
                                    <option value="Other"><?php echo TranslationHelper::translateIfNeeded('Other'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700 dark:text-gray-300 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Subject'); ?></label>
                            <input type="text" id="subject" name="subject" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 dark:text-gray-300 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Message'); ?></label>
                            <textarea id="message" name="message" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100" required></textarea>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50"><?php echo TranslationHelper::translateIfNeeded('Send'); ?></button>
                        </div>
                    </form>
                </div>
                <!-- Informational Text -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('Drone Log Book'); ?></h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-2 dark:text-white">
                        <?php echo TranslationHelper::translateIfNeeded('Thank you for choosing DroneLogBook as your trusted solution for recording drone activities. We are committed to continuously improving our service to meet your needs and expectations. Your feedback is invaluable in helping us grow and deliver the best experience possible. Don’t hesitate to reach out to us through our contact form or email us directly at support. We’re more than happy to listen and respond to any questions or suggestions you may have. 
                        We look forward to continuing our collaboration to create the best experience for you.'); ?></p>
                    <p class="text-gray-700 dark:text-gray-300 dark:text-white"><?php echo TranslationHelper::translateIfNeeded('We invite you to visit us on the following platforms, where you can find more information about our services, as well as various resources that can help you in using DroneLogBook.'); ?></p>
                    <div class="flex space-x-4 mt-4">
                        <a href="https://twitter.com" target="_blank" class="text-gray-700 dark:text-white hover:text-blue-500">
                            <i class="fab fa-twitter fa-2x"></i>
                        </a>
                        <a href="https://facebook.com" target="_blank" class="text-gray-700 dark:text-white hover:text-blue-700">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="text-gray-700 dark:text-white hover:text-pink-500">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const notification = document.getElementById('success-notification');
                const closeButton = document.getElementById('close-notification');
                if (notification) {
                    notification.style.display = 'block';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 8000); // ngatur hilang 8 detik
    
                    closeButton.addEventListener('click', () => {
                        notification.style.display = 'none';
                    });
                }
            });
        </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $attributes = $__attributesOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__attributesOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $component = $__componentOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__componentOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/filament/contact-resource/pages/contact-page.blade.php ENDPATH**/ ?>