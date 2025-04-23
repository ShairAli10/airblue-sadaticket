<?php

namespace App\Http\Controllers\Front\Flight;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\SabreTrait as Sabre;
use App\Models\ApiOffer;
use App\Http\Traits\CustomerPricingEngineTrait as CustomerPricingEngine;
use App\Models\Provider;
use App\Models\Setting;

class FlightController extends Controller
{
    public function searchResult(){
        $apis = Provider::where('status', '1')->pluck('identifier')->toArray();
        return view('front.flight.search-result',compact('apis'));
    }
    public function availability(Request $request){
        $origin = explode(' - ', $request->origin);
        $destination = explode(' - ', $request->destination);
        $requestData = [
            'tripType' => $request->tripType,
            'origin' => strtoupper($origin[0]),
            'destination' => strtoupper($destination[0]),
            'departureDate' => $request->departureDate,
            'returnDate' => $request->returnDate,
            'adults' => $request->adults,
            'children' => $request->children,
            'infants' => $request->infants,
            'stop' => false,
            'ticket_class' => 'Economy',
        ];
        
        // Perform the search using Sabre
        $response = Sabre::lowFareSearch($requestData);
        // dd($response);
        if($response['status'] == 200){
            $data = $response['msg'];
            // $totalPassenger = $request->adults + $request->children + $request->infants;
            // $api = Setting::where('name', strtolower($response['msg'][0]['api']))->first();
            // $pricinEngineResult = CustomerPricingEngine::applyPricingEngine($data,$requestData['origin'],$requestData['destination'],$totalPassenger,$api);
            
            $results = array(
                'status' => 200,
                // 'msg' => $pricinEngineResult
                'msg' => $response['msg']
            );
            
            $asideFilter = view('front.flight.includes.sidebar-filter',compact('results'))->render();
            if($request->tripType == 'oneway'){
                $html = view('front.flight.includes.search-result-render',compact('results'))->render();
            }else{
                $html = view('front.flight.includes.search-result-return-render',compact('results'))->render();
            }
            return json_encode(['message' => 'success', 'html' => $html, 'filter'=>$asideFilter]);
        }else{
            return json_encode(['message' => $response['msg']]);
        }
        
    }

    public function flightDetail(Request $request){
        $api_offer = ApiOffer::where('ref_key', $request->key)->first();
        $data = $api_offer->finaldata;

        // $requestData = json_decode($api_offer->query,true);
        // $totalPassenger = $requestData['adults'] + $requestData['children'] + $requestData['infants'];
        // $api = Setting::where('name', strtolower($api_offer->api))->first();
        // $pricinEngineResult = PricingEngine::applyPricingEngine(json_decode(json_encode($data)),$requestData['origin'],$requestData['destination'],$totalPassenger,$api);

        // $offerData = array(
        //     'id' => $api_offer->id,
        //     'finaldata' => json_decode(json_encode($pricinEngineResult),true),
        // );

        $result = $data;
        $flightDetailHtml = view('front.flight.includes.modal-result-render',compact('result'))->render();
        return json_encode(['message' => 'success', 'flightDetailHtml' => $flightDetailHtml]);
    }
    ////////////////////////////////////////////////
    public function getAllAirPorts($q){
        $airport = DB::table('airports');
        if ($q != null) {
            $value = explode(' - ', $q);
            // return response()->json(['code'=>$value[1]]);
            if (isset($value[1])) {
              $airport = $airport->where('code','LIKE','%'.$value[0].'%');
            }
            elseif (strlen($q) == 3) {
              $airport = $airport->where('code','LIKE','%'.$q.'%');
            }
            else{
              $airport = $airport->where('code','LIKE','%'.$q.'%')->orWhere('city','LIKE','%'.$q.'%')->orWhere('name','LIKE','%'.$q.'%');
            }
        }
          
        $airport = $airport->get(['name','code']);

        $first_array = [];
        $sec_array = [];
        foreach ($airport as $key => $value) {
            if ($value->code==strtoupper($q)) {
                $first_array[]=array(
                    'code' => $value->code,
                    'airport_name' => $value->name,
                );
            }
            else{
                $sec_array[]=array(
                    'code' => $value->code,
                    'airport_name' => $value->name,
                );
            }
        }

        $record = array_merge($first_array,$sec_array);
        return response()->json($record);
    }
}
