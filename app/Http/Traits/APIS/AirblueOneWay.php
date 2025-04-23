<?php

require_once "../router.php";
use AppRouter\Router;

$router->get('/', function() {
    header('Content-Type: application/json');

    // Production API endpoint
    $url = "https://ota3.zapways.com/v2.0/OTAAPI.asmx";

    // SOAP XML payload
    $xmlPayload = <<<XML
        <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
            <Header/>
            <Body>
                <AirLowFareSearch xmlns="http://zapways.com/air/ota/2.0">
                    <airLowFareSearchRQ EchoToken="-8586704355136787339" Target="Production" Version="1.04" xmlns="http://www.opentravel.org/OTA/2003/05">
                        <POS>
                            <Source ERSP_UserID="1942/21329E055EBD7C7FE0CF559DA20067651A">
                                <RequestorID Type="29" ID="binhamtravelota" MessagePassword="k5dv!rMv9ExDRkXT8"/>
                            </Source>
                        </POS>
                        <OriginDestinationInformation RPH="1">
                            <DepartureDateTime>2024-12-10T00:16:30</DepartureDateTime>
                            <OriginLocation LocationCode="LHE"/>
                            <DestinationLocation LocationCode="KHI"/>
                        </OriginDestinationInformation>
                        <TravelerInfoSummary>
                            <AirTravelerAvail>
                                <PassengerTypeQuantity Code="ADT" Quantity="1"/>
                                <PassengerTypeQuantity Code="CHD" Quantity="2"/>
                                <PassengerTypeQuantity Code="INF" Quantity="0"/>
                            </AirTravelerAvail>
                        </TravelerInfoSummary>
                    </airLowFareSearchRQ>
                </AirLowFareSearch>
            </Body>
        </Envelope>
    XML;

    // Helper function for airline names
    function getAirlineName($code) {
        $airlineNames = [
            "PA" => "Airblue",
            // Add more mappings as required
        ];
        return $airlineNames[$code] ?? $code; // Return code if name not found
    }

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: text/xml; charset=utf-8",
        "Content-Length: " . strlen($xmlPayload),
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlPayload);
    curl_setopt($ch, CURLOPT_SSLCERT, __DIR__ . '/cert.pem'); // Replace with actual path to cert.pem
    curl_setopt($ch, CURLOPT_SSLKEY, __DIR__ . '/key.pem');   // Replace with actual path to key.pem
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    // Execute request
    $response = curl_exec($ch);

    // Handle errors
    if ($response === false) {
        echo json_encode([
            "status" => "error",
            "message" => curl_error($ch)
        ]);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    // Parse XML
    $xmlObject = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);

    if ($xmlObject === false) {
        $errors = libxml_get_errors();
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = $error->message;
        }
        echo json_encode([
            "status" => "error",
            "message" => "Failed to parse XML response",
            "errors" => $errorMessages
        ]);
        exit;
    }

    // Extract the relevant portion of the response
    $xmlObject->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
    $body = $xmlObject->xpath('//soap:Body')[0];
    $airLowFareSearchResponse = $body->AirLowFareSearchResponse->AirLowFareSearchResult;

    // Convert to desired JSON structure
    $results = [];
    foreach ($airLowFareSearchResponse->PricedItineraries->PricedItinerary as $itinerary) {
        $segment = $itinerary->AirItinerary->OriginDestinationOptions->OriginDestinationOption->FlightSegment;

        $departure_time = (string)$segment['DepartureDateTime'];
        $arrival_time = (string)$segment['ArrivalDateTime'];

        // Calculate duration dynamically
        $duration = (new DateTime($arrival_time))->diff(new DateTime($departure_time));
        $total_duration = $duration->format('%H:%I');

        // Extract baggage information dynamically
        $checked_baggage = (string)$itinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown->PassengerFare->FareBaggageAllowance['UnitOfMeasureQuantity'] ?? "Not Provided";
        $cabin_baggage = "7KG"; // Default cabin baggage (update dynamically if available)

        // Extract airline information dynamically
        $airline_code = (string)$segment->OperatingAirline['Code'];
        $airline_name = getAirlineName($airline_code);

        // Determine flight class dynamically
        $class = (string)$segment['ResBookDesigCode'] ?? "Economy";

        // Determine flight type (one-way, return, multi-city)
        $flight_type = count($itinerary->AirItinerary->OriginDestinationOptions->OriginDestinationOption) > 1 ? "return" : "oneway";

        // Extract pricing dynamically
        $adult_price = 0;
        $child_price = 0;
        $infant_price = 0;
        $total_price = 0;

        foreach ($itinerary->AirItineraryPricingInfo->PTC_FareBreakdowns->PTC_FareBreakdown as $fareBreakdown) {
            $passengerType = (string)$fareBreakdown->PassengerTypeQuantity['Code'];
            $passengerQuantity = (int)$fareBreakdown->PassengerTypeQuantity['Quantity'];
            $passengerFare = (float)$fareBreakdown->PassengerFare->TotalFare['Amount'];

            switch ($passengerType) {
                case 'ADT': // Adult
                    $adult_price = $passengerFare;
                    $total_price += $adult_price * $passengerQuantity;
                    break;
                case 'CHD': // Child
                    $child_price = $passengerFare;
                    $total_price += $child_price * $passengerQuantity;
                    break;
                case 'INF': // Infant
                    $infant_price = $passengerFare;
                    $total_price += $infant_price * $passengerQuantity;
                    break;
            }
        }

        $results[] = (object)[
            'img' => $airline_code,
            'flight_no' => (string)$segment['FlightNumber'],
            'airline' => $airline_name,
            'class' => $class,
            "checked_baggage" => $checked_baggage . "KG",
            "cabin_baggage" => $cabin_baggage,
            'departure_airport' => (string)$segment->DepartureAirport['LocationCode'],
            'departure_date' => date('d-m-Y', strtotime($departure_time)),
            'departure_time' => date('H:i', strtotime($departure_time)),
            'arrival_airport' => (string)$segment->ArrivalAirport['LocationCode'],
            'arrival_date' => date('d-m-Y', strtotime($arrival_time)),
            'arrival_time' => date('H:i', strtotime($arrival_time)),
            'duration' => $total_duration,
            'currency' => "PKR",
            'price' => number_format($total_price),
            'adult_price' => number_format($adult_price),
            'child_price' => number_format($child_price),
            'infant_price' => number_format($infant_price),
            "type" => $flight_type,
            'supplier' => $airline_name,
            "stops" => isset($segment->StopLocations->StopLocation) ? count($segment->StopLocations->StopLocation) : 0,
        ];
    }

    // Output the results as JSON
    echo json_encode($results, JSON_PRETTY_PRINT);
});

$router->dispatchGlobal();
