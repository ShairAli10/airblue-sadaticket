@extends('front.layouts.app')
@section('styles')

<link rel="stylesheet" href="{{ asset('front-assets/css/account-pages.css') }}">

@endsection

@section('content')

<div class="container-fluid edit-profile-wrapper">
    <div class="row">
        <div class="col-md-4 bg-white">
            @include('front.customer-panel.includes.sidebar')
        </div>
        <div class="col-md-8">
            

            <div class="transaction-title m-lg-4 m-2 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Your Bookings</h5>
            </div>

            <div class="customer-bookings bg-white m-lg-4 m-2">
                @foreach ($bookings as $order)
                    <div class="result-flight-item mb-3 mt-3 flight-confirmation-card">
                        <div class="booked-flight-date f-12px">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="_1MZrIK28AE8HVj289UBgZw st-svg-icon "><g><path d="M20.9062 1.87524H18.75V0.750244C18.75 0.336057 18.4142 0.000244141 18 0.000244141C17.5858 0.000244141 17.25 0.336057 17.25 0.750244V1.87524H6.75V0.750244C6.75 0.336057 6.41423 0.000244141 6 0.000244141C5.58577 0.000244141 5.25 0.336057 5.25 0.750244V1.87524H3.09375C1.38783 1.87524 0 3.26307 0 4.96899V20.9065C0 22.6124 1.38783 24.0002 3.09375 24.0002H20.9062C22.6122 24.0002 24 22.6124 24 20.9065V4.96899C24 3.26307 22.6122 1.87524 20.9062 1.87524ZM22.5 20.9065C22.5 21.7867 21.7865 22.5002 20.9062 22.5002H3.09375C2.21353 22.5002 1.5 21.7867 1.5 20.9065V8.48462C1.5 8.3552 1.60495 8.25024 1.73438 8.25024H22.2656C22.395 8.25024 22.5 8.3552 22.5 8.48462V20.9065Z" fill="black"></path></g><defs><clipPath><rect width="24" height="24" fill="white" transform="translate(0 0.000244141)"></rect></clipPath></defs></svg>
                            @php
                                $dateTime = new DateTime($order->created_at);
                                $create_on = $dateTime->format('l j M, Y');
                            @endphp
                            <span>{{ $create_on }}</span>
                        </div>
                        <div class="flight-item-wrapper">
                            @foreach(json_decode($order->final_data, true)['Flights'] as $offer)
                                @php
                                    $stops = count($offer['Segments']) - 1;
                                @endphp
                                @foreach ($offer['Segments'] as $segKey => $segment)
                                    @php
                                        $originCode = $offer['Segments'][0]['Departure']['LocationCode'];
                                        $destinationCode = $segment['Arrival']['LocationCode'];
                                        $departure_date = date('d M Y', strtotime($offer['Segments'][0]['Departure']['DepartureDateTime']));
                                        $departure_date2 = date('d M', strtotime($offer['Segments'][0]['Departure']['DepartureDateTime']));
                                        $arrival_date = date('d M Y', strtotime($segment['Arrival']['ArrivalDateTime']));
                                        $arrival_date2 = date('d M', strtotime($segment['Arrival']['ArrivalDateTime']));
                                        $dapartTime = date('H:i', strtotime($offer['Segments'][0]['Departure']['DepartureDateTime']));
                                        $arrtivelTime = date('H:i', strtotime($segment['Arrival']['ArrivalDateTime']));
                                        $flightCode = $segment['OperatingAirline']['Code'];

                                        $airName = AirlineNameByAirlineCode($flightCode);
                                        $airName = strlen($airName) > 20 ? substr($airName, 0, 20) . '...' : $airName;
                                        $duration = $segment['Duration'];
                                        $duration = str_replace(['PT', 'H'], ['', 'H '], $duration);

                                        $cabin = $segment['Cabin'];
                                        // ---------------------------------------
                                        $layover = null;
                                        if ($segKey > 0) {
                                            $currentDeparture = new DateTime($segment['Departure']['DepartureDateTime']);
                                            $previousArrival = new DateTime($offer['Segments'][$segKey - 1]['Arrival']['ArrivalDateTime']);
                                            $layover = $currentDeparture->diff($previousArrival)->format('%H:%I');
                                        }
                                    @endphp
                                @endforeach
                                <div class="flight-details">
                                    <div class="flight-brand-info text-center">
                                        <div class="flight-brand-img">
                                            <img src="{{ asset('assets/airlines/' . $flightCode . '.png') }}" />
                                        </div>
                                        <div class="flight-brand-name f-12px">{{ $airName }}</div>
                                    </div>
                                    <div class="flight-details-location align-items-center justify-content-center d-flex flex-column">
                                        <div class="one-time-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                            <span class="flight-details-location-name">
                                                {{ CityNameByAirportCode($originCode) }} ({{ $originCode }})
                                            </span>
                                            <span class="flight-details-location-time f-14px">
                                                {{ $departure_date2 }} {{ $dapartTime }}
                                            </span>
                                        </div>
                                        <div style="display: none !important;" class="return-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                            <span class="flight-details-location-name">
                                                {{ CityNameByAirportCode($originCode) }} ({{ $originCode }})
                                            </span>
                                            <span class="flight-details-location-time f-14px">
                                                {{ $departure_date2 }} {{ $dapartTime }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flight-details-duration ps-3 pe-3 justify-content-center d-flex flex-column align-items-center">
                                        <div class="onetime-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                            <div class="flight-details-duration-badges justify-content-center  gap-1 d-flex flex-row align-items-center">
                                                <span class="flight-details-duration-lowest me-2">
                                                    <span class="low-fare-tag">Lowest fare</span>
                                                </span>
                                                <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">
                                                    @if ($stops <= 1)
                                                        {{ $stops }} Stop
                                                    @else
                                                        {{ $stops }} Stops
                                                    @endif
                                                </span>
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
                                                    <div>{{ $duration }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: none !important;" class="return-flight-duration w-100 d-flex flex-column justify-content-center align-content-center">
                                            <div class="flight-details-duration-badges justify-content-center gap-1 d-flex flex-row align-items-center">
                                                <span class="flight-details-duration-lowest me-2">
                                                    <span class="low-fare-tag">Lowest fare</span>
                                                </span>
                                                <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">
                                                    @if ($stops <= 1)
                                                        {{ $stops }} Stop
                                                    @else
                                                        {{ $stops }} Stops
                                                    @endif
                                                </span>
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
                                                    <div>{{ $duration }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flight-details-location d-flex flex-column align-items-center justify-content-center">
                                        <div class="one-time-flight-info text-center  d-flex flex-column justify-content-center align-items-center">
                                            <span class="flight-details-location-name">
                                                {{ CityNameByAirportCode($destinationCode) }} ({{ $destinationCode }})
                                            </span>
                                            <span class="flight-details-location-time f-14px">
                                                {{ $arrtivelTime }} {{ $arrival_date2 }}
                                            </span>
                                        </div>
                                        <div style="display: none !important;" class="return-flight-info text-center">
                                            <span class="flight-details-location-name">
                                                {{ CityNameByAirportCode($destinationCode) }} ({{ $destinationCode }})
                                            </span>
                                            <span class="flight-details-location-time">
                                                {{ $arrival_date2 }} {{ $arrtivelTime }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flight-book-actions align-items-center d-flex justify-content-center flex-column">
                                        <div class="left-seats f-12px d-none">9 seats left</div>
                                        <button class="green_btn flight-complete-btn">{{ $order->status }}</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                @endforeach

            </div>

        </div>
    </div>
</div>


@endsection
@section('scripts')


@endsection