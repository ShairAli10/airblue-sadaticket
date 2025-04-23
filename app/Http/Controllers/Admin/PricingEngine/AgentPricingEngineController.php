<?php

namespace App\Http\Controllers\Admin\PricingEngine;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\PricingEngineTravelAgent;
use App\Models\Provider;
use App\Models\Setting;
use Illuminate\Http\Request;

class AgentPricingEngineController extends Controller
{
    public function index(){
        $rulesList = PricingEngineTravelAgent::with('provider')->get();
        $airports = DB::table('airports')->select('code', 'city')->get();
        $apis = Provider::where('status',1)->get();
        return view('admin.pricing-engine-agent.list',compact('rulesList','airports','apis'));
    }
    public function store(Request $request){
        $data = ['description' => $request->input('description')];
        $rule = $request->input('rulePurpose');
        $rulePurpose = PricingEngineTravelAgent::$rulePurpose;
        $rulePurposeCast = PricingEngineTravelAgent::$rulePurposeCast;
            $data['destinations'] = $request->boolean('all_destination') ? [] : $request->input('destination');
            $data['isAllDestinations'] = $request->boolean('all_destination') ? 1 : 0;
            $data['origins'] = $request->boolean('all_origin') ? [] : $request->input('origin');
            $data['isAllOrigins'] = $request->boolean('all_origin') ? 1 : 0;
            $data['isAllAirline'] = $request->boolean('all_airline') ? 1 : 0;
            $data['airline'] = $request->input('airline', '');

        $pricing = new PricingEngineTravelAgent([
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
            return redirect()->route('admin.pricingEngine.list');
        }else{
            session()->flash('Error', __("Pricing Rule not saved...."));
            return redirect()->route('admin.pricingEngine.list');
        }
    }
    public function edit($id)
    {
        $rule = PricingEngineTravelAgent::find($id);
        $airports = DB::table('airports')->select('code', 'city')->get();
        $apis = Provider::where('status',1)->get();

        if (!$rule) {
            return response()->json(['message' => 'Rule not found'], 404);
        }
        return view('admin.pricing-engine-agent.edit-rule-modal', compact('rule','airports','apis'))->render();
    }
    public function update(Request $request){
        $pricing = PricingEngineTravelAgent::findOrFail($request->rule_id);
    
        $data = ['description' => $request->input('description')];
        $rule = $request->input('rulePurpose');
        $rulePurpose = PricingEngineTravelAgent::$rulePurpose;
        $rulePurposeCast = PricingEngineTravelAgent::$rulePurposeCast;
    
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
        return redirect()->route('admin.pricingEngine.list');
    }
    public function delete($rule_id){
        $price_rule = PricingEngineTravelAgent::where('id',$rule_id)->first();
        if($price_rule->delete()){
            session()->flash('success', __("Pricing Rule has been Delete"));
            return redirect()->route('admin.pricingEngine.list');
        }else{
            session()->flash('Error', __("Pricing Rule not Delete...."));
            return redirect()->route('admin.pricingEngine.list');
        }
    }
}
