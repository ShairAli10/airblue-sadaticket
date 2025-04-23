<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(){
        $customers = User::all();
        return view('admin.customers.list',compact('customers'));
    }
    public function createCustomer(Request $request){
        $validator = Validator::make($request->input(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $customer = new User();
        $customer->name = $request->first_name.' '.$request->last_name;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->is_verified = 0;
        $customer->status = 0;
        

        if($customer->save()){
            // activityLogs('Pricing Rule has been created', $pricing,null);
            session()->flash('success', __("New customer successfuly created"));
            return redirect()->route('admin.customer');
        }else{
            session()->flash('Error', __("customer not created...."));
            return redirect()->route('admin.customer');
        }
        
    }
    public function viewCustomer(User $customer){
        return view('admin.customers.customer-detail', compact('customer'));
    }
    public function updateCustomer(Request $request){
        $validator = Validator::make($request->input(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $customer = User::find($request->id);
        $customer->name = $request->first_name.' '.$request->last_name;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->status = User::$statusCast[$request->status];
        
        if($customer->save()){
            // activityLogs('Pricing Rule has been created', $pricing,null);
            session()->flash('success', __("customer info successfuly Updated"));
            return redirect()->route('admin.customer.view',[$request->id]);
        }else{
            session()->flash('Error', __("customer info not Updated...."));
            return redirect()->route('admin.customer.view',[$request->id]);
        }
    }
    public function deleteCustomer(User $customer){
        if($customer->delete()){
            session()->flash('success', __("Customer deleted successfuly ....."));
            return redirect()->route('admin.customer');
        }else{
            session()->flash('Error', __("customer not delete ...."));
            return redirect()->route('admin.customer');
        }
    }
}
