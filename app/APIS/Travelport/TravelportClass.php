<?php

namespace App\APIS\Travelport;

use Illuminate\Support\Facades\Storage;
use App\Models\ApiOfferModel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Exception;

class TravelportClass
{
   /********************************************************************************\
   |*************************************pre production*****************************|
   \********************************************************************************/

    protected static $link = ('https://emea.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService');

    protected static $link2 = ("https://emea.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");

    protected static $link3 = ("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");


   /********************************************************************************\
   |*************************************production*********************************|
   \********************************************************************************/

//   protected static $link = ('https://emea.universal-api.travelport.com/B2BGateway/connect/uAPI/AirService');

//   protected static $link2 = ("https://emea.universal-api.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");

//   protected static $link3 = ("https://apac.universal-api.travelport.com/B2BGateway/connect/uAPI/AirService");

   /********************************************************************************\
   |***********************************Functions Starts*****************************|
   \********************************************************************************/
   public static function lowFareSearch($request)
   {
      $apiObject = json_decode($request->apiObject);
      dd($request,$apiObject);
      if ($request->airlines == "") {
         $allowedAirlinesArray = [];
      } else {
         $allowedAirlinesArray = explode(',', $request->airlines);
      }

      $message = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                  <soap:Body>
                     <air:LowFareSearchReq TargetBranch="' . $apiObject->targetBranch . '" TraceId="' . rand(0, 9999999999) . '" ReturnUpsellFare="true" SolutionResult="false" AuthorizedBy="USER" 
                       xmlns:air="http://www.travelport.com/schema/air_v51_0" 
                       xmlns:com="http://www.travelport.com/schema/common_v51_0">
                        <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>';

      $message .=    '<air:SearchAirLeg>
                           <air:SearchOrigin>
                              <com:Airport Code="' . $request->origin . '"/>
                           </air:SearchOrigin>
                           <air:SearchDestination>
                              <com:Airport Code="' . $request->destination . '"/>
                           </air:SearchDestination>
                           <air:SearchDepTime PreferredTime="' . $request->departureDate . '"/>
                           
                        </air:SearchAirLeg>';
      if ($request->trip == 'Return') {
         $message .=       '<air:SearchAirLeg>
                              <air:SearchOrigin>
                                 <com:Airport Code="' . $request->destination . '"/>
                              </air:SearchOrigin>
                              <air:SearchDestination>
                                 <com:Airport Code="' . $request->origin . '"/>
                              </air:SearchDestination>
                              <air:SearchDepTime PreferredTime="' . $request->arrivalDate . '"/>
                           </air:SearchAirLeg>';
      }

      $message  .=      '<air:AirSearchModifiers IncludeFlightDetails="true">
                           <air:PreferredProviders>
                              <com:Provider Code="' . $apiObject->provider . '"/>
                           </air:PreferredProviders>
                           
                        </air:AirSearchModifiers>';
      $passTypeKeys = array();
      $j = 0;
      if ($request->adults != null) {
         for ($i = 1; $i <= $request->adults; $i++) {
            $BookingTravelerRef = (string) Str::random(22);
            $message  .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerRef . '==" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v51_0"/>';
            $passTypeKeys['ADT'][$j]['BookingTravelerRef'] = $BookingTravelerRef;
            $j++;
         }
      }
      if ($request->children != null) {
         for ($i = 1; $i <= $request->children; $i++) {
            $BookingTravelerRef2 = (string) Str::random(22);
            $message  .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerRef2 . '==" Code="CNN" Age="10" DOB="2011-12-24" xmlns:com="http://www.travelport.com/schema/common_v51_0"/>';
            $passTypeKeys['CNN'][$j]['BookingTravelerRef'] = $BookingTravelerRef2;
            $j++;
         }
      }
      if ($request->infants != null) {
         for ($i = 1; $i <= $request->infants; $i++) {
            $BookingTravelerRef3 = (string) Str::random(22);
            $message  .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerRef3 . '==" Code="INF" Age="1" xmlns:com="http://www.travelport.com/schema/common_v51_0"/>';
            $passTypeKeys['INF'][$j]['BookingTravelerRef'] = $BookingTravelerRef3;
            $j++;
         }
      }


      $message  .= '<air:AirPricingModifiers CurrencyType="' . $apiObject->currency . '" FaresIndicator="AllFares"/>
                     </air:LowFareSearchReq>
                  </soap:Body>
               </soap:Envelope>';
      if ($request->trip == 'ONE_WAY') {
         Storage::put('travelport/search/LowFareSearchReq.xml', self::prettyPrint($message));
         $res = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
         Storage::put('travelport/search/LowFareSearchRsp.xml', self::prettyPrint($res));
         dd($res);

         if (str_contains($res, 'Authentication Result Error Message Response')) {
            $error['status'] = 400;
            $error['msg']['error'] = 'error';
            $error['msg']['api'] = 'Travelport';
            $error['msg']['message'] = 'Authentication Result Error Message Response';
            return $error;
         }

         $rest = self::convertToArray($res);
         $finalData = self::makeResponse($rest, $request, $allowedAirlinesArray, $passTypeKeys);
      } else {

         Storage::put('travelport/search/returnFlightSearchRequest.xml', self::prettyPrint($message));
         $res = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
         Storage::put('travelport/search/returnFlightSearchResponse.xml', self::prettyPrint($res));

         if (str_contains($res, 'Authentication Result Error Message Response')) {
            $error['status'] = 400;
            $error['msg']['error'] = 'error';
            $error['msg']['api'] = 'Travelport';
            $error['msg']['message'] = 'Authentication Result Error Message Response';
            return $error;
         }

         $rest = self::convertToArray($res);
         $finalData = self::makeResponse($rest, $request, $allowedAirlinesArray, $passTypeKeys);
      }

      if (@$finalData['error']) {
         return ['status' => '400', 'msg' => $finalData];
      } else {
         return ['status' => '200', 'msg' => $finalData];
      }
   }
   public static function lowFareSearchMulti($request)
   {
      $apiObject = json_decode($request->apiObject);

      if ($request->airlines == "") {
         $allowedAirlinesArray = [];
      } else {
         $allowedAirlinesArray = explode(',', $request->airlines);
      }

      $message = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
               <air:LowFareSearchReq TargetBranch="' . $apiObject->targetBranch . '" TraceId="Trace" SolutionResult="false" AuthorizedBy="USER" 
               xmlns:air="http://www.travelport.com/schema/air_v51_0" 
               xmlns:com="http://www.travelport.com/schema/common_v51_0">
                  <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>';

      foreach ($request->leg as $key => $leg) {
         $message .=       '<air:SearchAirLeg>
                        <air:SearchOrigin>
                           <com:CityOrAirport Code="' . $leg['origin'] . '" PreferCity="true"/>
                        </air:SearchOrigin>
                        <air:SearchDestination>
                           <com:CityOrAirport Code="' . $leg['destination'] . '" PreferCity="true"/>
                        </air:SearchDestination>
                        <air:SearchDepTime PreferredTime="' . date('Y-m-d', strtotime($leg['departureDate'])) . '"/>
                        <air:AirLegModifiers AllowDirectAccess="true">
                           <air:PreferredCabins>
                           <CabinClass xmlns="http://www.travelport.com/schema/common_v51_0" Type="ECONOMY" />
                           </air:PreferredCabins>
                        </air:AirLegModifiers>
                     </air:SearchAirLeg>';
      }
      $message  .=      '<air:AirSearchModifiers IncludeFlightDetails="true">
                        <air:PreferredProviders>
                           <com:Provider Code="' . $apiObject->provider . '"/>
                        </air:PreferredProviders>
                     </air:AirSearchModifiers>';
      $passTypeKeys = array();
      $j = 0;
      if ($request->adults != null) {
         for ($i = 1; $i <= $request->adults; $i++) {
            $BookingTravelerRef = (string) Str::random(22);
            $message  .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerRef . '==" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v51_0"/>';
            $passTypeKeys['ADT'][$j]['BookingTravelerRef'] = $BookingTravelerRef;
            $j++;
         }
      }
      if ($request->children != null) {
         for ($i = 1; $i <= $request->children; $i++) {
            $BookingTravelerRef2 = (string) Str::random(22);
            $message  .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerRef2 . '==" Code="CNN" Age="10" DOB="2011-12-24" xmlns:com="http://www.travelport.com/schema/common_v51_0"/>';
            $passTypeKeys['CNN'][$j]['BookingTravelerRef'] = $BookingTravelerRef2;
            $j++;
         }
      }
      if ($request->infants != null) {
         for ($i = 1; $i <= $request->infants; $i++) {
            $BookingTravelerRef3 = (string) Str::random(22);
            $message  .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerRef3 . '==" Code="INF" Age="1" xmlns:com="http://www.travelport.com/schema/common_v51_0"/>';
            $passTypeKeys['INF'][$j]['BookingTravelerRef'] = $BookingTravelerRef3;
            $j++;
         }
      }
      $message  .= '<air:AirPricingModifiers CurrencyType="' . $apiObject->currency . '" FaresIndicator="AllFares"/>
                  </air:LowFareSearchReq>
               </soap:Body>
            </soap:Envelope>';

      Storage::put('travelport/search/multiFlightSearchRequest' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      $res = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
      Storage::put('travelport/search/multiFlightSearchResponse' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($res));

      $rest = self::convertToArray($res);

      $finalData = self::makeResponse($rest, $request, $allowedAirlinesArray, $passTypeKeys);

      if (@$finalData['error']) {
         return ['status' => '400', 'msg' => $finalData];
      } else {
         return ['status' => '200', 'msg' => $finalData];
      }
   }

   public static function createPnr($request)
   {
      $optionalBagg =  json_decode($request->optionalBagg,true);
      // return $optionalBagg;
      $apiObject = json_decode($request->apiObject);
      $res = json_decode($request->data, true);
      $passData = json_decode($request->passengerData, true);

      $TraceId = $res[0]['TraceId'];
      $passTypeKeys = $res[0]['passTypeKeys'];
      if(@$optionalBagg && @$optionalBagg != ''){
         $priceSolutionSegments['air_AirPricingSolution'][0] = $optionalBagg['AirPricingSolution'];
         $priceSolutionSegments['air_AirSegment'] = $optionalBagg['air_AirSegments'];
      }else{
         $priceSolutionSegments = self::airPrice($res, $passData, $apiObject);
      }
     
      if (@$priceSolutionSegments['error']) {
         return $priceSolutionSegments;
      }
      $message = self::createPnrRequest($TraceId, $passTypeKeys, $priceSolutionSegments, $request, $apiObject);


      // Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/AirCreateReservationReq' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      // return $message;
      // $resp = Storage::get('travelport/14/AirCreateReservationRsp2022-11-16-16-21-03.xml');

      
      $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/AirCreateReservationRsp' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));


      $response = self::convertToArray2($resp);

      if (@$response['SOAP_Body']['SOAP_Fault']) {
         $respnr = [
            'status' => '500',
            'error' => @$response['SOAP_Body']['SOAP_Fault']['faultstring'],
            'msg' => @$response['SOAP_Body']['SOAP_Fault']
         ];
      } else {
         $pnr = @$response['SOAP_Body']['universal_AirCreateReservationRsp']['universal_UniversalRecord']['universal_ProviderReservationInfo']['@attributes']['LocatorCode'];
         $uapipnr = @$response['SOAP_Body']['universal_AirCreateReservationRsp']['universal_UniversalRecord']['@attributes']['LocatorCode'];

         if(@$response['SOAP_Body']['universal_AirCreateReservationRsp']['universal_UniversalRecord']['air_AirReservation']['common_v51_0_SupplierLocator']){
            
            $supplierArray = @$response['SOAP_Body']['universal_AirCreateReservationRsp']['universal_UniversalRecord']['air_AirReservation']['common_v51_0_SupplierLocator'];

            if (!array_key_exists("0", $supplierArray)) {
               $supplierArray = self::putOnZeroIndex($supplierArray);
            }

            $supplierCode = "";
            if (@$supplierArray) {
               foreach ($supplierArray as $key => $supplier) {
                  $supplierCode .= $supplier['@attributes']['SupplierLocatorCode'] . '(' . $supplier['@attributes']['SupplierCode'] . ')';
                  if ($key < count($supplierArray) - 1) {
                     $supplierCode .= '/';
                  }
               }
            }
         }

         if ($pnr) {
            $respnr = ['status' => '200', 'pnr' => $pnr, 'uapipnr' => $uapipnr, 'supplierCode' => @$supplierCode, 'msg' => json_encode($response)];
         } else {
            $errorMessage =  @$response['SOAP_Body']['universal_AirCreateReservationRsp']['common_v51_0_ResponseMessage'];
            if (!array_key_exists("0", $errorMessage)) {
               $errorMessage = self::putOnZeroIndex($errorMessage);
            }
            if ($errorMessage) {
               $respnr = ['status' => '500', 'error' => $errorMessage[0], 'msg' => @$response['SOAP_Body']];
            } else {
               $respnr = ['status' => '500', 'error' => 'Something went wrong......'];
            }
         }
      }

      return $respnr;
   }

   public static function airPrice($res, $passData, $apiObject)
   {
      $carrier = '';
      $segment = '';
      $segmentsKey = '';
      $TraceId = $res[0]['TraceId'];
      if ($res) {
         foreach ($res as $key => $segments) {
            $numItems = count($segments['segments']);
            $i = 0;
            foreach ($segments['segments'] as $singleSeg) {
               $segment .= '<air:AirSegment ';
               $segment .= 'ProviderCode="' . $apiObject->provider . '" ';
               foreach ($singleSeg['@attributes'] as $segAttr2 => $segVal2) {
                  if ($segAttr2 == 'Carrier') {
                     $carrier = $segVal2;
                  }
                  // if ($segAttr2 == 'OptionalServicesIndicator') {
                  //    $segVal2 = "true";
                  // }
                  if ($segAttr2 == 'Key') {
                     $segmentsKey = $segVal2;
                  }

                  $segment .= '' . $segAttr2 . '="' . $segVal2 . '" ';
               }
               $segment .= '>';
               if (++$i !== $numItems) {
                  $segment .= '<air:Connection/>';
               }
               $segment .= '</air:AirSegment>';
            }
         }
      }

      $passTypeKeys = $res[0]['passTypeKeys'];
      $passengers = '';
      $message = '';
      if (@$passData['Adult']) {
         $ADTKey = array_values($passTypeKeys['ADT']);
         foreach ($passData['Adult'] as $key => $ADT) {
            $age = Carbon::parse(@$ADT['dob'])->age;
            $BookingTravelerKey1 = $ADTKey[$key]['BookingTravelerRef'];
            $passengers .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerKey1 . '" Code="ADT" Age="' . $age . '"/>';
         }
      }
      if (@$passData['Child']) {
         $CNNKey = array_values($passTypeKeys['CNN']);
         foreach ($passData['Child'] as $key => $CNN) {
            $age = Carbon::parse(@$CNN['dob'])->age;
            $BookingTravelerKey3 = $CNNKey[$key]['BookingTravelerRef'];
            $passengers .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerKey3 . '" Code="CNN" Age="' . $age . '"/>';
         }
      }
      if (@$passData['Infant']) {
         $INFKey = array_values($passTypeKeys['INF']);
         foreach ($passData['Infant'] as $key => $INF) {
            $age = Carbon::parse(@$INF['dob'])->age;
            $BookingTravelerKey2 = $INFKey[$key]['BookingTravelerRef'];
            $passengers .= '<com:SearchPassenger BookingTravelerRef="' . $BookingTravelerKey2 . '" Code="INF" Age="' . $age . '"/>';
         }
      }

      $message .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
                    <soapenv:Header/>
                    <soapenv:Body>
                      <air:AirPriceReq xmlns:air="http://www.travelport.com/schema/air_v51_0" xmlns:com="http://www.travelport.com/schema/common_v51_0" AuthorizedBy="user" TraceId="' . $TraceId . '" TargetBranch="' . $apiObject->targetBranch . '" FareRuleType="short" CheckOBFees="FOPOnly" CheckFlightDetails="true">
                        <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
                        <air:AirItinerary>'
         . $segment .
         '</air:AirItinerary>
                        <air:AirPricingModifiers InventoryRequestType="DirectAccess" FaresIndicator="AllFares" CurrencyType="' . $apiObject->currency . '" PlatingCarrier="'.$carrier.'"> 
                           <air:BrandModifiers>
                              <air:FareFamilyDisplay ModifierType="FareFamily" />
                           </air:BrandModifiers>
                        </air:AirPricingModifiers>'
         . $passengers .
                     '</air:AirPriceReq>
                    </soapenv:Body>
                  </soapenv:Envelope>';

      /*************Get Static AirPrice Respnse*******************/
      // $resp = Storage::get('travelport/airPriceRes-Live2.xml');

      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/airPriceReq' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/airPriceRes' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));


