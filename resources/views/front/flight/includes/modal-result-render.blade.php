<div class="details-content flight-details-content details content-active">
    @foreach ($result['Flights'] as $offer)
        @foreach ($offer['Segments'] as $segKey => $segment)
            @php
                $originCode = $segment['Departure']['LocationCode'];
                $destinationCode = $segment['Arrival']['LocationCode'];
                $departure_date = date('d M Y',strtotime($segment['Departure']['DepartureDateTime']));
                $arrival_date = date('d M Y',strtotime($segment['Arrival']['ArrivalDateTime']));
                $dapartTime = date('H:i', strtotime($segment['Departure']['DepartureDateTime']));
                $arrtivelTime = date('H:i', strtotime($segment['Arrival']['ArrivalDateTime']));
                $flightCode = $segment['OperatingAirline']['Code'];
                $flightNumber = $segment['OperatingAirline']['FlightNumber'];

                $airName = AirlineNameByAirlineCode($flightCode);
                $airName = strlen($airName) > 20 ? substr($airName, 0, 13) . "..." : $airName;
                $duration = $segment['Duration'];
                $duration = str_replace(["PT", "H"], ["", "H "], $duration);

                $Baggage = $offer['Fares'][0]['BaggagePolicy'];
                $cabin = $segment['Cabin'];
                // ---------------------------------------
                $layover = null;
                if ($segKey > 0) {
                    $currentDeparture = new DateTime($segment['Departure']['DepartureDateTime']);
                    $previousArrival = new DateTime($offer['Segments'][$segKey - 1]['Arrival']['ArrivalDateTime']);
                    $layover = $currentDeparture->diff($previousArrival)->format('%H:%I');
                }
            @endphp

            @if($segKey ==0)
                <div class="details-date-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <g clip-path="url(#clip0)">
                            <path d="M25.0391 2.12324H24.1391V0.773241C24.1391 0.524729 23.9376 0.323242 23.6891 0.323242C23.4405 0.323242 23.2391 0.524729 23.2391 0.773241V2.12324H19.6391V0.773241C19.6391 0.524729 19.4376 0.323242 19.1891 0.323242C18.9406 0.323242 18.7391 0.524729 18.7391 0.773241V2.12324H15.1391V0.773241C15.1391 0.524729 14.9376 0.323242 14.6891 0.323242C14.4406 0.323242 14.2391 0.524729 14.2391 0.773241V2.12324H10.6391V0.773241C10.6391 0.524729 10.4376 0.323242 10.1891 0.323242C9.94057 0.323242 9.73908 0.524729 9.73908 0.773241V2.12324H6.13909V0.773241C6.13909 0.524729 5.9376 0.323242 5.68909 0.323242C5.44058 0.323242 5.23909 0.524729 5.23909 0.773241V2.12324H4.33909C3.0971 2.1247 2.09056 3.13124 2.0891 4.37323V15.3775C-0.354227 18.1384 -0.304558 22.3024 2.20385 25.0043C2.32872 25.144 2.46125 25.2766 2.60075 25.4016L2.6048 25.4057H2.6075C5.30867 27.9154 9.47319 27.9662 12.2348 25.5231H25.0391C26.281 25.5217 27.2876 24.5151 27.289 23.2731V4.37318C27.2875 3.13118 26.281 2.1247 25.0391 2.12324ZM11.7899 24.744C9.36761 26.9851 5.628 26.9826 3.20864 24.7383C3.089 24.6309 2.97526 24.517 2.86799 24.3972C0.500097 21.8378 0.655346 17.8433 3.21477 15.4754C5.7742 13.1074 9.76873 13.2627 12.1367 15.8222C14.5046 18.3816 14.3494 22.3761 11.7899 24.744ZM26.389 23.2732C26.389 24.0188 25.7846 24.6232 25.0391 24.6232H13.1051C13.16 24.5552 13.2081 24.4828 13.2599 24.413C13.3116 24.3433 13.3562 24.2861 13.4016 24.2204C13.502 24.076 13.5956 23.927 13.6847 23.7754C13.7108 23.7304 13.74 23.6894 13.7648 23.6449C13.8758 23.4475 13.977 23.2451 14.0685 23.0378C14.0919 22.9852 14.1108 22.9307 14.1329 22.8776C14.1981 22.721 14.2593 22.5626 14.3129 22.402C14.3385 22.3264 14.3606 22.2499 14.3831 22.1734C14.4281 22.0289 14.4654 21.8831 14.4992 21.736C14.5176 21.6554 14.5356 21.5753 14.5518 21.4939C14.5815 21.34 14.6054 21.1843 14.6252 21.0277C14.6342 20.9557 14.6459 20.8841 14.6531 20.8117C14.6751 20.5835 14.6891 20.354 14.6891 20.1232C14.6843 16.1487 11.4636 12.9279 7.48909 12.9232C7.25824 12.9232 7.02874 12.9372 6.80059 12.9592C6.72814 12.9664 6.65659 12.9781 6.58414 12.9871C6.42799 13.0074 6.27274 13.0321 6.11839 13.0605C6.03694 13.0767 5.95639 13.0947 5.87584 13.1131C5.72914 13.147 5.58407 13.1856 5.44069 13.2288C5.36329 13.2517 5.28589 13.2738 5.20939 13.2994C5.05144 13.3525 4.89439 13.4128 4.74229 13.4763C4.68559 13.4997 4.62844 13.5213 4.57264 13.5442C4.36744 13.6342 4.16764 13.7355 3.97055 13.8457C3.9206 13.8736 3.87335 13.906 3.82385 13.9357C3.6785 14.0221 3.5354 14.1117 3.3959 14.2057C3.32705 14.2534 3.2609 14.3047 3.1934 14.3547C3.1259 14.4046 3.05525 14.4532 2.9891 14.5072V7.52323H26.389V23.2732ZM26.389 6.62323H2.9891V4.37323C2.9891 3.62764 3.5935 3.02324 4.33909 3.02324H5.23909V4.37323C5.23909 4.62175 5.44058 4.82323 5.68909 4.82323C5.9376 4.82323 6.13909 4.62175 6.13909 4.37323V3.02324H9.73908V4.37323C9.73908 4.62175 9.94057 4.82323 10.1891 4.82323C10.4376 4.82323 10.6391 4.62175 10.6391 4.37323V3.02324H14.2391V4.37323C14.2391 4.62175 14.4406 4.82323 14.6891 4.82323C14.9376 4.82323 15.1391 4.62175 15.1391 4.37323V3.02324H18.7391V4.37323C18.7391 4.62175 18.9406 4.82323 19.1891 4.82323C19.4376 4.82323 19.6391 4.62175 19.6391 4.37323V3.02324H23.2391V4.37323C23.2391 4.62175 23.4405 4.82323 23.6891 4.82323C23.9376 4.82323 24.1391 4.62175 24.1391 4.37323V3.02324H25.0391C25.7846 3.02324 26.389 3.62764 26.389 4.37323V6.62323Z" fill="#555555"/>
                            <path d="M7.48886 15.1729C7.24035 15.1729 7.03886 15.3743 7.03886 15.6229V19.6728H4.78887C4.54035 19.6728 4.33887 19.8743 4.33887 20.1228C4.33887 20.3714 4.54035 20.5728 4.78887 20.5728H7.48886C7.73737 20.5728 7.93886 20.3714 7.93886 20.1228V15.6229C7.93886 15.3743 7.73737 15.1729 7.48886 15.1729Z" fill="#555555"/>
                        </g>
                        <defs>
                            <clipPath id="clip0">
                                <rect width="27" height="27" fill="white" transform="translate(0.289062 0.322266)"/>
                            </clipPath>
                        </defs>
                    </svg>
                    <div>
                        <p>{{ $departure_date }}</p>
                        <p>{{ $dapartTime }}</p>
                    </div>
                </div>
            @endif
            @if ($layover)
                <div class="flight-details-transit-info layour">
                    
                    <div class="flight-details-transit-airport">
                        <div class="flight-details-msg-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none">
                                <g clip-path="url(#clip0)">
                                    <path d="M9.26756 0C4.58076 0 0.767578 3.58888 0.767578 7.99998C0.767578 12.4111 4.58076 16 9.26756 16C13.9544 16 17.7675 12.4111 17.7675 7.99998C17.7675 3.58888 13.9544 0 9.26756 0ZM9.26756 15.3043C4.988 15.3043 1.5067 12.0278 1.5067 7.99998C1.5067 3.97216 4.988 0.695641 9.26756 0.695641C13.5471 0.695641 17.0284 3.97216 17.0284 7.99998C17.0284 12.0278 13.5471 15.3043 9.26756 15.3043Z" fill="black"/>
                                    <path d="M12.8548 10.8848L9.63661 7.85594V2.43475C9.63661 2.24275 9.47104 2.08691 9.26704 2.08691C9.06304 2.08691 8.89746 2.24275 8.89746 2.43475V7.99997C8.89746 8.09248 8.93665 8.18085 9.00539 8.24623L12.3315 11.3767C12.4039 11.4441 12.4985 11.4782 12.5931 11.4782C12.6877 11.4782 12.7823 11.4442 12.8548 11.3767C12.9989 11.241 12.9989 11.0205 12.8548 10.8848Z" fill="black"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect x="0.767578" width="17" height="16" rx="5" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            @php
                                list($hours, $minutes) = explode(':', $layover);
                                $hours = (int) $hours;
                                $minutes = (int) $minutes;
                            @endphp
                            {{ $hours.' Hours '.$minutes.' Minutes' }} layover 
                            - {{ AirportByCode($originCode) }} ({{ $originCode }})
                        </div>
                    </div>
                </div>
            @endif
            <div class="details-flight-step">
                <img src="{{asset('assets/airlines/'.$flightCode.'.png')}}" alt="J9">
                <ul>
                    <li class="flight-details-location">
                        <strong>{{ $dapartTime }}</strong>
                        <strong>{{ CityNameByAirportCode($originCode) }}</strong> 
                        {{ AirportByCode($originCode) }} ({{ $originCode }})
                    </li>
                    <li class="flight-details-travel-time">
                        <p>{{ $airName }}</p>
                        <p>Travel time: <strong>{{ $duration }}</strong></p>
                    </li>
                    <li class="flight-details-location">
                        <strong>{{ $arrtivelTime }}</strong>
                        <strong>{{ CityNameByAirportCode($destinationCode) }}</strong> 
                        {{ AirportByCode($destinationCode) }} ({{ $destinationCode }})
                    </li>
                </ul>
                <div class="flight-details_luggage-info">
                    <p>Flight no: <strong>{{ $flightNumber }}</strong></p>
                    <p>Cabin: <strong>{{ $cabin }}</strong></p>
                </div>
            </div>
            
            @if ($segKey == array_key_last($offer['Segments']))
                <div class="details-date-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 0C7.34756 0 3.5625 3.78506 3.5625 8.4375C3.5625 10.0094 3.99792 11.5434 4.82198 12.8743L11.5197 23.6676C11.648 23.8744 11.874 24 12.1171 24C12.119 24 12.1208 24 12.1227 24C12.3679 23.9981 12.5944 23.8686 12.7204 23.6582L19.2474 12.7603C20.026 11.4576 20.4375 9.96277 20.4375 8.4375C20.4375 3.78506 16.6524 0 12 0ZM18.0406 12.0383L12.1065 21.9462L6.0172 12.1334C5.33128 11.0257 4.95938 9.74766 4.95938 8.4375C4.95938 4.56047 8.12297 1.39687 12 1.39687C15.877 1.39687 19.0359 4.56047 19.0359 8.4375C19.0359 9.7088 18.6885 10.9541 18.0406 12.0383Z" fill="#555555"/>
                        <path d="M12 4.21875C9.67378 4.21875 7.78125 6.11128 7.78125 8.4375C7.78125 10.7489 9.64298 12.6562 12 12.6562C14.3861 12.6562 16.2188 10.7235 16.2188 8.4375C16.2188 6.11128 14.3262 4.21875 12 4.21875ZM12 11.2594C10.4411 11.2594 9.17813 9.9922 9.17813 8.4375C9.17813 6.88669 10.4492 5.61563 12 5.61563C13.5508 5.61563 14.8172 6.88669 14.8172 8.4375C14.8172 9.96952 13.5836 11.2594 12 11.2594Z" fill="#555555"/>
                    </svg>
                    <div>
                        <p>{{ $arrival_date }}</p>
                        <p>{{ $arrtivelTime }}</p>
                    </div>
                </div>

                <div class="flight-details-arrive-destination">
                    <label>Arrive at destination</label>
                    <p class="m-0">{{ CityNameByAirportCode($destinationCode) }}</p>
                </div>
            @endif

        @endforeach
    @endforeach
</div>


<div class="details-content flight-baggage-content baggage">
    @foreach ($result['Flights'] as $offer)
        @foreach ($offer['Segments'] as $segment)
            @php
                $departure_date = date('l, j F Y', strtotime($segment['Departure']['DepartureDateTime']));
                // $arrival_date = date('l, j F Y',strtotime($segment['Arrival']['ArrivalDateTime']));
                $flightCode = $segment['OperatingAirline']['Code'];
            @endphp
            <div class="content-header d-flex justify-content-between align-items-center">
                <span>Flight from {{ CityNameByAirportCode($originCode) }} ({{ $originCode}}) to {{ CityNameByAirportCode($destinationCode) }} ({{ $destinationCode }}) on {{ $departure_date }}</span>
                {{-- <span class="stop-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M6.66 0C2.98 0 0 2.98667 0 6.66667C0 10.3467 2.98 13.3333 6.66 13.3333C10.3467 13.3333 13.3333 10.3467 13.3333 6.66667C13.3333 2.98667 10.3467 0 6.66 0ZM6.66667 12C3.72 12 1.33333 9.61333 1.33333 6.66667C1.33333 3.72 3.72 1.33333 6.66667 1.33333C9.61333 1.33333 12 3.72 12 6.66667C12 9.61333 9.61333 12 6.66667 12ZM7 3.33333H6V7.33333L9.5 9.43333L10 8.61333L7 6.83333V3.33333Z" fill="#333333"></path>
                    </svg>
                    {{ count($offer['Segments']) }} Stop
                </span> --}}
            </div>
            <div class="details-content-inner d-flex justify-content-between align-items-center mb-4">
                <div class="flight-brand-info text-center">
                    <div class="flight-brand-img">
                        <img src="{{asset('assets/airlines/'.$flightCode.'.png')}}"/>
                    </div>
                    <div class="flight-brand-name f-12px">{{ $airName }}</div>
                </div>
                <div class="flight-baggage-info">
                    @foreach ($offer['Fares'][0]['BaggagePolicy'] as $key => $pass)
                        <div class="check-in-baggage f-14px"><span class="font-500">Check-in: </span>{{ $pass['PaxType'] }}: {{ $pass['Weight']}} {{ $pass['Unit']}} </div>
                    @endforeach
                </div>
                <div class="flight-baggage-charges text-center">
                    <div class="flight-baggage-text carry-on-charges f-14px font-500">Free</div>
                </div>
            </div>
        @endforeach
    @endforeach

</div>

<div class="details-content flight-fare-content fare">
    <div class="details-content-inner">
        <div class="content-header d-flex justify-content-between align-items-center">
            <span class="font-500">Fare Details</span>
            <span class="refund-info">
                Non-Refundable
            </span>
        </div>
        @if(@$result['Fares'])
            @php
                $CurrencyCode = @$result['Fares']['CurrencyCode'];
                $fareBreakDown = @$result['Fares']['fareBreakDown'];
                $TotalPrice = @$result['Fares']['TotalPrice'];
                $TotalBase = 0;
                $TotalTax = 0;
                foreach ($result['Fares']['fareBreakDown'] as $key => $pass){
                    $baseFare = (int) $pass['BaseFare'] * (int) $pass['Quantity'];
                    $TotalBase += $baseFare;
                    $taxFare = (int) $pass['TotalTax'] * (int) $pass['Quantity'];
                    $TotalTax += $taxFare;
                }
            @endphp
            <div class="fare-details-inner">
                <div class="base-fare font-500">Base Fare: <span>{{ $CurrencyCode }} {{ number_format($TotalBase,2) }}</span></div>
                <div class="fare-tax-fee font-500">Taxes & Fees : <span>{{ $CurrencyCode }} {{ number_format($TotalTax,2) }}</span></div>
                <div class="total-fare-value font-500">Total (incl. VAT): <span>{{  $CurrencyCode }} {{ number_format((int)$TotalPrice,2) }}</span></div>
            </div>
        @endif
    </div>
</div>