
<div class="modal-body scrollable">
    @foreach ($offerData['finaldata']['LowFareSearch'] as $offer)
        @foreach ($offer['Segments'] as $segKey => $segment)
            @php
                $originCode = $segment['Departure']['LocationCode'];
                $destinationCode = $segment['Arrival']['LocationCode'];
                $departure_date = date('d M Y',strtotime($segment['Departure']['DepartureDateTime']));
                $dapartTime = date('H:i', strtotime($segment['Departure']['DepartureDateTime']));
                $arrtivelTime = date('H:i', strtotime($segment['Arrival']['ArrivalDateTime']));
                $flightCode = $segment['OperatingAirline']['Code'];
                $flightNumber = $segment['OperatingAirline']['FlightNumber'];

                $airName = AirlineNameByAirlineCode($flightCode);
                $airName = strlen($airName) > 20 ? substr($airName, 0, 13) . "..." : $airName;
                $duration = $segment['Duration'];
                $duration = str_replace(["PT", "H"], ["", "H "], $duration);

                $Baggage = $segment['Baggage'];
                // ---------------------------------------
                $layover = null;
                if ($segKey > 0) {
                    $currentDeparture = new DateTime($segment['Departure']['DepartureDateTime']);
                    $previousArrival = new DateTime($offer['Segments'][$segKey - 1]['Arrival']['ArrivalDateTime']);
                    $layover = $currentDeparture->diff($previousArrival)->format('%H:%I');
                }
            @endphp
            @if ($layover)
                <div class="mx-3 px-2 p-1" style="background: linear-gradient(to right, #ffa50029, transparent);">
                    @php
                        list($hours, $minutes) = explode(':', $layover);
                        $hours = (int) $hours;
                        $minutes = (int) $minutes;
                    @endphp
                    <strong>Layover Time: {{ $hours.' Hours '.$minutes.' Minutes' }}</strong>
                </div>
            @endif
            <div class="fares-detail">
                <div class="modal-baggage bg-soft-primary d-flex justify-content-between px-4 pt-2 pb-2">
                    <div class="flight-fare w-50">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <span>{{ $departure_date }}</span> 
                    </div>
                    <div class="flight-fare w-50 text-end">
                        <span>({{ $dapartTime }} - {{ $arrtivelTime }})</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between px-4 pt-3">
                    <div class="w-50">
                        <img src="{{asset('assets/airlines/'.$flightCode.'.png')}}" class="avatar-md" alt="" style="height: 20px; width: 20px; margin-top: 0;">
                            <span>{{ $airName }}</span>
                    </div>
                    <div class="w-50 text-end">
                        <i class="fas fa-plane"></i>
                        <span>{{$flightCode }} {{ $flightNumber }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between px-4 pt-3">
                    <div class="w-33">
                    <i class="fa fa-plane-departure"></i> {{ CityNameByAirportCode($originCode) }} ({{ $dapartTime}})
                    </div>
                    <div class="text-center w-33">
                        <i class="fa fa-clock"></i>
                        <span>{{ $duration }}</span>
                    </div>
                    <div class="w-33 text-end">
                        <i class="fas fa-plane-arrival"></i>
                        {{ CityNameByAirportCode($destinationCode) }} ({{ $arrtivelTime }})
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
            
    <div class="modal-baggage p-4 mt-5">
        <h5><i class="fa fa-briefcase" aria-hidden="true"></i>Baggage Details</h5>
        @foreach ($offerData['finaldata']['LowFareSearch'] as $offer)
            @foreach ($offer['Segments'] as $segment)
                @php
                    $originCode = $segment['Departure']['LocationCode'];
                    $destinationCode = $segment['Arrival']['LocationCode'];
                @endphp
                <div>
                    
                    <ul>
                        <li>
                            {{ CityNameByAirportCode($originCode) }} ({{ $originCode}}) - {{ CityNameByAirportCode($destinationCode) }} ({{ $destinationCode }})
                        </li>
                    </ul>
                    @foreach ($segment['Baggage'] as $key => $pass)
                        @if ($key == 'ADT')
                            <p class="modal-pira"><i class="fa-solid fa-cart-flatbed-suitcase"></i>
                                <b>
                                    <i class="fa fa-male" aria-hidden="true"></i>Adult
                                    {{ $pass['Weight']}} {{ $pass['Unit']}} 
                                </b>
                            </p>
                        @endif
                        @if ($key == 'CNN')
                            <p class="modal-pira"><i class="fa-solid fa-cart-flatbed-suitcase"></i>
                                <b>
                                    <i class="fa fa-child" aria-hidden="true"></i>Child
                                    {{ $pass['Weight']}} {{ $pass['Unit']}} 
                                </b>
                            </p>
                        @endif
                        @if ($key == 'INF')
                            <p class="modal-pira"><i class="fa-solid fa-cart-flatbed-suitcase"></i>
                                <b>
                                    <i class="fa fa-baby" aria-hidden="true"></i>Infant
                                    {{ $pass['Weight']}} {{ $pass['Unit']}} 
                                </b>
                            </p>
                        @endif
                    @endforeach    
                </div>
            @endforeach
        @endforeach
        
        @if(@$offerData['finaldata']['Fares'])
            @php
                $CurrencyCode = @$offerData['finaldata']['Fares']['CurrencyCode'];
                $fareBreakDown = @$offerData['finaldata']['Fares']['fareBreakDown'];
            @endphp
            <div class="modal-botom">
                <h5><i class="fa fa-money-bill-wave"></i>Fare Breakdown</h5>
                @foreach ($fareBreakDown as $key => $pass)
                    <p class="d-flex justify-content-between mb-0" style="font-size: 12px;">
                        <span>
                            {{ $CurrencyCode }} {{ number_format($pass['TotalFare'],2) }} for 1 {{ $key }} 
                        </span>
                        <span>
                            ({{ $CurrencyCode }} {{ number_format($pass['TotalFare'] * $pass['Quantity'],2) }} Total)
                        </span>
                    </p>
                @endforeach
            </div>
        @endif
    </div>

    <!-- <h6 class="mt-4">FARE RULES</h6>
    <div class="modal-farerule p-4">
        <p>
            Category 0application and other condations rule 033/pk10 for one way fares strategic
            fares application area these fares apply between pakistan and middle east.class of 
            servic these fares apply for first /business/Premium economy/ economy class service.
            type of transportation this role governs oneway fares. fares governed by this rule can 
            be used to creat... <span>...Read More</span>
        </p>
    </div> -->
    <h6 class="mt-4">SELECTED FARES</h6>
    <div class="modal-fares p-4">
        @if(@$offerData['finaldata']['Fares'])
            @php
                $CurrencyCode = @$offerData['finaldata']['Fares']['CurrencyCode'];
                $fareBreakDown = @$offerData['finaldata']['Fares']['fareBreakDown'];
                $TotalPrice = @$offerData['finaldata']['Fares']['TotalPrice'];
                $TotalBase = 0;
                $TotalTax = 0;
            @endphp
            <div class="modal-left">
                @foreach ($offerData['finaldata']['Fares']['fareBreakDown'] as $key => $pass)
                    @if($key == "ADT")
                        @php
                            $adtBase = (int) $pass['BaseFare'] * (int) $pass['Quantity'];
                            $TotalBase += $adtBase;
                        @endphp
                        <p class="d-flex justify-content-between mb-0">
                            <span>{{ $pass['Quantity'] }} Adult base fare:</span>
                            <span>{{ $CurrencyCode }} {{ number_format($adtBase,2) }}</span>
                        </p>
                    @endif
                    @if($key == "CNN")
                        @php
                            $cnnBase = (int) $pass['BaseFare'] * (int) $pass['Quantity'];
                            $TotalBase += $cnnBase;
                        @endphp
                        <p class="d-flex justify-content-between mb-0">
                            <span>{{ $pass['Quantity'] }} Child base fare:</span>
                            <span>{{ $CurrencyCode }} {{ number_format($cnnBase,2) }}</span>
                        </p>
                    @endif
                    @if($key == "INF")
                        @php
                            $infBase = (int) $pass['BaseFare'] * (int) $pass['Quantity'];
                            $TotalBase += $infBase;
                        @endphp
                        <p class="d-flex justify-content-between mb-0">
                            <span>{{ $pass['Quantity'] }} Infant base fare:</span>
                            <span>{{ $CurrencyCode }} {{ number_format($infBase,2) }}</span>
                        </p>
                    @endif
                @endforeach
                
                <h5 class="d-flex justify-content-between mt-1">
                    <span>Total Base Fare:</span>
                    <span>{{ $CurrencyCode }} {{ number_format($TotalBase,2) }}</span>
                </h5>
                <br>


                
                @foreach ($offerData['finaldata']['Fares']['fareBreakDown'] as $key => $pass)
                    @if($key == "ADT")
                        @php
                            $adtTax = (int) $pass['TotalTax'] * (int) $pass['Quantity'];
                            $TotalTax += $adtTax;
                        @endphp
                        <p class="d-flex justify-content-between mb-0">
                            <span>{{ $pass['Quantity'] }} Adult tax amount</span>
                            <span>{{ $CurrencyCode }} {{ number_format($adtTax,2) }}</span>
                        </p>
                    @endif
                    @if($key == "CNN")
                        @php
                            $cnnTax = (int) $pass['TotalTax'] * (int) $pass['Quantity'];
                            $TotalTax += $cnnTax;
                        @endphp
                        <p class="d-flex justify-content-between mb-0">
                            <span>{{ $pass['Quantity'] }} Child tax amount</span>
                            <span>{{ $CurrencyCode }} {{ number_format($cnnTax,2) }}</span>
                        </p>
                    @endif
                    @if($key == "INF")
                        @php
                            $infTax = (int) $pass['TotalTax'] * (int) $pass['Quantity'];
                            $TotalTax += $infTax;
                        @endphp
                        <p class="d-flex justify-content-between mb-0">
                            <span>{{ $pass['Quantity'] }} Infant tax amount</span>
                            <span>{{ $CurrencyCode }} {{ number_format($infTax,2) }}</span>
                        </p>
                    @endif
                @endforeach
                <h5 class="d-flex justify-content-between mt-1">
                    <span>Total Taxes and fees:</span>
                    <span>{{ $CurrencyCode }} {{ number_format($TotalTax,2) }}</span>
                    
                </h5>
            </div>
            <div class="modal-botom">
                <h5 style="font-weight: 700">Total Amount:</h5>
                <h5 style="font-weight: 700">{{  $CurrencyCode }} {{ number_format((int)$TotalPrice,2) }}</h5>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    @if(auth('admin')->user()->can('Create-PNR'))
    <form action="{{ route('admin.flight.checkout') }}" method="POST">
        @csrf
        <input type="hidden" name="fare_id" value="{{ $offerData['id'] }}">
        <button type="submit" class="btn btn-primary w-md">Book Now</button>
    </form>
    @endif
</div>