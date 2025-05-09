<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking-{{ @$pnrCode}}</title>
	<style>
		body p{
			font-size: 12px !important;
		}
		table th{
			font-size: 12px !important;
		}
	</style>
</head>

<body style="font-family: Work Sans, sans-serif; background-color: #f1f3f;">
    <div>
        <div style="width: 100%; background-color: #f8f9fa;">
			{{-- //////////////////////////Agent and Agency Detail//////////////////////// --}}
			@if (@$agency)
				<div style="page-break-inside: avoid; padding:10px; padding-bottom: 0px;">     
					<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;">
						<tr>
							<td style="text-align: left;">
								@if (@$agency['logo'])
									<img src="{{ asset($agency['logo'])}}" height="80px" alt="{{ $agency['name'] }}" style="display: block;">
								@else
									<img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}" height="80px" alt="INDUS" style="display: block;">
								@endif
							</td>

							<td style="text-align: right; font-size:13px;">
								<span style="text-align: left;">
									<span style="margin: 0;">
										Travel Consultant: {{ @$admin['first_name'] .' '.@$admin['last_name']}}
									</span>
									<br>
									<span style="margin: 0; color: green; font-weight: bold; text-decoration: none;">
										<i class="fas fa-envelope"></i>{{ @$admin['email'] }}
									</span>
								</span>
							</td>
						</tr>
					</table>
					<br>
				</div>
			@endif
			{{-- /////////////////////////////Status Header////////////////////////////////// --}}
			
            <div style="background-color: #6ba605; color: #fff; padding: 5px 15px; border-radius: 5px; box-shadow: 0 2px 3px #7e7e7e; background-color: hsla(219, 73%, 56%, 0.906);">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="text-align: left;">
							<h5 style="font-size: 15px; font-weight: bold; color: #ffc107; margin-top: 0px; margin-bottom: 5px;">GDS PNR: {{ @$pnrCode}}</h5>
						</td>
						<td style="text-align: right; font-size:11px;">
                            Booking Date: <b>{{ date('d M Y',strtotime($created_at)) }}</b>
						</td>
					</tr>
					<tr>
						<td style="text-align: left; font-size: 14px;">
							<small>Ticket Status: </small>
                            <span style="font-weight: bold;">{{ @$status}}</span>
						</td>
						<td style="text-align: right; font-size:11px;">
                            {{-- <small>Issue Date: </small> --}}
                            @if (@$issued_at)
								Issue Date: <b>{{ date('d M Y',strtotime($issued_at)) }}</b>
							@endif
						</td>
					</tr>
				</table>
            </div>
            {{-- ------------------------------------------ --}}
            <div style="background-color: #fff; border-radius: 5px; margin-top: 10px; box-shadow: 0 2px 3px #7e7e7e;">
				{{-- =========================Itineraries========================= --}}
				@php
					$finaldata = json_decode($final_data,true);
					$extras = json_decode($extras,true);
					$customer_data = json_decode($customer_data,true);
					$tickets_data = json_decode($tickets_data,true);
					$brand_ref_key = @$customer_data['brand_ref_key'];
					$Brands = array();
					
					$CurrencyCode = "PKR";
					$passBreak = [];
					foreach (['Adult', 'Child', 'Infant'] as $paxType) {
						$passBreak[] = [
							'PaxType' => $paxType,
							'Quantity' => 0,
							'BasePrice' => 0,
							'TaxPrice' => 0,
							'TotalPaxPrice' => 0,
						];
					}
				@endphp
				@foreach ($finaldata['Flights'] as $flightIndex => $flights)
					@php
						if($flightIndex == 0){
							$trip = "Onward";
						}else{
							$trip = "Return";
						}

						$segments = collect($flights['Segments']);
						$firstSegment = $segments->first();
						$lastSegment = $segments->last();
						$originCode = $firstSegment['Departure']['LocationCode'];
						$arrivalionCode = $lastSegment['Arrival']['LocationCode'];

						if(@$brand_ref_key){
							$brand_ref = $brand_ref_key[$flightIndex];
							if (isset($flights['Fares']) && is_array($flights['Fares'])) {
								$filteredFares = array_filter($flights['Fares'], function ($fare) use ($brand_ref) {
									return $fare['RefID'] == $brand_ref;
								});
								if (!empty($filteredFares)) {
									foreach ($filteredFares as $filteredFare) {
										foreach ($filteredFare['PassengerFares'] as $key => $value) {
											if(@$value['BasePrice']){
												$passBreak[$key]['Quantity'] = @$value['Quantity'];
												$passBreak[$key]['BasePrice'] += $value['BasePrice'] / count($finaldata['Flights']);
												$passBreak[$key]['TaxPrice'] += $value['Taxes'] / count($finaldata['Flights']);
												$passBreak[$key]['TotalPaxPrice'] += $value['TotalPrice'] / count($finaldata['Flights']);
											}
										}
										$flightBrands = $filteredFare;
									}
									foreach ($passBreak as $key => $value) {
										if (empty($value['BasePrice'])) {
											unset($passBreak[$key]);
										}
									}
								}
							}
						}else{
							$flightBrands = $flights['Fares'][0];
							foreach ($flights['Fares'][0]['PassengerFares'] as $key => $value) {
                                $passBreak[$key]['Quantity'] = @$value['Quantity'];
								$passBreak[$key]['BasePrice'] += $value['BasePrice'] / count($finaldata['Flights']);
								$passBreak[$key]['TaxPrice'] += $value['Taxes'] / count($finaldata['Flights']);
								$passBreak[$key]['TotalPaxPrice'] += $value['TotalPrice'] / count($finaldata['Flights']);
							}
						}
					@endphp
					<div class="row" style="background-color:rgba(249,194,86,.25)!important; padding:10px;">
						<div class="col-sm-9">
							<h5 style="margin: 0;">
								<i class="fas fa-plane" style="font-size: 20px; {{ ($trip == 'Return') ? 'transform: rotate(180deg);' : '' }}"></i> 
								{{ $trip }} <span style="font-weight: 300;">Flight(s)</span> | 
								<span>{{ $originCode }} - {{ $arrivalionCode }}</span>
								@if(@$flightBrands['Name'])
									<span style="border-radius: 5px; padding: 3px 10px; border:1px solid #6ba605; color: #6ba605; margin-left: 10px;">
										<i class="fas fa-check-double"></i>
										{{ $flightBrands['Name'] }}
									</span>
								@endif
							</h5>
						</div>
					</div>

					<table style="width: 100%; border-collapse: collapse;">
						<thead style="text-align: left;">
							<tr style="background-color: #f5f5f5;">
								<th colspan="2" style="padding: 5px 10px;">Airline</th>
								<th style="padding: 5px 10px;">Departing</th>
								<th style="padding: 5px 10px;">Arriving</th>
								<th style="padding: 5px 10px;"></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($flights['Segments'] as $segKey => $segment)
								@php
									$FlightCode = $segment['OperatingAirline']['Code'];
									$FlightNumber = $segment['OperatingAirline']['FlightNumber'];
									
									$DepartureCode = $segment['Departure']['LocationCode'];
									$ArrivalCode = $segment['Arrival']['LocationCode'];
									$originTerminal = @$segment['Departure']['Terminal'];
									$arrivalTerminal = @$segment['Arrival']['Terminal'];

									$DepartureDate =  date('D d M Y, H:i',strtotime($segment['Departure']['DepartureDateTime']));
									$ArrivalDate =  date('D d M Y, H:i',strtotime($segment['Arrival']['ArrivalDateTime']));

									$AirName = AirlineNameByAirlineCode($FlightCode);
									$AirName = strlen($AirName) > 20 ? substr($AirName, 0, 13) . "..." : $AirName;
									$Cabin = @$segment['Cabin'];
									$CabinClass = @$segment['CabinClass'];
									// ---------------------------------------
									$Layover = null;
									if ($segKey > 0) {
										$CurrentDeparture = new DateTime($segment['Departure']['DepartureDateTime']);
										$PreviousArrival = new DateTime($flights['Segments'][$segKey - 1]['Arrival']['ArrivalDateTime']);
										$Layover = $CurrentDeparture->diff($PreviousArrival)->format('%H:%I');
									}
									if(@$extras['airline'][0]['airlineCode']){
										$filteredAirline = array_filter($extras['airline'], function($airline) use ($FlightCode) {
											return $airline['airlineCode'] === $FlightCode;
										});
										$filteredAirline = array_values($filteredAirline);

									}else{
										$ailinePnrStatus = @$extras['airline'][0]['pnrStatus'];
									}
								@endphp
								@if ($Layover)
									<tr>
										<td colspan="5">
											<div style="margin: auto!important; width: 50%!important;">
												<div style="border-radius: .5rem!important; background-color:#dfe0e2; border: 1px solid #eff0f2!important; text-align: center; font-size:10px;">
													<i class="fas fa-clock me-2"></i>
													@php
														list($hours, $minutes) = explode(':', $Layover);
														$hours = (int) $hours;
														$minutes = (int) $minutes;
													@endphp
													Stop duration: {{ $hours.' Hours '.$minutes.' Minutes' }}
												</div>
											</div>
										</td>
									</tr>
								@endif
								<tr>
									<td style="padding: 5px 10px;">
										<img src="{{ asset('assets/airlines/'.$FlightCode.'.png') }}" alt="{{ $FlightCode }}" style="width: 30px;">
									</td>
									<td style="padding: 5px 10px;">
										<p style="font-weight: bold; margin-bottom: 0px;">{{ $AirName }}</p>
										<p style="margin-bottom: 0px; margin-top: 0px;">{{ $FlightCode }}-{{ $FlightNumber }}</p>
										<p style="margin-top: 0px;">{{ $CabinClass }}({{ @$flightBrands['FareBases'][$segKey]['BookingCode'] }})</p>
									</td>
									<td style="padding: 5px 10px;">
										<p style="margin: 0;">
											<b>{{ $DepartureCode }}</b> 
											{{ CityNameByAirportCode($DepartureCode) }}
											@if (@$originTerminal)
												| <b>Terminal: {{ $originTerminal }}</b>
											@endif
										</p>
										<p style="display: none;">{{ AirportByCode($DepartureCode) }}</p>
										<p style="margin: 0;"><b>{{ $DepartureDate }}</b></p>
									</td>
									<td style="padding: 5px 10px;">
										<p style="margin: 0;">
											<b>{{ $ArrivalCode }}</b> 
											{{ CityNameByAirportCode($ArrivalCode) }}
											@if (@$arrivalTerminal)
											| <b>Terminal: {{ $arrivalTerminal }}</b>
											@endif
										</p>
										<p style="display: none;">
											{{ AirportByCode($ArrivalCode) }}
										</p>
										<p style="margin: 0;">
											<b>{{ $ArrivalDate }}</b>
										</p>
									</td>
									<td style="padding: 5px 10px;">
										@php
											$SegHours = floor($segment['Duration'] / 60);
											$SegMinutes = $segment['Duration'] % 60;
										@endphp
										@if (@$filteredAirline)
											<p style="margin: 0; color: #6ba605;">{{ $FlightCode.' PNR: '}}: <b>{{ $filteredAirline[0]['airlinePnr'] }}</b></p>
										@endif
										<!-- <p style -->
										<p style="margin: 0;"><small><i class="fas fa-clock me-1" style="color: #9f9494;"></i> {{ $SegHours }}H {{ $SegMinutes }}M</small></p>
										@foreach ($flightBrands['BaggagePolicy'] as $bagg)
											@if (is_array($bagg) && isset($bagg['PaxType']))
												<p style="margin: 0;">
													<small><i class="fas fa-suitcase" style="color: #9f9494;"></i>
														{{ $bagg['PaxType'] }}: {{ $bagg['Weight'] }} {{ $bagg['Unit'] }}
													</small>
												</p>
											@endif
										@endforeach
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@endforeach

            </div>
            {{-- -----------------------------Passenger Details------------------------- --}}
            <div style="background-color: #fff; border-radius: 5px; margin-top: 10px; box-shadow: 0 2px 3px #7e7e7e; padding-bottom: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="text-align: left;">
                        <tr class="header-row Passengerheader" style="background-color: rgba(249,194,86,.25)!important; padding:10px;">
                            <th style="padding: 13px 10px;">S.No</th>
                            <th class="" style="padding: 5px 10px;">Passenger(s) Details</th>
                            <th class="" style="padding: 5px 10px;">Passport Details</th>
                            <th class="" style="padding: 5px 10px;">FF No</th>
                            <th class="" style="padding: 5px 10px;">E-Ticket</th>
                            <th class="" style="padding: 5px 10px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
						@foreach ($customer_data['passengers'] as $passKey => $passenger)
							@php
								if($passenger['passenger_type'] == 'ADT')
									$PaxType = 'Adult';
								elseif($passenger['passenger_type'] == 'CNN')
									$PaxType = 'Child';
								else
									$PaxType = 'Infant';
							@endphp
							<tr class="border-bottom pb-3 Passengerbody" style="padding-bottom:10px !important">
								<td class="" style="padding: 5px 10px;">
									<span class="fs-5">
										{{ $passKey+1 }}
									</span>
								</td>
								<td class="" style="padding: 5px 10px; margin-left: -109px; font-size: 12px;">
									<span style="font-weight: 700;">
										{{ $passenger['passenger_title'].' '.strtoupper($passenger['name']).' '.strtoupper($passenger['sur_name']) }}
										<br>
										<span style="font-weight: 400!important;">
											{{ $PaxType }} ({{ date('M d, Y',strtotime($passenger['dob'])) }})
										</span>
									</span>
								</td>
								<td class="" style="padding: 5px 10px; margin-left: -39px; font-size: 12px;">
									{{ capitalizeAlphabetic($passenger['document_number']) }},
									{{ date('M d, Y',strtotime($passenger['document_expiry_date'])) }},
									{{ $passenger['nationality'] }}
								</td>
								<td class="" style="padding: 5px 10px; margin-left: 7px;">-</td>
								<td class="" style="padding: 5px 10px; margin-left: -39px; font-size: 12px;">
									@if(@$tickets_data)
										@php
											$passengerFirstName = strtoupper($passenger['name']).' '.strtoupper($passenger['passenger_title']);
											$ticketedName = $tickets_data[$passKey]['name'];
										@endphp
										@if(strtoupper($passenger['name']) == $ticketedName || $passengerFirstName == $ticketedName)
											{{ $tickets_data[$passKey]['TicketNumber'] }}
										@endif
									@endif
								</td>
								<td class="" style="padding: 5px 10px; margin-left: -39px; font-size: 12px;">
									{{ $status }}
								</td>
							</tr>
						@endforeach
                    </tbody>
                </table>
            </div>
            {{-- ---------------------Fare Detail--------------------- --}}
            @if (@$f == 1)
                <div style="background-color: #fff; border-radius: 5px; margin-top: 10px; box-shadow: 0 2px 3px #7e7e7e; ">

                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="card">
                            <div class="row gx-0">
                                <div class="col-md-12 rounded-1">
                                    <div class="" style="border-radius: 5px 5px 0px 0px; background-color: #f5f5f5; padding: 1px; padding-left: 12px;">
                                        <h3 style="color: #212529; font-weight: bold;">Payment Details</h3>
                                    </div>
                                    @php
                                        $CurrencyCode = "PKR";
                                        $BasePrice = 0;
                                        $Taxes = 0;
                                        $BillablePrice = 0;
                                        
                                        foreach ($passBreak as $key => $breakfare) {
                                            $BasePrice += @$breakfare['BasePrice'] * $breakfare['Quantity'];
                                            $Taxes += $breakfare['TaxPrice'] * $breakfare['Quantity'];
                                        }
                                    @endphp
                                    <table width="100%;" style="padding: 12px;">
                                        <thead style="text-align: left;">
                                            <tr>
                                                <th style="text-align: left; font-weight:bold; font-size;13px;">
                                                    <span>Type</span>
                                                </th>
                                                <th style="text-align: right; font-weight:bold; font-size;13px;">
                                                    <span>Amount</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 12px;">
                                            <tr>
                                                <td>Base Fare</td>
                                                <td style="text-align: right;">{{ $CurrencyCode }} {{ number_format($BasePrice) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Booking Fee &amp; Taxes </td>
                                                <td style="text-align: right;">{{ $CurrencyCode }} {{ number_format($Taxes) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Service Fee </td>
                                                <td style="text-align: right;">PKR 0</td>
                                            </tr>
                                            <tr>
                                                <td>Addon Fee</td>
                                                <td style="text-align: right;">PKR 0</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><b>Total Fare</b></td>
                                                <td style="text-align: right; font-weight:bold;"><b>{{ $CurrencyCode }} {{ number_format($userPricingEnginePrice) }}</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- ---------------------Important Information--------------------- --}}

        </div>
    </div>
    
</body>

</html>