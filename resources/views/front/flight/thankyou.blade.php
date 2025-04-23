@extends('front.layouts.app')
@section('styles')
<style>
    .container-small{
        position: relative;
    }
    .tick-icon svg{
        width: 60px;
        height: 60px;
        fill: #40C84F;
    }
    .anim-img-holder{
        position: relative;
    }
    .anim-image{
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
    }
    .order-id{
        display: inline-block;
        min-width: 250px;
    }
    .flight-selected-payment-method{
        border-top: 1px solid #e8e8e8;
    }
    .imp-infor{
        background: #fffbe6;
        border: 1px solid #ffe58f;
        border-radius: 11px;
    }
</style>
@endsection

@section('content')
@php
    $customerData = json_decode($order->customer_data,true);
@endphp
<div class="flight-thankyou-step container-small mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex gap-2 align-items-center justify-content-start pb-4 pt-4">
                <div class="tick-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
                </div>
                <div class="thanks-user">
                    <h4 class="mb-0">Thank you, <span>{{$customerData['first_name']}} {{$customerData['last_name']}}</span></h4>
                    <p class="mb-0 f-14px">You're one step away from traveling to dubai.</p>
                </div>
            </div>
            {{-- <div class="order-id bg-white p-2 pe-5">Order ID #2749375</div> --}}
        </div>



            <div class="col-lg-7 flight-confimation-wrapper mb-5 mt-5">
                <div class="flight-confimation-header mb-3">
                    <h5 class="confimation-title">
                        Payment Procedure
                    </h5>
                </div>
                <div class="flight-book-contact-details p-4 bg-white mb-3">
                    <ul class="mb-0">
                        <li class="list--item">For make payment please contact 03 111 222 427.</li>
                        <li class="list--item">You will receive your Eticket once you have made the payment.</li>
                        <li class="list--item">If you have made the payment and have not received the Eticket please call us at 03 111 222 427.</li>
                    </ul>
                </div>
                {{-- <div class="flight-confimation-header mb-3">
                    <h5 class="confimation-title">
                        How You Pay
                    </h5>
                </div>
                <div class="flight-book-contact-details p-4 bg-white mb-3">
                    <form class="form mb-0 d-flex gap-3">
                        <div class="input-group">
                            <label>Select Transfer Method</label>
                            <select class="form-select w-100">
                                <option>Bank Transfer via Mobile App</option>
                                <option>Bank Transfer via Internet Banking</option>
                                <option>Transfer via Digital Wallets</option>
                                <option>Over the counter/Pay at a shop</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>Select Bank</label>
                            <select class="form-select w-100">
                                <option>Allied Bank (ABL)</option>
                                <option>Askari Bank (ASK)</option>
                                <option>Bank Al Habib (BAHL)</option>
                                <option>Bank Al Falah (BAFL)</option>
                            </select>
                        </div>
                    </form>
                </div> --}}
                <div class="booking-card-trigger mt-4 f-14px d-flex align-items-center gap-1">
                    Your Bookings <i class="fa fa-angle-down"></i>
                </div>
                
                
                <div class="result-flight-item mb-3 mt-3 flight-confirmation-card flight-booking-card">
                    <div class="booked-flight-date f-12px">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="_1MZrIK28AE8HVj289UBgZw st-svg-icon "><g><path d="M20.9062 1.87524H18.75V0.750244C18.75 0.336057 18.4142 0.000244141 18 0.000244141C17.5858 0.000244141 17.25 0.336057 17.25 0.750244V1.87524H6.75V0.750244C6.75 0.336057 6.41423 0.000244141 6 0.000244141C5.58577 0.000244141 5.25 0.336057 5.25 0.750244V1.87524H3.09375C1.38783 1.87524 0 3.26307 0 4.96899V20.9065C0 22.6124 1.38783 24.0002 3.09375 24.0002H20.9062C22.6122 24.0002 24 22.6124 24 20.9065V4.96899C24 3.26307 22.6122 1.87524 20.9062 1.87524ZM22.5 20.9065C22.5 21.7867 21.7865 22.5002 20.9062 22.5002H3.09375C2.21353 22.5002 1.5 21.7867 1.5 20.9065V8.48462C1.5 8.3552 1.60495 8.25024 1.73438 8.25024H22.2656C22.395 8.25024 22.5 8.3552 22.5 8.48462V20.9065Z" fill="black"></path></g><defs><clipPath><rect width="24" height="24" fill="white" transform="translate(0 0.000244141)"></rect></clipPath></defs></svg>
                        @php
                            $dateTime = new DateTime($order->created_at);
                            $create_on = $dateTime->format('l j M, Y');
                        @endphp
                        <span>{{ $create_on }}</span>
                    </div>
                    <div class="flight-item-wrapper">
                        @foreach(json_decode($order->final_data, true)['LowFareSearch'] as $offer)
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
                                $airName = strlen($airName) > 20 ? substr($airName, 0, 13) . '...' : $airName;
                                $duration = $segment['Duration'];
                                $duration = str_replace(['PT', 'H'], ['', 'H '], $duration);

                                $Baggage = $segment['Baggage'];
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
                                </div>
                                <div class="flight-details-location align-items-center justify-content-center d-flex flex-column">
                                    <div
                                        class="one-time-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                        <span class="flight-details-location-name">
                                            {{ CityNameByAirportCode($originCode) }} ({{ $originCode }})
                                        </span>
                                        <span class="flight-details-location-time f-14px">
                                            {{ $departure_date2 }} {{ $dapartTime }}
                                        </span>
                                    </div>
                                    <div style="display: none !important;"
                                        class="return-flight-info text-center d-flex flex-column justify-content-center align-items-center">
                                        <span
                                            class="flight-details-location-name">{{ CityNameByAirportCode($originCode) }}
                                            ({{ $originCode }})</span>
                                        <span class="flight-details-location-time f-14px">{{ $departure_date2 }}
                                            {{ $dapartTime }}</span>
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
                                            <span class="flight-details-duration-hours f-12px d-flex flex-nowrap">1 stop at JED</span>
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
                            </div>
                        @endforeach
                    </div>
                    
                </div>

                <div class="flight-confimation-header mb-3">
                    <h5 class="confimation-title">
                        Important Information
                    </h5>
                </div>
                
                <div class="imp-infor p-4 mb-3 f-14px">
                    Travelers with Visit, Tourist, and Business Visas must book their return flight with the same airline. Failure to do so will result in denied boarding.
                </div>

                <div class="additional-infor bg-white flight-book-contact-details p-4 mb-3 f-14px">
                    <ul class="mb-0">
                        <li>
                            <span>E-ticket:</span>
                            <span>Your E-Ticket will be sent to your registered Email.</span>
                        </li>
                        <li><span>Travel Documents:</span>
                            <span>Keep your E-ticket on your phone, along with your original Passport.No printouts needed if saved. And don't forget to carry your Visa.</span>
                        </li>
                        <li>
                            <span>Departure Time:</span>
                            <span>Arrive at the airport at least 4 hours before your flight.</span>
                        </li>
                        <li>
                            <span>Manage Booking:</span>
                            <span>For changes or cancellations, visit <span>Manage Bookings.</span></span>
                        </li>
                        <li>
                            <span>Need Help?:</span>
                            <span>Call <span>03 111 222 427</span> or WhatsApp<span>+92 3 111 222 427</span></span>
                        </li>
                    </ul>
                </div>
                <div class="flight-confimation-header mb-3">
                    <h5 class="confimation-title">
                        Travelers
                    </h5>
                </div>
                <div class="flight-book-contact-details bg-white p-4 mb-3 f-14px">
                    @foreach($customerData['passengers'] as $index => $passenger)
                        <ul class="mb-0">
                            <li><span>Traveler {{ $index + 1 }}: </span>
                                @if($passenger['passenger_type'] === 'ADT')
                                    <span>Adult</span>
                                @elseif($passenger['passenger_type'] === 'CNN')
                                    <span>Child</span>
                                @elseif($passenger['passenger_type'] === 'INF')
                                    <span>Infant</span>
                                @endif
                            </li>
                            <li><span>Full Name: </span><span>{{ $passenger['passenger_title'] }} {{ ucfirst(strtolower($passenger['name'])) }} {{ ucfirst(strtolower($passenger['sur_name'])) }}</span></li>
                            <li><span>DOB: </span><span>{{ date('d.m.Y', strtotime($passenger['dob'])) }}</span></li>
                            <li><span>Passport Number: </span><span>{{ $passenger['document_number'] }}</span></li>
                            <li><span>Passport Expiry: </span><span>{{ date('d.m.Y', strtotime($passenger['document_expiry_date'])) }}</span></li>
                        </ul>
                    @endforeach
                </div>

                <div class="back-to-flights-btn mt-5">
                    <a href="{{ url('/') }}" class="green_btn p-2 rounded-3">Back to Flights</a>
                </div>
                            
            </div>
            
            <div class="col-lg-5 right-flight-summary pb-2 mt-lg-5">
                @php
                    $fares = json_decode($order->final_data, true)['Fares'];
                @endphp
                <h5 class="flight-summary-header-thankyou mb-3">Price Summary</h5>
                <div class="flight-summary-wrapper checkout-booking-confirm mt-0">
                    @foreach ($fares['fareBreakDown'] as $key => $item)
                        @php
                            $passPrice = $item['Quantity'] * $item['TotalFare'];
                        @endphp
                        <div class="flight-passenger-price-summary p-3 d-flex justify-content-between align-items-center f-14px">
                            <span class="flight-booked-airline-and-passenger">PIA ({{$key}} x 1)</span>
                            <span class="flight-booked-price">{{ $fares['CurrencyCode'] }} {{ number_format($passPrice, 0, '', ',') }}</span>
                        </div>
                    @endforeach
                    <div class="flight-passenger-price-summary p-3 d-flex justify-content-between align-items-center">
                        <span class="flight-booked-airline-and-passenger">Price you pay</span>
                        <span class="flight-booked-price">{{ $fares['CurrencyCode'] }} {{ number_format($fares['TotalPrice'], 0, '', ',') }}</span>
                    </div>
                    <div class="flight-selected-payment-method p-3 d-flex flex-column justify-content-start align-items-start">
                        <h6 class="flight-booked-airline-and-passenger">Payment Method</h6>
                        <span class="flight-booked-price f-14px">1Bill - Bank Transfer - 1Bill-Bank Transfer</span>
                    </div>
                </div>
            </div>
            

    </div>
</div>
@endsection
@section('scripts')

@endsection