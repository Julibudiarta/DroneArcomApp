<?php
    $tenant_id = Auth()->User()->teams()->first()->id;
    $topDrone = App\Models\Fligh::where('teams_id', $tenant_id)
                ->selectRaw('drones_id, COUNT(id) as flight_count')
                ->groupBy('drones_id')
                ->orderByDesc('flight_count')
                ->limit(3)
                ->with('drones')
                ->get();
    $topDroneCount = App\Models\Fligh::where('teams_id', $tenant_id)
                ->selectRaw('drones_id, COUNT(id) as flight_count')
                ->groupBy('drones_id')
                ->orderByDesc('flight_count')
                ->limit(3)
                ->with('drones')
                ->get()
                ->count();
    
    $otherTotalDrone = App\Models\Fligh::where('teams_id', $tenant_id)
                ->whereNotIn('drones_id', $topDrone->pluck('drones_id'))
                ->count();

    
    $labels=[];
    $datas = [];
    foreach ($topDrone as $drone) {
        $labels[] = $drone->drones->name;
        $datas[] = $drone->flight_count;
    };
    if($topDroneCount == 3){
        $data = [$datas[0], $datas[1], $datas[2],$otherTotalDrone];
        $label = [$labels[0],$labels[1],$labels[2],'Other'];
        $color = [
            '#FFA500',
            '#ADD8E6',
            '#6A5ACD',
            '#32CD32'   
        ];
    }elseif($topDroneCount == 2){
        $data = [$datas[0], $datas[1],$otherTotalDrone];
        $label = [$labels[0],$labels[1],'Other'];
        $color = [
            '#FFA500',
            '#ADD8E6',
            '#32CD32'   
        ];
    }elseif($topDroneCount == 1){
        $data = [$datas[0],$otherTotalDrone];
        $label = [$labels[0],'Other'];
        $color = [
            '#FFA500',
            '#32CD32'   
        ];
    }elseif($topDroneCount == 0){
        $data = [$otherTotalDrone];
        $label = ['Other'];
        $color = [
            '#32CD32'   
        ];
    }

    //drone
    $totalDrones = App\Models\fligh::where('teams_id', $tenant_id)
    ->distinct('drones_id')
    ->count('drones_id');
    $totalFlight = App\Models\fligh::where('teams_id', $tenant_id)->count('name');

        
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <p class="text-center uppercase font-semibold mb-2 text-sm text-gray-800 dark:text-gray-200">Total <?php echo e($totalFlight); ?> Flights with <?php echo e($totalDrones); ?> Drones</p>
    <canvas id="tabflightdrone"></canvas>
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
    // Dummy data
    const chartLabelsFlightDrone = <?php echo json_encode($label, 15, 512) ?>;
    const chartDataFlightDrone = <?php echo json_encode($data, 15, 512) ?>;
    const chartColorsFlightDrone = <?php echo json_encode($color, 15, 512) ?>;
    const dataFlightDrone = {
        labels: chartLabelsFlightDrone,
        datasets: [{
            label: 'Flight Data',
            data: chartDataFlightDrone,
            backgroundColor: chartColorsFlightDrone,
            borderColor: chartColorsFlightDrone,
            borderWidth: 1
        }]
    };

    const configFlightDrone = {
        type: 'doughnut',
        data: dataFlightDrone,
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || 'Unknown';
                            const value = context.raw || 0;
                            return `${label}: ${value} Flight`;
                        }
                    },
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    borderColor: '#ccc',
                    borderWidth: 1,
                    titleColor: '#000',
                    bodyColor: '#000',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 10,
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 12
                        },
                        padding: 10,
                        boxWidth: 10,
                        boxHeight: 10,
                    }
                }
            }
        }
    };

    // Render the chart
    const ctxFlightDrone = document.getElementById('tabflightdrone').getContext('2d');
    new Chart(ctxFlightDrone, configFlightDrone);
</script> <?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/component/chartjs/doughnut-tab-fligh-drone.blade.php ENDPATH**/ ?>