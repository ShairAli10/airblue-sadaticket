<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirlineDiscount;
use App\Models\Provider;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(){
        $providers = Provider::all();
        return view('admin.setting.index',compact('providers'));
    }
    public function storeAirlineDiscount(Request $request){
        $provider = Provider::where('identifier',$request->source)->first();
        $airDiscounts = new AirlineDiscount();
        $airDiscounts->airline = $request->airline;
        $airDiscounts->provider = $request->source;
        $airDiscounts->provider_id = $provider->id;
        $airDiscounts->discount = $request->discount;
        $airDiscounts->departure_codes = $request->from;
        if($airDiscounts->save()){
            return redirect()->back()->with('success','Airline discount saved successfull');
        }else{
            return redirect()->back()->with('error','Airline discount not saved');
        }
    }
    public function updateAirlineDiscount(Request $request){
        $airDiscounts = AirlineDiscount::find($request->id);
        $airDiscounts->airline = $request->airline;
        $airDiscounts->provider = $request->source;
        $airDiscounts->discount = $request->discount;
        $airDiscounts->departure_codes = $request->from;
        if($airDiscounts->save()){
            return redirect()->back()->with('success','Airline discount updated successfull');
        }else{
            return redirect()->back()->with('error','Airline discount not updated');
        }
    }
    public function deleteAirlineDiscount(Request $request){
        $airDiscounts = AirlineDiscount::find($request->id);
        if($airDiscounts->delete()){
            return redirect()->back()->with('success','Airline discount deleted successfull');
        }else{
            return redirect()->back()->with('error','Airline discount not delete');
        }
    }
    public function changeProviderStatus(Request $request){
        $provider = Provider::findOrFail($request->id);
        $provider->status = !$provider->status;
        if($provider->save()){
            return ['status' => 'success','message' => 'Provider status updated successfull'];
        }else{
            return ['status' => 'error','message' => 'Provider status not updated'];
        }
    }
    /********************************************************\
     *                  Provider methods                    *|
    \********************************************************/
    public function ProviderDetail($contec_provider){
        $provider = Provider::where('identifier',$contec_provider)->first();
        return view('admin.setting.providers.details',compact('provider'));
    }
    public function StoreExcludeAirline(Request $request){
        $provider = Provider::find($request->provider);
        if ($provider) {
            $provider->exclude_airlines = $request->exclude_airlines;
            $provider->save();
            return redirect()->route('admin.provider',[$provider->identifier])
                    ->with('success', 'Airline added to provider.');
        }else{
            return redirect()->back()->with('error', 'Provider not found...');
        }
        
    }
    /**********************Old******************************/
    public function smtp(){
        $smtp = Setting::where('type','smtp')->get();
        return view('admin.setting.smtp.index',compact('smtp'));
    }
    public function editSmtp(Setting $smtp){
        return view('admin.setting.smtp.edit',compact('smtp'));
    }
    public function updateSmtp(Request $request){
        try{
            DB::beginTransaction();
            $smtp = Setting::find($request->id);
            $smtp->data = $request->data;
            $smtp->save();
            DB::commit();
            return redirect()->route('admin.setting.smtp')->with('success', 'API data updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            if (env('APP_ENV') == "local") {
                return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong'], 500);
            }
        }
    }
}
