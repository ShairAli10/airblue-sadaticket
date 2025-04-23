<div id="desktop-view">
@foreach ($results['msg'] as $flight)
    @php
        $totalPrice = $flight['Flights'][0]['Fares'][0]['TotalFare'];
        $airCode = $flight['MarketingAirline']['Airline'];
        $airName = AirlineNameByAirlineCode($airCode);
        $airName = strlen($airName) > 15 ? substr($airName, 0, 20) . "..." : $airName;
        $departLeg = head(head($flight['Flights'])['Segments']);
        $TotalDuration = $flight['Flights'][0]['TotalDuration'];
        
        $departureTime = strtotime($departLeg['Departure']['DepartureDateTime']);

    @endphp
    <div class="result-flight-item mb-3 return-result-flight-item" 
        data-price="{{ $totalPrice }}" 
        data-depart="{{(int)$departureTime}}" 
        data-airline="{{ $airCode }}" 
        data-api="{{ $flight['api'] }}" 
        data-key="{{ $flight['itn_ref_key'] }}">
        
        <div class="flight-item-wrapper return-flight-item-wrapper">
            @foreach ($flight['Flights'] as $key => $item)
                @if ($key == 0)
                    @php
                        $departStops = count($item['Segments']) - 1;
                        $origin = head($item['Segments'])['Departure']['LocationCode'];
                        // $departureTime = strtotime(head($item['Segments'])['Departure']['DepartureDateTime']);
                        $departureDateTime = head($item['Segments'])['Departure']['DepartureDateTime'];
                        $dapartTime = date('H:i', strtotime($departureDateTime));
                        $totalDuration = $item['TotalDuration'];
                        // $totalDuration = str_replace(["Hours", "Minutes"], ["H", "M"], $totalDuration);

                        $destination = '';
                        $arrivalDateTime = '';
                        foreach ($item['Segments'] as $key => $seg) {
                            $destination = $seg['Arrival']['LocationCode'];
                            $arrivalDateTime = $seg['Arrival']['ArrivalDateTime'];
                            $arrivalTime = date('H:i', strtotime($arrivalDateTime));
                        }
                    @endphp
                    <div class="flight-details flight-details-onetime">
                        <div class="flight-brand-info text-center">
                            <div class="flight-brand-img">
                                <img src="{{asset('assets/airlines/'.$airCode.'.png')}}"/>
                            </div>
                            <div class="flight-brand-name f-12px">{{ $airName }}</div>
                        </div>
                        <div class="flight-details-location align-items-center justify-content-center d-flex flex-column">
                            <div class="one-time-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                <span class="flight-details-location-name">{{ CityNameByAirportCode($origin) }} ({{ $origin }})</span>
                                <span class="flight-details-location-time f-14px">{{ date('d M',strtotime($departureDateTime)) }}, {{ $dapartTime }}</span>
                            </div>
                        </div>
                        <div class="flight-details-duration ps-3 pe-3 justify-content-center d-flex flex-column align-items-center">
                            <div class="onetime-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                <div class="flight-details-duration-badges justify-content-center  gap-1 d-flex flex-row align-items-center">
                                    <span class="flight-details-duration-lowest me-2">
                                        <span class="low-fare-tag">Lowest fare</span>
                                    </span>
                                    <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">{{ $departStops }} stop</span>
                                </div>
                                <div class="flight-details-duration-widget d-flex align-items-center gap-1 w-100">
                                    <span class="flight-details-duration-flight-icon"> 
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                            <path d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z"></path>
                                        </svg>	
                                    </span>
                                    <div class="seprator"></div>
                                    <span class="flight-details-duration-flight-icon"> 
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                            <path d="M24.012 20h-20v-2h20v2zm-2.347-5.217c-.819 1.083-2.444 1.284-3.803 1.2-1.142-.072-10.761-1.822-11.186-1.939-1.917-.533-3.314-1.351-4.276-2.248-.994-.927-1.557-1.902-1.676-2.798l-.724-4.998 3.952.782 2.048 2.763 1.886.386-1.344-4.931 4.667 1.095 4.44 5.393 2.162.51c1.189.272 2.216.653 3.181 1.571.957.911 1.49 2.136.673 3.214zm-3.498-2.622c-.436-.15-3.221-.781-3.717-.892l-4.45-5.409-.682-.164 1.481 4.856-5.756-1.193-2.054-2.773-.772-.19.486 2.299c.403 1.712 2.995 3.155 4.575 3.439 1.06.192 8.89 1.612 9.959 1.773.735.105 2.277.214 2.805-.302l.003-.002c-.268-.652-1.214-1.213-1.878-1.442z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="flight-details-duration-hours justify-content-center gap-1 align-items-center d-flex flex-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
                                    </svg>
                                    <div class="hour d-flex f-12px flex-nowrap">
                                        @php
                                            $hours = floor($TotalDuration / 60);
                                            $minutes = $TotalDuration % 60;
                                        @endphp
                                        <div>{{ $hours }}H {{ $minutes }}M</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flight-details-location d-flex flex-column align-items-center justify-content-center">
                            <div class="one-time-flight-info text-center  d-flex flex-column justify-content-center align-items-center">
                                <span class="flight-details-location-name">({{ $destination }}) {{ CityNameByAirportCode($destination) }}</span>
                                <span class="flight-details-location-time d-inline-block f-14px">{{ $arrivalTime }}, {{ date('d M',strtotime($arrivalDateTime)) }}</span>
                            </div>
                        </div>
                    </div>
                @elseif ($key == 1)
                    <hr>
                    @php
                        $departStops = count($item['Segments']) - 1;
                        $origin = head($item['Segments'])['Departure']['LocationCode'];
                        // $departureTime = strtotime(head($item['Segments'])['Departure']['DepartureDateTime']);
                        $departureDateTime = head($item['Segments'])['Departure']['DepartureDateTime'];
                        $dapartTime = date('H:i', strtotime($departureDateTime));
                        $totalDuration = $item['TotalDuration'];
                        $totalDuration = str_replace(["Hours", "Minutes"], ["H", "M"], $totalDuration);

                        $destination = '';
                        $arrivalDateTime = '';
                        foreach ($item['Segments'] as $key => $seg) {
                            $destination = $seg['Arrival']['LocationCode'];
                            $arrivalDateTime = $seg['Arrival']['ArrivalDateTime'];
                            $arrivalTime = date('H:i', strtotime($arrivalDateTime));
                        }
                    @endphp
                    <div class="flight-details flight-details-returns">
                        <div class="flight-brand-info text-center">
                            <div class="flight-brand-img">
                                <img src="{{asset('assets/airlines/'.$airCode.'.png')}}"/>
                            </div>
                            <div class="flight-brand-name f-12px">{{ $airName }}</div>
                        </div>
                        <div class="flight-details-location align-items-center justify-content-center d-flex flex-column">
                            <div class="return-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                <span class="flight-details-location-name">({{ $origin }}) {{ CityNameByAirportCode($origin) }}</span>
                                <span class="flight-details-location-time f-14px">{{ $dapartTime }}, {{ date('d M',strtotime($departureDateTime)) }}</span>
                            </div>
                        </div>
                        <div class="flight-details-duration ps-3 pe-3 justify-content-center d-flex flex-column align-items-center">
                            <div class="return-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                <div class="flight-details-duration-badges justify-content-center gap-1 d-flex flex-row align-items-center">
                                    <span class="flight-details-duration-lowest me-2">
                                        <span class="low-fare-tag">Lowest fare</span>
                                    </span>
                                    <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">{{ $departStops }} stop</span>
                                </div>
                                <div class="flight-details-duration-widget d-flex align-items-center gap-1 w-100">
                                    <span class="flight-details-duration-flight-icon">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                            <path d="M24.012 20h-20v-2h20v2zm-2.347-5.217c-.819 1.083-2.444 1.284-3.803 1.2-1.142-.072-10.761-1.822-11.186-1.939-1.917-.533-3.314-1.351-4.276-2.248-.994-.927-1.557-1.902-1.676-2.798l-.724-4.998 3.952.782 2.048 2.763 1.886.386-1.344-4.931 4.667 1.095 4.44 5.393 2.162.51c1.189.272 2.216.653 3.181 1.571.957.911 1.49 2.136.673 3.214zm-3.498-2.622c-.436-.15-3.221-.781-3.717-.892l-4.45-5.409-.682-.164 1.481 4.856-5.756-1.193-2.054-2.773-.772-.19.486 2.299c.403 1.712 2.995 3.155 4.575 3.439 1.06.192 8.89 1.612 9.959 1.773.735.105 2.277.214 2.805-.302l.003-.002c-.268-.652-1.214-1.213-1.878-1.442z"/>
                                        </svg> 
                                        
                                    </span>
                                    <div class="seprator"></div>
                                    <span class="flight-details-duration-flight-icon"> 
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                            <path d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z"></path>
                                        </svg>	
                                    </span>
                                </div>
                                <div class="flight-details-duration-hours justify-content-center gap-1 align-items-center d-flex flex-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
                                    </svg>
                                    <div class="hour d-flex f-12px flex-nowrap">
                                        <div>{{ $totalDuration }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flight-details-location d-flex flex-column align-items-center justify-content-center">
                            <div class="return-flight-info text-center">
                                <span class="flight-details-location-name">{{ CityNameByAirportCode($destination) }} ({{ $destination }})</span>
                                <span class="flight-details-location-time d-inline-block f-14px">{{ date('d M',strtotime($arrivalDateTime)) }}, {{ $arrivalTime }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="flight-book-actions align-items-center d-flex justify-content-center flex-column">
            <form action="{{ route('checkout') }}">
                <input type="hidden" name="reference" value="{{ $flight['itn_ref_key'] }}">
                <button class="green_btn">PKR {{ number_format(intval($totalPrice), 0, '', ',') }}</button>
            </form>
            <span class="f-12px flight-details-popup-trigger" onclick="flightModal('{{ $flight['itn_ref_key'] }}')">Details</span>
        </div>
        
    </div>

@endforeach
</div>
{{-- ========================Mobile view========================= --}}
<div id="mobile-view">
    @foreach ($results['msg'] as $flight)
        @php
            $totalPrice = $flight['Flights'][0]['Fares'][0]['TotalFare'];
            $airCode = $flight['MarketingAirline']['Airline'];
            $airName = AirlineNameByAirlineCode($airCode);
            $airName = strlen($airName) > 15 ? substr($airName, 0, 20) . "..." : $airName;
            $departLeg = head(head($flight['Flights'])['Segments']);
            $departureTime = strtotime($departLeg['Departure']['DepartureDateTime']);
        @endphp
        <div class="result-flight-item mb-3" 
            data-price="{{ $totalPrice }}" 
            data-depart="{{(int)$departureTime}}" 
            data-airline="{{ $airCode }}" 
            data-api="{{ $flight['api'] }}" 
            data-key="{{ $flight['itn_ref_key'] }}">
        
            <div class="flight-item-wrapper">
                @foreach ($flight['Flights'] as $key => $item)
                    @if ($key == 0)
                        @php
                            $departStops = count($item['Segments']) - 1;
                            $origin = head($item['Segments'])['Departure']['LocationCode'];
                            // $departureTime = strtotime(head($item['Segments'])['Departure']['DepartureDateTime']);
                            $departureDateTime = head($item['Segments'])['Departure']['DepartureDateTime'];
                            $dapartTime = date('H:i', strtotime($departureDateTime));
                            $totalDuration = $item['TotalDuration'];
                            // $totalDuration = str_replace(["Hours", "Minutes"], ["H", "M"], $totalDuration);

                            $destination = '';
                            $arrivalDateTime = '';
                            foreach ($item['Segments'] as $key => $seg) {
                                $destination = $seg['Arrival']['LocationCode'];
                                $arrivalDateTime = $seg['Arrival']['ArrivalDateTime'];
                                $arrivalTime = date('H:i', strtotime($arrivalDateTime));
                            }
                        @endphp
                        <div class="flight-details">
                            <div class="flight-brand-info text-center">
                                <div class="flight-brand-img">
                                    <img src="{{asset('assets/airlines/'.$airCode.'.png')}}"/>
                                </div>
                                <div class="flight-brand-name f-12px">{{ $airName }}</div>
                            </div>
                            <div class="flight-details-location align-items-center justify-content-center d-flex flex-column">
                                <div class="one-time-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                    <span class="flight-details-location-name">{{ CityNameByAirportCode($origin) }} ({{ $origin }})</span>
                                    <span class="flight-details-location-time f-14px">{{ date('d M',strtotime($departureDateTime)) }} {{ $dapartTime }}</span>
                                </div>
                                <div style="display: none !important;" class="return-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                    <span class="flight-details-location-name">{{ CityNameByAirportCode($origin) }} ({{ $origin }})</span>
                                    <span class="flight-details-location-time f-14px">{{ date('d M',strtotime($departureDateTime)) }} {{ $dapartTime }}</span>
                                </div>
                            </div>
                            <div class="flight-details-duration ps-3 pe-3 justify-content-center d-flex flex-column align-items-center">
                                
                                <div class="onetime-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                    <div class="flight-details-duration-badges justify-content-center  gap-1 d-flex flex-row align-items-center">
                                        <span class="flight-details-duration-lowest me-2">
                                            <span class="low-fare-tag">Lowest fare</span>
                                        </span>
                                        <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">{{ $departStops }} stop</span>
                                    </div>
                                    <div class="flight-details-duration-widget d-flex align-items-center gap-1 w-100">
                                        <span class="flight-details-duration-flight-icon"> 
                                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                                <path d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z"></path>
                                            </svg>	
                                        </span>
                                        <div class="seprator"></div>
                                        <span class="flight-details-duration-flight-icon"> 
                                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                                <path d="M24.012 20h-20v-2h20v2zm-2.347-5.217c-.819 1.083-2.444 1.284-3.803 1.2-1.142-.072-10.761-1.822-11.186-1.939-1.917-.533-3.314-1.351-4.276-2.248-.994-.927-1.557-1.902-1.676-2.798l-.724-4.998 3.952.782 2.048 2.763 1.886.386-1.344-4.931 4.667 1.095 4.44 5.393 2.162.51c1.189.272 2.216.653 3.181 1.571.957.911 1.49 2.136.673 3.214zm-3.498-2.622c-.436-.15-3.221-.781-3.717-.892l-4.45-5.409-.682-.164 1.481 4.856-5.756-1.193-2.054-2.773-.772-.19.486 2.299c.403 1.712 2.995 3.155 4.575 3.439 1.06.192 8.89 1.612 9.959 1.773.735.105 2.277.214 2.805-.302l.003-.002c-.268-.652-1.214-1.213-1.878-1.442z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flight-details-duration-hours justify-content-center gap-1 align-items-center d-flex flex-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
                                        </svg>
                                    <div class="hour d-flex f-12px flex-nowrap">
                                        <div>{{ $totalDuration }}</div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flight-details-location d-flex flex-column align-items-center justify-content-center">
                                <div class="one-time-flight-info text-center  d-flex flex-column justify-content-center align-items-center">
                                    <span class="flight-details-location-name">({{ $destination }}) {{ CityNameByAirportCode($destination) }}</span>
                                    <span class="flight-details-location-time f-14px">
                                        {{ $arrivalTime }}, {{ date('d M',strtotime($arrivalDateTime)) }}
                                    </span>
                                </div>
                                <div style="display: none !important;" class="return-flight-info text-center">
                                    <span class="flight-details-location-name">({{ $destination }}) {{ CityNameByAirportCode($destination) }}</span>
                                    <span class="flight-details-location-time">
                                        {{ $arrivalTime }}, {{ date('d M',strtotime($arrivalDateTime)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @elseif ($key == 1)
                        <hr>
                        @php
                            $returnStops = count($item['Segments']) - 1;
                            $origin = head($item['Segments'])['Departure']['LocationCode'];
                            // $departureTime = strtotime(head($item['Segments'])['Departure']['DepartureDateTime']);
                            $departureDateTime = head($item['Segments'])['Departure']['DepartureDateTime'];
                            $dapartTime = date('H:i', strtotime($departureDateTime));
                            $totalDuration = $item['TotalDuration'];
                            $totalDuration = str_replace(["Hours", "Minutes"], ["H", "M"], $totalDuration);

                            $destination = '';
                            $arrivalDateTime = '';
                            foreach ($item['Segments'] as $key => $seg) {
                                $destination = $seg['Arrival']['LocationCode'];
                                $arrivalDateTime = $seg['Arrival']['ArrivalDateTime'];
                                $arrivalTime = date('H:i', strtotime($arrivalDateTime));
                            }
                        @endphp
                        <div class="flight-details">
                            <div class="flight-brand-info text-center">
                                <div class="flight-brand-img">
                                    <img src="{{asset('assets/airlines/'.$airCode.'.png')}}"/>
                                </div>
                                <div class="flight-brand-name f-12px">{{ $airName }}</div>
                            </div>
                            <div class="flight-details-location align-items-center justify-content-center d-flex flex-column">
                                <div class="one-time-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                    <span class="flight-details-location-name">{{ CityNameByAirportCode($origin) }} ({{ $origin }})</span>
                                    <span class="flight-details-location-time f-14px">{{ date('d M',strtotime($departureDateTime)) }} {{ $dapartTime }}</span>
                                </div>
                                <div style="display: none !important;" class="return-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                    <span class="flight-details-location-name">{{ CityNameByAirportCode($origin) }} ({{ $origin }})</span>
                                    <span class="flight-details-location-time f-14px">{{ date('d M',strtotime($departureDateTime)) }} {{ $dapartTime }}</span>
                                </div>
                            </div>
                            <div class="flight-details-duration ps-3 pe-3 justify-content-center d-flex flex-column align-items-center">
                                
                                <div class="onetime-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                    <div class="flight-details-duration-badges justify-content-center  gap-1 d-flex flex-row align-items-center">
                                        <span class="flight-details-duration-lowest me-2">
                                            <span class="low-fare-tag">Lowest fare</span>
                                        </span>
                                        <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">{{ $returnStops }} stop</span>
                                        {{-- <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">{{ $stops }} stop at JED</span> --}}
                                    </div>
                                    <div class="flight-details-duration-widget d-flex align-items-center gap-1 w-100">
                                        <span class="flight-details-duration-flight-icon"> 
                                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                                <path d="M20.012 18v2h-20v-2h20zm3.973-13.118c.154 1.349-.884 2.615-1.927 3.491-.877.735-9.051 6.099-9.44 6.307-1.756.936-3.332 1.306-4.646 1.32-1.36.014-2.439-.354-3.144-.872l-4.784-3.977 3.742-2.373 4.203 1.445.984-.578-4.973-3.645 3.678-2.124 7.992 1.545c.744-.445 1.482-.9 2.225-1.348 1.049-.623 2.056-1.055 3.387-1.055 1.321 0 2.552.52 2.703 1.864zm-4.341.512c-.419.192-3.179 1.882-3.615 2.144l-8.01-1.55-.418.241 5.288 3.307-4.683 2.876-4.214-1.448-.69.395c.917.729 1.787 1.522 2.751 2.186 1.472.962 4.344.22 5.685-.663.9-.592 7.551-4.961 8.436-5.582.605-.431 1.797-1.414 1.824-2.152l.001-.004c-.644-.287-1.716-.041-2.355.25z"></path>
                                            </svg>	
                                        </span>
                                        <div class="seprator"></div>
                                        <span class="flight-details-duration-flight-icon"> 
                                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                                <path d="M24.012 20h-20v-2h20v2zm-2.347-5.217c-.819 1.083-2.444 1.284-3.803 1.2-1.142-.072-10.761-1.822-11.186-1.939-1.917-.533-3.314-1.351-4.276-2.248-.994-.927-1.557-1.902-1.676-2.798l-.724-4.998 3.952.782 2.048 2.763 1.886.386-1.344-4.931 4.667 1.095 4.44 5.393 2.162.51c1.189.272 2.216.653 3.181 1.571.957.911 1.49 2.136.673 3.214zm-3.498-2.622c-.436-.15-3.221-.781-3.717-.892l-4.45-5.409-.682-.164 1.481 4.856-5.756-1.193-2.054-2.773-.772-.19.486 2.299c.403 1.712 2.995 3.155 4.575 3.439 1.06.192 8.89 1.612 9.959 1.773.735.105 2.277.214 2.805-.302l.003-.002c-.268-.652-1.214-1.213-1.878-1.442z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flight-details-duration-hours justify-content-center gap-1 align-items-center d-flex flex-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
                                        </svg>
                                        <div class="hour d-flex f-12px flex-nowrap">
                                            @php
                                                $hours = floor($TotalDuration / 60);
                                                $minutes = $TotalDuration % 60;
                                            @endphp
                                            <div>{{ $hours }}H {{ $minutes }}M</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flight-details-location d-flex flex-column align-items-center justify-content-center">
                                <div class="one-time-flight-info text-center  d-flex flex-column justify-content-center align-items-center">
                                    <span class="flight-details-location-name">{{ CityNameByAirportCode($destination) }} ({{ $destination }})</span>
                                    <span class="flight-details-location-time f-14px">
                                        {{ date('d M',strtotime($arrivalDateTime)) }}, {{ $arrivalTime }}
                                    </span>
                                </div>
                                <div style="display: none !important;" class="return-flight-info text-center">
                                    <span class="flight-details-location-name">{{ CityNameByAirportCode($destination) }} ({{ $destination }})</span>
                                    <span class="flight-details-location-time">{{ date('d M',strtotime($arrivalDateTime)) }}, {{ $arrivalTime }}</span>
                                </div>
                            </div>
                            <div class="flight-book-actions align-items-center d-flex justify-content-center flex-column">
                                {{-- <div class="left-seats f-12px">9 seats left</div> --}}
                                <form action="{{ route('checkout') }}">
                                    <input type="hidden" name="reference" value="{{ $flight['itn_ref_key'] }}">
                                    <button class="green_btn">PKR {{ $totalPrice }}</button>
                                </form>
                                <span class="f-12px flight-details-popup-trigger" onclick="flightModal('{{ $flight['itn_ref_key'] }}')">Details</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(function() {
        if ($(window).width() < 768) {
            $('#mobile-view').show();
            $('#desktop-view').hide();
        } else {
            $('#mobile-view').hide();
            $('#desktop-view').show();
        }
    });
</script>