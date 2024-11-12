<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<script src="https://cdn.tailwindcss.com"></script>
<div>
<!--alret massage   -->
<div id="success-notification-battrei" class="hidden-notif bg-green-500 text-white p-4 rounded-lg shadow-lg flex items-center justify-between">
    <span>Successfully</span>
    <button id="close-notification-battrei" class="ml-4 text-white hover:text-gray-200 focus:outline-none">
        <i class="fas fa-times"></i>
    </button>
</div>


  <!-- Tombol untuk Membuka Modal -->
    <button style="font-size: 12px; background-color: #4A5568; color: white; font-weight: bold; padding: 4px 8px; border-radius: 4px; border: none; cursor: pointer;" onclick="openModalBattrei()" type="button">
        <span style="color: inherit; text-decoration: none;">
            Add New Batterei
        </span>
    </button>

    <!-- Modal -->
    <div class="fixed battrei active inset-0 flex justify-center z-50" style="max-height: 80%">
        <div class="relative space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[80%] overflow-y-auto mx-4 md:mx-auto">
            <!-- Tombol Close -->
            <button type="button"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-500 text-2xl font-bold p-2"
                onclick="closeModalBattrei()">
                 &times;
            </button>

            <!-- Judul Modal -->
            <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-white">
                Create Batterei
            </h2>
            <hr class="border-t border-gray-300 dark:border-gray-600 w-24 mx-auto">

            <!-- Form --> 
            <div>
                @csrf
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Name</label>
                        <input id="namebattrei" type="text" name="name" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Model Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Model</label>
                        <input id="modelbattrei" type="text" name="model" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Status Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Status</label>
                        <select id="statusbattrei" name="statusbattreit" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            <option value="airworthy">airworthy</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="retired">Retired</option>
                        </select>
                    </div>
            
                    <!-- Inventory Asset Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Asset Inventory</label>
                        <select id="inventory_assetequipment" name="inventory_asset" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            <option value="inventory">Inventory</option>
                            <option value="asset">Asset</option>
                        </select>
                        
                    </div>
            
                    <!-- Serial P Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Serial P</label>
                        <input id="serial_Pbattrei" type="text" name="serial_P" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Serial I Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Serial I</label>
                        <input id="serial_Ibattrei" type="text" name="serial_I" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Cell Count Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Cell Count</label>
                        <input id="cellCountbattrei" type="number" name="cellCount" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Nominal Voltage Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Nominal Voltage</label>
                        <input id="nominal_voltagebattrei" type="number" name="nominal_voltage" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Capacity Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Capacity</label>
                        <input id="capacitybattrei" type="number" name="capacity" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Initial Cycle Count Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Initial Cycle Count</label>
                        <input id="initial_Cycle_countbattrei" type="number" name="initial_Cycle_count" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Life Span Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Life Span</label>
                        <input id="life_spanbattrei" type="number" name="life_span" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Flight Count Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Flight Count</label>
                        <input id="fligh_countbattrei" type="number" name="flaight_count" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- For Drone Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">For Drone</label>
                        <input id="for_dronebattrei" type="text" name="for_drone" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Purchase Date Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Purchase Date</label>
                        <input id="purchase_datebattrei" type="date" name="purchase_date" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Insurable Value Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Insurable Value</label>
                        <input id="insurable_valuebattrei" type="number" name="insurable_value" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Weight Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Weight</label>
                        <input id="weightbattrei" type="number" name="weight" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Firmware Version Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Firmware Version</label>
                        <input id="firmware_versionbattrei" type="text" name="firmware_version" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
            
                    <!-- Hardware Version Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Hardware Version</label>
                        <input id="hardware_versionbattrei" type="text" name="hardware_version" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                    </div>
                    <!-- owner Input-->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Owner</label>
                        <select id="users_idbattrei" name="users_id" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            @foreach (App\Models\User::whereHas('teams', function ($query) {
                                    $query->where('teams.id', auth()->user()->teams()->first()->id);
                                })->pluck('name', 'id') as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Is Loaner Input -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Is Loaner</label>
                        <select id="is_loanerbattrei" name="is_loaner" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            
                <!-- Description Text Area -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="descriptionbattrei" name="description" maxlength="255" class="w-full mt-1 p-2 border dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 rounded-md focus:ring focus:ring-blue-500"></textarea>
                </div>
            
                <!-- Submit Button -->
                <div class="flex justify-end mt-4">
                    <button id="triggerButtonB" type="button" 
                        style="font-size: 16px; background-color: #4A5568; color: white; font-weight: bold; padding: 8px 16px; border-radius: 4px; border: none; cursor: pointer;"
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600" onclick="createBattrei()">
                        Submit
                    </button>
                </div>
            </div>
                      
            
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- close and open pop-up --}}
<script>
    function closeModalBattrei() {
        const contents = document.querySelector('.battrei');
        contents.classList.add('active');
    }
    function openModalBattrei() {
        const contents = document.querySelector('.battrei');
        contents.classList.remove('active');     
    }
