<style>
    
</style>
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
        foreach ($flight['Flights'] as $key => $segments) {
            $stops = count($segments['Segments']) - 1;
            if (!in_array($stops, $stopsArray)) {
                $stopsArray[] = $stops;
            }
        }
    }
    sort($stopsArray);
@endphp

    <i class="fa fa-close filter-close"></i>
    {{-- <div class="filter-item pb-5">
        <div class="filter-label f-14px fw-semibold">PRICE RANGE</div>
        <div class="price-range-slider">

            <p class="range-value">
              <span id="amount" ></span>
            </p>
            <div id="slider-range" class="range-bar"></div>
            
        </div>
        <div id="slider"></div>
    </div> --}}
    <div class="filter-item pb-4">
        <div class="filter-label f-14px fw-semibold">STOPS</div>
        <div class="stops-filter-options">
            @foreach ($stopsArray as $item)
                <label class="filter-label">
                    <input type="checkbox" name="stops" class="stops" value="{{$item}}" />
                        @if($item == 0)
                            Direct 
                        @elseif ($item == 1)
                            Stop {{ $item }}
                        @else
                            Stops {{ $item }}
                        @endif
                </label>
            @endforeach
            
        </div>
    </div>
    
    {{-- <div class="filter-item d-none pb-5">
        <div class="filter-label f-14px fw-semibold">DEPARTURE TIME</div>
        <div class="price-range-slider">

            <p class="range-value">
              <input type="text" id="amount" readonly>
            </p>
            <div id="slider-range" class="range-bar"></div>
            
        </div>
        <div id="slider2"></div>
    </div> --}}
    <div class="filter-item airlines-filter pb-4">
        <div class="filter-label f-14px fw-semibold">AIRLINES</div>
        <div class="stops-filter-options">
            <div class="filter-label flex-column d-flex gap-1 w-100">
                @foreach ($airlineArray as $key => $air)
                @php
                    $airName = AirlineNameByAirlineCode($air);
                    $airName = strlen($airName) > 20 ? substr($airName, 0, 20) . "..." : $airName;
                @endphp
                    <div class="d-flex align-items-center gap-2">
                        <input type="checkbox" class="airlines" value="{{ $air }}" id="{{ $air }}">
                        <label for="{{ $air }}">
                            {{ $airName }} ({{ $air }})
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endif


<script>
    $(document).ready(function() {
		$('input[name="stops"]').change(function() {
			if ($(this).is(":checked")) {
				$(this).parent('.filter-label').css('background', 'darkgray');
			} else {
				$(this).parent('.filter-label').css('background', '#fff'); // Set the background color back to the default color when unchecked
			}
		});
	});
    // ==============================filter==============================
    $(document).ready(function () {
        // Event listener for filter changes
        $('input[type="checkbox"]').on('change', function () {
            applyFilters();
        });

        applyFilters(); // Apply filters initially
    });
    function applyFilters() {

        var selectedStops = $('.stops:checked').map(function () {
            return parseInt($(this).val());
        }).get();

        var selectedAirlines = $('.airlines:checked').map(function () {
            return $(this).val();
        }).get();
        // Loop through flight cards
        $('.result-flight-item').each(function () {
            var stops = $(this).data('stops');
            var airline = $(this).data('airline');

            // Check if the flight card should be shown or hidden based on filters
            var show = true;

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

        // var sortCriteria = getSortCriteria();
        // sortFlightCards(sortCriteria);
    }


    // function getSortCriteria() {
    //     var priceSort = $('input[name="price_sort"]:checked').val();
    //     var flightSort = $('input[name="flight_sort"]:checked').val();

    //     return {
    //         price: priceSort,
    //         airline: flightSort,
    //     };
    // }

    // function sortFlightCards(sortCriteria) {
    //     var $flightCards = $('.result-flight-item');

    //     if (sortCriteria.price === 'lowest') {
    //         $flightCards.sort(function (a, b) {
    //             return (
    //                 parseInt($(a).data('price')) - parseInt($(b).data('price'))
    //             );
    //         });
    //     } else if (sortCriteria.price === 'highest') {
    //         $flightCards.sort(function (a, b) {
    //             return (
    //                 parseInt($(b).data('price')) - parseInt($(a).data('price'))
    //             );
    //         });
    //     }

    //     if (sortCriteria.airline === 'asc') {
    //         $flightCards.sort(function (a, b) {
    //             return $(a).data('airline').localeCompare($(b).data('airline'));
    //         });
    //     } else if (sortCriteria.airline === 'desc') {
    //         $flightCards.sort(function (a, b) {
    //             return $(b).data('airline').localeCompare($(a).data('airline'));
    //         });
    //     }

    //     // Append the sorted flight cards back to their container
    //     $flightCards.detach().appendTo('.flight-cards-container');
    // }

    // ==============================End filter==============================
</script>
