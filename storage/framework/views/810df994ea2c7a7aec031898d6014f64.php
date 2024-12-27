<?php
use App\Helpers\TranslationHelper;
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
    <div class="container mx-auto p-5 w-full px-0 mx-0">
        <!-- Footer -->
        <footer class="text-center text-white bg-black rounded-lg p-4">
            <!-- Grid container -->
            <div class="flex flex-wrap justify-center space-y-4 md:space-y-0 md:space-x-8">
                <!-- Column 1 -->
                <div class="w-full md:w-1/3 text-left">
                    <h6 class="uppercase font-bold mb-2">DroneLog Book</h6>
                    <p class="text-sm">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi non similique inventore soluta
                        aspernatur deserunt dolorum molestias at distinctio necessitatibus?
                    </p>
                </div>

                <!-- Column 2: Contact -->
                <div class="w-full md:w-1/4 text-left">
                    <h6 class="uppercase font-bold mb-2"><?php echo TranslationHelper::translateIfNeeded('Contact'); ?></h6>
                    <p class="flex items-center"><i class="fas fa-home mr-2"></i> Denpasar, Bali, ID</p>
                    <p class="flex items-center"><i class="fas fa-envelope mr-2"></i> admin@example.com</p>
                    <p class="flex items-center"><i class="fas fa-phone mr-2"></i> + 62 234 567 88</p>
                    <p class="flex items-center"><i class="fas fa-print mr-2"></i> + 62 234 567 89</p>
                </div>

                <!-- Column 3: Social Links -->
                <div class="w-full md:w-1/4 text-left">
                    <h6 class="uppercase font-bold mb-2"><?php echo TranslationHelper::translateIfNeeded('Follow Us'); ?></h6>
                    <div class="flex space-x-2">
                        <a class="text-white p-2 bg-blue-600 rounded-full" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="text-white p-2 bg-blue-400 rounded-full" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a class="text-white p-2 bg-red-500 rounded-full" href="#!" aria-label="Google"><i class="fab fa-google"></i></a>
                        <a class="text-white p-2 bg-pink-600 rounded-full" href="#!" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a class="text-white p-2 bg-blue-800 rounded-full" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a class="text-white p-2 bg-gray-800 rounded-full" href="#!" aria-label="GitHub"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-4 text-sm text-center bg-gray-900 py-2 rounded-md">
                © 2024 Copyright:
                <a class="text-white hover:underline" href="#">DroneLogBook.com</a>
            </div>
        </footer>
        <!-- End Footer -->
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
<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/footer/footer.blade.php ENDPATH**/ ?>