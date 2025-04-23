
@if (@$finaldata)
    {{-- ----------------Flight detail--------------- --}}
    <div class="card mb-2">
        <div class="accordion" id="flight_detail">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFlight">
                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFlight" aria-expanded="true" aria-controls="collapseFlight">
                    Flight Detail
                    </button>
                </h2>
                <div id="collapseFlight" class="accordion-collapse collapse show" aria-labelledby="headingFlight" data-bs-parent="#flight_detail">
                    @foreach ($finaldata['LowFareSearch'] as $fares)
                        @foreach ($fares['Segments'] as $segKey => $segment)
                            @php
                                $flightCode = $segment['OperatingAirline']['Code'];
                                $FlightNumber = $segment['OperatingAirline']['FlightNumber'];
                                
                                $DepartureCode = $segment['Departure']['LocationCode'];
                                $ArrivalCode = $segment['Arrival']['LocationCode'];

                                $departure_date =  date('d M Y',strtotime($segment['Departure']['DepartureDateTime']));
                                $dapartTime = date('H:i', strtotime($segment['Departure']['DepartureDateTime']));
                                $arrtivelTime = date('H:i', strtotime($segment['Arrival']['ArrivalDateTime']));

                                $duration = $segment['Duration'];
                                $duration = str_replace(["PT", "H"], ["", "H "], $duration);

                                $airName = AirlineNameByAirlineCode($flightCode);
                                $airName = strlen($airName) > 20 ? substr($airName, 0, 13) . "..." : $airName;
                                $Cabin = @$segment['Cabin'];
                                // ---------------------------------------
                                    $layover = null;

                                    if ($segKey > 0) {
                                        $currentDeparture = new DateTime($segment['Departure']['DepartureDateTime']);
                                        $previousArrival = new DateTime($fares['Segments'][$segKey - 1]['Arrival']['ArrivalDateTime']);
                                        $layover = $currentDeparture->diff($previousArrival)->format('%H:%I');
                                    }                                

                            @endphp
                            @if ($layover)
                                <div class="mx-3 px-2 p-1" style="background: linear-gradient(to right, #ffa50029, transparent);">
                                    <strong>Layover Time: {{ $layover }}</strong>
                                </div>
                            @endif
                            <div class="accordion-body">
                                <div class="modal-baggage bg-soft-primary-2 d-flex justify-content-between rounded px-2 pt-2 pb-2 mb-2" style="margin: 0 -10px;">
                                    <div class="flight-fare w-50">
                                        <span>{{ CityNameByAirportCode($DepartureCode) }} ({{$DepartureCode}})</span> 
                                    </div>
                                    <div class="flight-fare w-50 text-end">
                                        <span>{{ CityNameByAirportCode($ArrivalCode) }} ({{$ArrivalCode}})</span> 
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <div class="w-50">
                                        <img src="{{ asset('assets/airlines/'.$flightCode.'.png') }}" class="avatar-md" alt="" style="height: 20px; width: 20px; margin-top: 0;">
                                        <span>{{ $airName }}</span>
                                    </div>
                                    <div class="w-50 text-end">
                                        <i class="fas fa-plane font-size-10"></i>
                                        <span><b>{{ $flightCode }} {{ $FlightNumber }}</b></span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <div class="w-33">
                                        <span>({{ $dapartTime }})</span>
                                        <i class="fa fa-plane-departure font-size-10" style="margin-right: 0;"></i>
                                    </div>
                                    <div class="w-33 text-center">
                                        <i class="fa fa-clock font-size-10"></i>
                                        <span>{{ $duration }}</span>
                                    </div>
                                    <div class="w-33 text-end">
                                        <i class="fa fa-plane-arrival font-size-10 mr-0" style="margin-right: 0;"></i>
                                        <span>({{ $arrtivelTime }})</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="w-50">
                                        <i class="fas fa-person-seat"></i>
                                        <span>Cabin</span>
                                    </div>
                                    <div class="w-50 text-end">
                                        <span>{{ $Cabin }}</span>
                                    </div>
                                </div>
                                
                            </div>
                        @endforeach
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
    {{-- ----------------Baggage detail--------------- --}}
    <div class="card mb-2">
        <div class="accordion" id="baggage_detail">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingBaggage">
                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBaggage" aria-expanded="true" aria-controls="collapseBaggage">
                    Baggage Detail
                    </button>
                </h2>
                <div id="collapseBaggage" class="accordion-collapse collapse show" aria-labelledby="headingBaggage" data-bs-parent="#baggage_detail">
                    @foreach ($finaldata['LowFareSearch'] as $fares)
                        @foreach ($fares['Segments'] as $segment)
                            @php
                                $flightCode = $segment['OperatingAirline']['Code'];
                                $FlightNumber = $segment['OperatingAirline']['FlightNumber'];
                                
                                $DepartureCode = $segment['Departure']['LocationCode'];
                                $ArrivalCode = $segment['Arrival']['LocationCode'];

                            @endphp
                            <div class="accordion-body">
                                <div class="modal-baggage bg-soft-primary-2 fill-muted d-flex justify-content-between rounded px-2 pt-2 pb-2 mb-2" style="margin: 0 -10px;">
                                    <div class="flight-fare w-50">
                                        <span>({{ $DepartureCode }} - {{ $ArrivalCode }})</span>
                                    </div>
                                    <div class="flight-fare w-50 text-end">
                                        <img src="{{ asset('assets/airlines/'.$flightCode.'.png') }}" class="avatar-md" alt="" style="height: 20px; width: 20px; margin-top: 0;">
                                        <span><b>{{ $flightCode }} {{ $FlightNumber }}</b></span> 
                                    </div>
                                </div>
                                @foreach ($segment['Baggage'] as $key => $baggage)
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="w-50">
                                            @if ($key == 'ADT')
                                                <i class="fa fa-male" aria-hidden="true"></i>
                                                <span>Adult</span>
                                            @endif
                                            @if ($key == 'CNN')
                                                <i class="fa fa-child" aria-hidden="true"></i>
                                                <span>Child</span>
                                            @endif
                                            @if ($key == 'INF')
                                                <i class="fa fa-baby" aria-hidden="true"></i>
                                                <span>Infant</span>
                                            @endif
                                        </div>
                                        <div class="w-50 text-end">
                                            <span>{{ $baggage['Weight'] }} {{ $baggage['Unit']}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
    {{-- -----------------Price detail--------------- --}}
    <div class="card mb-2">
        <div class="accordion" id="price_detail">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPrice">
                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="true" aria-controls="collapsePrice">
                    Price Summary
                    </button>
                </h2>
                <div id="collapsePrice" class="accordion-collapse collapse show" aria-labelledby="headingPrice" data-bs-parent="#price_detail">
                    <div class="accordion-body">
                        @if(@$finaldata['Fares'])
                            @php
                                $TotalPrice = @$finaldata['Fares']['TotalPrice'];
                                $CurrencyCode = @$finaldata['Fares']['CurrencyCode'];
                                $fareBreakDown = @$finaldata['Fares']['fareBreakDown'];
                                $TotalBase = 0;
                                $TotalTax = 0;
                            @endphp
                            <div class="modal-fares border-0 mb-0">
                                <div class="modal-left mb-4">
                                    <h5 class="mt-0 mb-2">Fare Breakdown</h5>
                                    @foreach ($fareBreakDown as $key => $pass)
                                        <p class="d-flex justify-content-between mb-0" style="font-size: 10px;">
                                            <span>
                                                {{ $CurrencyCode }} {{ number_format($pass['TotalFare'],2) }} for 1 {{ $key }} 
                                            </span>
                                            <span>
                                                ({{ $CurrencyCode }} {{ number_format($pass['TotalFare'] * $pass['Quantity'],2) }} Total)
                                            </span>
                                        </p>
                                    @endforeach
                                </div>
                                <hr style="border-bottom: 1px dashed #8495ab; opacity: .25; background-color:unset;">
                                <div class="modal-left">
                                    @php
                                        
                                    @endphp
                                    @foreach ($fareBreakDown as $key => $pass)
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
                                    
                                    @foreach ($fareBreakDown as $key => $pass)
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
                                    <h5>Total Amount:</h5>
                                    <h5>{{ $CurrencyCode }} <span class="grand_total_span">{{ number_format($TotalPrice,2) }}</span></h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif