@extends('admin.layouts.app')

@section('styles')

@endsection

@section('content')
<div id="layout-wrapper">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row no-print">
                    <div class="col-lg-9 mb-3">
                        <button class="btn btn-outline-success w-md" onclick="issueTicket('{{ @$order->pnrCode }}','{{ encrypt(@$order->id) }}', this)">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Issue Ticket
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card rounded-0">
                            <div class="p-4 bg-primary bg-gradient ">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h2 class="mb-1"><strong>PNR#{{ @$order->pnrCode}}</strong></h2>
                                        {{-- <p class="text-white-50 mb-0">Last Ticketed Date:15 Dec 2023</p> --}}
                                    </div>
                                    <div class="flex-shrink-0">
                                        <h1 class="mb-0"><strong>Booked</strong></h1>
                                        <p class="text-danger mb-0 fw-bold">Not Ticketed</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 border-top">
                                {{-- -------------------------Fares Detail------------------------ --}}
                                <div class="bg-soft-primary align-items-center px-3 p-2">
                                    <h4 class="m-0">
                                        {{-- Departing - From <strong>Lahore, Pakistan</strong> --}}
                                    </h4>
                                </div>
                                @php
                                    $finaldata = json_decode($order['final_data'],true);
                                @endphp
                                @foreach ($finaldata['LowFareSearch'] as $fares)
                                    @foreach ($fares['Segments'] as $segKey => $segment)
                                        @php
                                            $flightCode = $segment['OperatingAirline']['Code'];
                                            $FlightNumber = $segment['OperatingAirline']['FlightNumber'];
                                            
                                            $DepartureCode = $segment['Departure']['LocationCode'];
                                            $ArrivalCode = $segment['Arrival']['LocationCode'];

                                            $departure_date =  date('d M Y',strtotime($segment['Departure']['DepartureDateTime']));
                                            $dapartTime = date('H:i', strtotime($segment['Departure']['DepartureDateTime']));
                                            $arrtivelDate = date('d M Y', strtotime($segment['Arrival']['ArrivalDateTime']));
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
                                        <div class="segment">
                                            <div class="d-flex justify-content-between p-3 pb-1">
                                                <div style="width: 12%">
                                                    <small>Flight</small>
                                                    <h3 class="m-0" style="margin-top: -3px">
                                                        <img src="{{ asset('assets/airlines/'.$flightCode.'.png') }}" width="25px" alt="{{$flightCode}}">
                                                        {{ $flightCode }} {{ $FlightNumber }}
                                                    </h3>
                                                    <strong>{{ $Cabin }}</strong>
                                                </div>
                                                <div style="width: 15%">
                                                    <small>Check-in opens</small>
                                                    <p class="mb-0" style="margin-top: -3px">{{ $departure_date }}</p>
                                                    <h4 class="m-0">{{ $dapartTime }}</h4>
                                                </div>
                                                <div>
                                                    <small>Departure</small>
                                                    <p class="mb-0">{{ $departure_date }}</p>
                                                    <h4 class="m-0">{{ $dapartTime }}</h4>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/icons/plane-2.png')}}" width="25px" alt="">
                                                </div>
                                                <div class="align-items-center" style="width: 45%">
                                                    <h3 class="m-0"><b>{{ CityNameByAirportCode($DepartureCode) }}</b></h3>
                                                    <small>Departing ({{$DepartureCode}}) - {{ AirportByCode($DepartureCode) }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between p-3 pt-2">
                                                <div style="width: 12%">
                                                    {{-- <small><b>Seat</b></small>
                                                    <h1 class="m-0" style="margin-top: -3px"><b>17F</b></h1> --}}
                                                </div>
                                                <div style="width: 15%">
                                                    <small>Duration</small>
                                                    <h4 class="m-0">{{ $duration }}</h4>
                                                    {{-- <small>ADT-32 kg, CHD-30 kg</small> --}}
                                                </div>
                                                <div>
                                                    <small>Arrival</small>
                                                    <p class="mb-0">{{ $arrtivelDate }}</p>
                                                    <h4 class="m-0">{{ $arrtivelTime }}</h4>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/images/icons/plane-2.png')}}" width="25px" alt="">
                                                </div>
                                                <div class="align-items-center" style="width: 45%">
                                                    <h3 class="m-0"><b>{{ CityNameByAirportCode($ArrivalCode) }}</b></h3>
                                                    <small>Departing ({{$ArrivalCode}}), {{ AirportByCode($ArrivalCode) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach

                                {{-- ------------------------Passengers Detail-------------------- --}}
                                @php
                                    $customer_data = json_decode($order['customer_data'],true);
                                @endphp
                                
                                <div class="bg-soft-primary align-items-center px-3 p-2 mt-5">
                                    <h4 class="m-0">
                                        Passenger Detail
                                    </h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm m-0 p-3 table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="px-3 w-50"><b>Passenger Name</b></th>
                                                <th class="px-3"><b>eTicket Number</b></th>
                                                <th class="px-3"><b>Passenger Type</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_data['passengers'] as $passenger)    
                                                <tr>
                                                    @php
                                                        if($passenger['passenger_type'] == 'ADT')
                                                            $type = 'Adult';
                                                        elseif($passenger['passenger_type'] == 'CNN')
                                                            $type = 'Child';
                                                        else
                                                            $type = 'Infant';
                                                    @endphp
                                                    <td class="px-3">{{ $passenger['passenger_title'].' '.$passenger['name'].' '.$passenger['sur_name'] }}</td>
                                                    <td class="px-3"></td>
                                                    <td class="px-3">{{ $type }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- ------------------------Price Summary-------------------- --}}
                                <div class="bg-soft-primary align-items-center px-3 p-2 mt-5">
                                    <h4 class="m-0">
                                        Price Summary
                                    </h4>
                                </div>
                                
                                @php
                                    $fares = $finaldata['Fares']
                                @endphp
                                <div class="table-responsive">
                                    <table class="table table-sm m-0 p-3 border-start border-end">
                                        <tbody>
                                            @foreach ($fares['fareBreakDown'] as $key => $item)
                                                @php
                                                    if($key == 'ADT')
                                                        $passType = 'Adult';
                                                    elseif($key == 'CNN')
                                                        $passType = 'Child';
                                                    else
                                                        $passType = 'Infant';
                                                @endphp
                                                <tr>
                                                    <td class="px-3 fw-bold ">{{ $passType }} X {{ $item['Quantity'] }}</td>
                                                    <td class="px-3 fw-bold  text-end">{{ $fares['CurrencyCode'] }} {{ $item['Quantity'] * $item['TotalFare'] }}</td>
                                                </tr>
                                            @endforeach
                                            
                                            <tr>
                                                <td class="px-3 "><h5 class="fw-bold">Total Paid</h5></td>
                                                <td class="px-3 fw-bold  text-end"><h5 class="fw-bold">{{ $fares['CurrencyCode'] }} {{ $fares['TotalPrice'] }}</h5></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function issueTicket(pnr, book_ref_key, button) {
        $(button).attr('disabled', true);
        console.log(pnr);
        showSweetAlertDelete(
            "Are you sure, You want to issue ticket",
            '',
            'warning',
            'Yes Issue',
            'No',
            function() {
                $(button).find('.spinner-border').removeClass('d-none');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.issue.ticket')}}",
                    data: {
                        pnr,book_ref_key
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            // showSweetAlert(data.message,"success","Okay, got it!","btn btn-primary");
                            $('#order_status').text(data.message);
                            $('#passenger_ticket_data').html(data.ticketRenderHtml);
                            $('#not_ticketed').hide();
                            $(button).remove();
                        } else {
                            showSweetAlert(data.message,"warning","Okay, got it!","btn btn-danger");
                        }
                    },
                    complete: function () {
                        $(button).find('.spinner-border').addClass('d-none');
                        $(button).removeAttr('disabled');
                    }
                });
            }
        );
    }
</script>
@endsection

