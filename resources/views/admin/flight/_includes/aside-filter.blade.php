@if($results['status'] == '200')
@php
    $apisArray = array();
    $airlineArray = array();
    $stopsArray = array();
    foreach($results['msg'] as $flight){
        $api = $flight['api'];
        $airline = $flight['MarketingAirline']['Airline'];

        // Check if the value already exists in the arrays
        if (!in_array($api, $apisArray)) {
            $apisArray[] = $api;
        }

        if (!in_array($airline, $airlineArray)) {
            $airlineArray[] = $airline;
        }
        foreach ($flight['LowFareSearch'] as $key => $segments) {
            $stops = count($segments['Segments']) - 1;
            if (!in_array($stops, $stopsArray)) {
                $stopsArray[] = $stops;
            }
        }
    }
@endphp
    <div class="card-head">
    </div>
    <div class="card-body">
        <h5>APIs</h5>
        @foreach ($apisArray as $api)    
            <label class="container">{{ $api }}
                <input type="checkbox" class="api" value="{{ $api }}">
            </label>
        @endforeach
        <h5 class="mt-4" style="font-size: 15px;">STOPs</h5>
        @foreach ($stopsArray as $stop)    
            <label class="container">{{ ($stop == 0) ? "Nonstop" : $stop . ' Stop' }}
                <input type="checkbox" class="stops" value="{{ $stop }}">
            </label>
        @endforeach
        
        <div class="card-body-bottom">
            <h6 class="mt-4" style="font-size: 15px;">Airlines</h6>
            @foreach ($airlineArray as $air)
                <label class="container">
                    <input type="checkbox" class="airlines" value="{{ $air }}">{{ AirlineNameByAirlineCode($air) }} ({{ $air }})
                </label>
            @endforeach
            
            <div class="body-bottom">
                <h5>Depart time</h5>
                <ul>
                    <li>                                                       
                        <label>
                            <input type="checkbox" class="depart" value="early-morning" name="">   
                            <i class="fas fa-cloud-sun"></i>
                            <h6>Early Morning</h6>
                            <p>00:00-11:59</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" class="depart" value="morning" name="">   
                            <i class="fas fa-cloud-sun"></i>
                            <h6>Morning</h6>
                            <p>(05:00-11:59)</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" class="depart" value="afternoon" name="">   
                            <i class="fas fa-sun"></i>
                            <h6>Afternoon</h6>
                            <p>(12:00-17:59)</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" class="depart" value="evening" name="">   
                            <i class="fas fa-moon"></i>
                            <h6>Evening</h6>
                            <p>(18:00-23:59)</p>
                        </label>
                    </li>
                </ul>
                <h5>Arrival time</h5>
                <ul>
                    <li>                                                       
                        <label>
                            <input type="checkbox" class="arrival" value="early-  name="">   
                            <i class="fas fa-cloud-sun"></i>
                            <h6>Early Morning</h6>
                            <p>00:00-11:59</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" class="arrival" value="morning"  name="">   
                            <i class="fas fa-cloud-sun"></i>
                            <h6>Morning</h6>
                            <p>(05:00-11:59)</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" class="arrival" value="afternoon"  name="">   
                            <i class="fas fa-sun"></i>
                            <h6>Afternoon</h6>
                            <p>(12:00-17:59)</p>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" class="arrival" value="evening"  name="">   
                            <i class="fas fa-moon"></i>
                            <h6>Evening</h6>
                            <p>(18:00-23:59)</p>
                        </label>
                    </li>
                </ul>
            </div>
        </div>                          
    </div>
@endif
<script>
    $(document).ready(function () {
        // Event listener for filter changes
        $('input[type="checkbox"]').on('change', function () {
            applyFilters();
        });

        applyFilters(); // Apply filters initially
    });

    function applyFilters() {
        // Get selected filter values
        var selectedApis = $('.api:checked').map(function () {
            return $(this).val();
        }).get();

        var selectedStops = $('.stops:checked').map(function () {
            return parseInt($(this).val());
        }).get();

        var selectedAirlines = $('.airlines:checked').map(function () {
            return $(this).val();
        }).get();
        
        // Loop through flight cards
        $('.card1').each(function () {
            var api = $(this).data('api');
            var stops = $(this).data('stops');
            var airline = $(this).data('airline');

            // Check if the flight card should be shown or hidden based on filters
            var show = true;
            if (selectedApis.length > 0 && !selectedApis.includes(api)) {
                show = false;
            }

            if (selectedStops.length > 0 && !selectedStops.includes(stops)) {
                show = false;
            }

            if (selectedAirlines.length > 0 && !selectedAirlines.includes(airline)) {
                show = false;
            }

            // Toggle the visibility of the flight card
            if (show) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

</script>