      $response = self::convertToArray2($resp);

      if (@$response['SOAP_Body']['SOAP_Fault']) {
         $finalResponse = ['status' => '500', 'error' => @$response['SOAP_Body']['SOAP_Fault']['detail']['common_v51_0_ErrorInfo']['common_v51_0_Description']];
      } else {
         $air_AirSegment = $response['SOAP_Body']['air_AirPriceRsp']['air_AirItinerary']['air_AirSegment'];
         $air_AirPricingSolution = $response['SOAP_Body']['air_AirPriceRsp']['air_AirPriceResult']['air_AirPricingSolution'];
         if (!array_key_exists("0", $air_AirPricingSolution)) {
            $air_AirPricingSolution = self::putOnZeroIndex($air_AirPricingSolution);
         }

         $air_OptionalServices = @$air_AirPricingSolution[0]['air_AirPricingInfo']['air_FareInfo']['air_Brand']['air_OptionalServices'];
         
         $serviceArray = array();
         if(@$air_OptionalServices){
            foreach($air_OptionalServices['air_OptionalService'] as $key => $service){
               if($service['@attributes']['Type'] == 'Baggage'){
                  $Key = $service['@attributes']['Key'];
                  $Chargeable = $service['@attributes']['Chargeable'];
                  $Tag = $service['@attributes']['Tag'];
                  $Description = $service['common_v51_0_ServiceInfo']['common_v51_0_Description'];
                  $AssociatedItem = @$service['air_EMD']['@attributes']['AssociatedItem'];

                  $serviceArray[] = compact('Key','Chargeable','Tag','Description','AssociatedItem',);
               }
            }
         }

         $finalResponse = compact('air_AirSegment','air_AirPricingSolution','air_OptionalServices');
      }
      return $finalResponse;
   }

   public static function airPriceForBaggage($request)
   {
      
      $apiObj = $request->apiObject;
      $resp = $request->data;
      $res = json_decode($resp,true);
      $apiObject = json_decode($apiObj);
      $passTypeKeys = $res[0]['passTypeKeys'];
      $cabin = json_decode($request->cabin);


      $carrier = '';
      $segment = '';
      $segmentsKey = array();
      $TraceId = $res[0]['TraceId'];
      if ($res) {
         foreach ($res as $key => $segments) {
            $numItems = count($segments['segments']);
            $i = 0;
            foreach ($segments['segments'] as $segKey => $singleSeg) {
              
               $segment .= '<air:AirSegment ';
               $segment .= 'ProviderCode="' . $apiObject->provider . '" ClassOfService="'.$cabin[$segKey].'" ';
               foreach ($singleSeg['@attributes'] as $segAttr2 => $segVal2) {
                  if ($segAttr2 == 'Carrier') {
                     $carrier = $segVal2;
                  }
                  if ($segAttr2 == 'Key') {
                     $segmentsKey[$key][$segKey]['Key'] = $segVal2;
                     $segmentsKey[$key][$segKey]['Cabin'] = $cabin[$segKey];
                  }

                  $segment .= '' . $segAttr2 . '="' . $segVal2 . '" ';
               }
               $segment .= '>';
               if (++$i !== $numItems) {
                  $segment .= '<air:Connection/>';
               }
               // $segment .= '<air:AirAvailInfo ProviderCode="' . $apiObject->provider . '"/>';
               $segment .= '</air:AirSegment>';
            }
         }
      }
      
      
      $passengers = '';
      $message = '';
      if (@$passTypeKeys['ADT']) {
         $ADTKey = array_values($passTypeKeys['ADT']);
         foreach ($passTypeKeys['ADT'] as $ADTkey => $travelKey) {
            $passengers .= '<com:SearchPassenger BookingTravelerRef="' . $travelKey['BookingTravelerRef'] . '" Code="ADT"/>';
         }
      }
      if (@$passTypeKeys['CNN']) {
         $ADTKey = array_values($passTypeKeys['CNN']);
         foreach ($passTypeKeys['CNN'] as $CNNkey => $travelKeyCNN) {
            $passengers .= '<com:SearchPassenger BookingTravelerRef="' . $travelKeyCNN['BookingTravelerRef'] . '" Code="CNN" Age="10"/>';
         }
      }
      if (@$passTypeKeys['INF']) {
         $ADTKey = array_values($passTypeKeys['INF']);
         foreach ($passTypeKeys['INF'] as $INFkey => $travelKeyINF) {
            $passengers .= '<com:SearchPassenger BookingTravelerRef="' . $travelKeyINF['BookingTravelerRef'] . '" Code="INF"/>';
         }
      }
      $PermittedBookingCodes = '';
      if (@$segmentsKey) {

         foreach ($segmentsKey as $b => $flightss) {

            foreach ($flightss as $BookingCode) {
               $PermittedBookingCodes .= '<air:AirSegmentPricingModifiers AirSegmentRef="' . $BookingCode['Key'] . '">  
                   <air:PermittedBookingCodes>  
                     <air:BookingCode Code="' . $BookingCode['Cabin'] . '" /> 
                   </air:PermittedBookingCodes> 
                 </air:AirSegmentPricingModifiers>';
            }
         }
      }
      
      $message .= '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
           <soapenv:Header/>
           <soapenv:Body>
             <air:AirPriceReq xmlns:air="http://www.travelport.com/schema/air_v51_0" xmlns:com="http://www.travelport.com/schema/common_v51_0" AuthorizedBy="user" TraceId="' . $TraceId . '" TargetBranch="' . $apiObject->targetBranch . '" FareRuleType="none" CheckFlightDetails="true" MostRestrictivePenalties="true" CheckOBFees="FOPOnly">
               <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
               <air:AirItinerary>'
                  . $segment .
               '</air:AirItinerary>
               <air:AirPricingModifiers CurrencyType="' . $apiObject->currency . '" ReturnServices="true" InventoryRequestType="DirectAccess" FaresIndicator="AllFares" PlatingCarrier="'.$carrier.'">
                     <air:BrandModifiers>
                           <air:FareFamilyDisplay ModifierType="FareFamily"/>
                     </air:BrandModifiers>
               </air:AirPricingModifiers>'
                  . $passengers .
               '<air:AirPricingCommand>'
                  .$PermittedBookingCodes.
               '</air:AirPricingCommand>

             </air:AirPriceReq>
           </soapenv:Body>
         </soapenv:Envelope>';

      /*************Get Static AirPrice Respnse*******************/
      // $resp = Storage::get('travelport/4/airPriceRes.xml');
      // $resp = Storage::get('travelport/222/airPriceRes.xml');

      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/airPriceReq' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/airPriceRes' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));


      $response = self::convertToArray2($resp);
      // return $response;
      if (@$response['SOAP_Body']['SOAP_Fault']) {
         $finalResponse = ['status' => '500', 'error' => @$response['SOAP_Body']['SOAP_Fault']['detail']['common_v51_0_ErrorInfo']['common_v51_0_Description']];
      } else {
         $air_AirSegments = $response['SOAP_Body']['air_AirPriceRsp']['air_AirItinerary']['air_AirSegment'];
         $air_AirPricingSolution = $response['SOAP_Body']['air_AirPriceRsp']['air_AirPriceResult']['air_AirPricingSolution'];

         if (!array_key_exists("0", $air_AirPricingSolution)) {
            $air_AirPricingSolution = self::putOnZeroIndex($air_AirPricingSolution);
         }

         $priceSolutionArray = array();
         $Fares = array();
         if($air_AirPricingSolution){
            $loop1 = 0;
            
            foreach($air_AirPricingSolution as $priceSolution){

               $Key = $priceSolution['@attributes']['Key'];
               $TotalPrice = str_replace($apiObject->currency, '', $priceSolution['@attributes']['TotalPrice']);
               $CurrencyCode = $apiObject->currencySymbol;
               $air_AirPricingInfo = $priceSolution['air_AirPricingInfo'];

               if (!array_key_exists("0", $air_AirPricingInfo)) {
                  $air_AirPricingInfo = self::putOnZeroIndex($air_AirPricingInfo);
               }

               $Fares['CurrencyCode'] = $CurrencyCode;
               $Fares['TotalPrice'] = $TotalPrice;

               // return $air_AirPricingInfo;
               foreach($air_AirPricingInfo as $PriceInfkey => $PricingInfo){
                  if (!array_key_exists("0", $PricingInfo['air_FareInfo'])) {
                     $PricingInfo['air_FareInfo'] = self::putOnZeroIndex($PricingInfo['air_FareInfo']);
                  }

                  $passTypeKeys = $PricingInfo['air_FareInfo'][0]['@attributes']['PassengerTypeCode'];
                  if($passTypeKeys == 'ADT'){   
                     $Quantity = count($PricingInfo['air_PassengerType']); 
                  }  
                  if($passTypeKeys == 'CNN'){   
                     $Quantity = count($PricingInfo['air_PassengerType']); 
                  }  
                  if($passTypeKeys == 'INF'){   
                     $Quantity = count($PricingInfo['air_PassengerType']); 
                  }  

                  $TotalFare = str_replace($apiObject->currency, '',$PricingInfo['@attributes']['ApproximateTotalPrice']);
                  $BaseFare = str_replace($apiObject->currency, '',$PricingInfo['@attributes']['ApproximateBasePrice']);
                  $TotalTax = str_replace($apiObject->currency, '',$PricingInfo['@attributes']['ApproximateTaxes']);

                  $Fares['fareBreakDown'][$passTypeKeys]['Quantity'] = $Quantity;
                  $Fares['fareBreakDown'][$passTypeKeys]['TotalFare'] = $TotalFare;
                  $Fares['fareBreakDown'][$passTypeKeys]['BaseFare'] = $BaseFare;
                  $Fares['fareBreakDown'][$passTypeKeys]['TotalTax'] = $TotalTax;

               }

               if (!array_key_exists("0", $air_AirPricingInfo[0]['air_FareInfo'])) {
                     $air_AirPricingInfo[0]['air_FareInfo'] = self::putOnZeroIndex($air_AirPricingInfo[0]['air_FareInfo']);
                  }

               $OptionName = $air_AirPricingInfo[0]['air_FareInfo'][0]['air_Brand']['@attributes']['Name'];
               $BrandTier = $air_AirPricingInfo[0]['air_FareInfo'][0]['air_Brand']['@attributes']['BrandTier'];
               $air_Options = $air_AirPricingInfo[0]['air_FareInfo'][0]['air_Brand']['air_OptionalServices'];

               $loop2 = 0;
               foreach($air_Options['air_OptionalService'] as $key2 => $service){
                  if($service['@attributes']['Type'] == 'Baggage' && $service['@attributes']['Chargeable'] == 'Included in the brand'){
                     $priceSolutionArray[$loop1]['air_OptionalService'][$loop2]['Tag'] = $service['@attributes']['Tag'];
                     $priceSolutionArray[$loop1]['air_OptionalService'][$loop2]['Title'] = $service['air_Title'][0];
                     $priceSolutionArray[$loop1]['AirPricingSolution'] = $priceSolution;
                     $priceSolutionArray[$loop1]['air_AirSegments'] = $air_AirSegments;
                     $priceSolutionArray[$loop1]['Segments'] = $segment;
                     $priceSolutionArray[$loop1]['SegmentsKey'] = json_encode($segmentsKey);
                     $priceSolutionArray[$loop1]['Passengers'] = $passengers;
                     $priceSolutionArray[$loop1]['TraceId'] = $TraceId;
                     $priceSolutionArray[$loop1]['Key'] = $Key;
                     $priceSolutionArray[$loop1]['Name'] = $OptionName;
                     $priceSolutionArray[$loop1]['BrandTier'] = $BrandTier;
                     $priceSolutionArray[$loop1]['TotalPrice'] = $TotalPrice;
                     $priceSolutionArray[$loop1]['CurrencyCode'] = $CurrencyCode;
                     $priceSolutionArray[$loop1]['Fares'] = $Fares;
                     $loop2++;
                  }
               }
               $loop1++;
            }
         }
         return $priceSolutionArray;

      }   
   }
   public static function airPriceForOptionalFlight($request){
      $apiObject = json_decode($request->apiObject);
      $brandtier = json_decode($request->brandtier);
      $segmentskey = json_decode($request->segmentskey,true);
      $segments = $request->segments;
      $passengers = $request->passengers;
      $TraceId = $request->traceid;

      
      $PermittedBookingCodes = '';
      if (@$segmentskey) {

         foreach ($segmentskey as $b => $flightss) {
            
            foreach ($flightss as $BookingCode) {
               $PermittedBookingCodes .= '<air:AirSegmentPricingModifiers AirSegmentRef="' . $BookingCode['Key'] . '" BrandTier="'.$brandtier[$b].'">  
                   <air:PermittedBookingCodes>  
                     <air:BookingCode Code="' . $BookingCode['Cabin'] . '"/> 
                   </air:PermittedBookingCodes> 
                 </air:AirSegmentPricingModifiers>';
            }
         }
      }
      
      $message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
           <soapenv:Header/>
           <soapenv:Body>
             <air:AirPriceReq xmlns:air="http://www.travelport.com/schema/air_v51_0" xmlns:com="http://www.travelport.com/schema/common_v51_0" AuthorizedBy="user" TraceId="' . $TraceId . '" TargetBranch="' . $apiObject->targetBranch . '" FareRuleType="none" CheckFlightDetails="true" MostRestrictivePenalties="true" CheckOBFees="FOPOnly">
               <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
               <air:AirItinerary>'
                  . $segments .
               '</air:AirItinerary>
               <air:AirPricingModifiers CurrencyType="' . $apiObject->currency . '" ReturnServices="true" InventoryRequestType="DirectAccess" FaresIndicator="AllFares" PlatingCarrier="TK">
                     <air:BrandModifiers>
                           <air:FareFamilyDisplay ModifierType="FareFamily"/>
                     </air:BrandModifiers>
               </air:AirPricingModifiers>'
                  . $passengers .
               '<air:AirPricingCommand>'
                  .$PermittedBookingCodes.
               '</air:AirPricingCommand>

             </air:AirPriceReq>
           </soapenv:Body>
         </soapenv:Envelope>';

      // $resp = Storage::get('travelport/13/airPriceResSelected2022-11-01-05-53-29.xml');
      // $resp = Storage::get('travelport/13/airPriceResSelected2022-11-01-07-02-39.xml');

      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/airPriceReqSelected' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/airPriceResSelected' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));

      $response = self::convertToArray2($resp);
      if (@$response['SOAP_Body']['SOAP_Fault']) {
         $finalResponse = ['status' => '500', 'error' => @$response['SOAP_Body']['SOAP_Fault']['detail']['common_v51_0_ErrorInfo']['common_v51_0_Description'],'msg' =>@$response['SOAP_Body']['SOAP_Fault']];
         return $finalResponse;
      } else {
         $air_AirSegments = $response['SOAP_Body']['air_AirPriceRsp']['air_AirItinerary']['air_AirSegment'];
         $air_AirPricingSolution = $response['SOAP_Body']['air_AirPriceRsp']['air_AirPriceResult']['air_AirPricingSolution'];

         if (!array_key_exists("0", $air_AirPricingSolution)) {
            $air_AirPricingSolution = self::putOnZeroIndex($air_AirPricingSolution);
         }

         $priceSolutionArray = array();
         $Fares = array();
         if($air_AirPricingSolution){
            $loop1 = 0;
            
            foreach($air_AirPricingSolution as $priceSolution){

               $Key = $priceSolution['@attributes']['Key'];
               $TotalPrice = str_replace($apiObject->currency, '', $priceSolution['@attributes']['TotalPrice']);
               $CurrencyCode = $apiObject->currencySymbol;
               $air_AirPricingInfo = $priceSolution['air_AirPricingInfo'];

               if (!array_key_exists("0", $air_AirPricingInfo)) {
                  $air_AirPricingInfo = self::putOnZeroIndex($air_AirPricingInfo);
               }

               $Fares['CurrencyCode'] = $CurrencyCode;
               $Fares['TotalPrice'] = $TotalPrice;

               // return $air_AirPricingInfo;
               foreach($air_AirPricingInfo as $PriceInfkey => $PricingInfo){
                  if (!array_key_exists("0", $PricingInfo['air_FareInfo'])) {
                     $PricingInfo['air_FareInfo'] = self::putOnZeroIndex($PricingInfo['air_FareInfo']);
                  }

                  $passTypeKeys = $PricingInfo['air_FareInfo'][0]['@attributes']['PassengerTypeCode'];
                  if($passTypeKeys == 'ADT'){   
                     $Quantity = count($PricingInfo['air_PassengerType']); 
                  }  
                  if($passTypeKeys == 'CNN'){   
                     $Quantity = count($PricingInfo['air_PassengerType']); 
                  }  
                  if($passTypeKeys == 'INF'){   
                     $Quantity = count($PricingInfo['air_PassengerType']); 
                  }  

                  $TotalFare = str_replace($apiObject->currency, '',$PricingInfo['@attributes']['ApproximateTotalPrice']);
                  $BaseFare = str_replace($apiObject->currency, '',$PricingInfo['@attributes']['ApproximateBasePrice']);
                  $TotalTax = str_replace($apiObject->currency, '',$PricingInfo['@attributes']['ApproximateTaxes']);

                  $Fares['fareBreakDown'][$passTypeKeys]['Quantity'] = $Quantity;
                  $Fares['fareBreakDown'][$passTypeKeys]['TotalFare'] = $TotalFare;
                  $Fares['fareBreakDown'][$passTypeKeys]['BaseFare'] = $BaseFare;
                  $Fares['fareBreakDown'][$passTypeKeys]['TotalTax'] = $TotalTax;

               }

               if (!array_key_exists("0", $air_AirPricingInfo[0]['air_FareInfo'])) {
                     $air_AirPricingInfo[0]['air_FareInfo'] = self::putOnZeroIndex($air_AirPricingInfo[0]['air_FareInfo']);
                  }

               $OptionName = $air_AirPricingInfo[0]['air_FareInfo'][0]['air_Brand']['@attributes']['Name'];
               $BrandTier = $air_AirPricingInfo[0]['air_FareInfo'][0]['air_Brand']['@attributes']['BrandTier'];
               $air_Options = $air_AirPricingInfo[0]['air_FareInfo'][0]['air_Brand']['air_OptionalServices'];

               $loop2 = 0;
               foreach($air_Options['air_OptionalService'] as $key2 => $service){
                  if($service['@attributes']['Type'] == 'Baggage' && $service['@attributes']['Chargeable'] == 'Included in the brand'){
                     $priceSolutionArray[$loop1]['air_OptionalService'][$loop2]['Tag'] = $service['@attributes']['Tag'];
                     $priceSolutionArray[$loop1]['air_OptionalService'][$loop2]['Title'] = $service['air_Title'][0];
                     $priceSolutionArray[$loop1]['AirPricingSolution'] = $priceSolution;
                     $priceSolutionArray[$loop1]['air_AirSegments'] = $air_AirSegments;
                     $priceSolutionArray[$loop1]['Passengers'] = $passengers;
                     $priceSolutionArray[$loop1]['TraceId'] = $TraceId;
                     $priceSolutionArray[$loop1]['Key'] = $Key;
                     $priceSolutionArray[$loop1]['Name'] = $OptionName;
                     $priceSolutionArray[$loop1]['TotalPrice'] = $TotalPrice;
                     $priceSolutionArray[$loop1]['CurrencyCode'] = $CurrencyCode;
                     $priceSolutionArray[$loop1]['Fares'] = $Fares;
                     $loop2++;
                  }
               }
               $loop1++;
            }
         }
         $finalResponseBagg[0] = $priceSolutionArray[0];
         return $finalResponseBagg;

      }
   }
   public static function issueTicket($request)
   {
     
      if (@$request->pnrResponse) {

         $AirPricingInfoKey = array();
         $PlatingCarrier = '';
         $ReservationLocatorCode = '';
         $apiObject = json_decode($request->apiObject);
         $response = json_decode($request->pnrResponse);
         $trace = $response->SOAP_Body->universal_AirCreateReservationRsp;
         $TraceArr = json_decode(json_encode($trace), true);
         $TraceId = $TraceArr['@attributes']['TraceId'];

         $reservationData = $response->SOAP_Body->universal_AirCreateReservationRsp->universal_UniversalRecord->air_AirReservation;

         foreach ($reservationData as $key => $res) {
            if ($key == '@attributes') {
               $ReservationLocatorCode = $res->LocatorCode;
            }
         }


         $data = $reservationData->air_AirPricingInfo;
         $getType = gettype($data);

         if ($getType == 'object') {
            foreach ($data as $key2 => $val) {
               if ($key2 == '@attributes') {
                  $AirPricingInfoKey[] = $val->Key;
               }
            }
         } else {
            foreach ($data as $key => $pricingInfos) {
               foreach ($pricingInfos as $key2 => $val) {
                  if ($key2 == '@attributes') {
                     $AirPricingInfoKey[$key] = $val->Key;
                  }
               }
            }
         }
         $message = '';
         $message .= '<?xml version="1.0"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
              <soapenv:Header/>
              <soapenv:Body>
                <air:AirTicketingReq xmlns:air="http://www.travelport.com/schema/air_v51_0" AuthorizedBy="user" BulkTicket="false" ReturnInfoOnFail="true" TargetBranch="' . $apiObject->targetBranch . '" TraceId="' . $TraceId . '">
                  <com:BillingPointOfSaleInfo xmlns:com="http://www.travelport.com/schema/common_v51_0" OriginApplication="UAPI"/>';
         $message .= '<air:AirReservationLocatorCode>' . $ReservationLocatorCode . '</air:AirReservationLocatorCode>';
         foreach ($AirPricingInfoKey as $priceKey) {
            $message .= '<air:AirPricingInfoRef Key="' . $priceKey . '"/>';
         }

         $message .= ' </air:AirTicketingReq>
              </soapenv:Body>
            </soapenv:Envelope>';


         // ********static response from storage for Testing*****
         // $resp = Storage::get('travelport/AirTicketingRspLive1.xml');


         Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/AirTicketingReq' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
         $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
         Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/AirTicketingRsp' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));

         $response = self::convertToArray2($resp);

         if (@$response['SOAP_Body']['SOAP_Fault']) {

            $finalResponse = [
               'status' => '500',
               'error' => @$response['SOAP_Body']['SOAP_Fault']['faultstring'],
               'apiError' => '{"Response" :' . json_encode($response) . ', "Request" :{"req":"' . self::prettyPrint($message) . '"}}'
            ];
         } else {
            if (@$response['SOAP_Body']['air_AirTicketingRsp']['air_TicketFailureInfo']) {
               $fails = $response['SOAP_Body']['air_AirTicketingRsp']['air_TicketFailureInfo'];

               $finalResponse = [
                  'status' => '500',
                  'error' => @$fails['@attributes']['Message'],
                  'code' => @$fails['@attributes']['Code'],
                  'apiError' => '{"Response" :' . json_encode($response) . ', "Request" :{"req":"' . self::prettyPrint($message) . '"}}'
               ];
            } else {
               $TicketArray = $response['SOAP_Body']['air_AirTicketingRsp']['air_ETR'];
               if (!array_key_exists("0", $TicketArray)) {
                  $TicketArray = self::putOnZeroIndex($TicketArray);
               }

               $ticketData = array();
               foreach ($TicketArray as $tktKey => $TicketVal) {
                  $TravelerType = $TicketVal['common_v51_0_BookingTraveler']['@attributes']['TravelerType'];
                  $FirstName = $TicketVal['common_v51_0_BookingTraveler']['common_v51_0_BookingTravelerName']['@attributes']['First'];
                  $TicketNumber = $TicketVal['air_Ticket']['@attributes']['TicketNumber'];
                  $ticketData[$TravelerType][] = compact(
                     'FirstName',
                     'TicketNumber'
                  );
               }

               if ($ticketData) {
                  $finalResponse = ['status' => '200', 'msg' => json_encode($response),  'ticketData' => $ticketData];
               } else {
                  $finalResponse = ['status' => '500', 'error' => 'Something went wrong......'];
               }
            }
         }

         return $finalResponse;
      }
   }

   public static function getPNR($request)
   {
      $pnr = "";
      if (str_contains($request->pnrCode, ',')) {
         $pnrSplit  = explode(',', $request->pnrCode);
         $pnrEithSpace = explode(':', $pnrSplit[1]);
         $pnr = str_replace(' ', '', $pnrEithSpace[1]);
      } else {
         $pnr = $request->pnrCode;
      }

      $apiObject = json_decode($request->apiObject);
      $message = '';
      $message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://www.travelport.com/schema/common_v51_0" xmlns:univ="http://www.travelport.com/schema/universal_v51_0">
        <soapenv:Body>
          <univ:UniversalRecordRetrieveReq AuthorizedBy="user" TargetBranch="' . $apiObject->targetBranch . '" TraceId="trace">
            <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
            <univ:ProviderReservationInfo ProviderCode="' . $apiObject->provider . '" ProviderLocatorCode="' . $pnr . '"/>
          </univ:UniversalRecordRetrieveReq>
        </soapenv:Body>
      </soapenv:Envelope>';


      Storage::put('travelport/pnr/getPNRReq' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword, self::$link2);
      Storage::put('travelport/pnr/getPNRResponse' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));

      $response = self::convertToArray2($resp);

      if (@$response['SOAP_Body']['SOAP_Fault']) {

         $finalResponse = ['status' => '500', 'error' => @$response['SOAP_Body']['SOAP_Fault']['faultstring']];
      } else {
         return self::makeGetPnrResponse($response, $apiObject);
      }
   }
   public static function OfferAvailabilityReq($request)
   {

      $apiObject = json_decode($request->apiObject);
      $response = json_decode($request->pnrRespData,true);

      $resp = $response['SOAP_Body']['universal_AirCreateReservationRsp'];
      $TraceId = $resp['@attributes']['TraceId'];
      $BookingTraveler = $resp['universal_UniversalRecord']['common_v51_0_BookingTraveler'];
      $air_AirSegment = $resp['universal_UniversalRecord']['air_AirReservation']['air_AirSegment'];
      if (!array_key_exists("0", $BookingTraveler)) {
         $BookingTraveler = self::putOnZeroIndex($BookingTraveler);
      }

      if (!array_key_exists("0", $air_AirSegment)) {
         $air_AirSegment = self::putOnZeroIndex($air_AirSegment);
      }

      $TravelerObj = '';
      $SegmentsObj = '';
      foreach($BookingTraveler as $travelers){
         $TravelerObj .= '<SearchTraveler Code="'.$travelers['@attributes']['TravelerType'].'" Age="'.Carbon::parse($travelers['@attributes']['DOB'])->age.'" DOB="'.$travelers['@attributes']['DOB'].'" Gender="'.$travelers['@attributes']['Gender'].'" BookingTravelerRef="'.$travelers['@attributes']['Key'].'" Key="'.$travelers['@attributes']['Key'].'">
                  <Name xmlns="http://www.travelport.com/schema/common_v51_0" Prefix="'.@$travelers['common_v51_0_BookingTravelerName']['@attributes']['Prefix'].'" First="'.$travelers['common_v51_0_BookingTravelerName']['@attributes']['First'].'" Last="'.$travelers['common_v51_0_BookingTravelerName']['@attributes']['Last'].'" />
            </SearchTraveler>';

      }
      foreach($air_AirSegment as $segments){

         $segment = '<AirSegment ';
         foreach($segments['@attributes'] as $segAttr => $segVal){
            $segment .= '' . $segAttr . '="' . $segVal . '" ';
         }
         $segment .= '/>';
         
         $SegmentsObj .= $segment;
      }
      // return $SegmentsObj;
      $message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Body>
          <AirMerchandisingOfferAvailabilityReq xmlns="http://www.travelport.com/schema/air_v51_0" TargetBranch="' . $apiObject->targetBranch . '" TraceId="' . $TraceId . '">
              <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v51_0" OriginApplication="uAPI" />
              <AirSolution>

               '.$TravelerObj
               .$SegmentsObj.'

              </AirSolution>

            </AirMerchandisingOfferAvailabilityReq>
        </soapenv:Body>
      </soapenv:Envelope>';



      // Storage::put('travelport/OfferAvailabilityReq' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      // $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword, self::$link);
      // Storage::put('travelport/OfferAvailabilityResp' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));

      $resp = Storage::get('travelport/OfferAvailabilityResp.xml');

      $response = self::convertToArray2($resp);
      $baggagesData = self::makeBaggageResponse($response,$apiObject->currency);
      
      if (@$baggagesData['error']) {
         return ['status' => '400', 'msg' => $baggagesData];
      }elseif (count($baggagesData) == 0) {
         return ['status' => '400', 'msg' => 'No Extra baggage options found'];
      }else {
         return ['status' => '200', 'msg' => $baggagesData];
      }
   }
   public static function MerchandisingFulfillmentReq($request){
      $apiObject = json_decode($request->apiObject);

      $baggagesData = json_decode($request->baggagesData,true);
      $baggageRequest = self::createBaggageFullfillRequest($request->apiObject,$baggagesData,$request->pnrRespData);

      return $baggageRequest;
   }
   public static function cancelPNR($request)
   {
      $apiObject = json_decode($request->apiObject);
      $res = json_decode($request->pnrRespData, true);

      $pnrRespnseData   = $res['SOAP_Body']['universal_AirCreateReservationRsp'];
      $TraceId          = $pnrRespnseData['@attributes']['TraceId'];
      $UniversalRecord  = $pnrRespnseData['universal_UniversalRecord']['@attributes']['LocatorCode'];

      


      $message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:com="http://www.travelport.com/schema/common_v51_0" xmlns:univ="http://www.travelport.com/schema/universal_v51_0">
        <soapenv:Body>
          <univ:UniversalRecordCancelReq AuthorizedBy="user" TargetBranch="' . $apiObject->targetBranch . '" TraceId="' . $TraceId . '" UniversalRecordLocatorCode="' . $UniversalRecord . '" Version="2">
            <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
          </univ:UniversalRecordCancelReq>
        </soapenv:Body>
      </soapenv:Envelope>';


      $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword, self::$link2);
      // Storage::put('travelport/tickets/ticketCancel/UniversalRecordCancelResp'.date('Y-m-d-H-i-s').'.xml', self::prettyPrint($resp));

      $response = self::convertToArray2($resp);

      return $response;
   }

   public static function fareRules($data, $request)
   {
      $apiObject = json_decode($request->apiObject);
      if (@$data) {
         $fares = '';
         foreach ($data as $fareKey => $fareRules) {
            foreach ($fareRules['FareRuleKey'] as $key => $value) {
               $fares .= '<air:FareRuleKey FareInfoRef="' . $value['Key'] . '" ProviderCode="' . $apiObject->provider . '">' . $value['Value'] . '</air:FareRuleKey>';
            }
         }

         $message = '<?xml version="1.0"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:air="http://www.travelport.com/schema/air_v51_0" xmlns:com="http://www.travelport.com/schema/common_v51_0">
              <soapenv:Header/>
              <soapenv:Body>
                <air:AirFareRulesReq TargetBranch="' . $apiObject->targetBranch . '" FareRuleType="long">
                  <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>' .
            $fares
            . '</air:AirFareRulesReq>
              </soapenv:Body>
            </soapenv:Envelope>';
         Storage::put('travelport/fareRule/fareRuleReq.xml', self::prettyPrint($message));
         $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
         Storage::put('travelport/fareRule/fareRuleResp.xml', self::prettyPrint($resp));


         $response = self::convertToArray2($resp);

         if (@$response['SOAP_Body']['SOAP_Fault']) {
            $fareArray[0] = 'NA';
            return $fareArray;
         }

         $fareRules = $response['SOAP_Body']['air_AirFareRulesRsp']['air_FareRule'];
         if (!array_key_exists("0", $fareRules)) {
            $fareRules = self::putOnZeroIndex($fareRules);
         }
         foreach ($fareRules as $rule) {
            if (@$rule['air_FareRuleLong']) {
               $fare_rule = '<ul class="addReadMore">';
               foreach ($rule['air_FareRuleLong'] as $key => $val) {
                  $fare_rule .= '<li><h6>Category ' . $key . '</h6>' . strtolower(str_replace('-', '', $val)) . '</li>';
               }
               $fare_rule .= '</ul>';
            } else {
               $fare_rule = '';
            }
         }

         $fareArray[0] = $fare_rule;


         return $fareArray;
      } else {
         return '';
      }
   }

   /*===========================================================
   *********************Create Requests*************************
   ============================================================*/
   public static function makeResponse($rest, $request, $allowedAirlinesArray, $passTypeKeys)
   {
      $apiObject = json_decode($request->apiObject);

      if (@$rest['SOAPBody']['SOAPFault']) {
         $error = array();
         $error['error'] = @$rest['SOAPBody']['SOAPFault']['detail']['common_v51_0ErrorInfo']['common_v51_0Code'];
         $error['api'] = 'Travelport';
         $error['message'] = @$rest['SOAPBody']['SOAPFault']['faultstring'];
         return $error;
      }
      $LowFare = $rest['SOAPBody']['airLowFareSearchRsp'];
      $TraceId = $LowFare['@attributes']['TraceId'];
      $airFlightDetailsList = $LowFare['airFlightDetailsList']['airFlightDetails'];
      $airAirSegmentList    = $LowFare['airAirSegmentList']['airAirSegment'];
      $airFareInfoList      = $LowFare['airFareInfoList']['airFareInfo'];
      $airAirPricePointList = $LowFare['airAirPricePointList']['airAirPricePoint'];
      $airBrandList         = @$LowFare['airBrandList'];

      if (!array_key_exists("0", $airAirSegmentList)) {
         $airAirSegmentList = self::putOnZeroIndex($airAirSegmentList);
      }
      if (!array_key_exists("0", $airFareInfoList)) {
         $airFareInfoList = self::putOnZeroIndex($airFareInfoList);
      }
      if (!array_key_exists("0", $airAirPricePointList)) {
         $airAirPricePointList = self::putOnZeroIndex($airAirPricePointList);
      }

      $apiResponse = array();
      $finalData = array();
      $segment = array();
      $data = array();

      foreach ($airAirPricePointList as $ind => $farePrice) {
         $api = 'Travelport';
         $api_offer_id = '';
         $MarketingAirline = array();
         $LowFareSearch = '';
         $Fares = array();
         $LowFareSearch = array();
         $apiResp = array();

         $segmentBag = array();
         if ($farePrice['@attributes']) {
            // $Fares['CurrencyCode'] = $apiObject->currency;
            $Fares['CurrencyCode'] = $apiObject->currencySymbol;
            $Fares['TotalPrice'] = str_replace($apiObject->currency, '', $farePrice['@attributes']['TotalPrice']);
         }
         if ($farePrice['airAirPricingInfo']) {

            if (!array_key_exists("0", $farePrice['airAirPricingInfo'])) {
               $farePrice['airAirPricingInfo'] = self::putOnZeroIndex($farePrice['airAirPricingInfo']);
            }

            foreach ($farePrice['airAirPricingInfo'] as $priceInfo) {

               if ($priceInfo['@attributes']) {
                  $airPassengerType = $priceInfo['airPassengerType'];
                  if (!array_key_exists("0", $airPassengerType)) {
                     $airPassengerType = self::putOnZeroIndex($airPassengerType);
                  }

                  foreach($airPassengerType as $passKey => $pass){
                     if($pass['@attributes']['Code'] == 'ADT'){
                        $Quantity = count($priceInfo['airPassengerType']);
                     }
                     if($pass['@attributes']['Code'] == 'CNN'){
                        $Quantity = count($priceInfo['airPassengerType']);
                     }
                     if($pass['@attributes']['Code'] == 'INF'){
                        $Quantity = count($priceInfo['airPassengerType']);
                     }
                  }
                  $passType = $airPassengerType[0]['@attributes']['Code'];

                  // $Fares['fareBreakDown'][$passType]['Quantity'] = 1;
                  $Fares['fareBreakDown'][$passType]['Quantity'] = $Quantity;
                  $Fares['fareBreakDown'][$passType]['TotalFare'] = str_replace($apiObject->currency, '', $priceInfo['@attributes']['TotalPrice']);
                  $Fares['fareBreakDown'][$passType]['BaseFare'] = str_replace($apiObject->currency, '', $priceInfo['@attributes']['EquivalentBasePrice']);
                  $Fares['fareBreakDown'][$passType]['TotalTax'] = str_replace($apiObject->currency, '', $priceInfo['@attributes']['Taxes']);
                  $MarketingAirline['FareRules'] = 'NA';
                  $MarketingAirline['Airline'] = $priceInfo['@attributes']['PlatingCarrier'];
               }
               /*--------------------airFlightOptionsList details--------------*/
               if ($priceInfo['airFlightOptionsList']) {
                  if ($priceInfo['airFlightOptionsList']['airFlightOption']) {
                     $airFlightOption = $priceInfo['airFlightOptionsList']['airFlightOption'];

                     if (!array_key_exists("0", $airFlightOption)) {
                        $airFlightOption = self::putOnZeroIndex($airFlightOption);
                     }

                     foreach ($airFlightOption as $key => $flight) {

                        if (!array_key_exists("0", $flight['airOption'])) {
                           $flight['airOption'] = self::putOnZeroIndex($flight['airOption']);
                        }
                        if ($flight['airOption'][0]['airBookingInfo']) {
                           $airBookingInfo = $flight['airOption'][0]['airBookingInfo'];

                           if (!array_key_exists("0", $airBookingInfo)) {
                              $airBookingInfo = self::putOnZeroIndex($airBookingInfo);
                           }

                           /*-------------segmments list--------*/
                           foreach ($airBookingInfo as $segKey => $bookingInfo) {
                              $segmentKey = $bookingInfo['@attributes']['SegmentRef'];

                              $CabinClass = $bookingInfo['@attributes']['CabinClass'];
                              $CabinClassCode = $bookingInfo['@attributes']['BookingCode'];

                              $segment = self::makeRespEachSegment($airAirSegmentList, $segmentKey);

                              $LowFareSearch[$key]['Segments'][$segKey] = $segment['keys'];
                              $LowFareSearch[$key]['Segments'][$segKey]['Cabin'] = $CabinClass . ' (' . $CabinClassCode . ')';
                              $apiResp[$key]['segments'][$segKey] = $segment['obj'];
                              $apiResp[$key]['TraceId'] = $TraceId;
                              $apiResp[$key]['passTypeKeys'] = $passTypeKeys;
                              /*-----------for Baggage detail----------*/
                              $FareInfoRefKey = $bookingInfo['@attributes']['FareInfoRef'];
                              // $baggage = self::makeRespForBaggage($airFareInfoList,$FareInfoRefKey);

                              // $LowFareSearch[$key]['Segments'][$segKey]['Baggage'] = $baggage['keys'];
                              // $apiResp[$key]['FareRuleKey'][$segKey] = $baggage['obj'];

                              $jj = 0;
                              foreach ($airFareInfoList as $bagg) {

                                 if ($bagg['@attributes']['Key'] == $FareInfoRefKey) {
                                    if (@$bagg['airBaggageAllowance']['airNumberOfPieces']) {
                                       $segmentBag[$bagg['@attributes']['PassengerTypeCode']]['Weight'] = @$bagg['airBaggageAllowance']['airNumberOfPieces'];
                                       $segmentBag[$bagg['@attributes']['PassengerTypeCode']]['Unit'] = 'Piece(s)';
                                    } else {
                                       $segmentBag[$bagg['@attributes']['PassengerTypeCode']]['Weight'] = @$bagg['airBaggageAllowance']['airMaxWeight']['@attributes']['Value'];
                                       $segmentBag[$bagg['@attributes']['PassengerTypeCode']]['Unit'] = @$bagg['airBaggageAllowance']['airMaxWeight']['@attributes']['Unit'];
                                    }
                                    $apiResp[$key]['FareRuleKey'][$segKey]['Key'] = $FareInfoRefKey;
                                    $apiResp[$key]['FareRuleKey'][$segKey]['Value'] = $bagg['airFareRuleKey'];
                                 }
                              }
                              $LowFareSearch[$key]['Segments'][$segKey]['Baggage'] = $segmentBag;
                              /*-----------end Baggage detail----------*/
                           }

                           $LowFareSearch[$key]['TotalDuration'] = self::convertToHoursMins3($flight['airOption'][0]['@attributes']['TravelTime']);
                        }
                        /*-----------end segmments list--------*/
                     }
                  }
               }
               /*--------------------End airFlightOptionsList details-------------*/
            }
         }



         $finalData[$ind] = compact(
            'api',
            'MarketingAirline',
            'LowFareSearch',
            'Fares',
            'api_offer_id',
         );

         $apiOffer = new ApiOfferModel();
         $apiOffer->api = "Travelport";
         $apiOffer->data = json_encode($apiResp);
         $apiOffer->finaldata = json_encode($finalData[$ind]);
         $apiOffer->timestamp = time();
         $apiOffer->query = json_encode($request->except('apiObject'));

         if (count($allowedAirlinesArray) > 0 && in_array($finalData[$ind]['MarketingAirline']['Airline'], $allowedAirlinesArray)) {
            $apiOffer->save();
            $finalData[$ind]['api_offer_id'] = $apiOffer->id;
         } else if (count($allowedAirlinesArray) == 0) {
            $apiOffer->save();
            $finalData[$ind]['api_offer_id'] = $apiOffer->id;
         } else {
            unset($finalData[$ind]);
         }
      }
      return $finalData;
   }
   public static function makeRespEachSegment($segList, $segKey)
   {
      $segment = array();
      foreach ($segList as $seg) {
         if ($seg['@attributes']['Key'] == $segKey) {
            $Duration = self::convertToHoursMins($seg['@attributes']['FlightTime']);
            $OperatingAirline['Code'] = $seg['@attributes']['Carrier'];
            $OperatingAirline['FlightNumber'] = $seg['@attributes']['FlightNumber'];

            $Departure['LocationCode'] = $seg['@attributes']['Origin'];
            $Departure['DepartureDateTime'] = $seg['@attributes']['DepartureTime'];

            $Arrival['LocationCode'] = $seg['@attributes']['Destination'];
            $Arrival['ArrivalDateTime'] = $seg['@attributes']['ArrivalTime'];

            $Baggage['ADT'] = '';
            $Cabin = '';

            $segment['keys'] = compact(
               'Duration',
               'OperatingAirline',
               'Departure',
               'Arrival',
               'Baggage',
               'Cabin',
            );
            $segment['obj'] = $seg;
         }
      }
      return $segment;
   }
   public static function makeRespForBaggage($airFareInfoList, $farInfoKey)
   {
      $baggagesArr = array();
      $baggages = array();
      foreach ($airFareInfoList as $bagg) {
         if ($bagg['@attributes']['Key'] == $farInfoKey) {
            $passType = $bagg['@attributes']['PassengerTypeCode'];
            if (@$bagg['airBaggageAllowance']['airNumberOfPieces']) {
               $baggages[$passType]['Weight'] = $bagg['airBaggageAllowance']['airNumberOfPieces'];
               $baggages[$passType]['Unit'] = 'Piece(s)';
            } else {
               $baggages[$passType]['Weight'] = @$bagg['airBaggageAllowance']['airMaxWeight']['@attributes']['Value'];
               $baggages[$passType]['Unit'] = @$bagg['airBaggageAllowance']['airMaxWeight']['@attributes']['Unit'];
            }

            $baggagesArr['keys'] = $baggages;
            $baggagesArr['obj']['Key'] = $farInfoKey;
            $baggagesArr['obj']['Value'] = $bagg['airFareRuleKey'];
         }
      }
      return $baggagesArr;
   }

   public static function createPnrRequest($TraceId, $passTypeKeys, $priceSolutionSegments, $request, $apiObject)
   {
      $passData = json_decode($request->passengerData, true);
      $airPricingSolution = $priceSolutionSegments['air_AirPricingSolution'];
      $airSegments = $priceSolutionSegments['air_AirSegment'];


      if (!array_key_exists("0", $airSegments)) {
         $airSegments = self::putOnZeroIndex($airSegments);
      }
      if (!array_key_exists("0", $airPricingSolution)) {
         $airPricingSolution = self::putOnZeroIndex($airPricingSolution);
      }

      /*---------------segments-----------------*/
      $segmentKeyForSsr = array();
      $carrier = array();
      $segment = '';

      foreach ($airSegments as $key => $airSegment) {
         $segmentKeyForSsr[$key] = $airSegment['@attributes']['Key'];
         if (!in_array($airSegment['@attributes']['Carrier'], $carrier)) {
            $carrier[$key] = $airSegment['@attributes']['Carrier'];
         }
         $segment .= '<air:AirSegment ';
         foreach ($airSegment as $segkey => $segVal) {
            if ($segkey == '@attributes') {
               foreach ($segVal as $segAttr2 => $segVal2) {
                  $segment .= '' . $segAttr2 . '="' . $segVal2 . '" ';
               }
               $segment .= '>';
            }
            if ($segkey == 'air_FlightDetails') {
               $segment .= '<air:FlightDetails ';
               foreach ($segVal['@attributes'] as $segAttr3 => $segVal3) {
                  $segment .= '' . $segAttr3 . '="' . $segVal3 . '" ';
               }
               $segment .= '/>';
            }
            if ($segkey == 'air_Connection') {
               $segment .= '<air:Connection/>';
            }
         }
         $segment .= '</air:AirSegment>';
      }
      /*---------------end segments--------------*/

      /*---------------AirPricing--------------*/
      $HostTokenRef = array();
      $airPricingInfo = '';
      $HostTokensArry = '';
      $AirPricingSolution = '<air:AirPricingSolution ';
      
      foreach ($airPricingSolution[0] as $price_attr => $price_val) {

         if ($price_attr == '@attributes') {
            foreach ($price_val as $attrName => $attrVal) {
               $AirPricingSolution .= '' . $attrName . '="' . $attrVal . '" ';
            }
            $AirPricingSolution .= '>';
         }

         /*====================AirPricingInfo==================*/
         if ($price_attr == 'air_AirPricingInfo') {
            $air_AirPricingInfo = $price_val;
            if (!array_key_exists("0", $air_AirPricingInfo)) {
               $air_AirPricingInfo = self::putOnZeroIndex($air_AirPricingInfo);
            }

            $j = 0;
            $k = 0;
            $pasRefKey = 0;

            foreach ($air_AirPricingInfo as  $price_val2) {
               $airPricingInfo .= '<air:AirPricingInfo ';
               // PlatingCarrier="'.$carrier[0].'"
               if ($price_val2['@attributes']) {
                  foreach ($price_val2['@attributes'] as $pricingAttr => $pricingVal) {
                     $airPricingInfo .= '' . $pricingAttr . '="' . $pricingVal . '" ';
                  }
                  $airPricingInfo .= '>';
               }
               /*----------------FareInfo----------------*/
               if ($price_val2['air_FareInfo']) {

                  if (!array_key_exists("0", $price_val2['air_FareInfo'])) {
                     $price_val2['air_FareInfo'] = self::putOnZeroIndex($price_val2['air_FareInfo']);
                  }
                  foreach ($price_val2['air_FareInfo'] as $FareInfo) {
                     $airPricingInfo .= '<air:FareInfo ';
                     $FareInfoRef = '';
                     if ($FareInfo['@attributes']) {
                        $FareInfoRef = $FareInfo['@attributes']['Key'];
                        foreach ($FareInfo['@attributes'] as $farAttr => $farVal) {
                           $airPricingInfo .= '' . $farAttr . '="' . $farVal . '" ';
                        }
                        $airPricingInfo .= '>';
                     }
                     if ($FareInfo['air_FareRuleKey']) {
                        $airPricingInfo .= '<air:FareRuleKey FareInfoRef="' . $FareInfoRef . '" ProviderCode="' . $apiObject->provider . '">';
                        $airPricingInfo .= $FareInfo['air_FareRuleKey'];
                        $airPricingInfo .= '</air:FareRuleKey>';
                     }
                     if (@$FareInfo['air_Brand']) {
                        $airPricingInfo .= '<air:Brand ';
                        foreach ($FareInfo['air_Brand']['@attributes'] as $brandAttr => $brandVal) {
                           $airPricingInfo .= '' . $brandAttr . '="' . $brandVal . '" ';
                        }
                        // ----Air:brand close--- //
                        $airPricingInfo .= '/>';

                     }

                     $airPricingInfo .= '</air:FareInfo>';
                  }
               }
               /*----------------end FareInfo----------------*/

               /*----------------------<air:BookingInfo>-------------------------*/
               if (!array_key_exists("0", $price_val2['air_BookingInfo'])) {
                  if ($price_val2['air_BookingInfo']['@attributes']) {
                     $air_BookingInfo = '<air:BookingInfo ';
                     foreach ($price_val2['air_BookingInfo']['@attributes'] as $bookKey => $bookVal) {
                        if ($bookKey == 'HostTokenRef') {
                           $HostTokenRef[$j] = $bookVal;
                        }
                        $air_BookingInfo .= '' . $bookKey . '="' . $bookVal . '" ';
                     }
                     $air_BookingInfo .= '/>';
                     $airPricingInfo .= $air_BookingInfo;
                  }
               } else {
                  foreach ($price_val2['air_BookingInfo'] as $BookingInfoKey => $bookingInfo) {
                     if ($bookingInfo['@attributes']) {
                        $air_BookingInfo = '<air:BookingInfo ';
                        foreach ($bookingInfo['@attributes'] as $bookKey => $bookVal) {
                           if ($bookKey == 'HostTokenRef') {
                              $HostTokenRef[$k] = $bookVal;
                           }
                           $air_BookingInfo .= '' . $bookKey . '="' . $bookVal . '" ';
                        }
                        $air_BookingInfo .= '/>';
                        $airPricingInfo .= $air_BookingInfo;
                     }
                     $k++;
                  }
               }

               /*----------------------</air:BookingInfo>-------------------------*/

               /*----------------------<air:TaxInfo>-------------------------*/
               if (@$price_val2['air_TaxInfo']) {
                  if (!array_key_exists("0", $price_val2['air_TaxInfo'])) {
                     $price_val2['air_TaxInfo'] = self::putOnZeroIndex($price_val2['air_TaxInfo']);
                  }
                  foreach ($price_val2['air_TaxInfo'] as $taxVal) {

                     $airPricingInfo .= '<air:TaxInfo ';
                     foreach ($taxVal['@attributes'] as $taKey => $taVal) {
                        $airPricingInfo .= '' . $taKey . '="' . $taVal . '" ';
                     }
                     $airPricingInfo .= '/>';
                  }
               }
               /*----------------------</air:TaxInfo>-------------------------*/
               /*----------------------<air:FareCalc>-------------------------*/
               if (@$price_val2['air_FareCalc']) {
                  $airPricingInfo .= '<air:FareCalc>';
                  $airPricingInfo .= $price_val2['air_FareCalc'];
                  $airPricingInfo .= '</air:FareCalc>';
               }
               /*----------------------</air:FareCalc>-------------------------*/
               /*----------------------<air:PassengerType>-------------------------*/
               if (@$price_val2['air_PassengerType']) {
                  if (!array_key_exists("0", $price_val2['air_PassengerType'])) {
                     $price_val2['air_PassengerType'] = self::putOnZeroIndex($price_val2['air_PassengerType']);
                  }
                  
                  foreach ($price_val2['air_PassengerType'] as $passengr) {
                     $airPassType = $passengr['@attributes']['Code'];
                     // if($pasRefKey == 1){
                     //    return $airPassType;
                     // }
                     $BookingTravelerRef = $passTypeKeys[$airPassType][$pasRefKey]['BookingTravelerRef'];

                     $airPricingInfo .= '<air:PassengerType BookingTravelerRef="' . $BookingTravelerRef . '" ';
                     if ($price_val2['air_PassengerType']) {
                        foreach ($passengr['@attributes'] as $passKey => $passVal) {
                           $airPricingInfo .= '' . $passKey . '="' . $passVal . '" ';
                        }
                     }
                     $airPricingInfo .= '/>';

                     $pasRefKey++;
                  }
               }
               /*----------------------</air:PassengerType>-------------------------*/
               /*----------------------<air:ChangePenalty>-------------------------*/
               if (@$price_val2['air_ChangePenalty']) {
                  $getType = gettype($price_val2['air_ChangePenalty']);

                  if ($getType == 'object') {
                     $airPricingInfo .= '<air:ChangePenalty ';
                     foreach ($price_val2['air_ChangePenalty']['@attributes'] as $changKey => $changVal) {
                        $airPricingInfo .= '' . $changKey . '="' . $changVal . '" ';
                     }
                     $airPricingInfo .= '>';

                     if (@$price_val2['air_ChangePenalty']['air_Amount']) {
                        $airPricingInfo .= '<air:Amount>' . $price_val2['air_ChangePenalty']['air_Amount'] . '</air:Amount>';
                     }

                     if (@$price_val2['air_ChangePenalty']['air_Percentage']) {
                        $airPricingInfo .= '<air:Percentage>' . $price_val2['air_ChangePenalty']['air_Percentage'] . '</air:Percentage>';
                     }
                     $airPricingInfo .= '</air:ChangePenalty>';
                  } else {

                     if (!array_key_exists("0", $price_val2['air_ChangePenalty'])) {
                        $price_val2['air_ChangePenalty'] = self::putOnZeroIndex($price_val2['air_ChangePenalty']);
                     }

                     foreach ($price_val2['air_ChangePenalty'] as $airChangeVal) {
                        $airPricingInfo .= '<air:ChangePenalty ';
                        if (@$airChangeVal['@attributes']) {
                           foreach ($airChangeVal['@attributes'] as $changKey => $changVal) {
                              $airPricingInfo .= '' . $changKey . '="' . $changVal . '" ';
                           }
                        }
                        $airPricingInfo .= '>';

                        if (@$airChangeVal['air_Amount']) {
                           $airPricingInfo .= '<air:Amount>' . $airChangeVal['air_Amount'] . '</air:Amount>';
                        }

                        if (@$airChangeVal['air_Percentage']) {
                           $airPricingInfo .= '<air:Percentage>' . $airChangeVal['air_Percentage'] . '</air:Percentage>';
                           // $airPricingInfo .= '<air:Percentage>'.$price_val2['air_ChangePenalty']['air_Percentage'].'</air:Percentage>';
                        }
                        $airPricingInfo .= '</air:ChangePenalty>';
                     }
                  }
               }
               /*----------------------</air:ChangePenalty>-------------------------*/
               /*----------------------<air:CancelPenalty>-------------------------*/
               if (@$price_val2['air_CancelPenalty']) {
                  $getType = gettype($price_val2['air_CancelPenalty']);

                  if ($getType == 'object') {
                     $airPricingInfo .= '<air:CancelPenalty ';
                     if ($price_val2['air_CancelPenalty']['@attributes']) {
                        foreach ($price_val2['air_CancelPenalty']['@attributes'] as $changKey => $changVal) {
                           $airPricingInfo .= '' . $changKey . '="' . $changVal . '" ';
                        }
                     }
                     $airPricingInfo .= '>';
                     if (@$price_val2['air_CancelPenalty']['air_Amount']) {
                        $airPricingInfo .= '<air:Amount>' . $price_val2['air_CancelPenalty']['air_Amount'] . '</air:Amount>';
                     }
                     if (@$price_val2['air_CancelPenalty']['air_Percentage']) {
                        $airPricingInfo .= '<air:Percentage>' . $price_val2['air_CancelPenalty']['air_Percentage'] . '</air:Percentage>';
                     }
                     $airPricingInfo .= '</air:CancelPenalty>';
                  } else {
                     if (!array_key_exists("0", $price_val2['air_CancelPenalty'])) {
                        $price_val2['air_CancelPenalty'] = self::putOnZeroIndex($price_val2['air_CancelPenalty']);
                     }
                     foreach ($price_val2['air_CancelPenalty'] as $airCancelVal) {
                        $airPricingInfo .= '<air:CancelPenalty ';
                        if (@$airCancelVal['@attributes']) {
                           foreach ($airCancelVal['@attributes'] as $changKey => $changVal) {
                              $airPricingInfo .= '' . $changKey . '="' . $changVal . '" ';
                           }
                        }
                        $airPricingInfo .= '>';
                        if (@$airCancelVal['air_Amount']) {
                           $airPricingInfo .= '<air:Amount>' . $airCancelVal['air_Amount'] . '</air:Amount>';
                        }
                        if (@$airCancelVal['air_Percentage']) {
                           $airPricingInfo .= '<air:Percentage>' . $airCancelVal['air_Percentage'] . '</air:Percentage>';
                        }
                        $airPricingInfo .= '</air:CancelPenalty>';
                     }
                  }
               }
               /*----------------------</air:CancelPenalty>-------------------------*/

               $airPricingInfo .= '</air:AirPricingInfo>';
               $j++;
            }
         }

         if ($price_attr == 'common_v51_0_HostToken') {
            $HostTokens = $price_val;
            $HostTokensType = gettype($HostTokens);

            if ($HostTokensType == 'string') {
               $HostTokensArry .= '<common_v51_0:HostToken Key="' . $HostTokenRef[0] . '">' . $HostTokens . '</common_v51_0:HostToken>';
            } else {
               $HostTokenRefKeys = array_unique($HostTokenRef);
               $reCreateArray = array_values($HostTokenRefKeys);

               foreach ($HostTokens as $hostKey => $hostToken) {
                  $HostTokensArry .= '<common_v51_0:HostToken Key="' . $reCreateArray[$hostKey] . '">' . $hostToken . '</common_v51_0:HostToken>';
               }
            }
         }
         /*====================end AirPricingInfo==================*/
      }

      $AirPricingSolution .= $segment;
      $AirPricingSolution .= $airPricingInfo;
      $AirPricingSolution .= $HostTokensArry;
      $AirPricingSolution .= '</air:AirPricingSolution>';
      /*---------------end AirPricing--------------*/

      /*------------------BookingTraveler info--------------------*/

      $traveler = '';
      $passNumber = str_replace('+', '', $request->passenger_phone);
      $phoneNumber = str_replace(' ', '', $passNumber);
      if ($passData['Adult'] != '') {
         $ADTKey = array_values($passTypeKeys['ADT']);

         foreach ($passData['Adult'] as $key => $adult) {
            if ($adult['salute'] == 'male') {
               $gender = 'M';
               $title = 'Mr';
            } else {
               $gender = 'F';
               $title = 'Ms';
            }
            $countryCodeADT = self::countryCode($adult['nationality']);
            $dob = date('Y-m-d', strtotime($adult['dob']));
            $dob2 = date('dMy', strtotime($adult['dob']));
            $passExpiry = date('dMy', strtotime($adult['passExpiry']));
            $BookingTravelerKey1 = $ADTKey[$key]['BookingTravelerRef'];

            $traveler .= '<com:BookingTraveler xmlns:com="http://www.travelport.com/schema/common_v51_0" DOB="' . $dob . '" Gender="' . $gender . '" Key="' . $BookingTravelerKey1 . '" TravelerType="ADT">
                     <com:BookingTravelerName First="' . $adult['firstname'] . '" Last="' . $adult['lastname'] . '" Prefix="' . $title . '"/>
                     <com:PhoneNumber Type="Mobile" Number="' . $phoneNumber . '"/>
                     <com:Email EmailID="' . $request->passenger_email . '" Type="p"/>';
            
            // =============SSRs==============================\\
            $traveler .= '<com:SSR Carrier="' . $carrier[0] . '" FreeText="P/' . $countryCodeADT . '/' . $adult['passport'] . '/' . $countryCodeADT . '/' . $dob2 . '/' . $gender . '/' . $passExpiry . '/' . $adult['lastname'] . '/' . $adult['firstname'] . '" Status="HK" Type="DOCS"/>';

            $passEmail = str_replace("@", "//", $request->passenger_email);
            $passEmail1 = str_replace('_', '..', $passEmail);
            $passEmail2 = str_replace('-', './', $passEmail1);
            if (@$carrier) {
               foreach ($carrier as $code) {
                  $traveler .= '<com:SSR Carrier="' . $code . '" Status="HK" FreeText="' . $phoneNumber . '" Type="CTCM"/>
                  <com:SSR Carrier="' . $code . '" Status="HK" FreeText="' . $passEmail2 . '" Type="CTCE"/>';

                  if (@$code == 'KC') {
                     $traveler .= '<com:SSR Carrier="KC" Status="HK" FreeText="' . $phoneNumber . '" Type="CTCP"/>';
                     $traveler .= '<com:SSR Carrier="KC" Status="HK" FreeText="PP' . $adult['passport'] . '" Type="FOID"/>';
                  }
               }
            }
            // ===================End SSRs=======================
            $traveler .= '</com:BookingTraveler>';
         }
      }

      if (count($passData['Infant']) > 0) {
         $INFKey = array_values($passTypeKeys['INF']);
         foreach ($passData['Infant'] as $key => $infant) {
            if ($infant['salute'] == 'male') {
               $gender = 'MI';
               $Prefix = 'MSTR';
            } else {
               $gender = 'FI';
               $Prefix = 'MISS';
            }
            $countryCodeINF = self::countryCode($infant['nationality']);
            $dob = date('Y-m-d', strtotime($infant['dob']));
            $dob2 = date('dMy', strtotime($infant['dob']));
            $passExpiry = date('dMy', strtotime($infant['passExpiry']));
            $BookingTravelerKey2 = $INFKey[$key]['BookingTravelerRef'];
            $age = Carbon::parse($infant['dob'])->age;

            $traveler .= '<com:BookingTraveler xmlns:com="http://www.travelport.com/schema/common_v51_0" DOB="' . $dob . '" Age="' . $age . '" Gender="' . $gender . '" Key="' . $BookingTravelerKey2 . '" TravelerType="INF">
                     <com:BookingTravelerName First="' . $infant['firstname'] . '" Last="' . $infant['lastname'] . '" Prefix="' . $Prefix . '"/>
                     <com:PhoneNumber Type="Mobile" Number="' . $phoneNumber . '"/>
                     <com:Email EmailID="' . $request->passenger_email . '" Type="p"/>';

            // foreach($segmentKeyForSsr as $key => $segmentKey){
            $traveler .= '<com:SSR Carrier="' . $carrier[0] . '" FreeText="P/' . $countryCodeINF . '/' . $infant['passport'] . '/' . $countryCodeINF . '/' . $dob2 . '/' . $gender . '/' . $passExpiry . '/' . $infant['lastname'] . '/' . $infant['firstname'] . '" Status="HK" Type="DOCS"/>';
            // }
            $traveler .= '<com:NameRemark>
                     <com:RemarkData>' . $dob2 . '</com:RemarkData>
                     </com:NameRemark>
                     ';
            $traveler .= '</com:BookingTraveler>';
         }
      }
      if (count($passData['Child']) > 0) {
         $CNNKey = array_values($passTypeKeys['CNN']);
         foreach ($passData['Child'] as $key => $child) {
            if ($child['salute'] == 'male') {
               $gender = 'M';
               $Prefix = 'MSTR';
            } else {
               $gender = 'F';
               $Prefix = 'MISS';
            }
            $countryCodeCNN = self::countryCode($child['nationality']);
            $dob = date('Y-m-d', strtotime($child['dob']));
            $dob2 = date('dMy', strtotime($child['dob']));
            $passExpiry = date('dMy', strtotime($child['passExpiry']));
            $BookingTravelerKey3 = $CNNKey[$key]['BookingTravelerRef'];
            $age = Carbon::parse($child['dob'])->age;

            $traveler .= '<com:BookingTraveler xmlns:com="http://www.travelport.com/schema/common_v51_0" DOB="' . $dob . '" Age="' . $age . '" Gender="' . $gender . '" Key="' . $BookingTravelerKey3 . '" TravelerType="CNN">
                     <com:BookingTravelerName First="' . $child['firstname'] . '" Last="' . $child['lastname'] . '" Prefix="' . $Prefix . '"/>
                     <com:PhoneNumber Type="Mobile" Number="' . $phoneNumber . '"/>
                     <com:Email EmailID="' . $request->passenger_email . '" Type="p"/>';

            // foreach($segmentKeyForSsr as $key => $segmentKey){
            $traveler .= '<com:SSR Carrier="' . $carrier[0] . '" FreeText="P/' . $countryCodeCNN . '/' . $child['passport'] . '/' . $countryCodeCNN . '/' . $dob2 . '/' . $gender . '/' . $passExpiry . '/' . $child['lastname'] . '/' . $child['firstname'] . '" Status="HK" Type="DOCS"/>';
            // }

            $traveler .= '<com:NameRemark>
               <com:RemarkData>P-C' . $age . ' DOB' . $dob2 . '</com:RemarkData>
               </com:NameRemark>
               ';
            $traveler .= '</com:BookingTraveler>';
         }
      }



      /*==========================================================================*/

      $pnrData = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
                 <soapenv:Header/>
                 <soapenv:Body>
                   <univ:AirCreateReservationReq xmlns:air="http://www.travelport.com/schema/air_v51_0" xmlns:common_v51_0="http://www.travelport.com/schema/common_v51_0" xmlns:univ="http://www.travelport.com/schema/universal_v51_0" AuthorizedBy="user" RetainReservation="Price" TargetBranch="' . $apiObject->targetBranch . '" TraceId="' . $TraceId . '">
                   <com:BillingPointOfSaleInfo xmlns:com="http://www.travelport.com/schema/common_v51_0" OriginApplication="UAPI"/>
                   ' . $traveler . '
                   <ContinuityCheckOverride Key="' . $apiObject->provider . '" xmlns="http://www.travelport.com/schema/common_v51_0">yes</ContinuityCheckOverride>
                   <com:FormOfPayment xmlns:com="http://www.travelport.com/schema/common_v51_0" Type="Cash"/>';
      $pnrData .= $AirPricingSolution;
      $pnrData .= '<com:ActionStatus xmlns:com="http://www.travelport.com/schema/common_v51_0" ProviderCode="' . $apiObject->provider . '" TicketDate="T*" Type="ACTIVE"/>
                   </univ:AirCreateReservationReq>
                 </soapenv:Body>
               </soapenv:Envelope>';
      return $pnrData;
   }

   public static function createSegments($res, $price_val, $providerCode)
   {
      /*
      * if statement for single segment and else for multiple segments
      */
      $dataArray = array();
      $segmentKeyForSsr = array();
      $carrier = array();
      if (!array_key_exists("0", $price_val)) {
         $segment = '<air:AirSegment ';
         $segment .= 'ProviderCode="' . $providerCode . '" ';

         foreach ($price_val as $attrName => $attrVal) {
            if ($attrName == 'airAirSegmentRef') {
               $segmentKey = $attrVal['@attributes']['Key'];

               foreach ($res['airAirSegmentList'] as $key => $segVal) {
                  if ($segVal['@attributes']['Key'] == $segmentKey) {
                     $segmentKeyForSsr[$key] = $segVal['@attributes']['Key'];
                     $carrier[$key] = $segVal['@attributes']['Carrier'];
                     foreach ($segVal['@attributes'] as $segAttr2 => $segVal2) {
                        $segment .= '' . $segAttr2 . '="' . $segVal2 . '" ';
                     }
                     $segment .= '>';

                     if (@$segVal['airAirAvailInfo']) {
                        $segment .= '<air:AirAvailInfo ';
                        foreach ($segVal['airAirAvailInfo']['@attributes'] as $AirAvailInfoAttr2 => $AirAvailInfoVal2) {
                           $segment .= '' . $AirAvailInfoAttr2 . '="' . $AirAvailInfoVal2 . '" ';
                        }
                        $segment .= '/>';
                     }

                     if (@$segVal['airFlightDetailsRef']) {
                        $segment .= '<air:FlightDetails ';
                        $flightDetailKey = $segVal['airFlightDetailsRef']['@attributes']['Key'];
                        foreach ($res['airFlightDetailsList'] as $fDetial) {
                           if ($fDetial['@attributes']['Key'] == $flightDetailKey) {
                              foreach ($fDetial['@attributes'] as $detialKey => $detailVal) {
                                 $segment .= '' . $detialKey . '="' . $detailVal . '" ';
                              }
                           }
                        }
                        $segment .= '/>';
                     }
                     $segment .= '</air:AirSegment>';
                  }
               }
            }
         }
      } else {
         $segment = '';
         foreach ($price_val as $seggments) {
            $segment1 = '';
            foreach ($seggments as $attrName => $attrVal) {
               if ($attrName == 'airAirSegmentRef') {
                  $segmentKey = $attrVal['@attributes']['Key'];

                  foreach ($res['airAirSegmentList'] as $key => $segVal) {
                     if ($segVal['@attributes']['Key'] == $segmentKey) {
                        $segment1 = '<air:AirSegment ';
                        $segment1 .= 'ProviderCode="' . $providerCode . '" ';
                        $segmentKeyForSsr[$key] = $segVal['@attributes']['Key'];
                        $carrier[$key] = $segVal['@attributes']['Carrier'];
                        foreach ($segVal['@attributes'] as $segAttr2 => $segVal2) {
                           $segment1 .= '' . $segAttr2 . '="' . $segVal2 . '" ';
                        }
                        $segment1 .= '>';

                        if (@$segVal['airAirAvailInfo']) {
                           $segment1 .= '<air:AirAvailInfo ';
                           foreach ($segVal['airAirAvailInfo']['@attributes'] as $AirAvailInfoAttr2 => $AirAvailInfoVal2) {
                              $segment1 .= '' . $AirAvailInfoAttr2 . '="' . $AirAvailInfoVal2 . '" ';
                           }
                           $segment1 .= '/>'; //<air:AirAvailInfo 
                        }

                        if (@$segVal['airFlightDetailsRef']) {
                           $segment1 .= '<air:FlightDetails ';
                           $flightDetailKey = $segVal['airFlightDetailsRef']['@attributes']['Key'];
                           foreach ($res['airFlightDetailsList'] as $fDetial) {
                              if ($fDetial['@attributes']['Key'] == $flightDetailKey) {
                                 foreach ($fDetial['@attributes'] as $detialKey => $detailVal) {
                                    $segment1 .= '' . $detialKey . '="' . $detailVal . '" ';
                                 }
                              }
                           }
                           $segment1 .= '/>'; //<air:FlightDetails 

                        }
                        $segment1 .= '</air:AirSegment>';
                     }
                  }
               }
               $segment .= $segment1;
            }
         }
      }

      $dataArray['segment'] = $segment;
      $dataArray['carrier'] = $carrier;
      $dataArray['segmentKeyForSsr'] = $segmentKeyForSsr;
      return $dataArray;
   }

   public static function makeGetPnrResponse($response, $apiObject)
   {

      $finaldata = array();
      $res = $response['SOAP_Body']['universal_UniversalRecordRetrieveRsp']['universal_UniversalRecord']['air_AirReservation'];

      $air_AirSegment = $res['air_AirSegment'];
      $air_AirPricingInfo = $res['air_AirPricingInfo'];
      $air_TicketingModifiers = $res['air_TicketingModifiers'];
      if (!array_key_exists("0", $air_AirPricingInfo)) {
         $air_AirPricingInfo = self::putOnZeroIndex($air_AirPricingInfo);
      }
      if (!array_key_exists("0", $air_AirSegment)) {
         $air_AirSegment = self::putOnZeroIndex($air_AirSegment);
      }


      $finalData = array();
      $segment0 = array();
      $segment1 = array();
      $segment2 = array();
      $segment3 = array();
      $segment4 = array();
      $segment5 = array();

      $minutes0 = 0;
      $minutes1 = 0;
      $minutes2 = 0;
      $minutes3 = 0;
      $minutes4 = 0;
      $minutes5 = 0;

      $Fares = array();
      $LowFareSearch = array();

      $finalData['api'] = 'Travelport';
      $finalData['MarketingAirline']['Airline'] = $air_TicketingModifiers['@attributes']['PlatingCarrier'];
      $finalData['MarketingAirline']['FareRules'] = 'NA';
      foreach ($air_AirSegment as $segsKey => $segmnts) {
         foreach ($segmnts as $segKey => $seg) {
            if ($segKey == '@attributes') {
               if (@$seg['Group'] == 0) {
                  $Group = $seg['Group'];
                  $Duration = self::convertToHoursMins($seg['TravelTime']);
                  $OperatingAirline['Code'] = $seg['Carrier'];
                  $OperatingAirline['FlightNumber'] = $seg['FlightNumber'];
                  $Departure['LocationCode'] = $seg['Origin'];
                  $Departure['DepartureDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['DepartureTime']));
                  $Arrival['LocationCode'] = $seg['Destination'];
                  $Arrival['ArrivalDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['ArrivalTime']));
                  $Cabin = $seg['CabinClass'];

                  $segment0[] = compact(
                     'Group',
                     'Duration',
                     'OperatingAirline',
                     'Departure',
                     'Arrival',
                     'Cabin'
                  );

                  $minutes0 += $seg['TravelTime'];
                  $hours = intdiv($minutes0, 60) . ' Hours ' . ($minutes0 % 60) . ' Minutes';

                  $LowFareSearch[0]['Segments'] = $segment0;
                  $LowFareSearch[0]['TotalDuration'] = $hours;
               } else if (@$seg['Group'] == 1) {
                  $Group = $seg['Group'];
                  $Duration = self::convertToHoursMins($seg['TravelTime']);
                  $OperatingAirline['Code'] = $seg['Carrier'];
                  $OperatingAirline['FlightNumber'] = $seg['FlightNumber'];
                  $Departure['LocationCode'] = $seg['Origin'];
                  $Departure['DepartureDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['DepartureTime']));
                  $Arrival['LocationCode'] = $seg['Destination'];
                  $Arrival['ArrivalDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['ArrivalTime']));
                  $Cabin = $seg['CabinClass'];

                  $segment1[] = compact(
                     'Group',
                     'Duration',
                     'OperatingAirline',
                     'Departure',
                     'Arrival',
                     'Cabin'
                  );
                  $minutes1 += $seg['TravelTime'];
                  $hours = intdiv($minutes1, 60) . ' Hours ' . ($minutes1 % 60) . ' Minutes';

                  $LowFareSearch[1]['Segments'] = $segment1;
                  $LowFareSearch[1]['TotalDuration'] = $hours;
               } else if (@$seg['Group'] == 2) {
                  $Group = $seg['Group'];
                  $Duration = self::convertToHoursMins($seg['TravelTime']);
                  $OperatingAirline['Code'] = $seg['Carrier'];
                  $OperatingAirline['FlightNumber'] = $seg['FlightNumber'];
                  $Departure['LocationCode'] = $seg['Origin'];
                  $Departure['DepartureDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['DepartureTime']));
                  $Arrival['LocationCode'] = $seg['Destination'];
                  $Arrival['ArrivalDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['ArrivalTime']));
                  $Cabin = $seg['CabinClass'];

                  $segment2[] = compact(
                     'Group',
                     'Duration',
                     'OperatingAirline',
                     'Departure',
                     'Arrival',
                     'Cabin'
                  );
                  $minutes2 += $seg['TravelTime'];
                  $hours = intdiv($minutes2, 60) . ' Hours ' . ($minutes2 % 60) . ' Minutes';

                  $LowFareSearch[2]['TotalDuration'] = $hours;
                  $LowFareSearch[2]['Segments'] = $segment2;
               } else if (@$seg['Group'] == 3) {
                  $Group = $seg['Group'];
                  $Duration = self::convertToHoursMins($seg['TravelTime']);
                  $OperatingAirline['Code'] = $seg['Carrier'];
                  $OperatingAirline['FlightNumber'] = $seg['FlightNumber'];
                  $Departure['LocationCode'] = $seg['Origin'];
                  $Departure['DepartureDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['DepartureTime']));
                  $Arrival['LocationCode'] = $seg['Destination'];
                  $Arrival['ArrivalDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['ArrivalTime']));
                  $Cabin = $seg['CabinClass'];

                  $segment3[] = compact(
                     'Group',
                     'Duration',
                     'OperatingAirline',
                     'Departure',
                     'Arrival',
                     'Cabin'
                  );
                  $minutes3 += $seg['TravelTime'];
                  $hours = intdiv($minutes3, 60) . ' Hours ' . ($minutes3 % 60) . ' Minutes';

                  $LowFareSearch[3]['TotalDuration'] = $hours;
                  $LowFareSearch[3]['Segments'] = $segment3;
               } else if (@$seg['Group'] == 4) {
                  $Group = $seg['Group'];
                  $Duration = self::convertToHoursMins($seg['TravelTime']);
                  $OperatingAirline['Code'] = $seg['Carrier'];
                  $OperatingAirline['FlightNumber'] = $seg['FlightNumber'];
                  $Departure['LocationCode'] = $seg['Origin'];
                  $Departure['DepartureDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['DepartureTime']));
                  $Arrival['LocationCode'] = $seg['Destination'];
                  $Arrival['ArrivalDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['ArrivalTime']));
                  $Cabin = $seg['CabinClass'];

                  $segment4[] = compact(
                     'Group',
                     'Duration',
                     'OperatingAirline',
                     'Departure',
                     'Arrival',
                     'Cabin'
                  );
                  $minutes4 += $seg['TravelTime'];
                  $hours = intdiv($minutes4, 60) . ' Hours ' . ($minutes4 % 60) . ' Minutes';

                  $LowFareSearch[4]['TotalDuration'] = $hours;
                  $LowFareSearch[4]['Segments'] = $segment4;
               } else if (@$seg['Group'] == 5) {
                  $Group = $seg['Group'];
                  $Duration = self::convertToHoursMins($seg['TravelTime']);
                  $OperatingAirline['Code'] = $seg['Carrier'];
                  $OperatingAirline['FlightNumber'] = $seg['FlightNumber'];
                  $Departure['LocationCode'] = $seg['Origin'];
                  $Departure['DepartureDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['DepartureTime']));
                  $Arrival['LocationCode'] = $seg['Destination'];
                  $Arrival['ArrivalDateTime'] = date('Y-m-d\TH:i:s', strtotime($seg['ArrivalTime']));
                  $Cabin = $seg['CabinClass'];

                  $segment5[] = compact(
                     'Group',
                     'Duration',
                     'OperatingAirline',
                     'Departure',
                     'Arrival',
                     'Cabin'
                  );
                  $minutes5 += $seg['TravelTime'];
                  $hours = intdiv($minutes5, 60) . ' Hours ' . ($minutes5 % 60) . ' Minutes';

                  $LowFareSearch[5]['TotalDuration'] = $hours;
                  $LowFareSearch[5]['Segments'] = $segment5;
               }
            }
         }
      }

      $Baggage = array();
      $fareBreakDown = array();
      $totalPrice = 0;
      foreach ($air_AirPricingInfo as $priceKey => $PricingInfo) {
         $air_FareInfo = $PricingInfo['air_FareInfo'];
         if (!array_key_exists("0", $air_FareInfo)) {
            $air_FareInfo = self::putOnZeroIndex($air_FareInfo);
         }
         foreach ($air_FareInfo as $key => $bag) {
            $passType = $bag['@attributes']['PassengerTypeCode'];
            if ($bag['air_BaggageAllowance']) {

               $bagg = $bag['air_BaggageAllowance'];
               if (@$bagg['air_NumberOfPieces']) {
                  $Baggage[$key][$passType]['Weight'] = @$bagg['air_NumberOfPieces'];
                  $Baggage[$key][$passType]['Unit'] = 'Piece(s)';
               } else {
                  if (@$bagg['air_MaxWeight']) {
                     $Baggage[$key][$passType]['Weight'] = $bagg['air_MaxWeight']['@attributes']['Value'];
                     $Baggage[$key][$passType]['Unit'] = $bagg['air_MaxWeight']['@attributes']['Unit'];
                  } else {
                     $Baggage[$key][$passType]['Weight'] = @$bagg['air_NumberOfPieces'];
                     $Baggage[$key][$passType]['Unit'] = 'Piece(s)';
                  }
               }
            }
         }


         if ($PricingInfo['@attributes']) {
            $quantity = count($PricingInfo['air_PassengerType']);
            $fareBreakDown[$passType]['Quantity'] = $quantity - 1; /////this just for dummy
            $fareBreakDown[$passType]['TotalFare'] = (int)str_replace($apiObject->currency, '', $PricingInfo['@attributes']['TotalPrice']);
            $fareBreakDown[$passType]['BaseFare'] = (int)str_replace($apiObject->currency, '', $PricingInfo['@attributes']['EquivalentBasePrice']);
            $fareBreakDown[$passType]['TotalTax'] = (int)str_replace($apiObject->currency, '', $PricingInfo['@attributes']['Taxes']);

            $totalPrice += (float)str_replace($apiObject->currency, '', $PricingInfo['@attributes']['TotalPrice']);
         }
      }
      $z = 0;
      $LowFareSearch2 = array();
      foreach ($LowFareSearch as $key => $lowFare) {
         $flights = array();
         foreach ($lowFare['Segments'] as $key2 => $segmt) {
            $segmt['Baggage'] = $Baggage[$z];
            $flights[$key2] = $segmt;
            $z++;
         }
         $lowFare['Segments'] = $flights;
         $LowFareSearch2[$key] = $lowFare;
      }

      $LowFareSearch[$priceKey]['Segments'][$key]['Baggage'] = $Baggage;
      $finalData['LowFareSearch'] = $LowFareSearch2;

      $Fares['CurrencyCode'] = self::currencySymbol($apiObject->currency);
      $Fares['fareBreakDown'] = $fareBreakDown;
      $Fares['TotalPrice'] = (int)$totalPrice;
      $Fares['OriginalPrice'] = (int)$totalPrice;
      $Fares['PricingEnginePrice'] = 0;
      $Fares['AdditionalPrice'] = 0;

      $finalData['Fares'] = $Fares;
      return $finalData;
   }
   public static function makeBaggageResponse($response,$CurrencyType)
   {

      if (@$response['SOAP_Body']['SOAP_Fault']) {
         $error = array();
         $error['error'] = @$response['SOAP_Body']['SOAP_Fault']['detail']['common_v51_0_ErrorInfo']['common_v51_0_Code'];
         $error['api'] = 'Travelport';
         $error['message'] = @$response['SOAP_Body']['SOAP_Fault']['faultstring'];
         return $error;
      }

      $finalData = array();
      $OptionalServicesArray = array();

      $TraceId = $response['SOAP_Body']['air_AirMerchandisingOfferAvailabilityRsp']['@attributes']['TraceId'];
      $SearchTravelers = $response['SOAP_Body']['air_AirMerchandisingOfferAvailabilityRsp']['air_AirSolution']['air_SearchTraveler'];
      if (!array_key_exists("0",$SearchTravelers))
      {
         $SearchTravelers = self::putOnZeroIndex($SearchTravelers);
      }
      $AirSegments = $response['SOAP_Body']['air_AirMerchandisingOfferAvailabilityRsp']['air_AirSolution']['air_AirSegment'];
      if (!array_key_exists("0",$AirSegments))
      {
         $AirSegments = self::putOnZeroIndex($AirSegments);
      }

      $air_OptionalServices = $response['SOAP_Body']['air_AirMerchandisingOfferAvailabilityRsp']['air_OptionalServices']['air_OptionalService'];
      foreach($air_OptionalServices as $BaggageObj){
         if($BaggageObj['@attributes']['Type'] == 'Baggage'){
            $Supplier = $BaggageObj['@attributes']['SupplierCode'];
            $AirSegmentRef = $BaggageObj['common_v51_0_ServiceData']['@attributes']['AirSegmentRef'];
            $BookingTravelerRef = $BaggageObj['common_v51_0_ServiceData']['@attributes']['BookingTravelerRef'];

            $bagPrice = $BaggageObj['@attributes']['TotalPrice'];
            $TotalPrice = str_replace('AUD', '', $bagPrice);
            // $TotalPrice = str_replace($CurrencyType, '', $bagPrice);
            $Currency = $CurrencyType;

            $Quantity = @$BaggageObj['@attributes']['Quantity'];
            if($Quantity != ''){
               $Unit = 'Piece';
            }else{
               $Unit = 'KG';
            }

            // ==================Traveler and Segments=============
            $SearchTraveler = '';
            $AirSegment = '';
            foreach($SearchTravelers as $trav){
               if ($trav['@attributes']['Key'] == $BookingTravelerRef) {
                  $travelerType = $trav['@attributes']['Code'];
                  $FirstName = $trav['common_v51_0_Name']['@attributes']['First'];
                  $LastName = $trav['common_v51_0_Name']['@attributes']['Last'];
                  $SearchTraveler = $trav;
               }
            }
            foreach($AirSegments as $segmnt){
               if ($segmnt['@attributes']['Key'] == $AirSegmentRef) {
                  $AirSegment = $segmnt;

               }
            }
            // ===============End Traveler And Segments================
            $OptionalServices = $BaggageObj;
            $OptionalServicesArray[$Supplier][] = compact(
            // $OptionalServicesArray[] = compact(
               'TraceId',
               'travelerType',
               'FirstName',
               'LastName',
               'TotalPrice',
               'Currency',
               'Quantity',
               'Unit',
               'OptionalServices',
               'SearchTraveler',
               'AirSegment'
            );
         }
      }

      return $OptionalServicesArray;
   }
   public static function createBaggageFullfillRequest($apiObject,$baggagesData,$pnrData){
      if (!array_key_exists("0", $baggagesData)) {
         $baggagesData = self::putOnZeroIndex($baggagesData);
      }

      $TraceId = $baggagesData[0]['TraceId'];
      $apiObject = json_decode($apiObject);
      $response = json_decode($pnrData,true);
      $BookingTraveler = json_decode($baggagesData[0]['SearchTraveler'],true);
      $air_AirSegment = json_decode($baggagesData[0]['AirSegment'],true);
      // return $air_AirSegment;
      $OptionalServices = json_decode($baggagesData[0]['OptionalServices'],true);

      if (!array_key_exists("0", $BookingTraveler)) {
         $BookingTraveler = self::putOnZeroIndex($BookingTraveler);
      }
      if (!array_key_exists("0", $BookingTraveler)) {
         $BookingTraveler = self::putOnZeroIndex($BookingTraveler);
      }
      if (!array_key_exists("0", $air_AirSegment)) {
         $air_AirSegment = self::putOnZeroIndex($air_AirSegment);
      }

      $TravelerObj = '';
      $SegmentsObj = '';
      /*----------------------------------Travelers------------------------------*/
      foreach($BookingTraveler as $travelers){
         $TravelerObj .= '<SearchTraveler Code="'.$travelers['@attributes']['Code'].'"  Key="'.$travelers['@attributes']['Key'].'">
                  <Name xmlns="http://www.travelport.com/schema/common_v51_0" Prefix="'.@$travelers['common_v51_0_Name']['@attributes']['Prefix'].'" First="'.$travelers['common_v51_0_Name']['@attributes']['First'].'" Last="'.$travelers['common_v51_0_Name']['@attributes']['Last'].'" />
            </SearchTraveler>';
      }
      
      /*-------------------------------Segments--------------------------------*/
      foreach($air_AirSegment as $segments){
         $segment = '<AirSegment ';
         foreach($segments['@attributes'] as $segAttr => $segVal){
            $segment .= '' . $segAttr . '="' . $segVal . '" ';
         }
         $segment .= '/>';

         $SegmentsObj .= $segment;
      }

      /*----------------------------PNR Codes----------------------------------*/
      $ProviderLocatorCode = @$response['SOAP_Body']['universal_AirCreateReservationRsp']['universal_UniversalRecord']['universal_ProviderReservationInfo']['@attributes']['LocatorCode'];
      $UniversalLocatorCode = @$response['SOAP_Body']['universal_AirCreateReservationRsp']['universal_UniversalRecord']['@attributes']['LocatorCode'];
      $CarrierLocator = @$response['SOAP_Body']['universal_AirCreateReservationRsp']['universal_UniversalRecord']['air_AirReservation']['common_v51_0_SupplierLocator'];

      if (!array_key_exists("0", $CarrierLocator)) {
         $CarrierLocator = self::putOnZeroIndex($CarrierLocator);
      }
      $CarrierLocatorCode = "";
      $CarrierCode = "";
      if (@$CarrierLocator) {
         foreach ($CarrierLocator as $key => $supplier) {
            $CarrierLocatorCode .= $supplier['@attributes']['SupplierLocatorCode'];
            $CarrierCode .= $supplier['@attributes']['SupplierCode'];
            if ($key < count($CarrierLocator) - 1) {
               $CarrierLocatorCode .= '/';
            }
         }
      }
      /*--------------------------------Optional services---------------------------*/
      if(@$segments['@attributes']){
         $OptionalService = '<air:OptionalService ';
         foreach($OptionalServices['@attributes'] as $optionAttr => $optionVal){
            $OptionalService .= '' . $optionAttr . '="' . $optionVal . '" ';
         }
         $OptionalService .= '>';

         if(@$OptionalServices['common_v51_0_ServiceData']){
            $OptionalService .= '<com:ServiceData  xmlns:com="http://www.travelport.com/schema/common_v51_0" ';
            foreach($OptionalServices['common_v51_0_ServiceData']['@attributes'] as $servAttr => $servVal){
               $OptionalService .= '' . $servAttr . '="' . $servVal . '" ';
            }
            $OptionalService .= '/>';
         }

         if(@$OptionalServices['common_v51_0_ServiceInfo']){
            $OptionalService .= '<com:ServiceInfo  xmlns:com="http://www.travelport.com/schema/common_v51_0"><com:Description>';
               $OptionalService .= @$OptionalServices['common_v51_0_ServiceInfo']['common_v51_0_Description'];
            $OptionalService .= '</com:Description></com:ServiceInfo>';
         }

         if(@$OptionalServices['air_EMD']){
            $OptionalService .= '<air:EMD ';
               foreach($OptionalServices['air_EMD']['@attributes'] as $emdAttr => $emdVal){
                  $OptionalService .= '' . $emdAttr . '="' . $emdVal . '" ';
               }
            $OptionalService .= '/>';
         }

         if(@$OptionalServices['air_FeeApplication']){
            $OptionalService .= '<air:FeeApplication>';
               $OptionalService .= $OptionalServices['air_FeeApplication'];
            $OptionalService .= '</air:FeeApplication>';
         }

      }
      $OptionalService .= '</air:OptionalService>';
      // return $OptionalService;
      /*--------------------------------Request-------------------------------------*/
      $message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Body>
          <AirMerchandisingFulfillmentReq xmlns="http://www.travelport.com/schema/air_v51_0" TargetBranch="' . $apiObject->targetBranch . '" TraceId="' . $TraceId . '">
              <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v51_0" OriginApplication="uAPI" />
              <air:HostReservation Carrier="'.$CarrierCode.'" CarrierLocatorCode="'.$CarrierLocatorCode.'" ProviderCode="1G" ProviderLocatorCode="'.$ProviderLocatorCode.'" UniversalLocatorCode="'.$UniversalLocatorCode.'" xmlns:air="http://www.travelport.com/schema/air_v51_0"/>
              <AirSolution>

               '.$TravelerObj
               .$SegmentsObj.'

              </AirSolution>
              <air:OptionalServices xmlns:air="http://www.travelport.com/schema/air_v51_0">
               '.$OptionalService.'
              </air:OptionalServices>
            </AirMerchandisingFulfillmentReq>
        </soapenv:Body>
      </soapenv:Envelope>';

      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/AirMerchandisingFulfillmentReq' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($message));
      $resp = self::curl_action($message, $apiObject->userId, $apiObject->apiPassword);
      Storage::put('travelport/'.date('Y-m-d').'-'.$TraceId.'/AirMerchandisingFulfillmentRsp' . date('Y-m-d-H-i-s') . '.xml', self::prettyPrint($resp));

      return $resp;
   }
   /*===========================================================
   * **********************Other Functions**********************
   ===========================================================*/
   public static function curl_action($message, $User_ID, $PASSWORD, $link = null)
   {

      if ($link != null) {
         $url = $link;
      } else {
         $url = self::$link;
      }

      $header = array(
         "Content-Type: text/xml;charset=UTF-8",
         "Accept: gzip,deflate",
         "Cache-Control: no-cache",
         "Pragma: no-cache",
         "SOAPAction: \"\"",
         "Authorization: Basic " . base64_encode($User_ID . ':' . $PASSWORD),
         "Content-length: " . strlen($message),
      );

      $soap_do = curl_init($url);
      curl_setopt($soap_do, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
      curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($soap_do, CURLOPT_POST, true);
      curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
      curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
      curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($soap_do);
      // return $response;
      if (curl_errno($soap_do)) {
         $error_msg = curl_error($soap_do);
         // return $error_msg;
      }
      curl_close($soap_do);

      if (isset($error_msg)) {
         return $error_msg;
      } else {
         return $response;
      }
   }

   public static function prettyPrint($result)
   {
      $dom = new \DOMDocument;
      $dom->preserveWhiteSpace = false;
      $dom->loadXML($result);
      $dom->formatOutput = true;
      return $dom->saveXML();
   }

   public static function convertToArray($response)
   {
      $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $response);
      $xml = simplexml_load_string($xml);
      $json = json_encode($xml);
      $responseArray = json_decode($json, true);
      return $responseArray;
   }

   public static function convertToArray2($response)
   {
      $plainXML = self::mungXML(trim($response));
      $arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
      return $arrayResult;
   }

   public static function convertToHoursMins($time, $format = 'PT%02dH%02dM')
   {
      if ($time < 1) {
         return;
      }
      $hours = floor($time / 60);
      $minutes = ($time % 60);
      return sprintf($format, $hours, $minutes);
   }
   public static function convertToHoursMins3($time)
   {
      $time = ltrim($time, "P");
      $time = rtrim($time, "0S");

      $time1 = explode('D', $time);

      $time2 = ltrim($time1[1], "T");

      $time3 = explode('H', $time2);

      $dayToHour = $time1[0] * 24;
      $totalHours = (int)$dayToHour + (int)$time3[0];

      $minutes = str_replace('M', ' Minutes', $time3[1]);

      $total_duration = $totalHours . ' Hours ' . $minutes;
      return $total_duration;
   }
   public static function putOnZeroIndex($obj)
   {
      $obj[0] = $obj;
      foreach ($obj as $k => $kVal) {
         if ($k != 0) {
            unset($obj[$k]);
         }
      }
      return $obj;
   }
   public static function mungXML($xml)
   {
      $obj = SimpleXML_Load_String($xml);
      if ($obj === FALSE)
         return $xml;

      // GET NAMESPACES, IF ANY
      $nss = $obj->getNamespaces(TRUE);
      if (empty($nss))
         return $xml;

      // CHANGE ns: INTO ns_
      $nsm = array_keys($nss);
      foreach ($nsm as $key) {
         // A REGULAR EXPRESSION TO MUNG THE XML
         $rgx = '#'               // REGEX DELIMITER
            . '('               // GROUP PATTERN 1
            . '\<'              // LOCATE A LEFT WICKET
            . '/?'              // MAYBE FOLLOWED BY A SLASH
            . preg_quote($key)  // THE NAMESPACE
            . ')'               // END GROUP PATTERN
            . '('               // GROUP PATTERN 2
            . ':{1}'            // A COLON (EXACTLY ONE)
            . ')'               // END GROUP PATTERN
            . '#'               // REGEX DELIMITER
         ;
         // INSERT THE UNDERSCORE INTO THE TAG NAME
         $rep = '$1'          // BACKREFERENCE TO GROUP 1
            . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
         ;
         // PERFORM THE REPLACEMENT
         $xml = preg_replace($rgx, $rep, $xml);
      }

      return $xml;
   }
   public static function currencySymbol($currencyCode)
   {
      $path = "assets/currencies.json"; // ie: /var/www/laravel/app/storage/json/filename.json
      if (!File::exists($path)) {
         throw new Exception("Invalid File");
      }
      $currencies = File::get($path);
      $symbols = json_decode($currencies, true);
      return strtoupper($symbols[$currencyCode]['symbol']);
   }
   public static function countryCode($countryName)
   {
      $path = "assets/countries.json"; // ie: /var/www/laravel/app/storage/json/filename.json
      if (!File::exists($path)) {
         throw new Exception("Invalid File");
      }
      $countries = File::get($path);
      $allCountries = json_decode($countries, true);
      foreach ($allCountries as $count) {
         if ($countryName == $count['name']) {
            return $count['code'];
         }
      }
      return strtoupper($symbols);
   }
}
