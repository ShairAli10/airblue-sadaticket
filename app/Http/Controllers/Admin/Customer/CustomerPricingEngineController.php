<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingEngineCustomer;
use App\Models\Provider;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class CustomerPricingEngineController extends Controller
{
    public function index(){
        $rulesList = PricingEngineCustomer::with('provider')->get();
        $airports = DB::table('airports')->select('code', 'city')->get();
        $apis = Provider::where('status',1)->get();
        return view('admin.customers.pricing-engine-agent.list',compact('rulesList','airports','apis'));
    }
    public function store(Request $request){
        $data = ['description' => $request->input('description')];
        $rule = $request->input('rulePurpose');
        $rulePurpose = PricingEngineCustomer::$rulePurpose;
        $rulePurposeCast = PricingEngineCustomer::$rulePurposeCast;
            $data['destinations'] = $request->boolean('all_destination') ? [] : $request->input('destination');
            $data['isAllDestinations'] = $request->boolean('all_destination') ? 1 : 0;
            $data['origins'] = $request->boolean('all_origin') ? [] : $request->input('origin');
            $data['isAllOrigins'] = $request->boolean('all_origin') ? 1 : 0;
            $data['isAllAirline'] = $request->boolean('all_airline') ? 1 : 0;
            $data['airline'] = $request->input('airline', '');

        $pricing = new PricingEngineCustomer([
            'rule' => $rulePurpose[$rule],
            'airline' => $data['airline'] ?? null,
            'api_id' => $request->input('api_id'),
            'type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'origin' => $data['origin'] ?? null,
            'destination' => $data['destination'] ?? null,
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'data' => json_encode($data),
        ]);
        if($pricing->save()){
            // activityLogs('Pricing Rule has been created', $pricing,null);
            session()->flash('success', __("Pricing Rule has been created"));
            return redirect()->route('admin.customer.pricingEngine.list');
        }else{
            session()->flash('Error', __("Pricing Rule not saved...."));
            return redirect()->route('admin.customer.pricingEngine.list');
        }
    }
    public function edit($id)
    {
        $rule = PricingEngineCustomer::find($id);
        $airports = DB::table('airports')->select('code', 'city')->get();
        $apis = Provider::where('status',1)->get();

        if (!$rule) {
            return response()->json(['message' => 'Rule not found'], 404);
        }
        return view('admin.customers.pricing-engine-agent.edit-rule-modal', compact('rule','airports','apis'))->render();
    }
    public function update(Request $request){
        $pricing = PricingEngineCustomer::findOrFail($request->rule_id);
    
        $data = ['description' => $request->input('description')];
        $rule = $request->input('rulePurpose');
        $rulePurpose = PricingEngineCustomer::$rulePurpose;
        $rulePurposeCast = PricingEngineCustomer::$rulePurposeCast;
    
        $data['destinations'] = $request->boolean('all_destination') ? [] : $request->input('destination');
        $data['isAllDestinations'] = $request->boolean('all_destination') ? 1 : 0;
        $data['origins'] = $request->boolean('all_origin') ? [] : $request->input('origin');
        $data['isAllOrigins'] = $request->boolean('all_origin') ? 1 : 0;
        $data['isAllAirline'] = $request->boolean('all_airline') ? 1 : 0;
        $data['airline'] = $request->input('airline', '');    
        $pricing->update([
            'rule' => $rulePurpose[$rule],
            'airline' => $data['airline'] ?? $pricing->airline,
            'api_id' => $request->input('api_id'),
            'type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'origin' => $data['origin'] ?? $pricing->origin,
            'destination' => $data['destination'] ?? $pricing->destination,
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'data' => json_encode($data),
        ]);
    
        session()->flash('success', __("Pricing Rule has been updated"));
        return redirect()->route('admin.customer.pricingEngine.list');
    }
    public function delete($rule_id){
        $price_rule = PricingEngineCustomer::where('id',$rule_id)->first();
        if($price_rule->delete()){
            session()->flash('success', __("Pricing Rule has been Delete"));
            return redirect()->route('admin.customer.pricingEngine.list');
        }else{
            session()->flash('Error', __("Pricing Rule not Delete...."));
            return redirect()->route('admin.customer.pricingEngine.list');
        }
    }
}