</script>
{{-- test ajax ke controller action --}}
<script>
    function createBattrei() {
        const nameValue = $('#namebattrei').val();
        const modelValue = $('#modelbattrei').val();
        const statusValue = $('#statusbattrei').val();
        const assetInventoryValue = $('#asset_inventorybattrei').val();
        const serialPValue = $('#serial_Pbattrei').val();
        const serialIValue = $('#serial_Ibattrei').val();
        const cellCountValue = $('#cellCountbattrei').val();
        const nominalVoltageValue = $('#nominal_voltagebattrei').val();
        const capacityValue = $('#capacitybattrei').val();
        const initialCycleCountValue = $('#initial_Cycle_countbattrei').val();
        const lifeSpanValue = $('#life_spanbattrei').val();
        const flightCountValue = $('#fligh_countbattrei').val();
        const forDroneValue = $('#for_dronebattrei').val();
        const purchaseDateValue = $('#purchase_datebattrei').val();
        const insurableValueValue = $('#insurable_valuebattrei').val();
        const weightValue = $('#weightbattrei').val();
        const firmwareVersionValue = $('#firmware_versionbattrei').val();
        const hardwareVersionValue = $('#hardware_versionbattrei').val();
        const isLoanerValue = $('#is_loanerbattrei').val();
        const descriptionValue = $('#descriptionbattrei').val();
        const userIdValue = $('#users_idbattrei').val();

        // Log for debugging
        console.log({
            name: nameValue,
            model: modelValue,
            status: statusValue,
            asset_inventory: assetInventoryValue,
            serial_P: serialPValue,
            serial_I: serialIValue,
            cellCount: cellCountValue,
            nominal_voltage: nominalVoltageValue,
            capacity: capacityValue,
            initial_Cycle_count: initialCycleCountValue,
            life_span: lifeSpanValue,
            flight_count: flightCountValue,
            for_drone: forDroneValue,
            purchase_date: purchaseDateValue,
            insurable_value: insurableValueValue,
            weight: weightValue,
            firmware_version: firmwareVersionValue,
            hardware_version: hardwareVersionValue,
            is_loaner: isLoanerValue,
            description: descriptionValue,
            users_id: userIdValue
        });

        // Validate empty fields
        if (
                nameValue.trim() === '' ||
                modelValue.trim() === '' ||
                statusValue.trim() === '' ||
                assetInventoryValue.trim() === '' ||
                serialPValue.trim() === '' ||
                serialIValue.trim() === '' ||
                cellCountValue.trim() === '' ||
                nominalVoltageValue.trim() === '' ||
                capacityValue.trim() === '' ||
                initialCycleCountValue.trim() === '' ||
                lifeSpanValue.trim() === '' ||
                flightCountValue.trim() === '' ||
                purchaseDateValue.trim() === '' ||
                insurableValueValue.trim() === '' ||
                weightValue.trim() === '' ||
                firmwareVersionValue.trim() === '' ||
                hardwareVersionValue.trim() === '' ||
                isLoanerValue.trim() === '' ||
                userIdValue.trim() === ''
            ) {
            alert('Name cannot be empty!');
            return;
        }

        // Send data via AJAX
        $.ajax({
            url: '{{ route('create-battrei') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Laravel CSRF token
                name: nameValue,
                model: modelValue,
                status: statusValue,
                asset_inventory: assetInventoryValue,
                serial_P: serialPValue,
                serial_I: serialIValue,
                cellCountValue: cellCountValue,
                nominal_voltage: nominalVoltageValue,
                capacity: capacityValue,
                initial_Cycle_count: initialCycleCountValue,
                life_span: lifeSpanValue,
                flight_count: flightCountValue,
                for_drone: forDroneValue,
                purchase_date: purchaseDateValue,
                insurable_value: insurableValueValue,
                weight: weightValue,
                firmware_version: firmwareVersionValue,
                hardware_version: hardwareVersionValue,
                is_loaner: isLoanerValue,
                description: descriptionValue,
                users_id: userIdValue,
            },
            success: function(response) {
                console.log(response);
                $("#success-notification-battrei").removeClass("hidden-notif")
                $("#success-notification-battrei").addClass("notification")
                setTimeout(() => {
                    location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                console.error('error:', error);
            }
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notification = document.getElementById('success-notification-battrei');
        const closeButton = document.getElementById('close-notification-battrei');
        if (notification) {
            setTimeout(() => {
                notification.style.display = 'none';
            }, 8000); // Hide after 8 seconds

            closeButton.addEventListener('click', () => {
                notification.style.display = 'none';
            });
        }
    });
</script>

