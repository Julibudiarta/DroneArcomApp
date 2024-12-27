<?php
session_start();

$year = session('tahun', now()->year);
    $droneId = session('drone_id');
        $tenant_id = Auth()->user()->teams()->first()->id;
            $flights = App\Models\fligh::where('teams_id', $tenant_id)->where('drones_id', $droneId)
                ->whereBetween('start_date_flight', [
                    Carbon\Carbon::createFromDate($year, 1, 1)->startOfDay(),
                    Carbon\Carbon::createFromDate($year, 12, 31)->endOfDay()
                ])
                ->get();
        
            $data = $flights->groupBy(function ($item) {
                return Carbon\Carbon::parse($item->start_date_flight)->format('Y-m');
            })->map(function ($group) {
                $totalFlights = $group->count();
                $totalDuration = $group->sum(function ($flight) {
                    list($hours, $minutes, $seconds) = explode(':', $flight->duration);
                    return ($hours * 3600) + ($minutes * 60) + $seconds;
                });
                $totalHours = $totalDuration / 3600;
                $formatTotalHour = round($totalHours,1);

                return [
                    'totalFlights' => $totalFlights,
                    'totalDuration' => $formatTotalHour,
                ];
            });
            $totalFlightsPerMonth = $data->pluck('totalFlights')->sum();
            $totalDurationInSeconds = $flights->sum(function ($flight) {
                list($hours, $minutes, $seconds) = explode(':', $flight->duration);
                return ($hours * 3600) + ($minutes * 60) + $seconds;
            });
            
            $totalHours = floor($totalDurationInSeconds / 3600);
            $totalMinutes = floor(($totalDurationInSeconds % 3600) / 60);
            $totalSeconds = $totalDurationInSeconds % 60;
            // Format total durasi
            $formattedTotalDuration = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds); 
            
            $chartDataFlight = json_encode($data);
        

?>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px; 
        flex-wrap: wrap;
    }
        @media (max-width: 640px) {
        .button-container {
            flex-direction: column;
            gap: 12px;
        }
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
    <div class="flex justify-center items-center mb-2">
        <div class="rounded-lg shadow-lg p-4 w-full max-w-md sm:max-w-lg md:max-w-2xl lg:max-w-1/2 dark:bg-gray-900">
            <p class="text-sm font-semibold text-center text-gray-800 dark:text-gray-100">Flight & Flying Times <br> <?php echo e($year); ?></p>
            <canvas id="dualAxisChart"></canvas>
            <p class="text-sm font-semibold text-center text-gray-700 dark:text-gray-100"><?php echo e($totalFlightsPerMonth); ?> Flights / <?php echo e($formattedTotalDuration); ?> Hours in <?php echo e($year); ?></p>
        </div>
    </div>
    <div class="button-container flex justify-center items-center space-x-4">
        <button id="button-left" type="button" class="bg-primary-500 text-white p-2 rounded-lg shadow hover:bg-primary-600 dark:bg-primary-700 dark:hover:bg-primary-800" onclick="changeYear(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="button-center" type="button" class="bg-primary-500 text-white p-2 rounded-lg shadow hover:bg-primary-600 dark:bg-primary-700 dark:hover:bg-primary-800" onclick="changeYearDefault()">
            <p id="current-year">current-year</p>
        </button>
        <button id="button-right" type="button" class="bg-primary-500 text-white p-2 rounded-lg shadow hover:bg-primary-600 dark:bg-primary-700 dark:hover:bg-primary-800" onclick="changeYear(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let tahun = <?php echo e($year); ?>;

    function updateYearDisplay() {
        $.ajax({
            url: '<?php echo e(route('change.year')); ?>',
            method: 'POST',
            data: { tahun: tahun, _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                console.log(response);
                location.reload();
            }
        });
    }

    function changeYear(increment) {
        tahun += increment;
        updateYearDisplay();
    }
    function changeYearDefault() {
        tahun = new Date().getFullYear();
        updateYearDisplay();
    }
  
</script>
<script>
    const chartData = <?php echo $chartDataFlight; ?>;

    const labels = Object.keys(chartData);
    const totalFlightsData = Object.values(chartData).map(item => item.totalFlights);
    const totalDurationData = Object.values(chartData).map(item => item.totalDuration);

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Flight #',
                data: totalFlightsData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y1',
            },
            {
                label: 'Flying Time',
                data: totalDurationData,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                yAxisID: 'y2', 
            },
        ],
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                y1: {
                    type: 'linear',
                    position: 'left', 
                    ticks: {
                        color: 'rgba(54, 162, 235, 1)',
                    },
                    grid: {
                        drawOnChartArea: true,
                        color: 'rgba(200, 200, 200, 0.5)',
                        lineWidth: 1, 
                    },
                    title: {
                        display: true,
                        text: 'Flight #',
                        color: 'rgba(54, 162, 235, 1)',
                    },
                },
                y2: {
                    type: 'linear',
                    position: 'right',
                    ticks: {
                        color: 'rgba(75, 192, 192, 1)',
                    },
                    title: {
                        display: true,
                        text: 'Flying Time',
                        color: 'rgba(75, 192, 192, 1)',
                    },
                },
                x: {
                    ticks: {
                        color: 'rgba(160, 160, 160, 1)' ,
                    },
                },
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const index = context.dataIndex;
                            const flightCount = totalFlightsData[index];
                            const flyingTime = totalDurationData[index];
                            return `Flight #: ${flightCount}, Flying Time: ${flyingTime} hrs`;
                        },
                    },
                },
            },
        },
    };
        const ctx = document.getElementById('dualAxisChart').getContext('2d');
        new Chart(ctx, config);
</script> 



<?php /**PATH C:\laragon\www\drone-app-arcom\resources\views/component/chartjs/drone-statistik.blade.php ENDPATH**/ ?>