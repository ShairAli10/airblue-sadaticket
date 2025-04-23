<?php
namespace App\Http\Traits\APIS;

use App\Models\ApiOffer;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait AirblueTrait
{

    public static function lowFareSearch($request)
    {
        // dd($request);
        // Load credentials from .env
        $apiUrl         = env('AIRBLUE_API_URL');
        $apiClientID    = env('AIRBLUE_API_CLIENT_ID');
        $apiClientKey   = env('AIRBLUE_API_CLIENT_KEY');
        $agentType      = env('AIRBLUE_AGENT_TYPE');
        $agentID        = env('AIRBLUE_AGENT_ID');
        $agentPassword  = env('AIRBLUE_AGENT_PASSWORD');
        $serviceTarget  = env('SERVICE_TARGET');
        $serviceVersion = env('SERVICE_VERSION');

        // Path to the combined certificate and key file
        $certPath = storage_path('app/Airblue/certs/combined.pem');

        if ($request['tripType'] == "oneway") {
            $xmlRequest = <<<XML
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:zap="http://zapways.com/air/ota/2.0" xmlns:ota="http://www.opentravel.org/OTA/2003/05">
            <soapenv:Header/>
            <soapenv:Body>
                <zap:AirLowFareSearch>
                    <ota:airLowFareSearchRQ EchoToken="-8586704355136787339" Target="{$serviceTarget}" Version="{$serviceVersion}">
                        <ota:POS>
                            <ota:Source ERSP_UserID="{$apiClientID}/{$apiClientKey}">
                                <ota:RequestorID Type="{$agentType}" ID="{$agentID}" MessagePassword="{$agentPassword}" />
                            </ota:Source>
                        </ota:POS>
                        <ota:OriginDestinationInformation RPH="1">
                            <ota:DepartureDateTime>{$request['departureDate']}T00:00:00Z</ota:DepartureDateTime>
                            <ota:OriginLocation LocationCode="{$request['origin']}"></ota:OriginLocation>
                            <ota:DestinationLocation LocationCode="{$request['destination']}"></ota:DestinationLocation>
                        </ota:OriginDestinationInformation>
                        <ota:TravelerInfoSummary>
                            <ota:AirTravelerAvail>
                                <ota:PassengerTypeQuantity Code="ADT" Quantity="{$request['adults']}" />
                                <ota:PassengerTypeQuantity Code="CHD" Quantity="{$request['children']}" />
                                <ota:PassengerTypeQuantity Code="INF" Quantity="{$request['infants']}" />
                            </ota:AirTravelerAvail>
                        </ota:TravelerInfoSummary>
                    </ota:airLowFareSearchRQ>
                </zap:AirLowFareSearch>
            </soapenv:Body>
        </soapenv:Envelope>
        XML;
        } elseif ($request['tripType'] == "return") {
            $xmlRequest = <<<XML
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                        xmlns:zap="http://zapways.com/air/ota/2.0"
                        xmlns:ota="http://www.opentravel.org/OTA/2003/05">
            <soapenv:Header/>
            <soapenv:Body>
                <zap:AirLowFareSearch>
                    <ota:airLowFareSearchRQ EchoToken="-8586704355136787339"
                                            Target="{$serviceTarget}"
                                            Version="{$serviceVersion}">
                        <ota:POS>
                            <ota:Source ERSP_UserID="{$apiClientID}/{$apiClientKey}">
                                <ota:RequestorID Type="{$agentType}" ID="{$agentID}" MessagePassword="{$agentPassword}" />
                            </ota:Source>
                        </ota:POS>
                        <ota:OriginDestinationInformation RPH="1">
                            <ota:DepartureDateTime>{$request['departureDate']}T00:00:00Z</ota:DepartureDateTime>
                            <ota:OriginLocation LocationCode="{$request['origin']}" />
                            <ota:DestinationLocation LocationCode="{$request['destination']}" />
                        </ota:OriginDestinationInformation>
                        <ota:OriginDestinationInformation RPH="2">
                            <ota:DepartureDateTime>{$request['returnDate']}T00:00:00Z</ota:DepartureDateTime>
                            <ota:OriginLocation LocationCode="{$request['destination']}" />
                            <ota:DestinationLocation LocationCode="{$request['origin']}" />
                        </ota:OriginDestinationInformation>
                        <ota:TravelerInfoSummary>
                            <ota:AirTravelerAvail>
                                <ota:PassengerTypeQuantity Code="ADT" Quantity="{$request['adults']}" />
                                <ota:PassengerTypeQuantity Code="CHD" Quantity="{$request['children']}" />
                                <ota:PassengerTypeQuantity Code="INF" Quantity="{$request['infants']}" />
                            </ota:AirTravelerAvail>
                        </ota:TravelerInfoSummary>
                    </ota:airLowFareSearchRQ>
                </zap:AirLowFareSearch>
            </soapenv:Body>
        </soapenv:Envelope>
        XML;
        } elseif ($request['tripType'] == "multi") {
            $xmlRequest = <<<XML
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                             xmlns:zap="http://zapways.com/air/ota/2.0"
                             xmlns:ota="http://www.opentravel.org/OTA/2003/05">
                           <soapenv:Header/>
                           <soapenv:Body>
                           <zap:AirLowFareSearch>
                           <ota:airLowFareSearchRQ EchoToken="-8586704355136787339"
                                           Target="{$serviceTarget}"
                                           Version="{$serviceVersion}">
                           <ota:POS>
                               <ota:Source ERSP_UserID="{$apiClientID}/{$apiClientKey}">
                                   <ota:RequestorID Type="{$agentType}" ID="{$agentID}" MessagePassword="{$agentPassword}" />
                               </ota:Source>
                           </ota:POS>
                           <ota:OriginDestinationInformation RPH="1">
                               <ota:DepartureDateTime>{$request['departureDate']}T00:00:00Z</ota:DepartureDateTime>
                               <ota:OriginLocation LocationCode="{$request['origin']}" />
                               <ota:DestinationLocation LocationCode="{$request['destination']}" />
                           </ota:OriginDestinationInformation>
                           <ota:OriginDestinationInformation RPH="2">
                               <ota:DepartureDateTime>{$request['departureDate2']}T00:00:00Z</ota:DepartureDateTime>
                               <ota:OriginLocation LocationCode="{$request['origin2']}" />
                               <ota:DestinationLocation LocationCode="{$request['destination2']}" />
                           </ota:OriginDestinationInformation>
                           <ota:TravelerInfoSummary>
                               <ota:AirTravelerAvail>
                                   <ota:PassengerTypeQuantity Code="ADT" Quantity="{$request['adults']}" />
                                   <ota:PassengerTypeQuantity Code="CHD" Quantity="{$request['children']}" />
                                   <ota:PassengerTypeQuantity Code="INF" Quantity="{$request['infants']}" />
                               </ota:AirTravelerAvail>
                           </ota:TravelerInfoSummary>
                           </ota:airLowFareSearchRQ>
                   </zap:AirLowFareSearch>
               </soapenv:Body>
           </soapenv:Envelope>
           XML;
        }

        try {
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: text/xml; charset=utf-8",
                "SOAPAction: http://zapways.com/air/ota/2.0/AirLowFareSearch",
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSLCERT, $certPath);
            curl_setopt($ch, CURLOPT_SSLKEY, $certPath);
            curl_setopt($ch, CURLOPT_SSLCERTPASSWD, '');

            $response  = curl_exec($ch);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error("Curl Error: " . $curlError);
                return ['status' => '400', 'msg' => $curlError];
            }

            // Store the raw response in a file
            Storage::put('Airblue/airLowFareSearchResponse.xml', $response);

            // Parse XML response with error handling
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($response);

            if ($xml === false) {
                // Log all XML errors
                $errors = libxml_get_errors();
                foreach ($errors as $error) {
                    Log::error("XML Parsing Error: " . $error->message);
                }
                libxml_clear_errors();
                return ['status' => '400', 'msg' => 'Invalid XML format'];
            }

            // Remove namespaces
            $xmlWithoutNamespaces = self::removeNamespaces($xml);

            // Convert to JSON
            $jsonResponse  = json_encode($xmlWithoutNamespaces);
            $arrayResponse = json_decode($jsonResponse, true);

            // Convert the array back to JSON for storage
            $jsonResponseString = json_encode($arrayResponse, JSON_PRETTY_PRINT);
            $response           = json_decode(json_encode($xmlWithoutNamespaces), true);
            // dd($response);

            // Save the JSON string to a file
            Storage::put('Airblue/airLowFareSearchResponse.json', $jsonResponseString);

            if ($request['tripType'] == "oneway") {
                $finalRes = self::makeResponseOneway($response, $request);
            } else {
                $finalRes = self::makeResponseReturn($response, $request);
            }
            // dd($finalRes);
            return $finalRes;
        } catch (\Exception $e) {
            Log::error("Airblue API Error: " . $e->getMessage());
            return ['status' => '400', 'msg' => $e->getMessage()];
        }
    }

    // Remove namespaces from a SimpleXMLElement
    private static function removeNamespaces($xml)
    {
        // Strip namespaces recursively
        $xmlString = $xml->asXML();
        $xmlString = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $xmlString);
        return simplexml_load_string($xmlString);
    }

    public static function makeResponseReturn($response, $request)
    {

        $finalData     = [];
        $goingFlights  = [];
        $returnFlights = [];
        $responseData  = $response['soap:Body']['AirLowFareSearchResponse']['AirLowFareSearchResult'];
        if (isset($responseData['Errors']['Error'])) {
            return [
                'status' => '400',
                'msg'    => [$responseData['Errors']['Error']],
            ];
        }
        if (! isset($responseData['PricedItineraries']) || empty($responseData['PricedItineraries'])) {
            return [
                'status' => '204',
                'msg'    => ['No flights found'],
            ];
        }

        if (! isset($responseData['PricedItineraries']['PricedItinerary']) || empty($responseData['PricedItineraries']['PricedItinerary'])) {
            return [
                'status' => '204',
                'msg'    => ['No flights found'],
            ];
        }

        $responseData = $responseData['PricedItineraries']['PricedItinerary'];

        // $responseData  = $response['soap:Body']['AirLowFareSearchResponse']['AirLowFareSearchResult']['PricedItineraries']['PricedItinerary'];

        if (! empty($responseData)) {

            foreach ($responseData as $key => $flight) {
                $segments        = [];
                $journeyDuration = 0;
                $passengerFares  = [];
                $baggagePolicy   = [];

                $originDestinationOptions = $flight['AirItinerary']['OriginDestinationOptions']['OriginDestinationOption'];
                foreach ($originDestinationOptions as $key_1 => $segment) {

                    $flightSegment = $segment['FlightSegment'] ?? $segment ?? null;

                    if (! $flightSegment || ! isset($flightSegment['OperatingAirline']['@attributes']['Code'])) {
                        continue;
                    }

                    $journeyDuration = self::getJourneyDuration(
                        $flightSegment['@attributes']['DepartureDateTime'],
                        $flightSegment['@attributes']['ArrivalDateTime']
                    );

                    $segments[] = [
                        'Duration'         => $journeyDuration,
                        'OperatingAirline' => [
                            'Code'         => $flightSegment['OperatingAirline']['@attributes']['Code'],
                            'FlightNumber' => $flightSegment['@attributes']['FlightNumber'],
                        ],
                        'MarketingAirline' => [
                            'Code'         => $flightSegment['MarketingAirline']['@attributes']['Code'],
                            'FlightNumber' => $flightSegment['@attributes']['FlightNumber'],
                        ],
                        'Departure'        => [
                            'LocationCode'      => $flightSegment['DepartureAirport']['@attributes']['LocationCode'],
                            'DepartureDateTime' => $flightSegment['@attributes']['DepartureDateTime'],
                        ],
                        'Arrival'          => [
                            'LocationCode'    => $flightSegment['ArrivalAirport']['@attributes']['LocationCode'],
                            'ArrivalDateTime' => $flightSegment['@attributes']['ArrivalDateTime'],
                        ],
                        'Cabin'            => $flightSegment['@attributes']['ResBookDesigCode'],
                        'CabinClass'       => 'ECONOMY (' . $flightSegment['@attributes']['ResBookDesigCode'] . ')',
                        'AvailableSeats'   => rand(0, 50),
                        'EquipType'        => $flightSegment['Equipment']['@attributes']['AirEquipType'] ?? null,
                    ];
                }

                // $fareBreakdown = $flight['AirItineraryPricingInfo']['PTC_FareBreakdowns']['PTC_FareBreakdown'];

                $baseFare = (int) $flight['AirItineraryPricingInfo']['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                // $taxes     = (int) $flight['AirItineraryPricingInfo']['ItinTotalFare']['Taxes']['@attributes']['Amount'];
                $taxes = isset($flight['AirItineraryPricingInfo']['ItinTotalFare']['Taxes'])
                ? (int) $flight['AirItineraryPricingInfo']['ItinTotalFare']['Taxes']['@attributes']['Amount']
                : 0;
                $totalFare = (int) $flight['AirItineraryPricingInfo']['ItinTotalFare']['TotalFare']['@attributes']['Amount'];

                if (! empty($flight['AirItineraryPricingInfo']['PTC_FareBreakdowns'])) {
                    $fareBreakdowns = $flight['AirItineraryPricingInfo']['PTC_FareBreakdowns']['PTC_FareBreakdown'];

                    if (! isset($fareBreakdowns[0])) {
                        $fareBreakdowns = [$fareBreakdowns];
                    }

                    $passengerFares = [];
                    $baggagePolicy  = [];

                    foreach ($fareBreakdowns as $fareBreakdown) {
                        $paxType   = $fareBreakdown['PassengerTypeQuantity']['@attributes']['Code'];
                        $currency  = $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['CurrencyCode'];
                        $quantity  = (int) $fareBreakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                        $basePrice = (int) $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['Amount'];
                        $taxes     = isset($fareBreakdown['PassengerFare']['Taxes']['@attributes']['Amount'])
                        ? (int) $fareBreakdown['PassengerFare']['Taxes']['@attributes']['Amount']
                        : 0;
                        $fees = isset($fareBreakdown['PassengerFare']['Fees']['@attributes']['Amount'])
                        ? (int) $fareBreakdown['PassengerFare']['Fees']['@attributes']['Amount']
                        : 0;
                        $totalPrice = (int) $fareBreakdown['PassengerFare']['TotalFare']['@attributes']['Amount'];

                        $passengerFares[] = [
                            'PaxType'        => $paxType,
                            'Currency'       => $currency,
                            'Quantity'       => $quantity,
                            'BasePrice'      => $basePrice,
                            'Taxes'          => $taxes,
                            "Fees"           => $fees,
                            "ServiceCharges" => 0,
                            'TotalPrice'     => $totalPrice,
                        ];

                        if (isset($fareBreakdown['FareInfo'][1]['PassengerFare'])) {
                            $weight = $fareBreakdown['FareInfo'][1]['PassengerFare'];
                            if (isset($weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'])) {
                                $weight = $weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'];
                            } else {
                                $weight = 0;
                            }
                        } else {
                            $weight = 0;
                        }

                        $baggagePolicy[] = [
                            'Weight'  => $weight ?? 0,
                            'Unit'    => 'Kg',
                            'PaxType' => $paxType,
                        ];
                    }
                } else {
                    $passengerFares = [
                        [
                            'PaxType'        => 'ADT',
                            'Currency'       => 'USD',
                            'Quantity'       => 1,
                            'BasePrice'      => 0,
                            'Taxes'          => 0,
                            "Fees"           => 0,
                            "ServiceCharges" => 0,
                            'TotalPrice'     => 0,
                        ],
                    ];
                    $baggagePolicy = [
                        [
                            'Weight'  => 0,
                            'Unit'    => 'Kg',
                            'PaxType' => 'none',
                        ],
                    ];
                }

                // $passengerFares[] = [
                //     'PaxType'        => $fareBreakdown['PassengerTypeQuantity']['@attributes']['Code'],
                //     'Currency'       => $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['CurrencyCode'],
                //     'Quantity'       => (int) $fareBreakdown['PassengerTypeQuantity']['@attributes']['Quantity'],
                //     'BasePrice'      => (int) $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['Amount'],
                //     'Taxes'          => (int) $fareBreakdown['PassengerFare']['Taxes']['@attributes']['Amount'],
                //     'Fees'           => 0,
                //     'ServiceCharges' => 0,
                //     'TotalPrice'     => (int) $fareBreakdown['PassengerFare']['TotalFare']['@attributes']['Amount'],
                // ];

                // $weight = $fareBreakdown['FareInfo'][1]['PassengerFare']['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'] ?? 0;

                // $baggagePolicy[] = [
                //     'Weight'  => $weight,
                //     'Unit'    => 'Kg',
                //     'PaxType' => $fareBreakdown['PassengerTypeQuantity']['@attributes']['Code'],
                // ];

                $flightData = [
                    'Segments'      => $segments,
                    'TotalDuration' => $journeyDuration,
                    'NonRefundable' => false,
                    'MultiFares'    => false,
                    'Fares'         => [[
                        'RefID'          => Str::uuid(),
                        'Currency'       => 'PKR',
                        'BaseFare'       => $baseFare,
                        'Taxes'          => $taxes,
                        'TotalFare'      => $totalFare,
                        'BillablePrice'  => $totalFare,
                        'BaggagePolicy'  => $baggagePolicy,
                        'PassengerFares' => $passengerFares,
                    ]],
                ];

                if ($flight['@attributes']['OriginDestinationRefNumber'] == 1) {
                    $goingFlights[] = $flightData;
                } else {
                    $returnFlights[] = $flightData;
                }
            }

            $maxCount  = max(count($goingFlights), count($returnFlights));
            $finalData = [];

            for ($i = 0; $i < $maxCount; $i++) {
                $flightPair = [
                    'api'              => 'AirBlue',
                    'MarketingAirline' => ['Airline' => 'N/A', 'FareRules' => 'NA'],
                    'Flights'          => [],
                    'itn_ref_key'      => Str::uuid(),
                ];

                $totalFare = 0;

                if (isset($goingFlights[$i])) {
                    $flightPair['Flights'][]                   = $goingFlights[$i];
                    $flightPair['MarketingAirline']['Airline'] = $goingFlights[$i]['Segments'][0]['MarketingAirline']['Code'] ?? 'N/A';
                    $totalFare += $goingFlights[$i]['Fares'][0]['TotalFare'];
                }

                if (isset($returnFlights[$i])) {
                    $flightPair['Flights'][] = $returnFlights[$i];
                    $totalFare += $returnFlights[$i]['Fares'][0]['TotalFare'];
                }

                if (! empty($flightPair['Flights'])) {
                    $flightPair['Flights'][0]['Fares'][0]['TotalFare']                       = $totalFare;
                    $flightPair['Flights'][0]['Fares'][0]['BillablePrice']                   = $totalFare;
                    $flightPair['Flights'][0]['Fares'][0]['PassengerFares'][0]['TotalPrice'] = $totalFare;

                    if (isset($flightPair['Flights'][1])) {
                        $flightPair['Flights'][1]['Fares'][0]['TotalFare']                       = $totalFare;
                        $flightPair['Flights'][1]['Fares'][0]['BillablePrice']                   = $totalFare;
                        $flightPair['Flights'][1]['Fares'][0]['PassengerFares'][0]['TotalPrice'] = $totalFare;
                    }

                }

                $finalData[] = $flightPair;

                // dd($finalData);
            }

            foreach ($finalData as $data) {
                $apiOffer            = new ApiOffer();
                $apiOffer->api       = "AirBlue";
                $apiOffer->data      = json_encode($data);
                $apiOffer->ref_key   = $data['itn_ref_key'];
                $apiOffer->finaldata = $data;
                $apiOffer->timestamp = time();
                $apiOffer->query     = json_encode($request);
                $apiOffer->save();
            }

            return ['status' => '200', 'msg' => $finalData];

        } else {
            return ['status' => '204', 'msg' => ['No flights found']];
        }
    }

    public static function makeResponseOneway($response, $request)
    {
        $finalData    = [];
        $responseData = $response['soap:Body']['AirLowFareSearchResponse']['AirLowFareSearchResult'];
        if (isset($responseData['Errors']['Error'])) {
            return [
                'status' => '400',
                'msg'    => [$responseData['Errors']['Error']],
            ];
        }
        if (! isset($responseData['PricedItineraries']) || empty($responseData['PricedItineraries'])) {
            return [
                'status' => '204',
                'msg'    => ['No flights found'],
            ];
        }

        if (! isset($responseData['PricedItineraries']['PricedItinerary']) || empty($responseData['PricedItineraries']['PricedItinerary'])) {
            return [
                'status' => '204',
                'msg'    => ['No flights found'],
            ];
        }

        $responseData = $responseData['PricedItineraries']['PricedItinerary'];

        if (! empty($responseData)) {
            foreach ($responseData as $key => $flight) {
                $segments        = [];
                $journeyDuration = 0;
                $passengerFares  = [];
                $baggagePolicy   = [];

                $originDestinationOptions = $flight['AirItinerary']['OriginDestinationOptions']['OriginDestinationOption'];
                foreach ($originDestinationOptions as $key_1 => $segment) {
                    $flightSegment = $segment['FlightSegment'] ?? $segment ?? null;

                    if (! $flightSegment || ! isset($flightSegment['OperatingAirline']['@attributes']['Code'])) {
                        continue;
                    }

                    $journeyDuration = self::getJourneyDuration($flightSegment['@attributes']['DepartureDateTime'], $flightSegment['@attributes']['ArrivalDateTime']);

                    $segments[] = [
                        'Duration'         => $journeyDuration,
                        'OperatingAirline' => [
                            'Code'         => $flightSegment['OperatingAirline']['@attributes']['Code'],
                            'FlightNumber' => $flightSegment['@attributes']['FlightNumber'],
                        ],
                        'MarketingAirline' => [
                            'Code'         => $flightSegment['MarketingAirline']['@attributes']['Code'],
                            'FlightNumber' => $flightSegment['@attributes']['FlightNumber'],
                        ],
                        'Departure'        => [
                            'LocationCode'      => $flightSegment['DepartureAirport']['@attributes']['LocationCode'],
                            'DepartureDateTime' => $flightSegment['@attributes']['DepartureDateTime'],
                        ],
                        'Arrival'          => [
                            'LocationCode'    => $flightSegment['ArrivalAirport']['@attributes']['LocationCode'],
                            'ArrivalDateTime' => $flightSegment['@attributes']['ArrivalDateTime'],
                        ],
                        'Cabin'            => $flightSegment['@attributes']['ResBookDesigCode'],
                        "CabinClass"       => "ECONOMY (" . $flightSegment['@attributes']['ResBookDesigCode'] . ")",
                        "AvailableSeats"   => rand(0, 50),
                        'EquipType'        => $flightSegment['Equipment']['@attributes']['AirEquipType'] ?? null,
                    ];
                }

                $baseFare = $flight['AirItineraryPricingInfo']['ItinTotalFare']['BaseFare']['@attributes']['Amount'];
                $taxes    = isset($flight['AirItineraryPricingInfo']['ItinTotalFare']['Taxes'])
                ? (int) $flight['AirItineraryPricingInfo']['ItinTotalFare']['Taxes']['@attributes']['Amount']
                : 0;
                $totalFare = $flight['AirItineraryPricingInfo']['ItinTotalFare']['TotalFare']['@attributes']['Amount'];

                // Process Passenger fares and baggage policy
                // if (! empty($flight['AirItineraryPricingInfo']['PTC_FareBreakdowns'])) {
                //     $fareBreakdowns = $flight['AirItineraryPricingInfo']['PTC_FareBreakdowns']['PTC_FareBreakdown'];
                //     if (! isset($fareBreakdowns[0])) {
                //         $fareBreakdowns = [$fareBreakdowns];
                //     }
                //     $passengerFares = [];
                //     foreach ($fareBreakdowns as $fareBreakdown) {
                //         $paxType   = $fareBreakdown['PassengerTypeQuantity']['@attributes']['Code'];
                //         $currency  = $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['CurrencyCode'];
                //         $quantity  = (int) $fareBreakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                //         $basePrice = (int) $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['Amount'];
                //         $taxes     = isset($fareBreakdown['PassengerFare']['Taxes']['@attributes']['Amount'])
                //         ? (int) $fareBreakdown['PassengerFare']['Taxes']['@attributes']['Amount']
                //         : 0;
                //         $fees = isset($fareBreakdown['PassengerFare']['Fees']['@attributes']['Amount'])
                //         ? (int) $fareBreakdown['PassengerFare']['Fees']['@attributes']['Amount']
                //         : 0;
                //         $totalPrice = (int) $fareBreakdown['PassengerFare']['TotalFare']['@attributes']['Amount'];
                //         $passengerFares[] = [
                //             'PaxType'        => $paxType,
                //             'Currency'       => $currency,
                //             'Quantity'       => $quantity,
                //             'BasePrice'      => $basePrice,
                //             'Taxes'          => $taxes,
                //             "Fees"           => $fees,
                //             "ServiceCharges" => 0,
                //             'TotalPrice'     => $totalPrice,
                //         ];

                //         if (isset($fareBreakdown['FareInfo'][1]['PassengerFare'])) {
                //             $weight = $fareBreakdown['FareInfo'][1]['PassengerFare'];
                //             if (isset($weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'])) {
                //                 $weight = $weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'];
                //             } else {
                //                 $weight = 0;
                //             }
                //         } else {
                //             $weight = 0;
                //         }
                //         $baggagePolicy[] = [
                //             'Weight'  => $weight ?? 0,
                //             'Unit'    => 'Kg',
                //             'PaxType' => $fareBreakdown['PassengerTypeQuantity']['@attributes']['Code'],
                //             'PaxType' => "none",
                //         ];
                //     }

                // }

                if (! empty($flight['AirItineraryPricingInfo']['PTC_FareBreakdowns'])) {
                    $fareBreakdowns = $flight['AirItineraryPricingInfo']['PTC_FareBreakdowns']['PTC_FareBreakdown'];

                    if (! isset($fareBreakdowns[0])) {
                        $fareBreakdowns = [$fareBreakdowns];
                    }

                    $passengerFares = [];
                    $baggagePolicy  = [];

                    foreach ($fareBreakdowns as $fareBreakdown) {
                        $paxType   = $fareBreakdown['PassengerTypeQuantity']['@attributes']['Code'];
                        $currency  = $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['CurrencyCode'];
                        $quantity  = (int) $fareBreakdown['PassengerTypeQuantity']['@attributes']['Quantity'];
                        $basePrice = (int) $fareBreakdown['PassengerFare']['BaseFare']['@attributes']['Amount'];
                        $taxes     = isset($fareBreakdown['PassengerFare']['Taxes']['@attributes']['Amount'])
                        ? (int) $fareBreakdown['PassengerFare']['Taxes']['@attributes']['Amount']
                        : 0;
                        $fees = isset($fareBreakdown['PassengerFare']['Fees']['@attributes']['Amount'])
                        ? (int) $fareBreakdown['PassengerFare']['Fees']['@attributes']['Amount']
                        : 0;
                        $totalPrice = (int) $fareBreakdown['PassengerFare']['TotalFare']['@attributes']['Amount'];

                        $passengerFares[] = [
                            'PaxType'        => $paxType,
                            'Currency'       => $currency,
                            'Quantity'       => $quantity,
                            'BasePrice'      => $basePrice,
                            'Taxes'          => $taxes,
                            "Fees"           => $fees,
                            "ServiceCharges" => 0,
                            'TotalPrice'     => $totalPrice,
                        ];

                        if (isset($fareBreakdown['FareInfo'][1]['PassengerFare'])) {
                            $weight = $fareBreakdown['FareInfo'][1]['PassengerFare'];
                            if (isset($weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'])) {
                                $weight = $weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'];
                            } else {
                                $weight = 0;
                            }
                        } else {
                            $weight = 0;
                        }

                        $baggagePolicy[] = [
                            'Weight'  => $weight ?? 0,
                            'Unit'    => 'Kg',
                            'PaxType' => $paxType,
                        ];
                    }
                } else {
                    $passengerFares = [
                        [
                            'PaxType'        => 'ADT',
                            'Currency'       => 'USD',
                            'Quantity'       => 1,
                            'BasePrice'      => 0,
                            'Taxes'          => 0,
                            "Fees"           => 0,
                            "ServiceCharges" => 0,
                            'TotalPrice'     => 0,
                        ],
                    ];
                    $baggagePolicy = [
                        [
                            'Weight'  => 0,
                            'Unit'    => 'Kg',
                            'PaxType' => 'none',
                        ],
                    ];
                }

                // if (isset($fareBreakdowns['FareInfo'][1]['PassengerFare'])) {
                //     $weight = $fareBreakdowns['FareInfo'][1]['PassengerFare'];
                //     if (isset($weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'])) {
                //         $weight = $weight['FareBaggageAllowance']['@attributes']['UnitOfMeasureQuantity'];
                //     } else {
                //         $weight = 0;
                //     }
                // } else {
                //     $weight = 0;
                // }
                // Example baggage policy
                // $baggagePolicy[] = [
                //     'Weight'  => $weight ?? 0,
                //     'Unit'    => 'Kg',
                //     'PaxType' => $fareBreakdown['PassengerTypeQuantity']['@attributes']['Code'],
                //     'PaxType' => "none",
                // ];

                // Extract Marketing Airline Code
                $originDestinationOption = $flight['AirItinerary']['OriginDestinationOptions']['OriginDestinationOption'] ?? null;
                $marketingAirlineCode    = is_array($originDestinationOption) && isset($originDestinationOption['FlightSegment']['MarketingAirline']['@attributes']['Code'])
                ? $originDestinationOption['FlightSegment']['MarketingAirline']['@attributes']['Code']
                : 'N/A';

                // Build the final response structure
                $finalData[] = [
                    'api'              => 'AirBlue',
                    'MarketingAirline' => [
                        'Airline'   => $marketingAirlineCode,
                        'FareRules' => 'NA',
                    ],
                    'Flights'          => [
                        [
                            'Segments'      => $segments,
                            'TotalDuration' => $journeyDuration,
                            'NonRefundable' => false,
                            'MultiFares'    => false,
                            'Fares'         => [[
                                'RefID'          => Str::uuid(),
                                'Currency'       => 'PKR',
                                'BaseFare'       => (int) $baseFare,
                                'Taxes'          => (int) $taxes,
                                'TotalFare'      => (int) $totalFare,
                                'BillablePrice'  => (int) $totalFare,
                                'BaggagePolicy'  => $baggagePolicy,
                                'PassengerFares' => $passengerFares,
                            ]],
                        ],
                    ],
                    'itn_ref_key'      => Str::uuid(),
                ];
            }
            // Save data to database (example)
            foreach ($finalData as $data) {
                $apiOffer            = new ApiOffer();
                $apiOffer->api       = "AirBlue";
                $apiOffer->data      = json_encode($data);
                $apiOffer->ref_key   = $data['itn_ref_key'];
                $apiOffer->finaldata = $data;
                $apiOffer->timestamp = time();
                $apiOffer->query     = json_encode($request);
                $apiOffer->save();
            }
            // Wrap final data inside an indexed array
            return ['status' => '200', 'msg' => $finalData];
        } else {
            return ['status' => '204', 'msg' => ['No flights found']];
        }
    }

    private static function getJourneyDuration($departure, $arrival)
    {
        $departureTime = new DateTime($departure);
        $arrivalTime   = new DateTime($arrival);

        $interval = $departureTime->diff($arrivalTime);

        return ($interval->h * 60) + $interval->i;
    }

}
