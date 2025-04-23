
@if($results['status'] == '200')
    @foreach($results['msg'] as $flight)
        @php
            $totalPrice = $flight['Fares']['TotalPrice'];

            $airCode = $flight['MarketingAirline']['Airline'];
            $totalDuration = '';
            $stops = '';
            $origin = '';
            $destination = '';
            $ADTBaggage = '';
            foreach ($flight['LowFareSearch'] as $key => $segments) {
                $departureTime = strtotime($segments['Segments'][0]['Departure']['DepartureDateTime']);
                $arrivalTime = strtotime($segments['Segments'][0]['Arrival']['ArrivalDateTime']);
                $duration = $segments['TotalDuration'];
                
                $parts = explode(" ", $duration);
                $totalSeconds = 0;
                for ($i = 0; $i < count($parts); $i += 2) {
                    $value = (int)$parts[$i];
                    $unit = strtolower($parts[$i + 1]);

                    if ($unit === "hour" || $unit === "hours") {
                        $totalSeconds += $value * 3600; // Convert hours to seconds
                    } elseif ($unit === "minute" || $unit === "minutes") {
                        $totalSeconds += $value * 60; // Convert minutes to seconds
                    }
                }

                $stops = count($segments['Segments']) - 1;
                
                $origin = $segments['Segments'][0]['Departure']['LocationCode'];
                $departureDateTime = $segments['Segments'][0]['Departure']['DepartureDateTime'];
                $dapartTime = date('H:i', strtotime($departureDateTime));
                foreach ($segments['Segments'] as $key2 => $seg) {
                    $duration2 = $seg['Duration'];
                    $duration2 = str_replace(["PT", "H"], ["", "H "], $duration2);
                    $totalDuration = str_replace(["Hours", "Minutes"], ["H", "M"], $duration2);

                    $destination = $seg['Arrival']['LocationCode'];
                    $arrtivelTime = date('H:i', strtotime($seg['Arrival']['ArrivalDateTime']));
                    $ADTBaggage = $seg['Baggage']['ADT']['Weight'];
                    $BaggageUnit = $seg['Baggage']['ADT']['Unit'];
                }
            }
            $airName = AirlineNameByAirlineCode($airCode);
            $airName = strlen($airName) > 20 ? substr($airName, 0, 20) . "..." : $airName;

        @endphp


        <div class="card1" style="cursor: pointer;" data-price="{{ $totalPrice }}" data-depart="{{(int)$departureTime}}" data-arrival="{{(int)$arrivalTime}}" data-duration="{{$totalSeconds}}" data-airline="{{ $airCode }}" data-api="{{ $flight['api'] }}" data-stops="{{ $stops }}" data-id="{{$flight['api_offer_id']}}">
            <div class="row">
                <div class="col-sm-5">
                    <h6>{{ $dapartTime }}-{{ $arrtivelTime }}</h6>
                    <p>{{ CityNameByAirportCode($origin) }} ({{ $origin }})-{{ CityNameByAirportCode($destination) }} ({{ $destination }})</p>
                    <p class="col-p">{{ $airName }} ({{ $airCode }})</p>
                    <img src="{{asset('assets/airlines/'.$airCode.'.png')}}" class="avatar-md" alt="" style="height: 20px; width: 20px;">
                </div>
                <div class="col-sm-2" style="text-align: center">
                    <p class="main-sm">{{ $totalDuration }} ({{ $stops }} stop)</p>
                    {{-- <p>2h 5 Minuts in Abu Dahbi</p> --}}
                    {{-- <p>4h 5 Minuts in Muscat</p> --}}
                </div>
                <div class="col-sm-5" style="text-align: end">
                    <h5>{{ $flight['Fares']['CurrencyCode'] }} {{ number_format($totalPrice, 2) }}</h5>
                </div>
            </div>
            <div class="card-bottom">
                <p>Baggage:{{ $ADTBaggage }} {{ $BaggageUnit }}</p>
                <p>Source {{ $flight['api'] }}</p>
            </div>
        </div>
    @endforeach
@endif